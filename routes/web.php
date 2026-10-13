<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\MotherController;

// ==========================================
// 1. مسارات الضيوف (Guest Routes)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// ==========================================
// 2. مسارات المسجلين (Authenticated Routes)
// ==========================================
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --------------------------------------
    // أ. مسارات الأدمن (Admin)
    // --------------------------------------
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // مسار الحسابات المعطلة (تم وضعه قبل مسارات البرامتر لعدم التضارب)
        Route::get('/managers/deactivated', [AdminController::class, 'deactivatedManagers'])->name('managers.deactivated');

        // إدارة المدراء باستعمال Route Model Binding {manager}
        Route::patch('/managers/{manager}/approve', [AdminController::class, 'approveManager'])->name('managers.approve');
        Route::delete('/managers/{manager}/reject', [AdminController::class, 'rejectManager'])->name('managers.reject');
        Route::patch('/managers/{manager}/deactivate', [AdminController::class, 'deactivateManager'])->name('managers.deactivate');
        Route::patch('/managers/{manager}/reactivate', [AdminController::class, 'reactivateManager'])->name('managers.reactivate');
        Route::delete('/managers/{manager}', [AdminController::class, 'destroyManager'])->name('managers.destroy');
    });

    // --------------------------------------
    // ب. مسارات المدير (Manager)
    // --------------------------------------
    // --------------------------------------
    // ب. مسارات المدير (Manager)
    // --------------------------------------
    Route::prefix('manager')->name('manager.')->group(function () {
        Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('dashboard');
        // حساب المدير
        Route::get('/profile', [ManagerController::class, 'profile'])
            ->name('profile');

        Route::get('/profile/edit', [ManagerController::class, 'editProfile'])
            ->name('profile.edit');

        Route::put('/profile', [ManagerController::class, 'updateProfile'])
            ->name('profile.update');

        Route::delete('/profile', [ManagerController::class, 'deleteAccount'])
            ->name('profile.delete');

        // موافقة ورفض معلم
        Route::patch('/teachers/{id}/approve', [ManagerController::class, 'approveTeacher'])->name('teachers.approve');
        Route::patch('/teachers/{id}/reject', [ManagerController::class, 'rejectTeacher'])->name('teachers.reject');
        Route::post('/assign-class-quick', [ManagerController::class, 'assignClassQuickStore'])->name('assign.class.quick');        // استعراض طلاب صف معين
        Route::get('/classes/{className}/students', [ManagerController::class, 'showClassStudents'])->name('classes.students');

        // ربط معلم بطلاب/صفوف
        Route::get('/teachers/{teacher}/assign', [ManagerController::class, 'assignTeacherForm'])->name('teachers.assign');
        Route::post('/teachers/{teacher}/assign', [ManagerController::class, 'assignTeacherStore'])->name('teachers.assign.store');

        // عرض قائمة المعلمين والصفوف المسندة لهم
        Route::get('/teachers', [ManagerController::class, 'teachersIndex'])->name('teachers.index');
        Route::get('/students', [ManagerController::class, 'studentsIndex'])
            ->name('students');
        Route::get(
            '/students/{id}/profile',
            [ManagerController::class, 'studentProfile']
        )->name('students.profile');

        Route::delete('/students/{id}', [ManagerController::class, 'destroyStudent'])->name('students.destroy');
        Route::get('/classes/{className}/grades', [ManagerController::class, 'showClassGrades'])->name('classes.grades');
        Route::get('/classes/{className}/notes', [ManagerController::class, 'showClassNotes'])->name('classes.notes');
        Route::put('/settings/update', [ManagerController::class, 'updateSettings'])->name('settings.update');
    });

    // --------------------------------------
    // ج. مسارات المعلم (Teacher)
    // --------------------------------------

    Route::middleware(['auth'])->group(function () {

        // لوحة تحكم المعلم
        Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
        // حساب المعلم (Profile, Edit, Update, Delete)
        Route::get('/teacher/profile', [TeacherController::class, 'profile'])->name('teacher.profile');
        Route::get('/teacher/profile/edit', [TeacherController::class, 'editProfile'])->name('teacher.profile.edit');
        Route::put('/teacher/profile', [TeacherController::class, 'updateProfile'])->name('teacher.profile.update');
        Route::delete('/teacher/profile', [TeacherController::class, 'deleteAccount'])->name('teacher.profile.delete');
        Route::get('/teacher/classes/{class}/grades', [TeacherController::class, 'showGrades'])->name('teacher.classes.grades');
        Route::get('/teacher/classes/{class}/notes', [TeacherController::class, 'showNotes'])->name('teacher.classes.notes');
        // عرض قائمة الطلاب
        // Route::get('/teacher/students', [TeacherController::class, 'students'])->name('teacher.students');

        // صفحة إضافة طفل جديد (GET)
        Route::get('/teacher/students/create', [TeacherController::class, 'createStudent'])->name('teacher.students.create');

        // حفظ الطفل الجديد (POST)
        Route::post('/teacher/students', [TeacherController::class, 'storeStudent'])->name('teacher.students.store');

        // تفاصيل طالب
        Route::get('/teacher/students/{id}', [TeacherController::class, 'showStudent'])->name('teacher.student.show');

        // المتغيرات اليومية
        Route::post('/teacher/students/{studentId}/daily-variable', [TeacherController::class, 'storeDailyVariable'])->name('teacher.daily_store');
        Route::put('/teacher/daily-variable/{id}', [TeacherController::class, 'updateDailyVariable'])->name('teacher.daily_update');
        Route::delete('/teacher/daily-variable/{id}', [TeacherController::class, 'deleteDailyVariable'])->name('teacher.daily_delete');
        Route::get('/teacher/daily-variables', [TeacherController::class, 'dailyVariables'])
            ->name('teacher.daily_variables');
        // عرض صفوف المعلم
        Route::get('/teacher/classes', [TeacherController::class, 'classes'])->name('teacher.classes');
    });

    // --------------------------------------
    // د. مسارات ولي الأمر (Parent)
    // --------------------------------------

    Route::middleware('auth')->prefix('mother')->name('mother.')->group(function () {
        Route::get('/dashboard', [MotherController::class, 'dashboard'])->name('dashboard');
        Route::get('/child/{id}', [MotherController::class, 'showChild'])->name('child_details');
        Route::get('/profile', [MotherController::class, 'profile'])->name('profile');
        Route::get('/profile/edit', [MotherController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile/update', [MotherController::class, 'updateProfile'])->name('profile.update');
        Route::delete('/profile/delete', [MotherController::class, 'deleteAccount'])->name('profile.delete');
    });
});
