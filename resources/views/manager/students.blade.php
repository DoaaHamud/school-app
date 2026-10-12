<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دليل الطلاب - روضتي</title>

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
            max-width: 1300px;
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
            margin-bottom: 30px;
            overflow: hidden;
        }

        .task-header {
            padding: 16px 22px;
            background: #2563eb;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .task-title {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: white;
        }

        .table {
            margin-bottom: 0;
            text-align: center;
        }

        .table th {
            color: #4b5563;
            font-size: 13px;
            font-weight: 600;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            padding: 12px;
        }

        .table td {
            color: #374151;
            font-size: 13px;
            vertical-align: middle;
            padding: 12px;
        }

        .btn-light-custom {
            background: #ffffff;
            color: #2563eb;
            font-size: 12px;
            font-weight: 600;
            border-radius: 8px;
            padding: 5px 12px;
            border: none;
            transition: 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-light-custom:hover {
            background: #f8fafc;
            color: #1d4ed8;
        }

        .search-btn {
            background: #2563eb;
            border: none;
            color: white;
            border-radius: 9px;
            padding: 9px 16px;
            font-size: 14px;
            font-weight: 600;
            transition: 0.2s;
        }

        .search-btn:hover {
            background: #1d4ed8;
            color: white;
        }

        .form-control,
        .form-select {
            border-radius: 9px;
            border: 1px solid #e5e7eb;
            padding: 9px 13px;
            font-size: 14px;
        }

        .grade-badge {
            background: #16a34a;
            color: white;
            padding: 4px 12px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 12px;
        }

        .empty-message {
            text-align: center;
            padding: 35px 10px;
            color: #9ca3af;
            font-size: 14px;
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

            <div class="collapse navbar-collapse" id="managerNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('manager.dashboard') }}"><i class="bi bi-check2-square nav-icon"></i> المهام</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('manager.teachers.index') }}"><i class="bi bi-people-fill nav-icon"></i> دليل الأساتذة</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('manager.students') }}"><i class="bi bi-mortarboard-fill nav-icon"></i> دليل الطلاب</a>
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
                                <small class="text-muted d-block">{{ auth()->user()->email }}</small>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('manager.profile') }}">
                                <i class="bi bi-person-circle me-1"></i> الملف الشخصي
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('manager.profile.edit') }}">
                                <i class="bi bi-pencil-square me-1"></i> تعديل البيانات
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteManagerModal">
                                <i class="bi bi-trash me-1"></i> حذف الحساب
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Logout -->
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="bi bi-box-arrow-right me-1"></i> خروج
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container page-container">

        @if(session('success'))
        <div class="alert alert-success shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
        </div>
        @endif

        <h1 class="page-title">دليل الطلاب</h1>
        <p class="page-subtitle">عرض وإدارة بيانات الطلاب والتقارير اليومية بحسب الصفوف الدراسية</p>

        <!-- Search & Filter Card -->
        <div class="task-card shadow-sm" style="background: white;">
            <div class="p-3 border-bottom bg-light fw-bold text-secondary">
                <i class="bi bi-funnel-fill me-1"></i> البحث والتصفية
            </div>
            <div class="p-3">
                <form method="GET" action="{{ route('manager.students') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-secondary small">اسم الطالب</label>
                            <input type="text" name="search" class="form-control" placeholder="ابحث باسم الطالب..." value="{{ $search ?? '' }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-secondary small">الصف الدراسي</label>
                            <select name="class" class="form-select">
                                <option value="">-- كل الصفوف --</option>
                                @foreach($classes as $classNameOpt)
                                <option value="{{ $classNameOpt }}" {{ ($class ?? '') == $classNameOpt ? 'selected' : '' }}>
                                    {{ $classNameOpt }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-secondary small">السنة الدراسية</label>
                            <input type="number" name="year" class="form-control" value="{{ $year ?? date('Y') }}">
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="search-btn w-100">
                                <i class="bi bi-search me-1"></i> بحث
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Students Grouped By Classes (الصفوف المرتبة تصاعدياً من الكنترولر) -->
        @forelse($groupedStudents as $className => $classStudents)
        <div class="task-card">
            <div class="task-header">
                <h2 class="task-title">
                    <i class="bi bi-mortarboard-fill me-1"></i> الصف: {{ $className ?: 'غير محدد' }}
                </h2>
                <div class="d-flex gap-2">
                    <a href="{{ route('manager.classes.grades', $className) }}" class="btn-light-custom">
                        <i class="bi bi-award"></i> عرض العلامات
                    </a>
                    <a href="{{ route('manager.classes.notes', $className) }}" class="btn-light-custom">
                        <i class="bi bi-journal-text"></i> عرض الملاحظات
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>اسم الطالب</th>
                            <th>الجنس</th>
                            <th>العمر</th>
                            <th>الحالة الصحية</th>
                            <th>المعدل العام للطالب</th>
                            <th>المتغيرات اليومية</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classStudents as $index => $student)
                        @php
                        $avgResult = $student->dailyVariables->isNotEmpty() ? number_format($student->dailyVariables->avg('result'), 1) : null;

                        // تحويل قيمة الجنس إلى اللغة العربية
                        $genderArabic = '-';
                        if (!empty($student->gender)) {
                        $g = strtolower(trim($student->gender));
                        if (in_array($g, ['male', 'ذكر', '1', 'm'])) {
                        $genderArabic = 'ذكر';
                        } elseif (in_array($g, ['female', 'أنثى', '0', 'f'])) {
                        $genderArabic = 'أنثى';
                        } else {
                        $genderArabic = $student->gender;
                        }
                        }
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span class="fw-bold text-dark">{{ $student->name }}</span>
                            </td>
                            <td>{{ $genderArabic }}</td>
                            <td>{{ $student->age ?? '-' }}</td>
                            <td>{{ $student->health_status ?? 'جيدة' }}</td>
                            <td>
                                @if($avgResult)
                                <span class="grade-badge">{{ $avgResult }}</span>
                                @else
                                <span class="text-muted small">لا توجد علامات</span>
                                @endif
                            </td>
                            <td>
                                @if($student->dailyVariables->isNotEmpty())
                                <a href="{{ route('manager.students.profile', $student->id) }}" class="btn btn-sm btn-info text-white bg-opacity-75 px-3 py-1" style="font-size: 12px; border-radius: 20px;">
                                    <i class="bi bi-eye me-1"></i> عرض البيانات ({{ $student->dailyVariables->count() }})
                                </a>
                                @else
                                <span class="text-muted small">لا توجد بيانات</span>
                                @endif
                            </td>
                            <td>
                                <!-- زر ونافذة حذف الطالب -->
                                <button type="button" class="btn btn-sm btn-outline-danger px-2 py-1" style="font-size: 12px; border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#deleteStudentModal{{ $student->id }}">
                                    <i class="bi bi-trash"></i> حذف
                                </button>

                                <!-- Modal حذف الطالب -->
                                <div class="modal fade" id="deleteStudentModal{{ $student->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    <i class="bi bi-exclamation-triangle-fill text-danger"></i> تأكيد حذف الطالب
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                                            </div>
                                            <div class="modal-body text-center py-4">
                                                <div class="mb-3">
                                                    <i class="bi bi-trash3-fill text-danger" style="font-size: 45px;"></i>
                                                </div>
                                                <h5 class="mb-2">هل أنت متأكد من حذف الطالب ({{ $student->name }})؟</h5>
                                                <p class="text-muted mb-0">سيتم حذف الطالب وكافة تقاريره المسجلة بشكل نهائي.</p>
                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">إلغاء</button>
                                                <form action="{{ route('manager.students.destroy', $student->id) }}" method="POST" class="d-inline">
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
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @empty
        <div class="task-card text-center py-5">
            <div class="empty-message">
                <i class="bi bi-emoji-neutral fs-1"></i>
                <div class="mt-2">لا توجد نتائج مطابقة للبحث أو لا يوجد طلاب مضافون.</div>
            </div>
        </div>
        @endforelse

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>