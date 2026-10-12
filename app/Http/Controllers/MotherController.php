<?php

namespace App\Http\Controllers;

use App\Models\chaldrin;

class MotherController extends Controller
{
    public function dashboard()
    {
        $mother = auth()->user();

        // جلب أطفال الأم مع ملاحظاتهم، من الأحدث إلى الأقدم
        $children = chaldrin::where('mother_id', $mother->id)
            ->with(['dailyVariables' => function ($query) {
                $query->latest();
            }])
            ->get();

        return view('mother.dashboard', compact('mother', 'children'));
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
            ->with(['dailyVariables' => function ($query) {
                $query->latest();
            }])
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

    // صفحة تعديل بيانات الأم
    public function editProfile()
    {
        $this->checkMother();
        $mother = auth()->user();

        return view('mother.profile-edit', compact('mother'));
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