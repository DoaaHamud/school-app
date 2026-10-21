<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use App\Models\SchoolMotherRequest;
use Illuminate\Http\Request;
use App\Models\chaldrin;
use App\Notifications\TeacherAssignmentNotification;
use Illuminate\Validation\Rule;

class ManagerController extends Controller
{
    // فحص صلاحيات المدير
    private function checkManager()
    {
        if (auth()->user()->role !== 'manager') {
            abort(403, 'غير مصرح لك بدخول هذه الصفحة.');
        }
    }

    private function schoolId(): int
    {
        $schoolId = auth()->user()->school_id;
        abort_if($schoolId === null, 409, 'لا توجد مدرسة مرتبطة بهذا الحساب.');

        return $schoolId;
    }

    // 1. لوحة تحكم المدير
    public function dashboard(Request $request)
    {
        $this->checkManager();
        $schoolId = $this->schoolId();

        // طلبات المعلمين المعلقة
        $pendingTeachers = User::where('role', 'teacher')
            ->where('status', 'pending')
            ->where('school_id', $schoolId)
            ->latest()
            ->get();

        $pendingMotherRequests = SchoolMotherRequest::where('school_id', $schoolId)
            ->where('status', 'pending')
            ->with('mother:id,name,username,email,phone')
            ->latest()
            ->get();

        return view('manager.dashboard', compact('pendingTeachers', 'pendingMotherRequests'));
    }

    public function teacherAssignments(Request $request)
    {
        $this->checkManager();
        $request->validate([
            'year' => 'sometimes|integer|min:2000|max:2100',
        ]);

        $schoolId = $this->schoolId();
        $school = School::findOrFail($schoolId);
        $year = (int) $request->input('year', date('Y'));
        $availableClasses = collect($this->configuredSchoolOptions($school->classes))
            ->unique(fn ($class) => $this->normalizeSchoolOption($class))
            ->values();
        $availableSections = collect($this->configuredSchoolOptions($school->sections))
            ->unique(fn ($section) => $this->normalizeSchoolOption($section))
            ->values();
        $approvedTeachers = User::where('role', 'teacher')
            ->where('status', 'approved')
            ->where('school_id', $schoolId)
            ->orderBy('name')
            ->get(['id', 'name']);

        $students = chaldrin::where('school_id', $schoolId)
            ->whereYear('created_at', $year)
            ->whereNotNull('class')
            ->with(['teachers' => function ($query) use ($schoolId) {
                $query->where('users.school_id', $schoolId)
                    ->where('users.role', 'teacher')
                    ->whereIn('users.status', ['approved', 'deactivated'])
                    ->orderBy('users.name');
            }])
            ->get();
        $classAssignments = $students
            ->groupBy(fn ($student) => json_encode(
                [
                    $this->normalizeSchoolOption($student->class),
                    $this->normalizeSchoolOption($student->section),
                ],
                JSON_UNESCAPED_UNICODE
            ))
            ->map(function ($groupStudents) use ($availableClasses, $availableSections) {
                $firstStudent = $groupStudents->first();
                $normalizedClass = $this->normalizeSchoolOption($firstStudent->class);
                $normalizedSection = $this->normalizeSchoolOption($firstStudent->section);

                return [
                    'className' => $availableClasses->first(
                        fn ($class) => $this->normalizeSchoolOption($class) === $normalizedClass
                    ) ?? $firstStudent->class,
                    'sectionName' => $availableSections->first(
                        fn ($section) => $this->normalizeSchoolOption($section) === $normalizedSection
                    ) ?? $firstStudent->section,
                    'teachers' => $groupStudents
                        ->flatMap(fn ($student) => $student->teachers)
                        ->unique('id')
                        ->sortBy('name')
                        ->values(),
                ];
            })
            ->sortBy(function ($assignment) {
                $className = $assignment['className'];
                $priority = match (true) {
                    str_contains($className, 'الأول'), str_contains($className, 'الاول') => 1,
                    str_contains($className, 'الثاني') => 2,
                    str_contains($className, 'الثالث') => 3,
                    default => 4,
                };

                return sprintf('%02d-%s-%s', $priority, $className, $assignment['sectionName'] ?? '');
            });

        return view('manager.teacher-assignments', compact(
            'year',
            'approvedTeachers',
            'classAssignments',
            'availableClasses',
            'availableSections'
        ));
    }

