<?php

namespace Tests\Feature;

use App\Models\chaldrin;
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
        $pendingTeacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'pending',
            'username' => 'pending-teacher-dashboard',
            'phone' => '15550000067',
            'school_name' => $manager->school_name,
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

    public function test_manager_can_view_class_assignments_and_unassign_a_teacher_from_a_class(): void
    {
        $manager = User::factory()->create([
            'role' => 'manager',
            'status' => 'approved',
            'username' => 'assignment-manager',
            'phone' => '15550000077',
            'school_name' => 'مدرسة التعيينات',
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
            'name' => 'المعلمة المسؤولة',
        ]);
        $child = chaldrin::create([
            'mother_id' => $mother->id,
            'manager_id' => $manager->id,
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
                'manager_id' => $manager->id,
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
