<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManagerBrandingProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_branding_settings_are_available_from_profile_and_saved_there(): void
    {
        $manager = User::factory()->create([
            'role' => 'manager',
            'status' => 'approved',
            'username' => 'branding-manager',
            'phone' => '15550000051',
            'school_name' => 'مدرسة قديمة',
        ]);

        $this->actingAs($manager)
            ->get(route('manager.profile'))
            ->assertOk()
            ->assertSee('تخصيص الهوية البصرية')
            ->assertSee(route('manager.settings.update'))
            ->assertSee(route('manager.profile.update'))
            ->assertSee('name="name"', false)
            ->assertDontSee('manager.profile.edit');

        $this->actingAs($manager)
            ->put(route('manager.profile.update'), [
                'name' => 'مدير محدث',
                'email' => $manager->email,
                'phone' => '15550000052',
            ])
            ->assertRedirect(route('manager.profile'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $manager->id,
            'name' => 'مدير محدث',
            'phone' => '15550000052',
        ]);

        $this->actingAs($manager)
            ->put(route('manager.settings.update'), [
                'school_name' => 'مدرسة جديدة',
                'primary_color' => '#123456',
            ])
            ->assertRedirect(route('manager.profile'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $manager->id,
            'school_name' => 'مدرسة جديدة',
            'primary_color' => '#123456',
        ]);

        $this->actingAs($manager)
            ->get(route('manager.dashboard'))
            ->assertOk()
            ->assertDontSee('تخصيص الهوية البصرية واسم المدرسة وألوان التطبيق');
    }
}
