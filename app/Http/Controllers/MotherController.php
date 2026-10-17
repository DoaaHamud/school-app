<?php

namespace App\Http\Controllers;

use App\Models\chaldrin;
use App\Notifications\MotherChildNoteNotification;
use Illuminate\Http\Request;

class MotherController extends Controller
{
    public function dashboard()
    {
        $mother = auth()->user();

        // جلب أطفال الأم مع ملاحظاتهم، من الأحدث إلى الأقدم
        $children = chaldrin::where('mother_id', $mother->id)
            ->with([
                'manager:id,school_name,school_logo,primary_color',
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

    public function storeChildNote(Request $request, $childId)
    {
        $this->checkMother();

        $validated = $request->validate([
            'note' => 'required|string|max:2000',
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

        foreach ($teachers as $teacher) {
            $teacher->notify(new MotherChildNoteNotification(
                $child,
                $mother,
                $validated['note']
            ));
        }

        return back()->with('success', "تم إرسال الملاحظة إلى جميع المعلمين المسؤولين عن {$child->name}.");
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
                'manager:id,school_name,school_logo,primary_color',
                'dailyVariables' => function ($query) {
                    $query->latest();
                },
            ])
            ->firstOrFail();

        return view('mother.child_details', compact('child'));
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