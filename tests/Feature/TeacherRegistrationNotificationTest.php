<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherRegistrationNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_registration_notifies_only_approved_managers_of_the_selected_school(): void
    {
        $manager = User::factory()->create([
            'role' => 'manager',
            'status' => 'approved',
            'username' => 'manager-school-one',
            'phone' => '15550000031',
            'school_name' => 'مدرسة الندى',
        ]);
        $sameSchoolManager = User::factory()->create([
            'role' => 'manager',
            'status' => 'approved',
            'username' => 'manager-school-two',
            'phone' => '15550000032',
            'school_name' => 'مدرسة الندى',
        ]);
        $otherSchoolManager = User::factory()->create([
            'role' => 'manager',
            'status' => 'approved',
            'username' => 'manager-other-school',
            'phone' => '15550000033',
            'school_name' => 'مدرسة أخرى',
        ]);

        $this->get(route('register'))
            ->assertOk()
            ->assertSee('مدرسة الندى');

        $this->post(route('register'), [
            'name' => 'المعلمة الجديدة',
            'username' => 'new-teacher',
            'email' => 'new-teacher@example.test',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'teacher',
            'phone' => '15550000034',
            'school_name' => 'مدرسة الندى',
        ])->assertRedirect(route('login'));

        $teacher = User::where('username', 'new-teacher')->firstOrFail();
        $this->assertSame('pending', $teacher->status);
        $this->assertSame(1, $manager->notifications()->count());
        $this->assertSame(1, $sameSchoolManager->notifications()->count());
        $this->assertCount(0, $otherSchoolManager->notifications);
        $this->assertDatabaseCount('notifications', 2);

        $notification = $manager->notifications()->sole();
        $this->assertSame($teacher->id, $notification->data['teacher_id']);

        $this->actingAs($manager)
            ->get(route('manager.dashboard'))
            ->assertOk()
            ->assertSee('طلب انضمام معلم جديد: المعلمة الجديدة');

        $this->actingAs($otherSchoolManager)
            ->get(route('manager.notifications.open', $notification->id))
            ->assertNotFound();
        $this->assertNull($notification->fresh()->read_at);

        $this->actingAs($manager)
            ->get(route('manager.notifications.open', $notification->id))
            ->assertRedirect(route('manager.dashboard'));
        $this->assertNotNull($notification->fresh()->read_at);

        $this->actingAs($otherSchoolManager)
            ->patch(route('manager.teachers.approve', $teacher->id))
            ->assertNotFound();
        $this->assertSame('pending', $teacher->fresh()->status);
    }

    public function test_teacher_registration_requires_a_school_with_an_approved_manager(): void
    {
        $this->post(route('register'), [
            'name' => 'معلمة بلا مدرسة',
            'username' => 'teacher-no-school',
            'email' => 'teacher-no-school@example.test',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'teacher',
            'phone' => '15550000041',
        ])->assertSessionHasErrors('school_name');

        $this->assertDatabaseMissing('users', [
            'username' => 'teacher-no-school',
        ]);
    }
}
