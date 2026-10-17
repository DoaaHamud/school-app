<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class TeacherProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_can_view_and_update_profile_on_the_same_page(): void
    {
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'profile-teacher',
            'phone' => '15550000081',
            'school_name' => 'مدرسة الأمل',
            'name' => 'سارة أحمد',
            'email' => 'sara@example.com',
        ]);

        $this->actingAs($teacher)
            ->get(route('teacher.profile'))
            ->assertOk()
            ->assertSee('value="سارة أحمد"', false)
            ->assertSee('value="sara@example.com"', false)
            ->assertSee('حفظ التغييرات')
            ->assertDontSee('تعديل البيانات')
            ->assertDontSee('حذف الحساب');

        $this->actingAs($teacher)
            ->put(route('teacher.profile.update'), [
                'name' => 'سارة محمد',
                'email' => 'sara.mohamed@example.com',
                'phone' => '15550000082',
            ])
            ->assertRedirect(route('teacher.profile'))
            ->assertSessionHas('success', 'تم تحديث البيانات الشخصية بنجاح.');

        $this->assertDatabaseHas('users', [
            'id' => $teacher->id,
            'name' => 'سارة محمد',
            'email' => 'sara.mohamed@example.com',
            'phone' => '15550000082',
        ]);
    }

    public function test_teacher_profile_has_no_separate_edit_route_or_account_delete_controls(): void
    {
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'profile-menu-teacher',
            'phone' => '15550000083',
        ]);

        $this->actingAs($teacher)
            ->get(route('teacher.dashboard'))
            ->assertOk()
            ->assertDontSee('تعديل البيانات')
            ->assertDontSee('حذف الحساب')
            ->assertDontSee('teacher.profile.edit');

        $this->assertFalse(Route::has('teacher.profile.edit'));
    }
}
