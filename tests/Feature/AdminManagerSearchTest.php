<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagerSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_approving_a_manager_creates_a_school_and_links_existing_school_users(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'username' => 'admin-school-approval',
            'phone' => '15550000045',
        ]);
        $manager = User::factory()->create([
            'role' => 'manager',
            'status' => 'pending',
            'username' => 'manager-school-approval',
            'phone' => '15550000046',
            'school_name' => 'مدرسة الربط',
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'pending',
            'username' => 'teacher-school-approval',
            'phone' => '15550000047',
            'school_name' => 'مدرسة الربط',
        ]);

        $this->actingAs($admin)
            ->patch(route('admin.managers.approve', $manager))
            ->assertRedirect();

        $this->assertDatabaseHas('schools', [
            'id' => $manager->fresh()->school_id,
            'name' => 'مدرسة الربط',
        ]);
        $this->assertSame($manager->fresh()->school_id, $teacher->fresh()->school_id);
    }

    public function test_admin_can_search_active_managers_by_name(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'username' => 'admin-manager-search',
            'phone' => '15550000041',
        ]);
        User::factory()->create([
            'role' => 'manager',
            'status' => 'approved',
            'name' => 'سارة أحمد',
            'username' => 'manager-sara-search',
            'phone' => '15550000042',
        ]);
        User::factory()->create([
            'role' => 'manager',
            'status' => 'approved',
            'name' => 'ليلى حسن',
            'username' => 'manager-layla-search',
            'phone' => '15550000043',
        ]);
        User::factory()->create([
            'role' => 'manager',
            'status' => 'deactivated',
            'name' => 'سارة غير مفعلة',
            'username' => 'manager-deactivated-search',
            'phone' => '15550000044',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard', ['manager_search' => 'سارة']))
            ->assertOk()
            ->assertSee('سارة أحمد')
            ->assertDontSee('ليلى حسن')
            ->assertDontSee('سارة غير مفعلة')
            ->assertSee('name="manager_search"', false);
    }

    public function test_deactivated_manager_list_shows_their_school_after_email(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'username' => 'admin-deactivated-school',
            'phone' => '15550000048',
        ]);
        $school = School::create(['name' => 'مدرسة النور']);
        User::factory()->create([
            'role' => 'manager',
            'status' => 'deactivated',
            'username' => 'manager-deactivated-school',
            'phone' => '15550000049',
            'school_id' => $school->id,
            'email' => 'manager@example.com',
        ]);

        $response = $this->actingAs($admin)
            ->get(route('admin.managers.deactivated'))
            ->assertOk()
            ->assertSee('البريد الإلكتروني')
            ->assertSee('اسم المدرسة')
            ->assertSee('manager@example.com')
            ->assertSee('مدرسة النور');

        $this->assertTrue(
            strpos($response->getContent(), 'manager@example.com')
                < strpos($response->getContent(), 'مدرسة النور')
        );
    }
}
