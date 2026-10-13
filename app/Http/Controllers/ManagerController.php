<?php


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\chaldrin;

class ManagerController extends Controller
{
    // فحص صلاحيات المدير
    private function checkManager()
    {
        if (auth()->user()->role !== 'manager') {
            abort(403, 'غير مصرح لك بدخول هذه الصفحة.');
        }
    }

    // 1. لوحة تحكم المدير
    public function dashboard(Request $request)
    {
        $this->checkManager();
        $manager = auth()->user();

        // طلبات المعلمين المعلقة
        $pendingTeachers = User::where('role', 'teacher')
            ->where('status', 'pending')
            ->where('school_name', $manager->school_name)
            ->latest()
            ->get();

        // المعلمون المقبولون
        $approvedTeachers = User::where('role', 'teacher')
            ->where('status', 'approved')
            ->where('school_name', $manager->school_name)
            ->latest()
            ->get();

        $selectedYear = $request->get('year', date('Y'));

        // جلب الصفوف
        $classes = chaldrin::where('manager_id', $manager->id)
            ->whereYear('created_at', $selectedYear)
            ->select('class')
            ->distinct()
            ->orderBy('class')
            ->pluck('class');

        return view('manager.dashboard', compact(
            'pendingTeachers',
            'approvedTeachers',
            'selectedYear',
            'classes'
        ));
    }

