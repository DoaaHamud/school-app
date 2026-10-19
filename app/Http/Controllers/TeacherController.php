<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\chaldrin;
use App\Models\Daily_variables;
use App\Models\MotherChildNote;
use App\Notifications\MotherChildNoteReplyNotification;
use App\Notifications\NewDailyReportNotification;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // فحص صلاحية المعلم
    private function checkTeacher()
    {
        if (auth()->user()->role !== 'teacher') {
            abort(403, 'غير مصرح لك بدخول هذه الصفحة.');
        }

        // المعلم يجب أن يكون مقبولاً
        if (auth()->user()->status !== 'approved') {
            abort(403, 'حساب المعلم غير مقبول بعد.');
        }
    }

    // 1. لوحة تحكم المعلم
    public function dashboard()
    {
        $this->checkTeacher();

        $teacher = auth()->user();
        $schoolBranding = User::where('role', 'manager')
            ->where('school_name', $teacher->school_name)
            ->first() ?? $teacher;

        // جلب الطلاب المسندين لهذا المعلم
        $students = $teacher->childrenAsTeacher()
            ->with('dailyVariables')
            ->get();
        $dailyVariables = Daily_variables::where('teacher_id', $teacher->id)
            ->with('child')
            ->latest()
            ->get();

        $latestDailyVariable = $dailyVariables->first();
        // 2. عدد الطلاب المسجلين
        $studentsCount = $students->count();

        // 3. استخراج الصفوف المسندة للمعلم من خلال طلابه
        $classes = $students->pluck('class')->unique()->filter();
        return view('teacher.dashboard', compact(
            'teacher',
            'students',
            'dailyVariables',
            'studentsCount',
            'latestDailyVariable',
            'classes',
            'schoolBranding'
        ));
    }

    public function openNotification(string $notificationId)
    {
        $this->checkTeacher();

        $notification = auth()->user()->notifications()->findOrFail($notificationId);

        if ($notification->unread()) {
            $notification->markAsRead();
        }

        if (($notification->data['type'] ?? null) === 'mother_child_note') {
            return redirect()->route('teacher.mother_notes');
        }

        return redirect()->route('teacher.classes');
    }

    public function motherNotes()
    {
        $this->checkTeacher();

        $childNotes = MotherChildNote::where('teacher_id', auth()->id())
            ->with(['child:id,name,class', 'mother:id,name'])
            ->latest()
            ->get();

        return view('teacher.mother_notes', compact('childNotes'));
    }

    public function replyToMotherNote(Request $request, $noteId)
    {
        $this->checkTeacher();

        $validated = $request->validate([
            'reply' => 'required|string|max:2000',
        ]);

        $childNote = MotherChildNote::where('teacher_id', auth()->id())
            ->with(['child', 'teacher'])
            ->findOrFail($noteId);
        $childNote->update([
            'reply' => $validated['reply'],
            'replied_at' => now(),
        ]);
        $childNote->mother->notify(new MotherChildNoteReplyNotification($childNote));

        return back()->with('success', 'تم إرسال الرد إلى وليّة الأمر.');
    }

    // // 2. عرض طلاب المعلم
    // public function students()
    // {
    //     $this->checkTeacher();

    //     $teacher = auth()->user();

    //     $students = $teacher->childrenAsTeacher()
    //         ->with('dailyVariables')
    //         ->get();

    //     return view('teacher.student.create', compact(
    //         'students',
    //         'teacher'
    //     ));
    // }

    // عرض الصفوف الخاصة بالمعلم الحالي مع الطلاب المقيدين في كل صف
    // عرض الصفوف الخاصة بالمعلم الحالي مع الطلاب المقيدين في كل صف مع إمكانية البحث
    // عرض الصفوف الخاصة بالمعلم الحالي مع الطلاب المقيدين في كل صف مع إمكانية البحث والقائمة المنسدلة
    // عرض الصفوف الخاصة بالمعلم الحالي مع الطلاب المقيدين في كل صف مع إمكانية البحث والترتيب
    public function classes(Request $request)
    {
        $this->checkTeacher();

        $teacher = auth()->user();
        $schoolBranding = User::where('role', 'manager')
            ->where('school_name', $teacher->school_name)
            ->first() ?? $teacher;

        $availableClasses = $teacher->childrenAsTeacher()
            ->whereNotNull('class')
            ->pluck('class')
            ->unique()
            ->values();

        $searchName = $request->input('search_name');
        $searchClass = $request->input('search_class');
        $searchDate = $request->input('search_date');

        $query = $teacher->childrenAsTeacher()->with([
            'mother:id,name',
            'dailyVariables' => function ($q) use ($searchDate) {
                if (!empty($searchDate)) {
                    $q->whereDate('report_date', $searchDate);
                }
            },
        ]);

        if (!empty($searchName)) {
            $query->where('name', 'like', '%' . $searchName . '%');
        }

        if (!empty($searchClass)) {
            $query->where('class', $searchClass);
        }

        if (!empty($searchDate)) {
            $query->whereHas('dailyVariables', function ($q) use ($searchDate) {
                $q->whereDate('report_date', $searchDate);
            });
        }

        $students = $query->get();

        // مصفوفة الترتيب من الأول إلى الثاني عشر
        $order = [
            'الأول' => 1,
            'الاول' => 1,
            'الثاني' => 2,
            'ثاني' => 2,
            'الثالث' => 3,
            'ثالث' => 3,
            'الرابع' => 4,
            'رابع' => 4,
            'الخامس' => 5,
            'خامس' => 5,
            'السادس' => 6,
            'سادس' => 6,
            'السابع' => 7,
            'سابع' => 7,
            'الثامن' => 8,
            'ثامن' => 8,
            'التاسع' => 9,
            'تاسع' => 9,
            'العاشر' => 10,
            'عاشر' => 10,
            'الحادي عشر' => 11,
            'حادي عشر' => 11,
            'الثاني عشر' => 12,
            'ثاني عشر' => 12,
        ];

        // تجميع الطلاب حسب الصف وترتيبهم تصاعدياً بدقة
        $classes = $students->groupBy('class')->sortBy(function ($group, $className) use ($order) {
            foreach ($order as $key => $val) {
                if (str_contains($className, $key)) {
                    return $val;
                }
            }
            return 99;
        });

        return view('teacher.classes', compact('teacher', 'classes', 'availableClasses', 'schoolBranding'));
    }
    // 3. عرض تفاصيل طالب
    public function showStudent($id)
    {
        $this->checkTeacher();

        $teacher = auth()->user();

        // نتأكد أن الطالب تابع لهذا المعلم
        $student = $teacher->childrenAsTeacher()
            ->with('dailyVariables')
            ->where('chaldrins.id', $id)
            ->firstOrFail();

        return view('teacher.student_details', compact(
            'student',
            'teacher'
        ));
    }

    // 4. إضافة تقرير / متغيرات يومية للطالب
    public function storeDailyVariable(Request $request, $studentId)
    {
        $this->checkTeacher();

        $teacher = auth()->user();

        // التأكد أن الطالب مسند لهذا المعلم
        $student = $teacher->childrenAsTeacher()
            ->where('chaldrins.id', $studentId)
            ->firstOrFail();

        $request->validate([
            'topic' => 'required|string|max:255',
            'result' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'report_date' => 'required|date',
        ]);

        $report = Daily_variables::create([
            'child_id' => $student->id,
            'teacher_id' => $teacher->id,
            'topic' => $request->topic,
            'result' => $request->result,
            'notes' => $request->notes,
            'report_date' => $request->report_date,
        ]);

        $student->mother->notify(new NewDailyReportNotification($report));

        return back()->with(
            'success',
            'تمت إضافة التقرير بنجاح.'
        );
    }

    // 5. تعديل تقرير يومي
    public function updateDailyVariable(
        Request $request,
        $id
    ) {
        $this->checkTeacher();

        $teacher = auth()->user();

        $dailyVariable = Daily_variables::where(
            'teacher_id',
            $teacher->id
        )->findOrFail($id);

        $request->validate([
            'topic' => 'required|string|max:255',
            'result' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'report_date' => 'required|date',
        ]);

        $dailyVariable->update([
            'topic' => $request->topic,
            'result' => $request->result,
            'notes' => $request->notes,
            'report_date' => $request->report_date,
        ]);

        return back()->with(
            'success',
            'تم تعديل التقرير بنجاح.'
        );
    }

    // 6. حذف تقرير يومي
    public function deleteDailyVariable($id)
    {
        $this->checkTeacher();

        $teacher = auth()->user();

        $dailyVariable = Daily_variables::where(
            'teacher_id',
            $teacher->id
        )->findOrFail($id);

        $dailyVariable->delete();

        return back()->with(
            'success',
            'تم حذف التقرير بنجاح.'
        );
    }


    // عرض صفحة المتغيرات اليومية
    public function dailyVariables()
    {
        $this->checkTeacher();

        $teacher = auth()->user();
        $schoolBranding = User::where('role', 'manager')
            ->where('school_name', $teacher->school_name)
            ->first() ?? $teacher;

        // Load only each student's latest report for the card preview.
        $students = $teacher->childrenAsTeacher()
            ->withCount(['dailyVariables' => function ($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            }])
            ->with(['latestDailyVariable' => function ($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            }])
            ->get();

        return view('teacher.daily_variables', compact(
            'teacher',
            'students',
            'schoolBranding'
        ));
    }

    public function studentDailyReports(Request $request, $studentId)
    {
        $this->checkTeacher();

        $teacher = auth()->user();
        $student = $teacher->childrenAsTeacher()
            ->where('chaldrins.id', $studentId)
            ->firstOrFail();

        $reports = Daily_variables::where('teacher_id', $teacher->id)
            ->where('child_id', $student->id)
            ->orderByDesc('report_date')
            ->orderByDesc('id')
            ->paginate(10);

        return response()->json([
            'html' => view('teacher.partials.daily_reports', compact('reports'))->render(),
            'has_more' => $reports->hasMorePages(),
            'next_page' => $reports->currentPage() + 1,
            'total' => $reports->total(),
        ]);
    }

    // 7. عرض صفحة إضافة طفل جديد
    public function createStudent()
    {
        $this->checkTeacher();

        $teacher = auth()->user();
        $schoolBranding = User::where('role', 'manager')
            ->where('school_name', $teacher->school_name)
            ->first() ?? $teacher;

        // جلب قائمة الأمهات لاختيار الأم من القائمة
        $mothers = User::where('role', 'mother')->get();

        return view('teacher.student.create', compact('teacher', 'mothers', 'schoolBranding'));
    }

    // 8. حفظ بيانات الطفل الجديد
    public function storeStudent(Request $request)
    {
        $this->checkTeacher();
        $teacher = auth()->user();

        // البحث عن مدير الروضة بنفس اسم المدرسة
        $manager = User::where('role', 'manager')
            ->where('school_name', $teacher->school_name)
            ->first();

        $request->validate([
            'mother_id'     => 'required|exists:users,id',
            'name'          => 'required|string|max:255',
            'gender'        => 'required|in:male,female',
            'health_status' => 'required|string',
            'class'         => 'required|string|max:255',
            'age'           => 'required|integer|min:1|max:10',
            'image'         => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/children'), $imageName);
        }

        $student = chaldrin::create([
            'mother_id'     => $request->mother_id,
            'manager_id'    => $manager ? $manager->id : null, // ربط بـ ID المدير المكتشف
            'name'          => $request->name,
            'gender'        => $request->gender,
            'Health_status' => $request->health_status,
            'class'         => $request->class,
            'age'           => $request->age,
            'image'         => $imageName,
        ]);

        $teacher->childrenAsTeacher()->attach($student->id);

        return back()->with('success', 'تمت إضافة الطفل بنجاح.');
    }

    // public function storeStudent(Request $request)
    // {
    //     $this->checkTeacher();

    //     $teacher = auth()->user();

    //     // التحقق من البيانات
    //     $request->validate([
    //         'mother_id' => 'required|exists:users,id',
    //         'name' => 'required|string|max:255',
    //         'gender' => 'required|in:male,female',
    //         'Health_status' => 'required|string',
    //         'class' => 'required|string|max:255',
    //         'age' => 'required|integer|min:1|max:10',
    //         'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    //     ]);

    //     // إنشاء الطفل في جدول chaldrins
    //     $student = chaldrin::create([
    //         'mother_id' => $request->mother_id,
    //         'manager_id' => null,
    //         'name' => $request->name,
    //         'gender' => $request->gender,
    //         'Health_status' => $request->Health_status,
    //         'class' => $request->class,
    //         'age' => $request->age,
    //         'image' => null,
    //     ]);

    //     // رفع الصورة
    //     if ($request->hasFile('image')) {

    //         $imageName = time() . '.' . $request->image->extension();

    //         $request->image->move(
    //             public_path('images/children'),
    //             $imageName
    //         );

    //         $student->update([
    //             'image' => $imageName,
    //         ]);
    //     }

    //     // ربط الطفل بالمعلم في جدول Pivot
    //     $teacher->childrenAsTeacher()->attach($student->id);

    //     return redirect()
    //         ->route('teacher.studentscreate')
    //         ->with('success', 'تمت إضافة الطفل بنجاح.');
    // }

    // ==========================================
    // حساب المعلم (الملف الشخصي، التعديل، والحذف)
    // ==========================================

    // عرض الملف الشخصي للمعلم
    public function profile()
    {
        $this->checkTeacher();
        $teacher = auth()->user();

        return view('teacher.profile', compact('teacher'));
    }

    // حفظ تعديلات بيانات المعلم
    public function updateProfile(Request $request)
    {
        $this->checkTeacher();
        $teacher = auth()->user();

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $teacher->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $teacher->update($validated);

        return redirect()->route('teacher.profile')->with('success', 'تم تحديث البيانات الشخصية بنجاح.');
    }

    // حذف حساب المعلم
    public function deleteAccount(Request $request)
    {
        $this->checkTeacher();
        $teacher = auth()->user();

        auth()->logout();
        $teacher->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'تم حذف حساب المعلم بنجاح.');
    }

    // عرض صفحة العلامات الخاصة بالصف مع البحث
    // عرض صفحة العلامات الخاصة بالصف مع دعم البحث (اسم الطالب والتاريخ)
    // عرض صفحة العلامات الخاصة بالصف مع دعم البحث (اسم الطالب، اسم المادة، والتاريخ)
    public function showGrades(Request $request, $className)
    {
        $this->checkTeacher();
        $teacher = auth()->user();

        $studentsQuery = $teacher->childrenAsTeacher()
            ->where('class', $className);

        if ($request->filled('search_name')) {
            $studentsQuery->where('name', 'like', '%' . $request->search_name . '%');
        }

        $students = $studentsQuery->with(['dailyVariables' => function ($query) use ($request) {
            if ($request->filled('search_date')) {
                $query->whereDate('report_date', $request->search_date);
            }
            if ($request->filled('search_topic')) {
                $query->where('topic', 'like', '%' . $request->search_topic . '%');
            }
        }])->get();

        return view('teacher.grades', compact('students', 'className', 'teacher'));
    }
    // عرض صفحة الملاحظات الخاصة بالصف مع دعم البحث (اسم الطالب والتاريخ)
    // عرض صفحة الملاحظات الخاصة بالصف مع دعم البحث (اسم الطالب، موضوع الملاحظة، والتاريخ)
    public function showNotes(Request $request, $className)
    {
        $this->checkTeacher();
        $teacher = auth()->user();

        $studentsQuery = $teacher->childrenAsTeacher()
            ->where('class', $className);

        if ($request->filled('search_name')) {
            $studentsQuery->where('name', 'like', '%' . $request->search_name . '%');
        }

        $students = $studentsQuery->with(['dailyVariables' => function ($query) use ($request) {
            if ($request->filled('search_date')) {
                $query->whereDate('report_date', $request->search_date);
            }
            if ($request->filled('search_topic')) {
                $query->where('topic', 'like', '%' . $request->search_topic . '%');
            }
        }])->get();

        return view('teacher.notes', compact('students', 'className', 'teacher'));
    }
}
