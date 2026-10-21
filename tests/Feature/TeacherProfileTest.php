<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\School;
use App\Models\chaldrin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TeacherProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_can_view_and_update_profile_on_the_same_page(): void
    {
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'profile-teacher',
            'phone' => '15550000081',
            'name' => 'سارة أحمد',
            'email' => 'sara@example.com',
        ]);

        $this->actingAs($teacher)
            ->get(route('teacher.profile'))
            ->assertOk()
            ->assertSee('value="سارة أحمد"', false)
            ->assertSee('value="sara@example.com"', false)
            ->assertSee('حفظ التغييرات')
            ->assertDontSee('تعديل البيانات')
            ->assertDontSee('حذف الحساب');

        $this->actingAs($teacher)
            ->put(route('teacher.profile.update'), [
                'name' => 'سارة محمد',
                'email' => 'sara.mohamed@example.com',
                'phone' => '15550000082',
            ])
            ->assertRedirect(route('teacher.profile'))
            ->assertSessionHas('success', 'تم تحديث البيانات الشخصية بنجاح.');

        $this->assertDatabaseHas('users', [
            'id' => $teacher->id,
            'name' => 'سارة محمد',
            'email' => 'sara.mohamed@example.com',
            'phone' => '15550000082',
        ]);
    }

    public function test_teacher_profile_has_no_separate_edit_route_or_account_delete_controls(): void
    {
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'profile-menu-teacher',
            'phone' => '15550000083',
        ]);

        $this->actingAs($teacher)
            ->get(route('teacher.dashboard'))
            ->assertOk()
            ->assertDontSee('تعديل البيانات')
            ->assertDontSee('حذف الحساب')
            ->assertDontSee('teacher.profile.edit');

        $this->assertFalse(Route::has('teacher.profile.edit'));
    }

    public function test_teacher_dashboard_uses_branding_from_the_related_school(): void
    {
        $school = School::create([
            'name' => 'مدرسة المعلم',
            'logo' => 'schools/logo.png',
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'school-branding-teacher',
            'phone' => '15550000084',
            'school_id' => $school->id,
        ]);

        $this->actingAs($teacher)
            ->get(route('teacher.dashboard'))
            ->assertOk()
            ->assertSee('مدرسة المعلم')
            ->assertSee('storage/schools/logo.png');
    }

    public function test_teacher_classes_are_grouped_and_searchable_by_class_and_section(): void
    {
        $school = School::create(['name' => 'مدرسة الصفوف']);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'classes-filter-teacher',
            'phone' => '15550000090',
            'school_id' => $school->id,
        ]);
        $mother = User::factory()->create([
            'role' => 'mother',
            'status' => 'approved',
            'username' => 'classes-filter-mother',
            'phone' => '15550000091',
        ]);

        foreach ([
            ['name' => 'طالب الثالث أ', 'class' => 'الثالث', 'section' => 'الأولى'],
            ['name' => 'طالب ثالث آخر أ', 'class' => 'الثالث', 'section' => 'الأولى'],
            ['name' => 'طالب الثالث أ بصيغة مختلفة', 'class' => 'الثالث', 'section' => 'الاولى'],
            ['name' => 'طالب الثالث ب', 'class' => 'الثالث', 'section' => 'الثانية'],
            ['name' => 'طالب الرابع أ', 'class' => 'الرابع', 'section' => 'الأولى'],
        ] as $studentData) {
            $student = chaldrin::create([
                'mother_id' => $mother->id,
                'school_id' => $school->id,
                'name' => $studentData['name'],
                'gender' => 'male',
                'Health_status' => 'جيد',
                'class' => $studentData['class'],
                'section' => $studentData['section'],
                'age' => 6,
                'image' => 'student.png',
            ]);
            $teacher->childrenAsTeacher()->attach($student->id);
        }

        $response = $this->actingAs($teacher)
            ->get(route('teacher.classes'))
            ->assertOk()
            ->assertSee('name="search_section"', false)
            ->assertSee('طالب الثالث أ')
            ->assertSee('طالب ثالث آخر أ')
            ->assertSee('طالب الثالث أ بصيغة مختلفة')
            ->assertSee('الصف: الثالث')
            ->assertSee('الشعبة: الأولى')
            ->assertSee('الشعبة: الثانية')
            ->assertSee('الصف: الرابع');
        $this->assertSame(2, substr_count($response->getContent(), 'الصف: الثالث'));

        $this->actingAs($teacher)
            ->get(route('teacher.classes', ['search_section' => 'الأولى']))
            ->assertOk()
            ->assertSee('طالب الثالث أ')
            ->assertSee('طالب الثالث أ بصيغة مختلفة')
            ->assertSee('طالب الرابع أ')
            ->assertDontSee('طالب الثالث ب')
            ->assertDontSee('الشعبة: الثانية');
    }

    public function test_daily_report_topic_dropdown_lists_school_subjects_and_custom_entry(): void
    {
        $school = School::create([
            'name' => 'مدرسة المواد',
            'subjects' => 'الرياضيات، العلوم' . PHP_EOL . 'اللغة العربية',
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'daily-subject-teacher',
            'phone' => '15550000085',
            'school_id' => $school->id,
        ]);

        $this->actingAs($teacher)
            ->get(route('teacher.daily_variables'))
            ->assertOk()
            ->assertSee('<select name="topic_subject" id="topic_subject" class="form-select" required>', false)
            ->assertSee('value="الرياضيات"', false)
            ->assertSee('value="العلوم"', false)
            ->assertSee('value="اللغة العربية"', false)
            ->assertSee('value="__custom__"', false)
            ->assertSee('name="custom_topic"', false)
            ->assertDontSee('list="report-topics"', false);
    }

    public function test_daily_report_student_filter_shows_manager_sections_after_class_is_selected(): void
    {
        $school = School::create([
            'name' => 'مدرسة الصفوف والشعب',
            'classes' => ['الأول'],
            'sections' => ['أ', 'ب'],
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'section-filter-teacher',
            'phone' => '15550000088',
            'school_id' => $school->id,
        ]);
        $mother = User::factory()->create([
            'role' => 'mother',
            'status' => 'approved',
            'username' => 'section-filter-mother',
            'phone' => '15550000089',
        ]);
        $student = chaldrin::create([
            'mother_id' => $mother->id,
            'school_id' => $school->id,
            'name' => 'طالب الشعبة أ',
            'gender' => 'male',
            'Health_status' => 'جيد',
            'class' => 'الأول',
            'section' => 'أ',
            'age' => 6,
            'image' => 'student.png',
        ]);
        $teacher->childrenAsTeacher()->attach($student->id);

        $this->actingAs($teacher)
            ->get(route('teacher.daily_variables'))
            ->assertOk()
            ->assertSee('id="sectionFilterContainer"', false)
            ->assertSee('id="sectionFilter"', false)
            ->assertSee('value="أ"', false)
            ->assertSee('value="ب"', false)
            ->assertSee('data-class="الأول" data-section="أ"', false);
    }

    public function test_teacher_can_save_a_school_subject_or_a_custom_daily_report_topic(): void
    {
        Notification::fake();

        $school = School::create([
            'name' => 'مدرسة التقارير',
            'subjects' => 'الرياضيات، العلوم',
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'status' => 'approved',
            'username' => 'report-topic-teacher',
            'phone' => '15550000086',
            'school_id' => $school->id,
        ]);
        $mother = User::factory()->create([
            'role' => 'mother',
            'status' => 'approved',
            'username' => 'report-topic-mother',
            'phone' => '15550000087',
        ]);
        $student = chaldrin::create([
            'mother_id' => $mother->id,
            'school_id' => $school->id,
            'name' => 'طالب التقارير',
            'gender' => 'male',
            'Health_status' => 'جيد',
            'class' => 'الأول',
            'age' => 6,
            'image' => 'student.png',
        ]);
        $teacher->childrenAsTeacher()->attach($student->id);

        $this->actingAs($teacher)
            ->post(route('teacher.daily_store', $student->id), [
                'topic_subject' => 'الرياضيات',
                'report_date' => '2026-10-21',
            ])
            ->assertSessionHas('success');

        $this->actingAs($teacher)
            ->post(route('teacher.daily_store', $student->id), [
                'topic_subject' => '__custom__',
                'custom_topic' => 'نشاط مخصص',
                'report_date' => '2026-10-21',
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('daily_variables', [
            'child_id' => $student->id,
            'topic' => 'الرياضيات',
        ]);
        $this->assertDatabaseHas('daily_variables', [
            'child_id' => $student->id,
            'topic' => 'نشاط مخصص',
        ]);
    }
}
