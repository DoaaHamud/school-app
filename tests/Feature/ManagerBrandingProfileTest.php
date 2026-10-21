<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ManagerBrandingProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_branding_settings_are_available_from_profile_and_saved_there(): void
    {
        $school = School::create(['name' => 'مدرسة قديمة']);
        $manager = User::factory()->create([
            'role' => 'manager',
            'status' => 'approved',
            'username' => 'branding-manager',
            'phone' => '15550000051',
            'school_id' => $school->id,
        ]);

        $this->actingAs($manager->fresh())
            ->get(route('manager.profile'))
            ->assertOk()
            ->assertSee('تخصيص معلومات وهيكلة المدرسة')
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
                'classes' => 'روضة، الأول' . PHP_EOL . 'الثاني',
                'sections' => 'أ، ب',
                'subjects' => 'الرياضيات، العلوم',
            ])
            ->assertRedirect(route('manager.profile'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('schools', [
            'id' => $school->id,
            'name' => 'مدرسة جديدة',
            'color' => '#123456',
            'subjects' => 'الرياضيات، العلوم',
        ]);
        $this->assertSame(['روضة', 'الأول', 'الثاني'], $school->fresh()->classes);
        $this->assertSame(['أ', 'ب'], $school->fresh()->sections);

        $this->actingAs($manager->fresh())
            ->get(route('manager.profile'))
            ->assertOk()
            ->assertSee('روضة، الأول، الثاني')
            ->assertSee('أ، ب');

        $this->actingAs($manager)
            ->get(route('manager.dashboard'))
            ->assertOk()
            ->assertDontSee('تخصيص الهوية البصرية واسم المدرسة وألوان التطبيق');
    }

    public function test_school_subjects_are_stored_in_a_single_plural_column(): void
    {
        $this->assertTrue(Schema::hasColumn('schools', 'subjects'));
        $this->assertFalse(Schema::hasColumn('schools', 'subject'));
    }
}