    public function openNotification(string $notificationId)
    {
        $this->checkManager();

        $notification = auth()->user()->notifications()->findOrFail($notificationId);

        if ($notification->unread()) {
            $notification->markAsRead();
        }

        return redirect()->route('manager.dashboard');
    }

    // حفظ تعيين صف من صفحة إدارة تعيينات المعلمين
    public function assignClassQuickStore(Request $request)
    {
        $this->checkManager();
        $school = School::findOrFail($this->schoolId());
        $classes = $this->configuredSchoolOptions($school->classes);
        $sections = $this->configuredSchoolOptions($school->sections);

        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'year' => 'required|integer|min:2000|max:2100',
            'class' => ['required', 'string', Rule::in($classes)],
            'section' => ['required', 'string', Rule::in($sections)],
        ]);

        $schoolId = $this->schoolId();
        $teacher = User::where('role', 'teacher')
            ->where('status', 'approved')
            ->where('school_id', $schoolId)
            ->findOrFail($request->teacher_id);

        $schoolStudents = chaldrin::where('school_id', $schoolId)
            ->whereYear('created_at', $request->year)
            ->get(['id', 'class', 'section']);
        $classAliases = $schoolStudents
            ->filter(fn ($student) => $this->normalizeSchoolOption($student->class) === $this->normalizeSchoolOption($request->class))
            ->pluck('class')
            ->unique()
            ->values()
            ->all();
        $sectionAliases = $schoolStudents
            ->filter(fn ($student) => $this->normalizeSchoolOption($student->section) === $this->normalizeSchoolOption($request->section))
            ->pluck('section')
            ->unique()
            ->values()
            ->all();

        $classStudentIds = chaldrin::where('school_id', $schoolId)
            ->whereYear('created_at', $request->year)
            ->whereIn('class', $classAliases ?: [$request->class])
            ->whereIn('section', $sectionAliases ?: [$request->section])
            ->pluck('id');

        if ($classStudentIds->isEmpty()) {
            return back()
                ->withInput()
                ->withErrors(['class' => 'لا يوجد طلاب في الصف والشعبة المحددين لهذه السنة الدراسية.']);
        }

        // ربط المعلم بطلاب الصف
        $assignment = $teacher->childrenAsTeacher()->syncWithoutDetaching($classStudentIds);

        if ($assignment['attached'] !== []) {
            $teacher->notify(new TeacherAssignmentNotification(
                $request->class . ' — ' . $request->section,
                count($assignment['attached'])
            ));
        }

        return back()->with('success', 'تم تعيين المعلم للصف والشعبة بنجاح.');
    }

    public function unassignClassQuickStore(Request $request)
    {
        $this->checkManager();

        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'year' => 'required|integer|min:2000|max:2100',
            'class' => 'required|string',
            'section' => 'nullable|string',
        ]);

        $schoolId = $this->schoolId();
        $teacher = User::where('role', 'teacher')
            ->whereIn('status', ['approved', 'deactivated'])
            ->where('school_id', $schoolId)
            ->findOrFail($request->teacher_id);

        $schoolStudents = chaldrin::where('school_id', $schoolId)
            ->whereYear('created_at', $request->year)
            ->get(['class', 'section']);
        $normalizedClass = $this->normalizeSchoolOption($request->class);
        $classAliases = $schoolStudents
            ->filter(fn ($student) => $this->normalizeSchoolOption($student->class) === $normalizedClass)
            ->pluck('class')
            ->unique()
            ->values()
            ->all();

        $classStudentQuery = chaldrin::where('school_id', $schoolId)
            ->whereYear('created_at', $request->year)
            ->whereIn('class', $classAliases ?: [$request->class])
            ->whereHas('teachers', function ($query) use ($teacher) {
                $query->where('users.id', $teacher->id);
            });
        if ($request->filled('section')) {
            $normalizedSection = $this->normalizeSchoolOption($request->section);
            $sectionAliases = $schoolStudents
                ->filter(fn ($student) => $this->normalizeSchoolOption($student->section) === $normalizedSection)
                ->pluck('section')
                ->unique()
                ->values()
                ->all();
            $classStudentQuery->whereIn('section', $sectionAliases ?: [$request->section]);
        } else {
            $classStudentQuery->whereNull('section');
        }
        $classStudentIds = $classStudentQuery->pluck('chaldrins.id');

        if ($classStudentIds->isEmpty()) {
            return back()
                ->withInput()
                ->withErrors(['unassignment' => 'لا يوجد تعيين لهذا المعلم في الصف والشعبة المحددين لهذه السنة الدراسية.']);
        }

        $teacher->childrenAsTeacher()->detach($classStudentIds->all());

        return redirect()
            ->route('manager.teacher-assignments', ['year' => $request->year])
            ->with('success', 'تم إلغاء تعيين المعلم من الصف والشعبة بنجاح، مع بقاء الطلاب والتقارير محفوظة.');
    }

    // 2. الموافقة على طلب معلم
    public function approveTeacher($id)
    {
        $this->checkManager();
        $schoolId = $this->schoolId();

        $teacher = User::where('role', 'teacher')
            ->where('status', 'pending')
            ->where('school_id', $schoolId)
            ->findOrFail($id);

        $teacher->update([
            'status' => 'approved'
        ]);

        return back()->with(
            'success',
            'تمت الموافقة على حساب المعلم بنجاح.'
        );
    }

    // رفض طلب معلم
    public function rejectTeacher($id)
    {
        $this->checkManager();
        $schoolId = $this->schoolId();

        $teacher = User::where('role', 'teacher')
            ->where('status', 'pending')
            ->where('school_id', $schoolId)
            ->findOrFail($id);

        $teacher->delete();

        return back()->with(
            'success',
            'تم رفض حساب المعلم وحذفه.'
        );
    }

    public function approveMotherRequest($requestId)
    {
        $this->checkManager();
        $schoolId = $this->schoolId();

        $motherRequest = SchoolMotherRequest::where('school_id', $schoolId)
            ->where('status', 'pending')
            ->findOrFail($requestId);

        abort_if($motherRequest->mother?->role !== 'mother', 404);

        $motherRequest->update(['status' => 'approved']);

        return back()->with('success', 'تمت الموافقة على انضمام وليّة الأمر للمدرسة، وأصبحت متاحة للمعلمات.');
    }

    public function rejectMotherRequest($requestId)
    {
        $this->checkManager();
        $schoolId = $this->schoolId();

        $motherRequest = SchoolMotherRequest::where('school_id', $schoolId)
            ->where('status', 'pending')
            ->findOrFail($requestId);

        abort_if($motherRequest->mother?->role !== 'mother', 404);

        $motherRequest->update(['status' => 'rejected']);

        return back()->with('success', 'تم رفض طلب وليّة الأمر.');
    }

    public function deactivateTeacher($id)
    {
        $this->checkManager();
        $schoolId = $this->schoolId();

        $teacher = User::where('role', 'teacher')
            ->where('status', 'approved')
            ->where('school_id', $schoolId)
            ->findOrFail($id);

        $teacher->update(['status' => 'deactivated']);

        return back()->with('success', 'تم إلغاء تفعيل حساب المعلم.');
    }

    public function deactivatedTeachers()
    {
        $this->checkManager();
        $schoolId = $this->schoolId();

        $teachers = User::where('role', 'teacher')
            ->where('status', 'deactivated')
            ->where('school_id', $schoolId)
            ->latest()
            ->get();

        return view('manager.deactivated-teachers', compact('teachers'));
    }

    public function reactivateTeacher($id)
    {
        $this->checkManager();
        $schoolId = $this->schoolId();

        $teacher = User::where('role', 'teacher')
            ->where('status', 'deactivated')
            ->where('school_id', $schoolId)
            ->findOrFail($id);

        $teacher->update(['status' => 'approved']);

        return redirect()
            ->route('manager.teachers.deactivated')
            ->with('success', 'تمت إعادة تفعيل حساب المعلم.');
    }

    // 3. عرض طلاب صف معين مع العلامات والمعدلات
    public function showClassStudents(Request $request, $className)
    {
        $this->checkManager();
        $schoolId = $this->schoolId();

        $year = $request->get('year', date('Y'));

        $students = chaldrin::where('school_id', $schoolId)
            ->where('class', $className)
            ->whereYear('created_at', $year)
            ->with([
                'dailyVariables',
                'teachers'
            ])
            ->get();

        // حساب معدل كل طالب
        foreach ($students as $student) {
            $student->average =
                $student->dailyVariables->avg('result') ?? 0;
        }

        return view(
            'manager.class_students',
            compact(
                'students',
                'className',
                'year'
            )
        );
    }

    // 4. صفحة تعيين الطلاب لمعلم
    public function assignTeacherForm(Request $request, $teacherId)
    {
        $this->checkManager();
        $schoolId = $this->schoolId();

        $teacher = User::where('role', 'teacher')
            ->where('status', 'approved')
            ->where('school_id', $schoolId)
            ->findOrFail($teacherId);

        $year = $request->get('year', date('Y'));

        $assignedStudents = fn () => chaldrin::where('school_id', $schoolId)
            ->whereYear('created_at', $year)
            ->whereHas('teachers', function ($q) use ($teacherId) {
                $q->where('users.id', $teacherId);
            });

        // جلب الصفوف والشعب المسندة لهذا الأستاذ فقط في هذه السنة
        $classes = $assignedStudents()
            ->select('class')
            ->distinct()
            ->orderBy('class')
            ->pluck('class')
            ->filter()
            ->values();

        // الصف المحدد (افتراضياً أول صف مسند للمعلم)
        $requestedClass = $request->input('class');
        $selectedClass = $classes->contains($requestedClass) ? $requestedClass : $classes->first();
        $sectionAliases = $selectedClass
            ? $assignedStudents()
                ->where('class', $selectedClass)
                ->whereNotNull('section')
                ->select('section')
                ->distinct()
                ->orderBy('section')
                ->pluck('section')
                ->groupBy(fn ($section) => $this->normalizeSchoolOption($section))
            : collect();
        $requestedSection = $request->input('section');
        $selectedSectionKey = $requestedSection !== null
            ? $this->normalizeSchoolOption($requestedSection)
            : null;
        $sections = $sectionAliases->map(fn ($aliases) => $aliases->first())->values();
        $selectedSection = $selectedSectionKey !== null && $sectionAliases->has($selectedSectionKey)
            ? $sectionAliases->get($selectedSectionKey)->first()
            : '';
        $selectedSectionAliases = $selectedSection !== ''
            ? $sectionAliases->get($this->normalizeSchoolOption($selectedSection), collect())->values()->all()
            : [];

        // عرض طلاب الصف المحدد المسندين لهذا المعلم فقط
        $students = $selectedClass
            ? $assignedStudents()
                ->where('class', $selectedClass)
                ->when($selectedSection !== '', fn ($query) => $query->whereIn('section', $selectedSectionAliases))
                ->get()
            : collect();

        return view('manager.assign_teacher', compact(
            'teacher',
            'classes',
            'sections',
            'students',
            'year',
            'selectedClass',
            'selectedSection'
        ));
    }
    // 2. حفظ إسناد الصف بالكامل للمعلم
    public function assignTeacherStore(Request $request, $teacherId)
    {
        $this->checkManager();

        $request->validate([
            'year' => 'required|integer',
            'class' => 'required|string',
        ]);

        $schoolId = $this->schoolId();
        $teacher = User::where('role', 'teacher')
            ->where('status', 'approved')
            ->where('school_id', $schoolId)
            ->findOrFail($teacherId);

        // جلب جميع طلاب هذا الصف بالكامل المضافين بالروضة لهذه السنة
        $classStudentIds = chaldrin::where('school_id', $schoolId)
            ->whereYear('created_at', $request->year)
            ->where('class', $request->class)
            ->pluck('id');

        // ربط المعلم بكل طلاب هذا الصف تلقائياً (سواء أنشأهم هو أو أستاذ آخر)
        $assignment = $teacher->childrenAsTeacher()->syncWithoutDetaching($classStudentIds);

        if ($assignment['attached'] !== []) {
            $teacher->notify(new TeacherAssignmentNotification(
                $request->class,
                count($assignment['attached'])
            ));
        }

        return redirect()
            ->route('manager.teachers.assign', [
                'teacher' => $teacher->id,
                'year' => $request->year,
                'class' => $request->class,
            ])
            ->with('success', 'تم إسناد الصف بكافة طلابه للأستاذ بنجاح.');
    }

    // 5. عرض المعلمين المقبولين مع الطلاب المسندين إليهم
    // 5. عرض المعلمين المقبولين مع البحث
    public function teachersIndex(Request $request)
    {
        $this->checkManager();

        $schoolId = $this->schoolId();
        $year = $request->get('year', date('Y'));
        $search = $request->get('search'); // متغير البحث
        $deactivatedTeachersCount = User::where('role', 'teacher')
            ->where('status', 'deactivated')
            ->where('school_id', $schoolId)
            ->count();

        $teachers = User::where('role', 'teacher')
            ->where('status', 'approved')
            ->where('school_id', $schoolId)
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->with([
                'childrenAsTeacher' => function ($query) use ($schoolId) {
                    $query->where('chaldrins.school_id', $schoolId);
                }
            ])
            ->get();

        $teachers->each(function (User $teacher): void {
            $teacher->setAttribute(
                'assigned_class_sections',
                $teacher->childrenAsTeacher
                    ->filter(fn ($student) => filled($student->class))
                    ->groupBy(fn ($student) => json_encode([
                        $this->normalizeSchoolOption($student->class),
                        $this->normalizeSchoolOption($student->section),
                    ], JSON_UNESCAPED_UNICODE))
                    ->map(function ($students) {
                        $student = $students->first();

                        return trim($student->class)
                            . ' / '
                            . (filled($student->section) ? trim($student->section) : 'شعبة غير محددة');
                    })
                    ->values()
            );
        });

        return view('manager.teachers', compact(
            'teachers',
            'year',
            'search',
            'deactivatedTeachersCount'
        ));
    }
    public function studentsIndex(Request $request)
    {
        $this->checkManager();
        $schoolId = $this->schoolId();

        $year = $request->get('year', date('Y'));
        $class = $request->get('class');
        $search = $request->get('search');
        $searchSection = $request->input('section');
        $deactivatedStudentsCount = chaldrin::onlyTrashed()
            ->where('school_id', $schoolId)
            ->count();

        $classes = chaldrin::where('school_id', $schoolId)
            ->whereYear('created_at', $year)
            ->select('class')
            ->distinct()
            ->orderBy('class')
            ->pluck('class');

        $sectionAliases = chaldrin::where('school_id', $schoolId)
            ->whereYear('created_at', $year)
            ->when($class, fn ($query) => $query->where('class', $class))
            ->whereNotNull('section')
            ->select('section')
            ->distinct()
            ->orderBy('section')
            ->pluck('section')
            ->filter(fn ($section) => $this->normalizeSchoolOption($section) !== '')
            ->groupBy(fn ($section) => $this->normalizeSchoolOption($section));
        $sections = $sectionAliases->map(fn ($aliases) => $aliases->first())->values();
        $searchSectionKey = $searchSection !== null
            ? $this->normalizeSchoolOption($searchSection)
            : null;
        $selectedSection = $searchSectionKey !== null && $sectionAliases->has($searchSectionKey)
            ? $sectionAliases->get($searchSectionKey)->first()
            : '';
        $selectedSectionAliases = $selectedSection !== ''
            ? $sectionAliases->get($this->normalizeSchoolOption($selectedSection))->values()->all()
            : [];

        $students = chaldrin::where('school_id', $schoolId)
            ->whereYear('created_at', $year)
            ->when($class, function ($query) use ($class) {
                $query->where('class', $class);
            })
            ->when($selectedSection !== '', fn ($query) => $query->whereIn('section', $selectedSectionAliases))
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->with(['teachers', 'mother:id,name'])
            ->latest()
            ->get();

        // مصفوفة الترتيب المنطقي للصفوف (تشمل المراحل الدراسية والروضة)
        $order = [
            'روضة' => 1,
            'بستان' => 2,
            'تمهيدي' => 3,
            'الأول' => 4,
            'الاول' => 4,
            'الثاني' => 5,
            'ثاني' => 5,
            'الثالث' => 6,
            'ثالث' => 6,
            'الرابع' => 7,
            'رابع' => 7,
            'الخامس' => 8,
            'خامس' => 8,
            'السادس' => 9,
            'سادس' => 9,
            'السابع' => 10,
            'سابع' => 10,
            'الثامن' => 11,
            'ثامن' => 11,
            'التاسع' => 12,
            'تاسع' => 12,
            'العاشر' => 13,
            'عاشر' => 13,
        ];

        // Keep each class-section combination in its own group.
        $groupedStudents = $students->groupBy(fn ($student) => json_encode(
            [
                $this->normalizeSchoolOption($student->class),
                $this->normalizeSchoolOption($student->section),
            ],
            JSON_UNESCAPED_UNICODE
        ))->map(function ($groupStudents) {
            $firstStudent = $groupStudents->first();

            return [
                'className' => $firstStudent->class,
                'sectionName' => $firstStudent->section,
                'students' => $groupStudents,
            ];
        })->sortBy(function ($group) use ($order) {
            $className = $group['className'] ?? '';
            foreach ($order as $key => $val) {
                if (str_contains($className, $key)) {
                    return sprintf('%02d|%s|%s', $val, $className, $group['sectionName'] ?? '');
                }
            }
            return sprintf('99|%s|%s', $className, $group['sectionName'] ?? '');
        })->values();

        return view('manager.students', compact(
            'students',
            'classes',
            'sections',
            'year',
            'class',
            'search',
            'searchSection',
            'selectedSection',
            'groupedStudents',
            'deactivatedStudentsCount'
        ));
    }

    public function deactivatedStudents(Request $request)
    {
        $this->checkManager();

        $schoolId = $this->schoolId();
        $search = $request->get('search');
        $students = chaldrin::onlyTrashed()
            ->where('school_id', $schoolId)
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->latest('deleted_at')
            ->get();

        return view('manager.deactivated-students', compact('students', 'search'));
    }

    public function deactivateStudent($id)
    {
        $this->checkManager();

        $student = chaldrin::where('school_id', $this->schoolId())->findOrFail($id);
        $student->delete();

        return back()->with('success', 'تم إلغاء تفعيل الطالب مع الاحتفاظ ببياناته وتقاريره.');
    }

    public function reactivateStudent($id)
    {
        $this->checkManager();

        $student = chaldrin::onlyTrashed()
            ->where('school_id', $this->schoolId())
            ->findOrFail($id);
        $student->restore();

        return back()->with('success', 'تمت إعادة تفعيل الطالب.');
    }

    // عرض ملف الطالب والمتغيرات اليومية الخاصة به
    public function studentProfile($id)
    {
        $this->checkManager();

        $student = chaldrin::where('school_id', $this->schoolId())->with([
            'dailyVariables',
            'teachers'
        ])->findOrFail($id);

        return view(
            'manager.student_profile',
            compact('student')
        );
    }

    // ==========================================
    // حساب المدير
    // ==========================================

    // عرض الملف الشخصي
    public function profile()
    {
        $this->checkManager();

        $manager = auth()->user();

        return view('manager.profile', compact('manager'));
    }

    // حفظ تعديلات المدير
    public function updateProfile(Request $request)
    {
        $this->checkManager();

        $manager = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $manager->id,
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],
        ]);

        $manager->update($validated);

        return redirect()
            ->route('manager.profile')
            ->with('success', 'تم تحديث بيانات الحساب بنجاح.');
    }


    // حذف حساب المدير
    public function deleteAccount(Request $request)
    {
        $this->checkManager();

        $manager = auth()->user();

        auth()->logout();

        $manager->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'تم حذف حساب المدير بنجاح.');
    }

    // عرض صفحة علامات الصف بالكامل للمدير
    public function showClassGrades(Request $request, $className)
    {
        $this->checkManager();
        $schoolId = $this->schoolId();

        $searchName = $request->get('search_name');
        $searchTopic = $request->get('search_topic');
        $selectedYear = $request->get('year', date('Y'));

        $students = chaldrin::where('school_id', $schoolId)
            ->where('class', $className)
            ->when($searchName, function ($query) use ($searchName) {
                $query->where('name', 'like', '%' . $searchName . '%');
            })
            ->with(['dailyVariables' => function ($q) use ($searchTopic, $selectedYear) {
                if (!empty($searchTopic)) {
                    $q->where('topic', 'like', '%' . $searchTopic . '%');
                }
                if (!empty($selectedYear)) {
                    $q->whereYear('report_date', $selectedYear);
                }
            }, 'teachers'])
            ->get();

        return view('manager.classes_grades', compact('students', 'className', 'searchName', 'searchTopic', 'selectedYear'));
    }

    // عرض صفحة ملاحظات الصف بالكامل للمدير
    public function showClassNotes(Request $request, $className)
    {
        $this->checkManager();
        $schoolId = $this->schoolId();

        $searchName = $request->get('search_name');
        $searchNotes = $request->get('search_notes');
        $selectedYear = $request->get('year', date('Y'));

        $students = chaldrin::where('school_id', $schoolId)
            ->where('class', $className)
            ->when($searchName, function ($query) use ($searchName) {
                $query->where('name', 'like', '%' . $searchName . '%');
            })
            ->with(['dailyVariables' => function ($q) use ($searchNotes, $selectedYear) {
                if (!empty($searchNotes)) {
                    $q->where('notes', 'like', '%' . $searchNotes . '%');
                }
                if (!empty($selectedYear)) {
                    $q->whereYear('report_date', $selectedYear);
                }
            }, 'teachers'])
            ->get();

        return view('manager.classes_notes', compact('students', 'className', 'searchName', 'searchNotes', 'selectedYear'));
    }

    // تحديث إعدادات الروضة (الاسم، الشعار، الألوان)
    public function updateSettings(Request $request)
    {
        $this->checkManager();
        $schoolId = $this->schoolId();
        $school = School::findOrFail($schoolId);

        // التحقق من صحة البيانات المرسلة بما فيها الهيكلة التعليمية
        $validated = $request->validate([
            'school_name'   => 'required|string|max:255',
            'primary_color' => 'required|string|max:7',
            'school_logo'   => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'classes'       => 'nullable|string',
            'sections'      => 'nullable|string',
            'subjects'      => 'nullable|string|max:5000',
        ]);

        $data = [
            'name'     => $validated['school_name'],
            'color'    => $validated['primary_color'],
            'classes'  => $this->parseSchoolOptions($validated['classes'] ?? null),
            'sections' => $this->parseSchoolOptions($validated['sections'] ?? null),
            'subjects' => $validated['subjects'] ?? null,
        ];

        // رفع الشعار الجديد إن وجد
        if ($request->hasFile('school_logo')) {
            $data['logo'] = $request->file('school_logo')->store('logos', 'public');
        }

        // تحديث بيانات المدرسة في قاعدة البيانات
        $school->update($data);

        return back()->with('success', 'تم تحديث إعدادات وهيكلة المدرسة بنجاح.');
    }

    private function parseSchoolOptions(?string $value): ?array
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        return collect(preg_split('/[,،\r\n]+/u', $value) ?: [])
            ->map(fn ($option) => trim($option))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function configuredSchoolOptions(mixed $value): array
    {
        if (is_string($value)) {
            $value = preg_split('/[,،\r\n]+/u', $value) ?: [];
        }

        return collect($value ?? [])
            ->map(fn ($option) => trim((string) $option))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function normalizeSchoolOption(?string $value): string
    {
        $value = trim((string) $value);
        $value = preg_replace('/[\x{200B}-\x{200F}\x{FEFF}\x{0640}]/u', '', $value) ?? $value;
        $value = preg_replace('/[\x{064B}-\x{065F}\x{0670}]/u', '', $value) ?? $value;
        $value = strtr($value, ['أ' => 'ا', 'إ' => 'ا', 'آ' => 'ا', 'ٱ' => 'ا']);

        return preg_replace('/\s+/u', ' ', $value) ?? $value;
    }
}
