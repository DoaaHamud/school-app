<?php

namespace Tests\Feature;

use App\Models\chaldrin;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ManagerTeacherManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_manage_approved_teachers_from_the_teacher_directory(): void
    {
        $school = School::create(['name' => 'مدرسة الأمل']);
        $manager = User::factory()->create([
            'role' => 'manager',
            'status' => 'approved',
            'username' => 'teacher-manager',
            'phone' => '15550000061',
            'school_name' => 'مدرسة الأمل',
            'school_id' => $school->id,
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'teacher-to-deactivate',
            'phone' => '15550000062',
            'school_name' => $manager->school_name,
            'school_id' => $school->id,
            'name' => 'سارة أحمد',
        ]);
        $pendingTeacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'pending',
            'username' => 'pending-teacher-dashboard',
            'phone' => '15550000067',
            'school_name' => $manager->school_name,
            'school_id' => $school->id,
            'name' => 'معلمة بانتظار الموافقة',
        ]);

        $this->actingAs($manager)
            ->get(route('manager.dashboard'))
            ->assertOk()
            ->assertSee('دليل الأساتذة')
            ->assertSee(route('manager.teachers.index'))
            ->assertSee(route('manager.teacher-assignments'))
            ->assertSee('معلمة بانتظار الموافقة')
            ->assertDontSee('تعيين أستاذ لصف دراسي')
            ->assertDontSee('سارة أحمد')
            ->assertDontSee('بحث باسم المعلم');

        $this->actingAs($manager)
            ->get(route('manager.teachers.index'))
            ->assertOk()
            ->assertSee('بحث عن أستاذ')
            ->assertSee('سارة أحمد')
            ->assertSee(route('manager.teachers.deactivated'))
            ->assertSee('المعلمون غير المفعلين')
            ->assertSee(route('manager.teachers.deactivate', $teacher->id))
            ->assertSee('إلغاء التفعيل');

        $this->actingAs($manager)
            ->patch(route('manager.teachers.deactivate', $teacher->id))
            ->assertRedirect(route('manager.teachers.index'))
            ->assertSessionHas('success', 'تم إلغاء تفعيل حساب المعلم.');

        $this->assertDatabaseHas('users', [
            'id' => $teacher->id,
            'status' => 'deactivated',
        ]);

        $this->actingAs($manager)
            ->get(route('manager.teachers.deactivated'))
            ->assertOk()
            ->assertSee('المعلمون غير المفعلين')
            ->assertSee('سارة أحمد')
            ->assertSee(route('manager.teachers.reactivate', $teacher->id))
            ->assertSee('إعادة التفعيل');

        $this->actingAs($manager)
            ->patch(route('manager.teachers.reactivate', $teacher->id))
            ->assertRedirect(route('manager.teachers.deactivated'))
            ->assertSessionHas('success', 'تمت إعادة تفعيل حساب المعلم.');

        $this->assertDatabaseHas('users', [
            'id' => $teacher->id,
            'status' => 'approved',
        ]);
    }

    public function test_teacher_directory_shows_assigned_class_and_section_together_without_duplicate_groups(): void
    {
        $school = School::create(['name' => 'مدرسة دليل المعلمين']);
        $manager = User::factory()->create([
            'role' => 'manager',
            'status' => 'approved',
            'username' => 'directory-section-manager',
            'phone' => '15550000157',
            'school_id' => $school->id,
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'directory-section-teacher',
            'phone' => '15550000158',
            'school_id' => $school->id,
        ]);
        $mother = User::factory()->create([
            'role' => 'mother',
            'status' => 'approved',
            'username' => 'directory-section-mother',
            'phone' => '15550000159',
        ]);

        foreach (['الشعبة الأولى', 'الشعبة الاولى', 'الشعبة الثانية'] as $index => $section) {
            $student = chaldrin::create([
                'mother_id' => $mother->id,
                'school_id' => $school->id,
                'name' => 'طالب الدليل ' . ($index + 1),
                'gender' => 'male',
                'Health_status' => 'جيد',
                'class' => 'الصف الثاني',
                'section' => $section,
                'age' => 6,
                'image' => 'child.jpg',
            ]);
            $student->teachers()->attach($teacher->id);
        }

        $response = $this->actingAs($manager)
            ->get(route('manager.teachers.index'))
            ->assertOk()
            ->assertSee('الصف الثاني / الشعبة الأولى')
            ->assertSee('الصف الثاني / الشعبة الثانية');

        $this->assertSame(1, substr_count($response->getContent(), 'الصف الثاني / الشعبة الأولى'));
    }

    public function test_manager_can_view_class_assignments_and_unassign_a_teacher_from_a_class(): void
    {
        $school = School::create(['name' => 'مدرسة التعيينات']);
        $manager = User::factory()->create([
            'role' => 'manager',
            'status' => 'approved',
            'username' => 'assignment-manager',
            'phone' => '15550000077',
            'school_name' => 'مدرسة التعيينات',
            'school_id' => $school->id,
        ]);
        $mother = User::factory()->create([
            'role' => 'mother',
            'username' => 'assignment-mother',
            'phone' => '15550000078',
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'assignment-teacher',
            'phone' => '15550000079',
            'school_name' => $manager->school_name,
            'school_id' => $school->id,
            'name' => 'المعلمة المسؤولة',
        ]);
        $child = chaldrin::create([
            'mother_id' => $mother->id,
            'school_id' => $school->id,
            'name' => 'طفل الصف الأول',
            'gender' => 'male',
            'Health_status' => 'جيدة',
            'class' => 'الأول',
            'age' => 6,
            'image' => 'child.jpg',
        ]);
        $child->teachers()->attach($teacher->id);

        foreach (['الثاني', 'الثالث'] as $className) {
            chaldrin::create([
                'mother_id' => $mother->id,
                'school_id' => $school->id,
                'name' => "طفل الصف {$className}",
                'gender' => 'male',
                'Health_status' => 'جيدة',
                'class' => $className,
                'age' => 6,
                'image' => 'child.jpg',
            ]);
        }

        $assignmentResponse = $this->actingAs($manager)
            ->get(route('manager.teacher-assignments', ['year' => $child->created_at->year]))
            ->assertOk()
            ->assertSee('تعيين أستاذ لصف دراسي')
            ->assertSee('الصف الأول')
            ->assertSee('المعلمة المسؤولة')
            ->assertSee(route('manager.unassign.class.quick'));

        $pageContent = $assignmentResponse->getContent();
        $firstGradePosition = strpos($pageContent, 'الصف الأول');
        $secondGradePosition = strpos($pageContent, 'الصف الثاني');
        $thirdGradePosition = strpos($pageContent, 'الصف الثالث');
        $this->assertNotFalse($firstGradePosition);
        $this->assertNotFalse($secondGradePosition);
        $this->assertNotFalse($thirdGradePosition);
        $this->assertTrue($firstGradePosition < $secondGradePosition);
        $this->assertTrue($secondGradePosition < $thirdGradePosition);

        $this->actingAs($manager)
            ->delete(route('manager.unassign.class.quick'), [
                'teacher_id' => $teacher->id,
                'year' => $child->created_at->year,
                'class' => 'الأول',
            ])
            ->assertRedirect(route('manager.teacher-assignments', ['year' => $child->created_at->year]))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('child_teacher', [
            'child_id' => $child->id,
            'teacher_id' => $teacher->id,
        ]);

        $this->actingAs($manager)
            ->get(route('manager.teacher-assignments', ['year' => $child->created_at->year]))
            ->assertOk()
            ->assertSee('لا يوجد معلمون معينون لهذا الصف.')
            ->assertDontSee('إلغاء التعيين');
    }

    public function test_assignment_page_uses_manager_class_and_section_options_and_assigns_only_that_group(): void
    {
        Notification::fake();

        $school = School::create([
            'name' => 'مدرسة الشعب',
            'classes' => ['الصف الثاني', 'الصف الثالث'],
            'sections' => ['الأولى', 'الثانية'],
        ]);
        $manager = User::factory()->create([
            'role' => 'manager',
            'status' => 'approved',
            'username' => 'section-assignment-manager',
            'phone' => '15550000151',
            'school_id' => $school->id,
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'section-assignment-teacher',
            'phone' => '15550000152',
            'school_id' => $school->id,
            'name' => 'معلم الشعب',
        ]);
        $mother = User::factory()->create([
            'role' => 'mother',
            'status' => 'approved',
            'username' => 'section-assignment-mother',
            'phone' => '15550000153',
        ]);

        $students = collect([
            ['name' => 'طالب الثانية الأولى', 'class' => 'الصف الثاني', 'section' => 'الأولى'],
            ['name' => 'طالب الثانية الثانية', 'class' => 'الصف الثاني', 'section' => 'الثانية'],
        ])->map(fn ($attributes) => chaldrin::create([
            'mother_id' => $mother->id,
            'school_id' => $school->id,
            'name' => $attributes['name'],
            'gender' => 'male',
            'Health_status' => 'جيد',
            'class' => $attributes['class'],
            'section' => $attributes['section'],
            'age' => 6,
            'image' => 'child.jpg',
        ]));
        $year = $students->first()->created_at->year;

        $this->actingAs($manager)
            ->get(route('manager.teacher-assignments', ['year' => $year]))
            ->assertOk()
            ->assertSee('data-bs-display="static"', false)
            ->assertSee('name="class"', false)
            ->assertSee('data-value="الصف الثالث"', false)
            ->assertSee('name="section"', false)
            ->assertSee('data-value="الأولى"', false)
            ->assertSee('data-value="الثانية"', false);

        $this->actingAs($manager)
            ->post(route('manager.assign.class.quick'), [
                'teacher_id' => $teacher->id,
                'year' => $year,
                'class' => 'الصف الثاني',
                'section' => 'الأولى',
            ])
            ->assertSessionHas('success', 'تم تعيين المعلم للصف والشعبة بنجاح.');

        $this->assertDatabaseHas('child_teacher', [
            'teacher_id' => $teacher->id,
            'child_id' => $students[0]->id,
        ]);
        $this->assertDatabaseMissing('child_teacher', [
            'teacher_id' => $teacher->id,
            'child_id' => $students[1]->id,
        ]);
    }

    public function test_manager_can_filter_a_teachers_assigned_students_by_section(): void
    {
        $school = School::create(['name' => 'مدرسة فلترة الشعب']);
        $manager = User::factory()->create([
            'role' => 'manager',
            'status' => 'approved',
            'username' => 'filter-sections-manager',
            'phone' => '15550000160',
            'school_id' => $school->id,
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'filter-sections-teacher',
            'phone' => '15550000161',
            'school_id' => $school->id,
        ]);
        $mother = User::factory()->create([
            'role' => 'mother',
            'status' => 'approved',
            'username' => 'filter-sections-mother',
            'phone' => '15550000162',
        ]);

        $students = collect([
            ['name' => 'طالب الشعبة أ', 'section' => 'الأولى'],
            ['name' => 'طالب الشعبة أ بصيغة مختلفة', 'section' => 'الاولى'],
            ['name' => 'طالب الشعبة ب', 'section' => 'الثانية'],
        ])->map(function ($attributes) use ($school, $mother, $teacher) {
            $student = chaldrin::create([
                'mother_id' => $mother->id,
                'school_id' => $school->id,
                'name' => $attributes['name'],
                'gender' => 'male',
                'Health_status' => 'جيد',
                'class' => 'الصف الثاني',
                'section' => $attributes['section'],
                'age' => 6,
                'image' => 'child.jpg',
            ]);
            $student->teachers()->attach($teacher->id);

            return $student;
        });
        $year = $students->first()->created_at->year;

        $response = $this->actingAs($manager)
            ->get(route('manager.teachers.assign', [
                'teacher' => $teacher->id,
                'year' => $year,
                'class' => 'الصف الثاني',
                'section' => 'الأولى',
            ]))
            ->assertOk()
            ->assertSee('name="section"', false)
            ->assertSee('طالب الشعبة أ بصيغة مختلفة')
            ->assertSee('طالب الشعبة أ')
            ->assertDontSee('طالب الشعبة ب');
        $this->assertSame(1, substr_count($response->getContent(), 'value="الأولى"'));
        $this->assertStringNotContainsString('value="الاولى"', $response->getContent());
    }

    public function test_assignment_page_merges_section_names_that_only_differ_by_hamza(): void
    {
        $school = School::create([
            'name' => 'مدرسة توحيد الشعب',
            'classes' => ['الصف الثاني'],
            'sections' => ['الشعبة الأولى'],
        ]);
        $manager = User::factory()->create([
            'role' => 'manager',
            'status' => 'approved',
            'username' => 'merge-sections-manager',
            'phone' => '15550000154',
            'school_id' => $school->id,
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'merge-sections-teacher',
            'phone' => '15550000155',
            'school_id' => $school->id,
            'name' => 'معلم واحد',
        ]);
        $mother = User::factory()->create([
            'role' => 'mother',
            'status' => 'approved',
            'username' => 'merge-sections-mother',
            'phone' => '15550000156',
        ]);

        $students = collect(['الشعبة الأولى', 'الشعبة الاولى'])->map(function ($section, $index) use ($mother, $school, $teacher) {
            $student = chaldrin::create([
                'mother_id' => $mother->id,
                'school_id' => $school->id,
                'name' => 'طالب ' . ($index + 1),
                'gender' => 'male',
                'Health_status' => 'جيد',
                'class' => 'الصف الثاني',
                'section' => $section,
                'age' => 6,
                'image' => 'child.jpg',
            ]);
            $student->teachers()->attach($teacher->id);
            return $student;
        });

        $response = $this->actingAs($manager)
            ->get(route('manager.teacher-assignments', ['year' => now()->year]))
            ->assertOk()
            ->assertSee('الصف الثاني — الشعبة الأولى')
            ->assertSee('معلم واحد');

        $this->assertSame(1, substr_count($response->getContent(), 'الصف الثاني — الشعبة الأولى'));

        $this->actingAs($manager)
            ->delete(route('manager.unassign.class.quick'), [
                'teacher_id' => $teacher->id,
                'year' => now()->year,
                'class' => 'الصف الثاني',
                'section' => 'الشعبة الأولى',
            ])
            ->assertSessionHas('success');

        foreach ($students as $student) {
            $this->assertDatabaseMissing('child_teacher', [
                'teacher_id' => $teacher->id,
                'child_id' => $student->id,
            ]);
        }
    }

    public function test_manager_cannot_deactivate_another_schools_teacher(): void
    {
        $school = School::create(['name' => 'مدرسة الأمل']);
        $otherSchool = School::create(['name' => 'مدرسة أخرى']);
        $manager = User::factory()->create([
            'role' => 'manager',
            'status' => 'approved',
            'username' => 'manager-school-a',
            'phone' => '15550000063',
            'school_name' => 'مدرسة الأمل',
            'school_id' => $school->id,
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'teacher-school-b',
            'phone' => '15550000064',
            'school_name' => 'مدرسة أخرى',
            'school_id' => $otherSchool->id,
        ]);

        $this->actingAs($manager)
            ->patch(route('manager.teachers.deactivate', $teacher->id))
            ->assertNotFound();

        $this->assertSame('approved', $teacher->fresh()->status);
    }

    public function test_manager_cannot_reactivate_another_schools_teacher(): void
    {
        $school = School::create(['name' => 'مدرسة الأمل']);
        $otherSchool = School::create(['name' => 'مدرسة أخرى']);
        $manager = User::factory()->create([
            'role' => 'manager',
            'status' => 'approved',
            'username' => 'manager-reactivate-a',
            'phone' => '15550000065',
            'school_name' => 'مدرسة الأمل',
            'school_id' => $school->id,
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'deactivated',
            'username' => 'teacher-reactivate-b',
            'phone' => '15550000066',
            'school_name' => 'مدرسة أخرى',
            'school_id' => $otherSchool->id,
        ]);

        $this->actingAs($manager)
            ->get(route('manager.teachers.deactivated'))
            ->assertOk()
            ->assertDontSee('teacher-reactivate-b');

        $this->actingAs($manager)
            ->patch(route('manager.teachers.reactivate', $teacher->id))
            ->assertNotFound();

        $this->assertSame('deactivated', $teacher->fresh()->status);
    }
}
