<?php

namespace Tests\Feature;

use App\Models\chaldrin;
use App\Models\Daily_variables;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManagerStudentActivationTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_deactivate_and_reactivate_a_student_without_losing_reports(): void
    {
        $manager = User::factory()->create([
            'role' => 'manager',
            'username' => 'students-manager',
            'phone' => '15550000071',
            'school_name' => 'مدرسة الأمل',
        ]);
        $mother = User::factory()->create([
            'role' => 'mother',
            'username' => 'students-mother',
            'phone' => '15550000072',
        ]);
        $student = chaldrin::create([
            'mother_id' => $mother->id,
            'manager_id' => $manager->id,
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
        $manager = User::factory()->create([
            'role' => 'manager',
            'username' => 'students-manager-one',
            'phone' => '15550000073',
            'school_name' => 'مدرسة الأمل',
        ]);
        $otherManager = User::factory()->create([
            'role' => 'manager',
            'username' => 'students-manager-two',
            'phone' => '15550000074',
            'school_name' => 'مدرسة أخرى',
        ]);
        $mother = User::factory()->create([
            'role' => 'mother',
            'username' => 'students-mother-two',
            'phone' => '15550000075',
        ]);
        $student = chaldrin::create([
            'mother_id' => $mother->id,
            'manager_id' => $otherManager->id,
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
