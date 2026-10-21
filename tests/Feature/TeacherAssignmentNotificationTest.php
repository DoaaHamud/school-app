<?php

namespace Tests\Feature;

use App\Models\chaldrin;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherAssignmentNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_assigning_a_class_notifies_the_teacher_and_repeated_assignment_does_not_duplicate_it(): void
    {
        $school = School::create(['name' => 'مدرسة الاختبار']);
        $otherSchool = School::create(['name' => 'مدرسة أخرى']);
        $manager = User::factory()->create([
            'role' => 'manager',
            'username' => 'manager-one',
            'phone' => '15550000011',
            'school_name' => 'مدرسة الاختبار',
            'school_id' => $school->id,
        ]);
        $mother = User::factory()->create([
            'role' => 'mother',
            'username' => 'mother-one',
            'phone' => '15550000012',
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'teacher-one',
            'phone' => '15550000013',
            'school_name' => $manager->school_name,
            'school_id' => $school->id,
        ]);
        $child = chaldrin::create([
            'mother_id' => $mother->id,
            'school_id' => $school->id,
            'name' => 'ليان',
            'gender' => 'female',
            'Health_status' => 'جيدة',
            'class' => 'الأول',
            'age' => 5,
            'image' => 'lian.jpg',
        ]);
        $secondChild = chaldrin::create([
            'mother_id' => $mother->id,
            'school_id' => $school->id,
            'name' => 'آدم',
            'gender' => 'male',
            'Health_status' => 'جيدة',
            'class' => 'الأول',
            'age' => 5,
            'image' => 'adam.jpg',
        ]);
        $otherManager = User::factory()->create([
            'role' => 'manager',
            'username' => 'manager-other-school',
            'phone' => '15550000015',
            'school_name' => 'مدرسة أخرى',
            'school_id' => $otherSchool->id,
        ]);
        $otherSchoolChild = chaldrin::create([
            'mother_id' => $mother->id,
            'school_id' => $otherSchool->id,
            'name' => 'نور',
            'gender' => 'female',
            'Health_status' => 'جيدة',
            'class' => 'الأول',
            'age' => 5,
            'image' => 'noor.jpg',
        ]);

        $assignmentData = [
            'teacher_id' => $teacher->id,
            'year' => $child->created_at->year,
            'class' => $child->class,
        ];

        $this->actingAs($manager)
            ->post(route('manager.assign.class.quick'), $assignmentData)
            ->assertRedirect();

        $this->assertEqualsCanonicalizing(
            [$child->id, $secondChild->id],
            $teacher->childrenAsTeacher()->pluck('chaldrins.id')->all()
        );
        $this->assertDatabaseMissing('child_teacher', [
            'child_id' => $otherSchoolChild->id,
            'teacher_id' => $teacher->id,
        ]);

        $notification = $teacher->notifications()->sole();
        $this->assertSame('الأول', $notification->data['class']);
        $this->assertSame(2, $notification->data['student_count']);
        $this->assertNull($notification->read_at);

        $this->actingAs($manager)
            ->post(route('manager.assign.class.quick'), $assignmentData)
            ->assertRedirect();

        $this->assertDatabaseCount('notifications', 1);

        $this->actingAs($teacher)
            ->get(route('teacher.dashboard'))
            ->assertOk()
            ->assertSee('تم إسناد 2 أطفال جدد من صف الأول إليكِ.');

        $otherTeacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'teacher-two',
            'phone' => '15550000014',
        ]);
        $this->actingAs($otherTeacher)
            ->get(route('teacher.notifications.open', $notification->id))
            ->assertNotFound();
        $this->assertNull($notification->fresh()->read_at);

        $this->actingAs($teacher)
            ->get(route('teacher.notifications.open', $notification->id))
            ->assertRedirect(route('teacher.classes'));

        $this->assertNotNull($notification->fresh()->read_at);
    }

    public function test_assigning_a_class_from_the_teacher_assignment_page_notifies_the_teacher(): void
    {
        $school = School::create(['name' => 'مدرسة الاختبار']);
        $manager = User::factory()->create([
            'role' => 'manager',
            'username' => 'manager-page',
            'phone' => '15550000021',
            'school_name' => 'مدرسة الاختبار',
            'school_id' => $school->id,
        ]);
        $mother = User::factory()->create([
            'role' => 'mother',
            'username' => 'mother-page',
            'phone' => '15550000022',
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'teacher-page',
            'phone' => '15550000023',
            'school_name' => $manager->school_name,
            'school_id' => $school->id,
        ]);
        $child = chaldrin::create([
            'mother_id' => $mother->id,
            'school_id' => $school->id,
            'name' => 'آدم',
            'gender' => 'male',
            'Health_status' => 'جيدة',
            'class' => 'الثاني',
            'age' => 6,
            'image' => 'adam.jpg',
        ]);

        $this->actingAs($manager)
            ->post(route('manager.teachers.assign.store', $teacher->id), [
                'year' => $child->created_at->year,
                'class' => $child->class,
            ])
            ->assertRedirect();

        $this->actingAs($manager)
            ->get(route('manager.teachers.assign', [
                'teacher' => $teacher->id,
                'year' => $child->created_at->year,
                'class' => $child->class,
            ]))
            ->assertOk()
            ->assertSee('آدم')
            ->assertDontSee('حفظ توزيع الطلاب');

        $notification = $teacher->notifications()->sole();
        $this->assertSame('الثاني', $notification->data['class']);
        $this->assertSame(1, $notification->data['student_count']);
    }
}
