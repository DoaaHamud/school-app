<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagerSearchTest extends TestCase
{
    use RefreshDatabase;

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
}
