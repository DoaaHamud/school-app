<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MotherProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_mother_can_view_and_update_profile_on_the_same_page(): void
    {
        $mother = User::factory()->create([
            'role' => 'mother',
            'status' => 'approved',
            'name' => 'سارة أحمد',
            'username' => 'mother-profile',
            'email' => 'sara@example.com',
            'phone' => '15550000051',
        ]);

        $this->actingAs($mother)
            ->get(route('mother.profile'))
            ->assertOk()
            ->assertSee('value="سارة أحمد"', false)
            ->assertSee('value="sara@example.com"', false)
            ->assertSee('حفظ التغييرات')
            ->assertDontSee('تعديل البيانات');

        $this->actingAs($mother)
            ->put(route('mother.profile.update'), [
                'name' => 'سارة محمد',
                'email' => 'sara.updated@example.com',
                'phone' => '15550000052',
            ])
            ->assertRedirect(route('mother.profile'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $mother->id,
            'name' => 'سارة محمد',
            'email' => 'sara.updated@example.com',
            'phone' => '15550000052',
        ]);
    }

    public function test_separate_mother_profile_edit_route_is_removed(): void
    {
        $this->assertFalse(\Illuminate\Support\Facades\Route::has('mother.profile.edit'));
    }
}
