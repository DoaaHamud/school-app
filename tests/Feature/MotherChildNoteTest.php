<?php

namespace Tests\Feature;

use App\Models\chaldrin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MotherChildNoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_mother_note_is_sent_to_every_teacher_assigned_to_the_child(): void
    {
        $mother = User::factory()->create([
            'role' => 'mother',
            'username' => 'mother-note',
            'phone' => '15550000061',
        ]);
        $firstTeacher = $this->createTeacher('teacher-note-one', '15550000062');
        $secondTeacher = $this->createTeacher('teacher-note-two', '15550000063');
        $unassignedTeacher = $this->createTeacher('teacher-note-three', '15550000064');
        $child = $this->createChild($mother);
        $child->teachers()->attach([$firstTeacher->id, $secondTeacher->id]);

        $this->actingAs($mother)
            ->get(route('mother.dashboard'))
            ->assertOk()
            ->assertSee($firstTeacher->name)
            ->assertSee($secondTeacher->name)
            ->assertSee(route('mother.child_notes.store', $child->id));

        $this->actingAs($mother)
            ->post(route('mother.child_notes.store', $child->id), [
                'note_child_id' => $child->id,
                'note' => 'يرجى متابعة القراءة في المنزل.',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseCount('notifications', 2);
        foreach ([$firstTeacher, $secondTeacher] as $teacher) {
            $notification = $teacher->notifications()->sole();
            $this->assertSame('mother_child_note', $notification->data['type']);
            $this->assertSame($child->id, $notification->data['child_id']);
            $this->assertSame('يرجى متابعة القراءة في المنزل.', $notification->data['note']);
        }

        $this->assertSame(0, $unassignedTeacher->notifications()->count());
    }

    public function test_mother_cannot_send_a_note_about_another_mothers_child(): void
    {
        $mother = User::factory()->create([
            'role' => 'mother',
            'username' => 'mother-note-outsider',
            'phone' => '15550000065',
        ]);
        $childOwner = User::factory()->create([
            'role' => 'mother',
            'username' => 'mother-note-owner',
            'phone' => '15550000066',
        ]);
        $child = $this->createChild($childOwner);

        $this->actingAs($mother)
            ->post(route('mother.child_notes.store', $child->id), [
                'note' => 'ملاحظة غير مصرح بها',
            ])
            ->assertNotFound();

        $this->assertDatabaseCount('notifications', 0);
    }

    private function createTeacher(string $username, string $phone): User
    {
        return User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => $username,
            'phone' => $phone,
        ]);
    }

    private function createChild(User $mother): chaldrin
    {
        return chaldrin::create([
            'mother_id' => $mother->id,
            'name' => 'ليان',
            'gender' => 'female',
            'Health_status' => 'جيدة',
            'class' => 'الأول',
            'age' => 5,
            'image' => 'lian.jpg',
        ]);
    }
}
