<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دليل الأساتذة - روضتي</title>

    <!-- Bootstrap RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background: #f7f8fc;
            font-family: Arial, sans-serif;
            color: #1f2937;
        }

        /* ================= Navbar ================= */
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

        /* ================= Manager Account ================= */
        .manager-account {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 6px 12px;
            margin-left: 15px;
            position: relative;
        }

        .manager-profile-btn {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 6px 8px;
            border: none;
            background: transparent;
            cursor: pointer;
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
            flex-shrink: 0;
        }

        .manager-info {
            display: flex;
            flex-direction: column;
            text-align: right;
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
            margin-right: 3px;
        }

        .manager-dropdown {
            min-width: 235px;
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
        }

        .logout-btn:hover {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* ================= Page ================= */
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
            margin-bottom: 25px;
        }

        /* ================= Filter ================= */
        .filter-card {
            background: white;
            border: 1px solid #e8eaf0;
            border-radius: 14px;
            padding: 18px 20px;
            margin-bottom: 25px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.04);
        }

        .filter-label {
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 7px;
        }

        .form-control,
        .form-select {
            border-radius: 9px;
            border: 1px solid #e5e7eb;
            padding: 9px 13px;
            font-size: 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .input-group-text {
            border-radius: 0 9px 9px 0;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-left: none;
            color: #9ca3af;
        }

        .input-group .form-control {
            border-radius: 9px 0 0 9px;
        }

        /* ================= Teacher Card ================= */
        .teacher-card {
            background: white;
            border: 1px solid #e8eaf0;
            border-radius: 15px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.04);
        }

        .teacher-header {
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #edf0f4;
        }

        .teacher-info {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .teacher-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .teacher-name {
            font-size: 17px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .teacher-email {
            font-size: 13px;
            color: #64748b;
        }

        .status-badge {
            background: #ecfdf5;
            color: #16a34a;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .teacher-body {
            padding: 20px;
        }

        /* ================= Info ================= */
        .info-item {
            margin-bottom: 15px;
        }

        .info-label {
            display: block;
            font-size: 12px;
            color: #94a3b8;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 14px;
            color: #475569;
            font-weight: 600;
        }

        .students-count {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #eff6ff;
            color: #2563eb;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .class-badge {
            display: inline-block;
            background: #f1f5f9;
            color: #475569;
            padding: 6px 10px;
            border-radius: 7px;
            font-size: 12px;
            margin-left: 5px;
            margin-bottom: 5px;
        }

        .assign-btn {
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 9px 16px;
            font-size: 13px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: 0.2s;
        }

        .assign-btn:hover {
            background: #1d4ed8;
            color: white;
        }

        .delete-teacher-btn {
            background: #fff1f2;
            color: #dc2626;
            border: 1px solid #fecdd3;
            border-radius: 8px;
            padding: 9px 16px;
            font-size: 13px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: 0.2s;
        }

        .delete-teacher-btn:hover {
            background: #fee2e2;
            color: #b91c1c;
        }

        .empty-box {
            background: white;
            border: 1px solid #e8eaf0;
            border-radius: 15px;
            padding: 50px 20px;
            text-align: center;
            color: #94a3b8;
        }

        .empty-box i {
            font-size: 40px;
            color: #cbd5e1;
            display: block;
            margin-bottom: 12px;
        }

        @media (max-width: 991px) {
            .navbar-nav {
                margin-top: 15px;
            }

            .manager-account {
                margin: 12px 0;
                padding: 10px 0;
                border-top: 1px solid #e5e7eb;
            }

            .logout-form {
                margin-bottom: 10px;
            }
        }

        @media (max-width: 768px) {
            .page-container {
                margin: 20px 15px;
            }

            .page-title {
                font-size: 22px;
            }

            .teacher-header {
                align-items: flex-start;
                flex-direction: column;
                gap: 15px;
            }
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
                            <div class="dropdown-header">
                                <strong>{{ auth()->user()->name }}</strong>
                                <small>{{ auth()->user()->email }}</small>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('manager.profile') }}">
                                <i class="bi bi-person-circle"></i> الملف الشخصي
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('manager.profile.edit') }}">
                                <i class="bi bi-pencil-square"></i> تعديل البيانات
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteManagerModal">
                                <i class="bi bi-trash"></i> حذف الحساب
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
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <h1 class="page-title">دليل الأساتذة</h1>
        <p class="page-subtitle">عرض المعلمين المقبولين والطلاب والصفوف المسندة إليها</p>

        <!-- Filter & Search Card -->
        <div class="filter-card">
            <form method="GET" action="{{ route('manager.teachers.index') }}" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="filter-label">البحث عن أستاذ</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="ادخل اسم الأستاذ..." value="{{ $search ?? '' }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="filter-label">العام الدراسي</label>
                    <select name="year" class="form-select">
                        @for($i = date('Y') - 5; $i <= date('Y') + 1; $i++)
                            <option value="{{ $i }}" {{ (int)($year ?? date('Y')) == $i ? 'selected' : '' }}>
                            العام الدراسي {{ $i }}
                            </option>
                            @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <button type="submit" class="assign-btn w-100 justify-content-center" style="padding: 10px;">
                        <i class="bi bi-filter"></i> تصفية وبحث
                    </button>
                </div>
            </form>
        </div>

        <!-- Teachers List -->
        @forelse($teachers as $teacher)
        <div class="teacher-card">

            <!-- Teacher Header -->
            <div class="teacher-header">
                <div class="teacher-info">
                    <div class="teacher-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <div class="teacher-name">{{ $teacher->name }}</div>
                        <div class="teacher-email">{{ $teacher->email }}</div>
                    </div>
                </div>

                <span class="status-badge">
                    <i class="bi bi-check-circle-fill"></i> مقبول
                </span>
            </div>

            <!-- Teacher Body -->
            <div class="teacher-body">
                <div class="row">
                    <!-- Phone -->
                    <div class="col-md-4">
                        <div class="info-item">
                            <span class="info-label">رقم الهاتف</span>
                            <span class="info-value">{{ $teacher->phone ?? 'غير متوفر' }}</span>
                        </div>
                    </div>

                    <!-- Students Count -->
                    <div class="col-md-4">
                        <div class="info-item">
                            <span class="info-label">عدد الطلاب</span>
                            <span class="students-count">
                                <i class="bi bi-people-fill"></i>
                                {{ $teacher->childrenAsTeacher->count() }} طالب
                            </span>
                        </div>
                    </div>

                    <!-- Classes -->
                    <div class="col-md-4">
                        <div class="info-item">
                            <span class="info-label">الصفوف المسندة</span>
                            @php
                            $teacherClasses = $teacher->childrenAsTeacher->pluck('class')->filter()->unique();
                            @endphp

                            @forelse($teacherClasses as $class)
                            <span class="class-badge">{{ $class }}</span>
                            @empty
                            <span class="text-muted small">لا يوجد صفوف مسندة</span>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Action Buttons (Assign & Delete) -->
                <div class="mt-3 d-flex gap-2 flex-wrap">
                    <a href="{{ route('manager.teachers.assign', ['teacher' => $teacher->id, 'year' => $year ?? date('Y')]) }}" class="assign-btn">
                        <i class="bi bi-person-plus-fill"></i> توزيع الطلاب
                    </a>

                    <!-- زر فتح مودال حذف الأستاذ -->
                    <button type="button" class="delete-teacher-btn" data-bs-toggle="modal" data-bs-target="#deleteTeacherModal{{ $teacher->id }}">
                        <i class="bi bi-trash"></i> حذف الأستاذ
                    </button>
                </div>
            </div>
        </div>

        <!-- Delete Teacher Modal لكل معلم على حدة -->
        <div class="modal fade" id="deleteTeacherModal{{ $teacher->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-exclamation-triangle-fill text-danger"></i> حذف المعلم
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <div class="mb-3">
                            <i class="bi bi-trash3-fill text-danger" style="font-size: 45px;"></i>
                        </div>
                        <h5 class="mb-2">هل أنت متأكد من حذف المعلم ({{ $teacher->name }})؟</h5>
                        <p class="text-muted mb-0">سيتم حذف حساب المعلم نهائيًا من الروضة.</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">إلغاء</button>

                        <!-- مسار الحذف المخصص للمعلم (استخدم مسار رفض/حذف المعلم الموجود لديك في الروابط، مثلاً manager.teachers.destroy أو reject) -->
                        <form action="{{ route('manager.teachers.reject', $teacher->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger px-4">
                                <i class="bi bi-trash3"></i> نعم، حذف
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-box">
            <i class="bi bi-people"></i>
            لا يوجد معلمون مطبقون لشروط البحث.
        </div>
        @endforelse

    </div>

    <!-- Delete Manager Account Modal -->
    <div class="modal fade" id="deleteManagerModal" tabindex="-1" aria-labelledby="deleteManagerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteManagerModalLabel">
                        <i class="bi bi-exclamation-triangle-fill text-danger"></i> حذف الحساب
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-3">
                        <i class="bi bi-trash3-fill text-danger" style="font-size: 45px;"></i>
                    </div>
                    <h5 class="mb-3">هل أنت متأكد من حذف حسابك؟</h5>
                    <p class="text-muted mb-0">سيتم حذف حساب المدير نهائيًا، ولا يمكن التراجع عن هذه العملية.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <form action="{{ route('manager.profile.delete') }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash3"></i> نعم، حذف الحساب
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>