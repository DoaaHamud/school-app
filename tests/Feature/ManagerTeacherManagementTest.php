<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManagerTeacherManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_manage_approved_teachers_from_the_teacher_directory(): void
    {
        $manager = User::factory()->create([
            'role' => 'manager',
            'status' => 'approved',
            'username' => 'teacher-manager',
            'phone' => '15550000061',
            'school_name' => 'مدرسة الأمل',
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'teacher-to-deactivate',
            'phone' => '15550000062',
            'school_name' => $manager->school_name,
            'name' => 'سارة أحمد',
        ]);

        $this->actingAs($manager)
            ->get(route('manager.dashboard'))
            ->assertOk()
            ->assertSee('دليل الأساتذة')
            ->assertSee(route('manager.teachers.index'))
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

    public function test_manager_cannot_deactivate_another_schools_teacher(): void
    {
        $manager = User::factory()->create([
            'role' => 'manager',
            'status' => 'approved',
            'username' => 'manager-school-a',
            'phone' => '15550000063',
            'school_name' => 'مدرسة الأمل',
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'teacher-school-b',
            'phone' => '15550000064',
            'school_name' => 'مدرسة أخرى',
        ]);

        $this->actingAs($manager)
            ->patch(route('manager.teachers.deactivate', $teacher->id))
            ->assertNotFound();

        $this->assertSame('approved', $teacher->fresh()->status);
    }

    public function test_manager_cannot_reactivate_another_schools_teacher(): void
    {
        $manager = User::factory()->create([
            'role' => 'manager',
            'status' => 'approved',
            'username' => 'manager-reactivate-a',
            'phone' => '15550000065',
            'school_name' => 'مدرسة الأمل',
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'deactivated',
            'username' => 'teacher-reactivate-b',
            'phone' => '15550000066',
            'school_name' => 'مدرسة أخرى',
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