    // دالة حفظ التعيين السريع من الداشبورد
    public function assignClassQuickStore(Request $request)
    {
        $this->checkManager();

        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'year' => 'required|integer',
            'class' => 'required|string',
        ]);

        $teacher = User::where('role', 'teacher')
            ->where('status', 'approved')
            ->findOrFail($request->teacher_id);

        // جلب معرفات طلاب الصف المحدد
        $classStudentIds = chaldrin::whereYear('created_at', $request->year)
            ->where('class', $request->class)
            ->pluck('id');

        // ربط المعلم بطلاب الصف
        $teacher->childrenAsTeacher()->syncWithoutDetaching($classStudentIds);

        return back()->with('success', 'تم تعيين المعلم للصف بنجاح.');
    }
    // 2. الموافقة على طلب معلم
    public function approveTeacher($id)
    {
        $this->checkManager();

        $teacher = User::where('role', 'teacher')
            ->where('status', 'pending')
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

        $teacher = User::where('role', 'teacher')
            ->where('status', 'pending')
            ->findOrFail($id);

        $teacher->delete();

        return back()->with(
            'success',
            'تم رفض حساب المعلم وحذفه.'
        );
    }

    // 3. عرض طلاب صف معين مع العلامات والمعدلات
    public function showClassStudents(Request $request, $className)
    {
        $this->checkManager();

        $year = $request->get('year', date('Y'));

        $students = chaldrin::where('class', $className)
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

        $manager = auth()->user();

        $teacher = User::where('role', 'teacher')
            ->where('status', 'approved')
            ->where('school_name', $manager->school_name)
            ->findOrFail($teacherId);

        $year = $request->get('year', date('Y'));

        // جلب الصفوف المسندة لهذا الأستاذ فقط في هذه السنة
        $classes = chaldrin::where('manager_id', $manager->id)
            ->whereYear('created_at', $year)
            ->whereHas('teachers', function ($q) use ($teacherId) {
                $q->where('users.id', $teacherId);
            })
            ->select('class')
            ->distinct()
            ->pluck('class');

        // الصف المحدد (افتراضياً أول صف مسند للمعلم)
        $selectedClass = $request->get('class', $classes->first());

        // جلب طلاب الصف المحدد
        $students = chaldrin::where('manager_id', $manager->id)
            ->whereYear('created_at', $year)
            ->when($selectedClass, function ($query) use ($selectedClass) {
                $query->where('class', $selectedClass);
            })
            ->with('teachers')
            ->get();

        return view('manager.assign_teacher', compact(
            'teacher',
            'classes',
            'students',
            'year',
            'selectedClass'
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

        $teacher = User::where('role', 'teacher')
            ->where('status', 'approved')
            ->findOrFail($teacherId);

        // جلب جميع طلاب هذا الصف بالكامل المضافين بالروضة لهذه السنة
        $classStudentIds = chaldrin::whereYear('created_at', $request->year)
            ->where('class', $request->class)
            ->pluck('id');

        // ربط المعلم بكل طلاب هذا الصف تلقائياً (سواء أنشأهم هو أو أستاذ آخر)
        $teacher->childrenAsTeacher()->syncWithoutDetaching($classStudentIds);

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

        $manager = auth()->user();
        $year = $request->get('year', date('Y'));
        $search = $request->get('search'); // متغير البحث

        $teachers = User::where('role', 'teacher')
            ->where('status', 'approved')
            ->where('school_name', $manager->school_name)
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->with([
                'childrenAsTeacher' => function ($query) use ($manager) {
                    $query->where(function ($q) use ($manager) {
                        $q->where('chaldrins.manager_id', $manager->id)
                            ->orWhereNull('chaldrins.manager_id');
                    });
                }
            ])
            ->get();

        return view('manager.teachers', compact('teachers', 'year', 'search'));
    }
    public function studentsIndex(Request $request)
    {
        $this->checkManager();
        $managerId = auth()->id(); // ID المدير المسجل دخوله

        $year = $request->get('year', date('Y'));
        $class = $request->get('class');
        $search = $request->get('search');

        // تصفية الصفوف حسب manager_id الخاص بالمدير الحالي
        $classes = chaldrin::where('manager_id', $managerId)
            ->whereYear('created_at', $year)
            ->select('class')
            ->distinct()
            ->orderBy('class')
            ->pluck('class');

        $students = chaldrin::where('manager_id', $managerId) // شرط العزل المهم جداً
            ->whereYear('created_at', $year)
            ->when($class, function ($query) use ($class) {
                $query->where('class', $class);
            })
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->with('teachers')
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

        // تجميع الطلاب حسب الصف وترتيبهم تصاعدياً بدقة باستخدام مصفوفة الأوزان
        $groupedStudents = $students->groupBy('class')->sortBy(function ($group, $className) use ($order) {
            foreach ($order as $key => $val) {
                if (str_contains($className, $key)) {
                    return $val;
                }
            }
            return 99; // الصفوف غير المعرفة تظهر في النهاية
        });

        return view('manager.students', compact(
            'students',
            'classes',
            'year',
            'class',
            'search',
            'groupedStudents'
        ));
    }
    // عرض ملف الطالب والمتغيرات اليومية الخاصة به
    public function studentProfile($id)
    {
        $this->checkManager();

        $student = chaldrin::with([
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


    // صفحة تعديل بيانات المدير
    public function editProfile()
    {
        $this->checkManager();

        $manager = auth()->user();

        return view('manager.profile-edit', compact('manager'));
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

    // حذف طالب
    public function destroyStudent($id)
    {
        $this->checkManager();

        $student = chaldrin::findOrFail($id);

        // حذف الطالب
        $student->delete();

        return back()->with('success', 'تم حذف الطالب بنجاح.');
    }

    // عرض صفحة علامات الصف بالكامل للمدير
    public function showClassGrades(Request $request, $className)
    {
        $this->checkManager();
        $managerId = auth()->id();

        $searchName = $request->get('search_name');
        $searchTopic = $request->get('search_topic');
        $selectedYear = $request->get('year', date('Y'));

        $students = chaldrin::where('manager_id', $managerId)
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
        $managerId = auth()->id();

        $searchName = $request->get('search_name');
        $searchNotes = $request->get('search_notes');
        $selectedYear = $request->get('year', date('Y'));

        $students = chaldrin::where('manager_id', $managerId)
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
        $manager = auth()->user();

        $request->validate([
            'school_name' => 'required|string|max:255',
            'primary_color' => 'required|string|max:7',
            'school_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $data = [
            'school_name' => $request->school_name,
            'primary_color' => $request->primary_color,
        ];

        // رفع الشعار الجديد إن وجد
        if ($request->hasFile('school_logo')) {
            $logoPath = $request->file('school_logo')->store('logos', 'public');
            $data['school_logo'] = $logoPath;
        }

        $manager->update($data);

        return back()->with('success', 'تم تحديث إعدادات المدرسة بنجاح.');
    }
}
