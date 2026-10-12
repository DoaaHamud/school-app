<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المعلم - روضتي</title>

    <!-- Bootstrap 5 RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background-color: #f6f8fb;
            font-family: "Segoe UI", Tahoma, Arial, sans-serif;
            color: #273142;
        }

        .navbar-custom {
            background-color: #ffffff;
            min-height: 70px;
            padding: 0 35px;
            border-bottom: 1px solid #e8ebef;
        }

        .navbar-brand {
            font-size: 22px;
            font-weight: 700;
            color: #1f2937;
            margin-left: 30px;
            text-decoration: none;
        }

        .nav-link {
            color: #4b5563;
            font-size: 15px;
            font-weight: 500;
            padding: 24px 15px !important;
            transition: 0.2s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #2563eb;
        }

        .teacher-profile-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background: transparent;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 10px;
        }

        .teacher-profile-btn:hover {
            background-color: #f1f5f9;
        }

        .teacher-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .teacher-dropdown {
            min-width: 230px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 8px;
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.10);
        }

        .logout-btn {
            background-color: transparent;
            border: 1px solid #dc3545;
            color: #dc3545;
            border-radius: 7px;
            padding: 7px 15px;
            font-size: 14px;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background-color: #dc3545;
            color: white;
        }

        .main-container {
            max-width: 1400px;
            margin: auto;
            padding: 40px 30px;
        }

        .page-header h2 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #1f2937;
        }

        .page-header p {
            color: #6b7280;
            margin: 0;
            font-size: 15px;
        }

        .stat-card {
            background-color: #ffffff;
            border: 1px solid #e8ebef;
            border-radius: 10px;
            padding: 24px;
            height: 100%;
            transition: 0.2s;
        }

        .stat-card:hover {
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.06);
        }

        .stat-label {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .stat-number {
            color: #1f2937;
            font-size: 30px;
            font-weight: 700;
        }

        .stat-description {
            color: #9ca3af;
            font-size: 13px;
            margin-top: 5px;
        }

        .latest-section {
            background-color: #ffffff;
            border: 1px solid #e8ebef;
            border-radius: 10px;
            margin-top: 30px;
            overflow: hidden;
        }

        .section-header {
            padding: 20px 25px;
            border-bottom: 1px solid #e8ebef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .student-count {
            background-color: #eef4ff;
            color: #2563eb;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .latest-content {
            padding: 25px;
        }

        .latest-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .latest-item {
            flex: 1;
            min-width: 180px;
            background-color: #f8fafc;
            border-radius: 8px;
            padding: 15px;
        }

        .latest-label {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .latest-value {
            color: #1f2937;
            font-size: 15px;
            font-weight: 600;
        }

        .latest-notes {
            margin-top: 15px;
            background-color: #f8fafc;
            border-radius: 8px;
            padding: 15px;
        }

        .no-latest {
            padding: 30px;
            text-align: center;
            color: #9ca3af;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <!-- حاوية الشعار -->
            <div style="width: 45px; height: 45px; flex-shrink: 0; border-radius: 12px; overflow: hidden; background: #eff6ff; display: flex; align-items: center; justify-content: center;">
                <img src="{{ asset('images/logo.jpeg') }}"
                    alt="شعار روضتي"
                    style="width: 100%; height: 100%; object-fit: contain;">
            </div>

            <!-- النصوص بجانب الشعار -->
            <div class="brand-text" style="display: flex; flex-direction: column; text-align: right;">
                <span style="font-size: 18px; font-weight: 800; color: #2563eb; line-height: 1.2;">روضتي</span>
                <span style="font-size: 12px; color: #64748b; margin-top: 2px; font-weight: 500;">لوحة تحكم المعلمة</span>
            </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#teacherNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="teacherNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}" href="{{ route('teacher.dashboard') }}">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('teacher.students.create') ? 'active' : '' }}" href="{{ route('teacher.students.create') }}">إضافة طفل جديد</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('teacher.classes') ? 'active' : '' }}" href="{{ route('teacher.classes') }}">الصفوف المتاحة</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('teacher.daily_variables') ? 'active' : '' }}" href="{{ route('teacher.daily_variables') }}">المتغيرات اليومية</a>
                    </li>
                </ul>

                <!-- قائمة حساب المعلم -->
                <div class="dropdown me-3">
                    <button class="teacher-profile-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="teacher-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-dark fs-6">{{ $teacher->name }}</div>
                            <small class="text-muted d-block" style="font-size: 11px;">معلم</small>
                        </div>
                        <i class="bi bi-chevron-down text-muted ms-1" style="font-size: 12px;"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end teacher-dropdown">
                        <li>
                            <div class="px-3 py-2">
                                <div class="fw-bold text-dark fs-6">{{ $teacher->name }}</div>
                                <small class="text-muted">{{ $teacher->email }}</small>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('teacher.profile') }}">
                                <i class="bi bi-person-circle me-2 text-primary"></i> الملف الشخصي
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('teacher.profile.edit') }}">
                                <i class="bi bi-pencil-square me-2 text-warning"></i> تعديل البيانات
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <button type="button" class="dropdown-item py-2 text-danger" data-bs-toggle="modal" data-bs-target="#deleteTeacherModal">
                                <i class="bi bi-trash me-2"></i> حذف الحساب
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- تسجيل الخروج -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="bi bi-box-arrow-right me-1"></i> تسجيل الخروج
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-container">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
        </div>
        @endif

        <div class="page-header">
            <h2>لوحة تحكم المعلم</h2>
            <p>مرحباً {{ $teacher->name }}، يمكنك متابعة الطلاب وإدارة سجلاتهم اليومية من هنا.</p>
        </div>

        <!-- Statistics -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-label">عدد الطلاب</div>
                    <div class="stat-number">{{ $studentsCount }}</div>
                    <div class="stat-description">إجمالي الطلاب المسندين إليك</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-label">عدد الصفوف</div>
                    <div class="stat-number">{{ $classes->count() }}</div>
                    <div class="stat-description">الصفوف المرتبطة بطلابك</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-label">السجلات اليومية</div>
                    <div class="stat-number">{{ $dailyVariables->count() }}</div>
                    <div class="stat-description">إجمالي السجلات التي تم إدخالها</div>
                </div>
            </div>
        </div>

        <!-- Latest Daily Variable -->
        <div class="latest-section">
            <div class="section-header">
                <h4 class="mb-0">آخر تحديث يومي</h4>
                @if($latestDailyVariable)
                <span class="student-count">آخر سجل</span>
                @endif
            </div>

            @if($latestDailyVariable)
            <div class="latest-content">
                <div class="latest-row">
                    <div class="latest-item">
                        <div class="latest-label">الطالب</div>
                        <div class="latest-value">{{ $latestDailyVariable->child->name ?? 'غير محدد' }}</div>
                    </div>
                    <div class="latest-item">
                        <div class="latest-label">الموضوع</div>
                        <div class="latest-value">{{ $latestDailyVariable->topic }}</div>
                    </div>
                    <div class="latest-item">
                        <div class="latest-label">النتيجة</div>
                        <div class="latest-value">
                            {{ $latestDailyVariable->result !== null ? $latestDailyVariable->result : 'غير محددة' }}
                        </div>
                    </div>
                    <div class="latest-item">
                        <div class="latest-label">تاريخ السجل</div>
                        <div class="latest-value">
                            {{ \Carbon\Carbon::parse($latestDailyVariable->report_date)->format('Y-m-d H:i') }}
                        </div>
                    </div>
                </div>

                @if($latestDailyVariable->notes)
                <div class="latest-notes">
                    <div class="latest-label">الملاحظات</div>
                    <p class="mb-0">{{ $latestDailyVariable->notes }}</p>
                </div>
                @endif
            </div>
            @else
            <div class="no-latest">لا توجد سجلات يومية حتى الآن.</div>
            @endif
        </div>
    </main>

    <!-- Modal تحذير حذف الحساب -->
    <div class="modal fade" id="deleteTeacherModal" tabindex="-1" aria-labelledby="deleteTeacherModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fs-6" id="deleteTeacherModalLabel">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> تحذير: حذف الحساب
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bi bi-trash3-fill text-danger display-4 mb-3 d-block"></i>
                    <h6 class="fw-bold text-dark mb-2">هل أنت متأكد من حذف حسابك؟</h6>
                    <p class="text-muted small mb-0">
                        سيتم حذف حساب المعلم نهائياً ولا يمكن التراجع عن هذه العملية.
                    </p>
                </div>
                <div class="modal-footer bg-light justify-content-center border-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">إلغاء</button>

                    <form action="{{ route('teacher.profile.delete') }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4">
                            <i class="bi bi-trash3 me-1"></i> نعم، احذف الحساب
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>