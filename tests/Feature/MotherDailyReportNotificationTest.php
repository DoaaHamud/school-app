<?php

namespace Tests\Feature;

use App\Models\chaldrin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MotherDailyReportNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_adding_a_child_report_notifies_the_mother_and_opening_it_marks_it_as_read(): void
    {
        $mother = User::factory()->create([
            'role' => 'mother',
            'status' => 'approved',
            'username' => 'mother-one',
            'phone' => '15550000001',
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'teacher-one',
            'phone' => '15550000002',
        ]);
        $child = chaldrin::create([
            'mother_id' => $mother->id,
            'name' => 'ليان',
            'gender' => 'female',
            'Health_status' => 'جيدة',
            'class' => 'الأول',
            'age' => 5,
            'image' => 'lian.jpg',
        ]);
        $teacher->childrenAsTeacher()->attach($child);

        $this->actingAs($teacher)
            ->post(route('teacher.daily_store', $child->id), [
                'topic' => 'الرسم',
                'result' => 90,
                'notes' => 'شاركت بفاعلية',
                'report_date' => now()->toDateString(),
            ])
            ->assertRedirect();

        $this->assertDatabaseCount('daily_variables', 1);
        $notification = $mother->notifications()->sole();
        $this->assertSame($child->id, $notification->data['child_id']);
        $this->assertSame('ليان', $notification->data['child_name']);
        $this->assertSame('الرسم', $notification->data['topic']);
        $this->assertNull($notification->read_at);

        $this->actingAs($mother)
            ->get(route('mother.dashboard'))
            ->assertOk()
            ->assertSee('تمت إضافة تقرير جديد عن ليان: الرسم');

        $otherMother = User::factory()->create([
            'role' => 'mother',
            'status' => 'approved',
            'username' => 'mother-two',
            'phone' => '15550000003',
        ]);
        $this->actingAs($otherMother)
            ->get(route('mother.notifications.open', $notification->id))
            ->assertNotFound();
        $this->assertNull($notification->fresh()->read_at);

        $this->actingAs($mother)
            ->get(route('mother.notifications.open', $notification->id))
            ->assertRedirect(route('mother.child_details', $child->id));

        $this->assertNotNull($notification->fresh()->read_at);
    }
}
