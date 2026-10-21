<?php

namespace Tests\Feature;

use App\Models\School;
use App\Models\SchoolMotherRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolMotherRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_mother_can_request_to_join_a_school_without_being_assigned_school_id(): void
    {
        $school = School::create(['name' => 'مدرسة الندى']);
        $secondSchool = School::create(['name' => 'مدرسة ثانية']);
        $manager = $this->managerFor($school, 'request-manager');
        $this->managerFor($secondSchool, 'second-request-manager');
        $mother = User::factory()->create([
            'role' => 'mother',
            'status' => 'approved',
            'username' => 'request-mother',
            'phone' => '15550000111',
        ]);

        $this->actingAs($mother)
            ->get(route('mother.school_requests'))
            ->assertOk()
            ->assertSee('اختاري المدرسة')
            ->assertSee('طلبات الانضمام');

        $this->actingAs($mother)
            ->get(route('mother.dashboard'))
            ->assertOk()
            ->assertSee('الانضمام إلى مدرسة جديدة')
            ->assertSee(route('mother.school_requests'));

        $this->actingAs($mother)
            ->post(route('mother.school_requests.store'), ['school_id' => $school->id])
            ->assertSessionHas('success', 'تم إرسال طلب الانضمام إلى المدرسة بانتظار موافقة المدير.');
        $this->actingAs($mother)
            ->post(route('mother.school_requests.store'), ['school_id' => $secondSchool->id])
            ->assertSessionHas('success', 'تم إرسال طلب الانضمام إلى المدرسة بانتظار موافقة المدير.');

        $this->assertDatabaseCount('school_mother_requests', 2);
        $this->assertSame(
            ['pending', 'pending'],
            SchoolMotherRequest::orderBy('school_id')->pluck('status')->all()
        );
        $this->assertNull($mother->fresh()->school_id);

        $this->actingAs($manager)
            ->get(route('manager.dashboard'))
            ->assertOk()
            ->assertSee('request-mother')
            ->assertSee('طلبات انضمام أولياء الأمور');
    }

    public function test_mother_registration_does_not_assign_a_school_even_if_one_is_submitted(): void
    {
        $school = School::create(['name' => 'مدرسة التسجيل']);
        $this->managerFor($school, 'registration-manager');

        $this->post(route('register'), [
            'name' => 'أم جديدة',
            'username' => 'new-registration-mother',
            'email' => 'new-registration-mother@example.test',
            'phone' => '15550000116',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'mother',
            'school_name' => $school->name,
        ])->assertRedirect(route('mother.dashboard'));

        $this->assertDatabaseHas('users', [
            'username' => 'new-registration-mother',
            'role' => 'mother',
            'school_id' => null,
            'school_name' => null,
        ]);
        $this->assertDatabaseCount('school_mother_requests', 0);
    }

    public function test_approved_mother_is_available_to_the_school_teacher_only_after_manager_approval(): void
    {
        $school = School::create(['name' => 'مدرسة الندى']);
        $otherSchool = School::create(['name' => 'مدرسة أخرى']);
        $manager = $this->managerFor($school, 'approval-manager');
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'approval-teacher',
            'phone' => '15550000112',
            'school_id' => $school->id,
        ]);
        $mother = User::factory()->create([
            'role' => 'mother',
            'status' => 'approved',
            'username' => 'approval-mother',
            'phone' => '15550000113',
        ]);
        $otherMother = User::factory()->create([
            'role' => 'mother',
            'status' => 'approved',
            'username' => 'other-school-mother',
            'phone' => '15550000114',
        ]);
        $request = SchoolMotherRequest::create([
            'school_id' => $school->id,
            'mother_id' => $mother->id,
            'status' => 'pending',
        ]);
        SchoolMotherRequest::create([
            'school_id' => $otherSchool->id,
            'mother_id' => $otherMother->id,
            'status' => 'approved',
        ]);

        $this->actingAs($teacher)
            ->get(route('teacher.students.create'))
            ->assertOk()
            ->assertDontSee('@approval-mother')
            ->assertDontSee('@other-school-mother');

        $this->actingAs($manager)
            ->patch(route('manager.mothers.requests.approve', $request->id))
            ->assertSessionHas('success');

        $this->actingAs($teacher)
            ->get(route('teacher.students.create'))
            ->assertOk()
            ->assertSee('@approval-mother')
            ->assertDontSee('@other-school-mother');
    }

    public function test_teacher_student_form_lists_only_classes_configured_by_the_school_manager(): void
    {
        $school = School::create([
            'name' => 'مدرسة الصفوف',
            'classes' => 'روضة، الأول' . PHP_EOL . 'الثاني',
            'sections' => 'أ، ب',
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'classes-teacher',
            'phone' => '15550000117',
            'school_id' => $school->id,
        ]);

        $this->actingAs($teacher)
            ->get(route('teacher.students.create'))
            ->assertOk()
            ->assertSee('<select id="student-class" name="class" class="form-select" required>', false)
            ->assertSee('value="روضة"', false)
            ->assertSee('value="الأول"', false)
            ->assertSee('value="الثاني"', false)
            ->assertSee('name="section"', false)
            ->assertSee('اختر الشعبة')
            ->assertSee('value="أ"', false)
            ->assertSee('value="ب"', false)
            ->assertDontSee('<input type="text" name="class"', false);
    }

    public function test_manager_cannot_approve_another_schools_mother_request(): void
    {
        $school = School::create(['name' => 'مدرسة الندى']);
        $otherSchool = School::create(['name' => 'مدرسة أخرى']);
        $manager = $this->managerFor($school, 'scoped-manager');
        $mother = User::factory()->create([
            'role' => 'mother',
            'status' => 'approved',
            'username' => 'scoped-mother',
            'phone' => '15550000115',
        ]);
        $request = SchoolMotherRequest::create([
            'school_id' => $otherSchool->id,
            'mother_id' => $mother->id,
            'status' => 'pending',
        ]);

        $this->actingAs($manager)
            ->patch(route('manager.mothers.requests.approve', $request->id))
            ->assertNotFound();

        $this->assertSame('pending', $request->fresh()->status);
    }

    private function managerFor(School $school, string $username): User
    {
        return User::factory()->create([
            'role' => 'manager',
            'status' => 'approved',
            'username' => $username,
            'phone' => (string) fake()->unique()->numberBetween(15550000200, 15550000999),
            'school_id' => $school->id,
            'school_name' => $school->name,
        ]);
    }
}
