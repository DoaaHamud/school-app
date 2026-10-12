<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المدير - روضتي</title>

    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #f7f8fc;
            font-family: Arial, sans-serif;
            color: #1f2937;
        }

        .main-navbar {
            background: #ffffff;
            border-bottom: 1px solid #e9edf3;
            box-shadow: 0 3px 18px rgba(30, 41, 59, 0.06);
            min-height: 76px;
        }

        .navbar-brand {
            color: #1e293b !important;
            text-decoration: none;
        }

        .brand-icon {
            width: 46px;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: white;
            font-size: 20px;
            box-shadow: 0 5px 12px rgba(37, 99, 235, 0.20);
        }

        .brand-text {
            line-height: 1.2;
        }

        .brand-name {
            font-size: 18px;
            font-weight: 800;
            color: #2563eb;
        }

        .dashboard-name {
            font-size: 12px;
            color: #64748b;
            margin-top: 4px;
            font-weight: 500;
        }

        .nav-link {
            color: #475569 !important;
            font-size: 14px;
            font-weight: 600;
            padding: 11px 16px !important;
            border-radius: 10px;
            margin: 0 3px;
            transition: 0.2s;
        }

        .nav-link:hover,
        .nav-link.active {
            background: #eff6ff;
            color: #2563eb !important;
        }

        .nav-icon {
            margin-left: 7px;
            font-size: 16px;
        }

        .manager-account {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 6px 12px;
            margin-left: 15px;
            border-right: 1px solid #e5e7eb;
        }

        .manager-profile-btn {
            display: flex;
            align-items: center;
            gap: 9px;
            background: transparent;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
            text-align: right;
            border-radius: 10px;
        }

        .manager-profile-btn:hover {
            background: #f8fafc;
        }

        .manager-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .manager-info {
            display: flex;
            flex-direction: column;
        }

        .manager-label {
            font-size: 13px;
            font-weight: 700;
            color: #334155;
        }

        .manager-role {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 2px;
        }

        .manager-arrow {
            font-size: 11px;
            color: #94a3b8;
            margin-right: 4px;
        }

        .manager-dropdown {
            min-width: 230px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 8px;
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.10);
        }

        .logout-form {
            margin: 0;
        }

        .logout-btn {
            border: none;
            background: #fff1f2;
            color: #dc2626;
            padding: 9px 14px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background: #fee2e2;
            color: #b91c1c;
        }

        .page-container {
            max-width: 1200px;
            margin: 35px auto;
        }

        .page-title {
            font-size: 26px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 7px;
        }

        .page-subtitle {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .task-card {
            background: #ffffff;
            border: 1px solid #e8eaf0;
            border-radius: 14px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.04);
            margin-bottom: 25px;
            overflow: hidden;
        }

        .task-header {
            padding: 18px 22px;
            border-bottom: 1px solid #edf0f4;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .task-title {
            margin: 0;
            font-size: 17px;
            font-weight: 700;
            color: #1f2937;
        }

        .task-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .pending-icon {
            background: #fff7ed;
            color: #ea580c;
        }

        .approved-icon {
            background: #ecfdf5;
            color: #16a34a;
        }

        .assign-icon {
            background: #eff6ff;
            color: #2563eb;
        }

        .task-body {
            padding: 22px;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            color: #4b5563;
            font-size: 14px;
            font-weight: 600;
            background: #f9fafb;
            white-space: nowrap;
        }

        .table td {
            color: #4b5563;
            font-size: 14px;
            vertical-align: middle;
        }

        .teacher-name {
            font-weight: 600;
            color: #1f2937;
        }

        .status-badge {
            background: #dcfce7;
            color: #15803d;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .approve-btn {
            background: #16a34a;
            border: none;
            color: white;
            border-radius: 7px;
            padding: 6px 13px;
            font-size: 13px;
        }

        .approve-btn:hover {
            background: #15803d;
            color: white;
        }

        .reject-btn {
            background: #fee2e2;
            border: none;
            color: #dc2626;
            border-radius: 7px;
            padding: 6px 13px;
            font-size: 13px;
        }

        .reject-btn:hover {
            background: #fecaca;
            color: #b91c1c;
        }

        .empty-message {
            text-align: center;
            padding: 35px 10px;
            color: #9ca3af;
            font-size: 14px;
        }

        .empty-message i {
            font-size: 26px;
            color: #22c55e;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg main-navbar">
        <div class="container">
                <!-- حاوية الشعار -->
                <div style="width: 45px; height: 45px; flex-shrink: 0; border-radius: 12px; overflow: hidden; background: #eff6ff; display: flex; align-items: center; justify-content: center;">
                    <img src="{{ asset('images/logo.jpeg') }}"
                        alt="شعار روضتي"
                        style="width: 100%; height: 100%; object-fit: contain;">
                </div>

                <!-- النصوص بجانب الشعار بشكل منظم -->
                <div class="brand-text" style="display: flex; flex-direction: column; text-align: right;">
                    <span style="font-size: 18px; font-weight: 800; color: #2563eb; line-height: 1.2;">روضتي</span>
                    <span style="font-size: 12px; color: #64748b; margin-top: 2px; font-weight: 500;">لوحة تحكم المدير</span>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#managerNavbar" aria-controls="managerNavbar" aria-expanded="false" aria-label="فتح القائمة">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="managerNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}" href="{{ route('manager.dashboard') }}">
                            <i class="bi bi-check2-square nav-icon"></i> المهام
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('manager.teachers.*') ? 'active' : '' }}" href="{{ route('manager.teachers.index') }}">
                            <i class="bi bi-people-fill nav-icon"></i> دليل الأساتذة
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('manager.students') ? 'active' : '' }}" href="{{ route('manager.students') }}">
                            <i class="bi bi-mortarboard-fill nav-icon"></i> دليل الطلاب
                        </a>
                    </li>
                </ul>

                <!-- Manager Account -->
                <div class="dropdown manager-account">
                    <button class="manager-profile-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="manager-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="manager-info">
                            <span class="manager-label">{{ auth()->user()->name }}</span>
                            <span class="manager-role">إدارة الروضة</span>
                        </div>
                        <i class="bi bi-chevron-down manager-arrow"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end manager-dropdown">
                        <li>
                            <div class="dropdown-header px-3 py-2">
                                <strong>{{ auth()->user()->name }}</strong>
                                <small class="text-muted">{{ auth()->user()->email }}</small>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('manager.profile') }}">
                                <i class="bi bi-person-circle me-1"></i> الملف الشخصي
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('manager.profile.edit') }}">
                                <i class="bi bi-pencil-square me-1"></i> تعديل البيانات
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <button type="button" class="dropdown-item py-2 text-danger" data-bs-toggle="modal" data-bs-target="#deleteManagerModal">
                                <i class="bi bi-trash me-1"></i> حذف الحساب
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Logout -->
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="bi bi-box-arrow-right"></i> خروج
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container page-container">

        @if(session('success'))
        <div class="alert alert-success shadow-sm">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
        @endif

        <h1 class="page-title">المهام</h1>
        <p class="page-subtitle">متابعة وإدارة المهام الخاصة بالمدير</p>

        <!-- 1. تعيين أستاذ لصف (المهمة الجديدة المضافة للداشبورد) -->
        <div class="task-card">
            <div class="task-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="task-icon assign-icon">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <h2 class="task-title">تعيين أستاذ لصف دراسي</h2>
                </div>
            </div>
            <div class="task-body">
                @if($approvedTeachers->isEmpty() || $classes->isEmpty())
                <div class="text-muted small">يجب توفر معلمين مقبولين وصفوف مضافة لتتمكن من عملية التعيين.</div>
                @else
                <form action="{{ route('manager.assign.class.quick') }}" method="POST" class="row g-3 align-items-end">
                    @csrf
                    <input type="hidden" name="year" value="{{ $selectedYear }}">

                    <div class="col-md-5">
                        <label class="form-label fw-bold small text-secondary">اختر المعلم</label>
                        <select name="teacher_id" class="form-select" required>
                            <option value="">-- اختر المعلم --</option>
                            @foreach($approvedTeachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-5">
                        <label class="form-label fw-bold small text-secondary">اختر الصف الدراسي</label>
                        <select name="class" class="form-select" required>
                            <option value="">-- اختر الصف --</option>
                            @foreach($classes as $className)
                            <option value="{{ $className }}">{{ $className }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-lg me-1"></i> تعيين
                        </button>
                    </div>
                </form>
                @endif
            </div>
        </div>

        <!-- 2. Pending Teachers -->
        <div class="task-card">
            <div class="task-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="task-icon pending-icon">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <h2 class="task-title">طلبات تسجيل المعلمين المعلقة</h2>
                </div>
            </div>

            <div class="task-body">
                @if($pendingTeachers->isEmpty())
                <div class="empty-message">
                    <i class="bi bi-check-circle"></i>
                    <div class="mt-2">لا توجد طلبات معلقة حالياً.</div>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>رقم الهاتف</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingTeachers as $teacher)
                            <tr>
                                <td class="teacher-name">{{ $teacher->name }}</td>
                                <td>{{ $teacher->email }}</td>
                                <td>{{ $teacher->phone }}</td>
                                <td>
                                    <form action="{{ route('manager.teachers.approve', $teacher->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="approve-btn">
                                            <i class="bi bi-check-lg"></i> موافقة
                                        </button>
                                    </form>

                                    <form action="{{ route('manager.teachers.reject', $teacher->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="reject-btn" onclick="return confirm('هل أنت متأكد من رفض طلب المعلم؟')">
                                            <i class="bi bi-x-lg"></i> رفض
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>

        <!-- 3. Approved Teachers -->
        <div class="task-card">
            <div class="task-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="task-icon approved-icon">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                    <h2 class="task-title">المعلمون المقبولون</h2>
                </div>
            </div>

            <div class="task-body">
                @if($approvedTeachers->isEmpty())
                <div class="empty-message">لا يوجد معلمون مقبولون حالياً.</div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>رقم الهاتف</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($approvedTeachers as $teacher)
                            <tr>
                                <td class="teacher-name">{{ $teacher->name }}</td>
                                <td>{{ $teacher->email }}</td>
                                <td>{{ $teacher->phone }}</td>
                                <td>
                                    <span class="status-badge">
                                        <i class="bi bi-check-circle-fill"></i> مقبول
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>

    </div>

    <!-- Modal تحذير حذف الحساب -->
    <div class="modal fade" id="deleteManagerModal" tabindex="-1" aria-labelledby="deleteManagerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fs-6" id="deleteManagerModalLabel">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> تحذير: حذف الحساب
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bi bi-trash-fill text-danger display-4 mb-3 d-block"></i>
                    <h6 class="fw-bold text-dark mb-2">هل أنت متأكد تماماً من رغبتك في حذف الحساب؟</h6>
                    <p class="text-muted small mb-0">سيؤدي هذا الإجراء إلى حذف حسابك كمدير بشكل نهائي.</p>
                </div>
                <div class="modal-footer bg-light justify-content-center border-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">إلغاء</button>
                    <form action="{{ route('manager.profile.delete') }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4">نعم، احذف الحساب</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>