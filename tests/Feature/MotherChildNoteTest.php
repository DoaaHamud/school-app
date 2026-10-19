<?php

namespace Tests\Feature;

use App\Models\chaldrin;
use App\Models\MotherChildNote;
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
            ->assertDontSee('إرسال ملاحظة للمعلمين');

        $this->actingAs($mother)
            ->get(route('mother.child_details', $child->id))
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

    public function test_teacher_can_reply_and_mother_can_view_reply_in_child_note_history(): void
    {
        $mother = User::factory()->create([
            'role' => 'mother',
            'username' => 'mother-note-reply',
            'phone' => '15550000073',
        ]);
        $teacher = $this->createTeacher('teacher-note-reply', '15550000074');
        $child = $this->createChild($mother);
        $child->teachers()->attach($teacher->id);

        $this->actingAs($mother)
            ->post(route('mother.child_notes.store', $child->id), [
                'teacher_id' => $teacher->id,
                'note' => 'أرجو إخباري عن تقدم ليان.',
            ])
            ->assertRedirect();

        $childNote = MotherChildNote::sole();

        $this->actingAs($teacher)
            ->get(route('teacher.mother_notes'))
            ->assertOk()
            ->assertSee('أرجو إخباري عن تقدم ليان.');

        $this->actingAs($teacher)
            ->post(route('teacher.mother_notes.reply', $childNote->id), [
                'reply' => 'تشارك ليان بفاعلية في الصف.',
                'reply_note_id' => $childNote->id,
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('mother_child_notes', [
            'id' => $childNote->id,
            'reply' => 'تشارك ليان بفاعلية في الصف.',
        ]);

        $this->actingAs($mother)
            ->get(route('mother.child_notes.index', $child->id))
            ->assertOk()
            ->assertSee('أرجو إخباري عن تقدم ليان.')
            ->assertSee('تشارك ليان بفاعلية في الصف.')
            ->assertSee('تم الرد');

        $replyNotification = $mother->notifications()->sole();
        $this->assertSame('mother_child_note_reply', $replyNotification->data['type']);

        $this->actingAs($mother)
            ->get(route('mother.notifications.open', $replyNotification->id))
            ->assertRedirect(route('mother.child_notes.index', $child->id));
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

    public function test_teacher_classes_show_each_childs_parent_name(): void
    {
        $mother = User::factory()->create([
            'role' => 'mother',
            'name' => 'ولي أمر ليان',
            'username' => 'mother-class-parent',
            'phone' => '15550000075',
        ]);
        $teacher = $this->createTeacher('teacher-class-parent', '15550000076');
        $child = $this->createChild($mother);
        $child->teachers()->attach($teacher->id);

        $this->actingAs($teacher)
            ->get(route('teacher.classes'))
            ->assertOk()
            ->assertSee('aria-label="الإشعارات"', false)
            ->assertSee('ولي الأمر')
            ->assertSee('ولي أمر ليان');
    }

    public function test_mother_can_send_a_note_to_a_selected_teacher_only(): void
    {
        $mother = User::factory()->create([
            'role' => 'mother',
            'username' => 'mother-selected-note',
            'phone' => '15550000067',
        ]);
        $teacher = $this->createTeacher('teacher-selected-note', '15550000068');
        $otherTeacher = $this->createTeacher('teacher-other-note', '15550000069');
        $child = $this->createChild($mother);
        $child->teachers()->attach([$teacher->id, $otherTeacher->id]);

        $this->actingAs($mother)
            ->get(route('mother.child_details', $child->id))
            ->assertOk()
            ->assertSee('aria-label="الإشعارات"', false)
            ->assertSee('إرسال ملاحظة للمعلمين')
            ->assertSee($teacher->name)
            ->assertSee('name="teacher_id"', false);

        $this->actingAs($mother)
            ->post(route('mother.child_notes.store', $child->id), [
                'teacher_id' => $teacher->id,
                'note' => 'يرجى التواصل معي.',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertSame(1, $teacher->notifications()->count());
        $this->assertSame(0, $otherTeacher->notifications()->count());
        $childNote = MotherChildNote::sole();

        $this->actingAs($otherTeacher)
            ->post(route('teacher.mother_notes.reply', $childNote->id), [
                'reply' => 'محاولة رد غير مصرّح بها.',
            ])
            ->assertNotFound();

        $this->assertNull($childNote->fresh()->reply);
    }

    public function test_mother_cannot_send_a_note_to_a_teacher_not_assigned_to_the_child(): void
    {
        $mother = User::factory()->create([
            'role' => 'mother',
            'username' => 'mother-invalid-teacher',
            'phone' => '15550000070',
        ]);
        $assignedTeacher = $this->createTeacher('teacher-assigned-note', '15550000071');
        $unassignedTeacher = $this->createTeacher('teacher-unassigned-note', '15550000072');
        $child = $this->createChild($mother);
        $child->teachers()->attach($assignedTeacher->id);

        $this->actingAs($mother)
            ->post(route('mother.child_notes.store', $child->id), [
                'teacher_id' => $unassignedTeacher->id,
                'note' => 'ملاحظة يجب ألا تصل.',
            ])
            ->assertRedirect()
            ->assertSessionHasErrors('teacher_id');

        $this->assertSame(0, $assignedTeacher->notifications()->count());
        $this->assertSame(0, $unassignedTeacher->notifications()->count());
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
