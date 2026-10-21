<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use App\Notifications\TeacherRegistrationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        $schoolNames = School::whereHas('users', function ($query) {
            $query->where('role', 'manager')->where('status', 'approved');
        })
            ->distinct()
            ->orderBy('name')
            ->pluck('name');

        return view('auth.register', compact('schoolNames'));
    }

    public function register(Request $request)
    {
        $schoolNameRules = ['nullable', 'string', 'max:255'];

        if ($request->input('role') === 'teacher') {
            $schoolNameRules = [
                'required',
                'string',
                'max:255',
                Rule::exists('users', 'school_name')
                    ->where(fn($query) => $query
                        ->where('role', 'manager')
                        ->where('status', 'approved')),
            ];
        } elseif ($request->input('role') === 'manager') {
            $schoolNameRules = ['required', 'string', 'max:255'];
        }

        $validated = $request->validate(
            [
                'name'        => 'required|string|max:255',
                'username'    => 'required|string|max:255|unique:users,username',
                'email'       => 'required|string|email|max:255|unique:users,email',
                'password'    => 'required|string|min:8|confirmed',
                'role'        => 'required|in:manager,teacher,mother',
                // تم إضافة unique:users,phone لتفادي خطأ Database Unique Constraint Violation
                'phone'       => 'required|numeric|unique:users,phone',
                'school_name' => $schoolNameRules,
            ],
            [
                'phone.unique'    => 'رقم الهاتف مسجل مسبقًا.',
                'phone.required'  => 'حقل رقم الهاتف مطلوب.',
                'phone.numeric'   => 'رقم الهاتف يجب أن يتكون من أرقام فقط.',
                'email.unique'    => 'البريد الإلكتروني مسجل مسبقًا.',
                'username.unique' => 'اسم المستخدم مسجل مسبقًا.',
            ]
        );

        // ولي الأمر مفعل فوراً، بينما المدير والمعلم ينتظرون الموافقة
        $status = ($validated['role'] === 'mother') ? 'approved' : 'pending';

        $schoolName = $validated['role'] === 'mother'
            ? null
            : ($validated['school_name'] ?? null);

        $school = $schoolName !== null
            ? School::where('name', $schoolName)->whereHas('users', function ($query) {
                $query->where('role', 'manager')->where('status', 'approved');
            })->first()
            : null;

        if ($validated['role'] === 'teacher' && !$school) {
            abort(409, 'المدرسة المحددة غير موجودة.');
        }

        $user = User::create([
            'name'        => $validated['name'],
            'username'    => $validated['username'],
            'email'       => $validated['email'],
            'password'    => Hash::make($validated['password']),
            'role'        => $validated['role'],
            'phone'       => $validated['phone'],
            'school_name' => $schoolName,
            'school_id'   => $school?->id,
            'status'      => $status,
        ]);

        if ($user->role === 'teacher' && $user->school_id !== null) {
            User::where('role', 'manager')
                ->where('status', 'approved')
                ->where('school_id', $user->school_id)
                ->each(fn(User $manager) => $manager->notify(
                    new TeacherRegistrationNotification($user)
                ));
        }

        if ($user->status === 'pending') {
            return redirect()->route('login')->with('success', 'تم إنشاء الحساب بنجاح، وهو بانتظار موافقة المسؤول.');
        }

        Auth::login($user);
        return redirect()->route('mother.dashboard')->with('success', 'تم إنشاء الحساب وتسجيل الدخول بنجاح.');
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // فحص حالات الحساب المعطلة أو المعلقة أو المرفوضة
            if (in_array($user->status, ['pending', 'rejected', 'deactivated'])) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $message = match ($user->status) {
                    'pending'     => 'حسابك قيد الانتظار لموافقة الإدارة.',
                    'deactivated' => 'حسابك معطل حالياً من قبل الإدارة.',
                    'rejected'    => 'تم رفض طلب تسجيل هذا الحساب.',
                    default       => 'لا يمكنك الدخول بهذا الحساب.',
                };

                return redirect()->route('login')->with('error', $message);
            }

            // تجديد المعرف الخاص بالجلسة لحماية الحساب (Session Fixation Protection)
            $request->session()->regenerate();

            // توجيه المستخدم حسب الدور
            return match ($user->role) {
                'admin'   => redirect()->route('admin.dashboard'),
                'manager' => redirect()->route('manager.dashboard'),
                'teacher' => redirect()->route('teacher.dashboard'),
                'mother'  => redirect()->route('mother.dashboard'),
                default   => redirect()->route('login'),
            };
        }

        return back()->with('error', 'اسم المستخدم أو كلمة المرور غير صحيحة.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
