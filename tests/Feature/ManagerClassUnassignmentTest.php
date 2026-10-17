<?php

namespace Tests\Feature;

use App\Models\chaldrin;
use App\Models\Daily_variables;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManagerClassUnassignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_unassign_a_teacher_from_a_class_without_deleting_students_or_reports(): void
    {
        $manager = User::factory()->create([
            'role' => 'manager',
            'username' => 'manager-unassign',
            'phone' => '15550000031',
            'school_name' => 'مدرسة الإسناد',
        ]);
        $mother = User::factory()->create([
            'role' => 'mother',
            'username' => 'mother-unassign',
            'phone' => '15550000032',
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'teacher-unassign',
            'phone' => '15550000033',
            'school_name' => $manager->school_name,
        ]);
        $otherTeacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'teacher-unassign-two',
            'phone' => '15550000034',
            'school_name' => $manager->school_name,
        ]);

        $classChild = $this->createChild($mother, $manager, 'الأول');
        $otherClassChild = $this->createChild($mother, $manager, 'الثاني');

        $teacher->childrenAsTeacher()->attach([$classChild->id, $otherClassChild->id]);
        $otherTeacher->childrenAsTeacher()->attach($classChild->id);
        $report = Daily_variables::create([
            'child_id' => $classChild->id,
            'teacher_id' => $teacher->id,
            'topic' => 'تقرير محفوظ',
            'result' => 90,
            'report_date' => now(),
        ]);

        $this->actingAs($manager)
            ->delete(route('manager.unassign.class.quick'), [
                'teacher_id' => $teacher->id,
                'year' => $classChild->created_at->year,
                'class' => 'الأول',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('child_teacher', [
            'child_id' => $classChild->id,
            'teacher_id' => $teacher->id,
        ]);
        $this->assertDatabaseHas('child_teacher', [
            'child_id' => $classChild->id,
            'teacher_id' => $otherTeacher->id,
        ]);
        $this->assertDatabaseHas('child_teacher', [
            'child_id' => $otherClassChild->id,
            'teacher_id' => $teacher->id,
        ]);
        $this->assertDatabaseHas('chaldrins', ['id' => $classChild->id]);
        $this->assertDatabaseHas('daily_variables', ['id' => $report->id]);
    }

    private function createChild(User $mother, User $manager, string $class): chaldrin
    {
        return chaldrin::create([
            'mother_id' => $mother->id,
            'manager_id' => $manager->id,
            'name' => 'طالب ' . $class,
            'gender' => 'female',
            'Health_status' => 'جيدة',
            'class' => $class,
            'age' => 5,
            'image' => 'student.jpg',
        ]);
    }
}
