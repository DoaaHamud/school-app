<?php

namespace Tests\Feature;

use App\Models\chaldrin;
use App\Models\Daily_variables;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManagerStudentActivationTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_students_can_be_filtered_by_section_and_are_grouped_by_class_and_section(): void
    {
        $school = School::create(['name' => 'مدرسة دليل الطلاب']);
        $manager = User::factory()->create([
            'role' => 'manager',
            'username' => 'section-filter-manager',
            'phone' => '15550000076',
            'school_id' => $school->id,
        ]);
        $mother = User::factory()->create([
            'role' => 'mother',
            'username' => 'section-filter-mother',
            'phone' => '15550000077',
        ]);

        foreach ([
            ['name' => 'طالب الشعبة الأولى', 'class' => 'الثالث', 'section' => 'الأولى'],
            ['name' => 'طالب بصيغة مختلفة', 'class' => 'الثالث', 'section' => 'الاولى'],
            ['name' => 'طالب الشعبة الثانية', 'class' => 'الثالث', 'section' => 'الثانية'],
            ['name' => 'طالب الصف الرابع', 'class' => 'الرابع', 'section' => 'الأولى'],
        ] as $studentData) {
            chaldrin::create([
                'mother_id' => $mother->id,
                'school_id' => $school->id,
                'name' => $studentData['name'],
                'gender' => 'male',
                'Health_status' => 'جيد',
                'class' => $studentData['class'],
                'section' => $studentData['section'],
                'age' => 6,
                'image' => 'student.png',
            ]);
        }

        $response = $this->actingAs($manager)
            ->get(route('manager.students'))
            ->assertOk()
            ->assertSee('name="section"', false)
            ->assertSee('طالب الشعبة الأولى')
            ->assertSee('طالب بصيغة مختلفة')
            ->assertSee('طالب الشعبة الثانية')
            ->assertSee('طالب الصف الرابع')
            ->assertSee('الشعبة: الأولى')
            ->assertSee('الشعبة: الثانية');

        $this->assertSame(2, substr_count($response->getContent(), 'الصف: الثالث'));
        preg_match('/<select name="section".*?<\/select>/s', $response->getContent(), $sectionSelect);
        $this->assertNotEmpty($sectionSelect);
        $this->assertSame(3, substr_count($sectionSelect[0], '<option'));

        $this->actingAs($manager)
            ->get(route('manager.students', ['section' => 'الأولى']))
            ->assertOk()
            ->assertSee('طالب الشعبة الأولى')
            ->assertSee('طالب بصيغة مختلفة')
            ->assertSee('طالب الصف الرابع')
            ->assertDontSee('طالب الشعبة الثانية');
    }

    public function test_manager_can_deactivate_and_reactivate_a_student_without_losing_reports(): void
    {
        $school = School::create(['name' => 'مدرسة الأمل']);
        $manager = User::factory()->create([
            'role' => 'manager',
            'username' => 'students-manager',
            'phone' => '15550000071',
            'school_name' => 'مدرسة الأمل',
            'school_id' => $school->id,
        ]);
        $mother = User::factory()->create([
            'role' => 'mother',
            'username' => 'students-mother',
            'phone' => '15550000072',
        ]);
        $student = chaldrin::create([
            'mother_id' => $mother->id,
            'school_id' => $school->id,
            'name' => 'ليان',
            'gender' => 'female',
            'Health_status' => 'جيدة',
            'class' => 'الأول',
            'age' => 5,
            'image' => 'lian.jpg',
        ]);
        $report = Daily_variables::create([
            'child_id' => $student->id,
            'topic' => 'الرسم',
            'result' => 90,
            'report_date' => now(),
        ]);

        $this->actingAs($manager)
            ->patch(route('manager.students.deactivate', $student->id))
            ->assertRedirect()
            ->assertSessionHas('success', 'تم إلغاء تفعيل الطالب مع الاحتفاظ ببياناته وتقاريره.');

        $this->assertSoftDeleted('chaldrins', ['id' => $student->id]);
        $this->assertDatabaseHas('daily_variables', ['id' => $report->id, 'child_id' => $student->id]);

        $this->actingAs($manager)
            ->get(route('manager.students'))
            ->assertOk()
            ->assertDontSee('ليان')
            ->assertSee(route('manager.students.deactivated'));

        $this->actingAs($manager)
            ->get(route('manager.students.deactivated'))
            ->assertOk()
            ->assertSee('ليان')
            ->assertSee(route('manager.students.reactivate', $student->id));

        $this->actingAs($manager)
            ->patch(route('manager.students.reactivate', $student->id))
            ->assertRedirect()
            ->assertSessionHas('success', 'تمت إعادة تفعيل الطالب.');

        $this->assertNotSoftDeleted('chaldrins', ['id' => $student->id]);
        $this->assertDatabaseHas('daily_variables', ['id' => $report->id, 'child_id' => $student->id]);

        $this->actingAs($manager)
            ->get(route('manager.students'))
            ->assertOk()
            ->assertSee('ليان');
    }

    public function test_manager_cannot_deactivate_or_reactivate_another_managers_student(): void
    {
        $school = School::create(['name' => 'مدرسة الأمل']);
        $otherSchool = School::create(['name' => 'مدرسة أخرى']);
        $manager = User::factory()->create([
            'role' => 'manager',
            'username' => 'students-manager-one',
            'phone' => '15550000073',
            'school_name' => 'مدرسة الأمل',
            'school_id' => $school->id,
        ]);
        $otherManager = User::factory()->create([
            'role' => 'manager',
            'username' => 'students-manager-two',
            'phone' => '15550000074',
            'school_name' => 'مدرسة أخرى',
            'school_id' => $otherSchool->id,
        ]);
        $mother = User::factory()->create([
            'role' => 'mother',
            'username' => 'students-mother-two',
            'phone' => '15550000075',
        ]);
        $student = chaldrin::create([
            'mother_id' => $mother->id,
            'school_id' => $otherSchool->id,
            'name' => 'آدم',
            'gender' => 'male',
            'Health_status' => 'جيدة',
            'class' => 'الثاني',
            'age' => 6,
            'image' => 'adam.jpg',
        ]);

        $this->actingAs($manager)
            ->patch(route('manager.students.deactivate', $student->id))
            ->assertNotFound();

        $student->delete();
        $this->actingAs($manager)
            ->patch(route('manager.students.reactivate', $student->id))
            ->assertNotFound();

        $this->assertSoftDeleted('chaldrins', ['id' => $student->id]);
    }
}
