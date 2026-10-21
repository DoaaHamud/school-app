<?php

namespace App\Http\Controllers;

use App\Models\chaldrin;
use App\Models\MotherChildNote;
use App\Models\School;
use App\Models\SchoolMotherRequest;
use App\Notifications\MotherChildNoteReplyNotification;
use App\Notifications\MotherChildNoteNotification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MotherController extends Controller
{
    public function dashboard()
    {
        $mother = auth()->user();

        // جلب أطفال الأم مع ملاحظاتهم، من الأحدث إلى الأقدم
        $children = chaldrin::where('mother_id', $mother->id)
            ->with([
                'school:id,name,logo,color',
                'teachers:id,name,status',
                'dailyVariables' => function ($query) {
                    $query->latest();
                },
            ])
            ->get();

        $motherNotifications = $mother->notifications()->latest()->take(5)->get();
        $unreadNotificationsCount = $mother->unreadNotifications()->count();

        return view('mother.dashboard', compact(
            'mother',
            'children',
            'motherNotifications',
            'unreadNotificationsCount'
        ));
    }

    public function schoolRequests()
    {
        $this->checkMother();
        $mother = auth()->user();
        $schoolRequests = $mother->schoolRequests()->with('school:id,name')->latest()->get();
        $availableSchools = School::whereHas('users', function ($query) {
            $query->where('role', 'manager')
                ->where('status', 'approved');
        })
            ->whereDoesntHave('motherRequests', function ($query) use ($mother) {
                $query->where('mother_id', $mother->id)
                    ->whereIn('status', ['pending', 'approved']);
            })
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('mother.school_requests', compact(
            'mother',
            'schoolRequests',
            'availableSchools'
        ));
    }

    public function requestSchool(Request $request)
    {
        $this->checkMother();

        $validated = $request->validate([
            'school_id' => ['required', 'integer', Rule::exists('schools', 'id')],
        ]);
        $mother = auth()->user();
        $school = School::whereKey($validated['school_id'])
            ->whereHas('users', function ($query) {
                $query->where('role', 'manager')
                    ->where('status', 'approved');
            })
            ->first();

        if (!$school) {
            return back()->withErrors([
                'school_id' => 'المدرسة المختارة غير متاحة حاليًا.',
            ]);
        }

        $existingRequest = SchoolMotherRequest::where('school_id', $school->id)
            ->where('mother_id', $mother->id)
            ->first();

        if ($existingRequest?->status === 'approved') {
            return back()->with('error', 'تمت الموافقة على انضمامك لهذه المدرسة مسبقًا.');
        }

        if ($existingRequest?->status === 'pending') {
            return back()->with('error', 'طلبك لهذه المدرسة ما زال بانتظار موافقة المدير.');
        }

        SchoolMotherRequest::updateOrCreate(
            ['school_id' => $school->id, 'mother_id' => $mother->id],
            ['status' => 'pending']
        );

        return redirect()
            ->route('mother.school_requests')
            ->with('success', 'تم إرسال طلب الانضمام إلى المدرسة بانتظار موافقة المدير.');
    }

    public function storeChildNote(Request $request, $childId)
    {
        $this->checkMother();

        $validated = $request->validate([
            'note' => 'required|string|max:2000',
            'teacher_id' => 'nullable|integer',
        ]);

        $mother = auth()->user();
        $child = chaldrin::where('mother_id', $mother->id)
            ->with('teachers')
            ->findOrFail($childId);
        $teachers = $child->teachers;

        if ($teachers->isEmpty()) {
            return back()
                ->withInput()
                ->withErrors(['note' => "لا يوجد معلمون معينون للطفل {$child->name} لإرسال الملاحظة إليهم."]);
        }

        $selectedTeacher = isset($validated['teacher_id'])
            ? $teachers->firstWhere('id', (int) $validated['teacher_id'])
            : null;

        if (isset($validated['teacher_id']) && !$selectedTeacher) {
            return back()
                ->withInput()
                ->withErrors(['teacher_id' => 'المعلم المحدد غير معين لهذا الطفل.']);
        }

        $recipients = $selectedTeacher ? collect([$selectedTeacher]) : $teachers;

        foreach ($recipients as $teacher) {
            $childNote = MotherChildNote::create([
                'child_id' => $child->id,
                'mother_id' => $mother->id,
                'teacher_id' => $teacher->id,
                'note' => $validated['note'],
            ]);

            $teacher->notify(new MotherChildNoteNotification(
                $childNote,
                $child,
                $mother,
                $validated['note']
            ));
        }

        $recipientLabel = $selectedTeacher
            ? "المعلم {$selectedTeacher->name}"
            : 'جميع المعلمين المسؤولين';

        return back()->with('success', "تم إرسال الملاحظة إلى {$recipientLabel} عن {$child->name}.");
    }

    public function childNotes($childId)
    {
        $this->checkMother();

        $mother = auth()->user();
        $child = chaldrin::where('mother_id', $mother->id)
            ->with('school:id,name,logo,color')
            ->findOrFail($childId);
        $childNotes = MotherChildNote::where('mother_id', $mother->id)
            ->where('child_id', $child->id)
            ->with('teacher:id,name')
            ->latest()
            ->get();

        return view('mother.child_notes', compact('child', 'childNotes'));
    }

    public function openNotification(string $notificationId)
    {
        $this->checkMother();

        $mother = auth()->user();
        $notification = $mother->notifications()->findOrFail($notificationId);
        $childId = $notification->data['child_id'] ?? null;

        if (!is_numeric($childId)) {
            abort(404);
        }

        $child = chaldrin::where('mother_id', $mother->id)
            ->findOrFail((int) $childId);

        if ($notification->unread()) {
            $notification->markAsRead();
        }

        if (($notification->data['type'] ?? null) === 'mother_child_note_reply') {
            return redirect()->route('mother.child_notes.index', $child->id);
        }

        return redirect()->route('mother.child_details', $child->id);
    }

    /**
     * عرض تفاصيل طفل معين مع كافة الملاحظات والسجلات
     */
    public function showChild($id)
    {
        $mother = auth()->user();

        // التأكد أن الطفل تابع للأم الحالية
        $child = chaldrin::where('id', $id)
            ->where('mother_id', $mother->id)
            ->with([
                'school:id,name,logo,color',
                'teachers:id,name,status',
                'dailyVariables' => function ($query) {
                    $query->latest();
                },
            ])
            ->firstOrFail();
        $motherNotifications = $mother->notifications()->latest()->take(5)->get();
        $unreadNotificationsCount = $mother->unreadNotifications()->count();

        return view('mother.child_details', compact(
            'child',
            'motherNotifications',
            'unreadNotificationsCount'
        ));
    }

    // فحص صلاحيات الأم
    private function checkMother()
    {
        if (auth()->user()->role !== 'mother') {
            abort(403, 'غير مصرح لك بدخول هذه الصفحة.');
        }
    }

    // عرض الملف الشخصي للأم
    public function profile()
    {
        $this->checkMother();
        $mother = auth()->user();

        return view('mother.profile', compact('mother'));
    }

    // حفظ تعديلات بيانات الأم
    public function updateProfile(Request $request)
    {
        $this->checkMother();
        $mother = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $mother->id,
            ],
            'phone' => 'nullable|string|max:20',
        ]);

        $mother->update($validated);

        return redirect()
            ->route('mother.profile')
            ->with('success', 'تم تحديث بيانات الحساب بنجاح.');
    }

    // حذف حساب الأم
    public function deleteAccount(Request $request)
    {
        $this->checkMother();
        $mother = auth()->user();

        auth()->logout();
        $mother->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'تم حذف حسابك بنجاح.');
    }
}