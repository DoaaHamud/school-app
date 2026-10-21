<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // عرض لوحة تحكم الأدمن (الطلبات المعلقة + المفعلون + عداد غير المفعلين)
    public function dashboard(Request $request)
    {
        $this->checkAdmin();

        $pendingManagers = User::where('role', 'manager')
            ->where('status', 'pending')
            ->latest()
            ->get();

        $approvedManagersQuery = User::where('role', 'manager')
            ->where('status', 'approved')
            ->latest();
        $approvedManagerCount = (clone $approvedManagersQuery)->count();
        $managerSearch = $request->input('manager_search');

        if (is_string($managerSearch) && trim($managerSearch) !== '') {
            $approvedManagersQuery->where('name', 'like', '%' . trim($managerSearch) . '%');
        }

        $approvedManagers = $approvedManagersQuery->get();

        $deactivatedCount = User::where('role', 'manager')
            ->where('status', 'deactivated')
            ->count();

        return view('admin.dashboard', compact(
            'pendingManagers',
            'approvedManagers',
            'approvedManagerCount',
            'managerSearch',
            'deactivatedCount'
        ));
    }

    // الموافقة على طلب مدير
    public function approveManager(User $manager)
    {
        $this->checkAdmin();

        $schoolName = $manager->school_name ?: $manager->name;
        $school = School::firstOrCreate(
            ['name' => $schoolName],
            [
                'logo' => $manager->school_logo,
                'color' => $manager->primary_color ?: '#2563eb',
            ]
        );

        if ($manager->school_name !== null) {
            User::where('school_name', $manager->school_name)
                ->whereNull('school_id')
                ->update(['school_id' => $school->id]);
        }
        $manager->update([
            'school_id' => $school->id,
            'school_name' => $schoolName,
            'status' => 'approved',
        ]);

        return back()->with('success', 'تمت الموافقة على حساب المدير بنجاح.');
    }

    // رفض طلب مدير (حذفه فوراً من قاعدة البيانات)
    public function rejectManager(User $manager)
    {
        $this->checkAdmin();

        $manager->delete();

        return back()->with('success', 'تم رفض طلب المدير وحذفه نهائياً من قاعدة البيانات.');
    }

    // إلغاء تفعيل حساب مدير (نقل حالته إلى deactivated)
    public function deactivateManager(User $manager)
    {
        $this->checkAdmin();

        $manager->update(['status' => 'deactivated']);

        return back()->with('success', 'تم إلغاء تفعيل حساب المدير ونقله لقائمة الحسابات غير المفعلة.');
    }

    // عرض صفحة المدراء غير المفعلين
    public function deactivatedManagers()
    {
        $this->checkAdmin();

        $deactivatedManagers = User::where('role', 'manager')
            ->where('status', 'deactivated')
            ->with('school:id,name')
            ->latest()
            ->get();

        return view('admin.deactivated', compact('deactivatedManagers'));
    }

    // إعادة تفعيل حساب مدير
    public function reactivateManager(User $manager)
    {
        $this->checkAdmin();

        $manager->update(['status' => 'approved']);

        return redirect()->route('admin.managers.deactivated')->with('success', 'تمت إعادة تفعيل حساب المدير بنجاح.');
    }

    // حذف حساب المدير نهائياً
    public function destroyManager(User $manager)
    {
        $this->checkAdmin();

        $manager->delete();

        return back()->with('success', 'تم حذف حساب المدير نهائياً من قاعدة البيانات.');
    }

    // فحص صلاحيات الأدمن
    private function checkAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بدخول هذه الصفحة.');
        }
    }
}
