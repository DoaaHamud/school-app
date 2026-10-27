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
    Route::view('/', 'welcome')->name('home');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
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
        // صفحة المؤشرات والرسومات البيانية الجديدة (تكون هي الواجهة الأولى للأدمن)
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/tasks', [AdminController::class, 'dashboardTasks'])->name('tasks');

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

        Route::get('/home', [ManagerController::class, 'home'])->name('home');
        Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('dashboard');
        Route::get('/teacher-assignments', [ManagerController::class, 'teacherAssignments'])->name('teacher-assignments');
        Route::get('/notifications/{notificationId}', [ManagerController::class, 'openNotification'])->name('notifications.open');
        // حساب المدير
        Route::get('/profile', [ManagerController::class, 'profile'])
            ->name('profile');

        Route::put('/profile', [ManagerController::class, 'updateProfile'])
            ->name('profile.update');

        Route::delete('/profile', [ManagerController::class, 'deleteAccount'])
            ->name('profile.delete');

        Route::get('/classes/{className}/mother-notes', [ManagerController::class, 'showClassMotherNotes'])
            ->name('classes.mother-notes');
        // موافقة ورفض معلم
        Route::patch('/teachers/{id}/approve', [ManagerController::class, 'approveTeacher'])->name('teachers.approve');
        Route::patch('/mothers/requests/{requestId}/approve', [ManagerController::class, 'approveMotherRequest'])->name('mothers.requests.approve');
        Route::patch('/mothers/requests/{requestId}/reject', [ManagerController::class, 'rejectMotherRequest'])->name('mothers.requests.reject');
        Route::patch('/teachers/{id}/reject', [ManagerController::class, 'rejectTeacher'])->name('teachers.reject');
        Route::patch('/teachers/{id}/deactivate', [ManagerController::class, 'deactivateTeacher'])->name('teachers.deactivate');
        Route::get('/teachers/deactivated', [ManagerController::class, 'deactivatedTeachers'])->name('teachers.deactivated');
        Route::patch('/teachers/{id}/reactivate', [ManagerController::class, 'reactivateTeacher'])->name('teachers.reactivate');
        Route::post('/assign-class-quick', [ManagerController::class, 'assignClassQuickStore'])->name('assign.class.quick');
        Route::delete('/unassign-class-quick', [ManagerController::class, 'unassignClassQuickStore'])->name('unassign.class.quick');
        // استعراض طلاب صف معين
        Route::get('/classes/{className}/students', [ManagerController::class, 'showClassStudents'])->name('classes.students');

        // ربط معلم بطلاب/صفوف
        Route::get('/teachers/{teacher}/assign', [ManagerController::class, 'assignTeacherForm'])->name('teachers.assign');
        Route::post('/teachers/{teacher}/assign', [ManagerController::class, 'assignTeacherStore'])->name('teachers.assign.store');

        // عرض قائمة المعلمين والصفوف المسندة لهم
        Route::get('/teachers', [ManagerController::class, 'teachersIndex'])->name('teachers.index');
        Route::get('/students/deactivated', [ManagerController::class, 'deactivatedStudents'])
            ->name('students.deactivated');
        Route::patch('/students/{id}/deactivate', [ManagerController::class, 'deactivateStudent'])
            ->name('students.deactivate');
        Route::patch('/students/{id}/reactivate', [ManagerController::class, 'reactivateStudent'])
            ->name('students.reactivate');
        Route::get('/students', [ManagerController::class, 'studentsIndex'])
            ->name('students');
        Route::get(
            '/students/{id}/profile',
            [ManagerController::class, 'studentProfile']
        )->name('students.profile');

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
        Route::get('/teacher/notifications/{notificationId}', [TeacherController::class, 'openNotification'])->name('teacher.notifications.open');
        Route::get('/teacher/mother-notes', [TeacherController::class, 'motherNotes'])->name('teacher.mother_notes');
        Route::post('/teacher/mother-notes/{noteId}/reply', [TeacherController::class, 'replyToMotherNote'])->name('teacher.mother_notes.reply');
        // حساب المعلم (Profile, Edit, Update, Delete)
        Route::get('/teacher/profile', [TeacherController::class, 'profile'])->name('teacher.profile');
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
        Route::get('/teacher/students/{studentId}/daily-reports', [TeacherController::class, 'studentDailyReports'])
            ->name('teacher.student.daily_reports');
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
        Route::get('/school-requests', [MotherController::class, 'schoolRequests'])->name('school_requests');
        Route::post('/school-requests', [MotherController::class, 'requestSchool'])->name('school_requests.store');
        Route::get('/notifications/{notificationId}', [MotherController::class, 'openNotification'])->name('notifications.open');
        Route::get('/child/{id}', [MotherController::class, 'showChild'])->name('child_details');
        Route::get('/child/{childId}/notes', [MotherController::class, 'childNotes'])->name('child_notes.index');
        Route::post('/child/{childId}/notes', [MotherController::class, 'storeChildNote'])->name('child_notes.store');
        Route::get('/profile', [MotherController::class, 'profile'])->name('profile');
        Route::put('/profile/update', [MotherController::class, 'updateProfile'])->name('profile.update');
        Route::delete('/profile/delete', [MotherController::class, 'deleteAccount'])->name('profile.delete');
    });
});
