<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المتغيرات اليومية - روضتي</title>

    <!-- Bootstrap RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f5f7fb;
            font-family: "Segoe UI", Tahoma, Arial, sans-serif;
            color: #273142;
        }

        /* Navbar */
        .navbar-custom {
            background: #ffffff;
            min-height: 70px;
            padding: 0 35px;
            border-bottom: 1px solid #e7ebf0;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.02);
        }

        .navbar-brand {
            font-size: 22px;
            font-weight: 700;
            color: #1f2937;
            margin-left: 30px;
            text-decoration: none;
        }

        .navbar-brand:hover {
            color: #1f2937;
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

        .nav-link.active {
            border-bottom: 2px solid #2563eb;
        }

        /* حساب المعلم */
        .teacher-profile-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background: transparent;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 10px;
            transition: background-color 0.2s;
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
            flex-shrink: 0;
        }

        .teacher-dropdown {
            min-width: 230px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 8px;
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.10);
        }

        .logout-btn {
            background: transparent;
            border: 1px solid #dc3545;
            color: #dc3545;
            border-radius: 7px;
            padding: 7px 15px;
            font-size: 14px;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background: #dc3545;
            color: white;
        }

        /* Main Container */
        .main-container {
            max-width: 1400px;
            margin: auto;
            padding: 40px 30px 60px;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 30px;
        }

        .page-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #6b7280;
            margin: 0;
            font-size: 15px;
        }

        /* Student Card */
        .student-card {
            background: #ffffff;
            border: 1px solid #e6eaf0;
            border-radius: 14px;
            margin-bottom: 25px;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
            transition: 0.2s;
        }

        .student-card:hover {
            box-shadow: 0 7px 22px rgba(15, 23, 42, 0.07);
        }

        .student-header {
            padding: 22px 25px;
            background: linear-gradient(to left, #f8faff, #ffffff);
            border-bottom: 1px solid #edf0f4;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .student-main-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .student-avatar-large {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            background: #eef4ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
            flex-shrink: 0;
        }

        .student-info h4 {
            margin: 0 0 8px;
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
        }

        .student-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .student-meta span {
            color: #6b7280;
            font-size: 13px;
        }

        .student-meta i {
            color: #2563eb;
            margin-left: 4px;
        }

        .report-count {
            background: #f1f5f9;
            color: #475569;
            border-radius: 20px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Reports List */
        .reports-container {
            padding: 22px 25px 25px;
        }

        .reports-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .reports-title {
            font-size: 15px;
            font-weight: 700;
            color: #374151;
            margin: 0;
        }

        .reports-title i {
            color: #2563eb;
            margin-left: 6px;
        }

        .report-item {
            border: 1px solid #e8ecf2;
            border-radius: 10px;
            padding: 17px 18px;
            margin-bottom: 12px;
            background: #ffffff;
            transition: 0.2s;
        }

        .report-item:last-child {
            margin-bottom: 0;
        }

        .report-item:hover {
            border-color: #d8e2f4;
            background: #fbfdff;
        }

        .report-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 12px;
        }

        .report-topic {
            font-weight: 700;
            color: #1f2937;
            font-size: 15px;
        }

        .report-date {
            color: #6b7280;
            font-size: 12px;
            white-space: nowrap;
        }

        .result-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #eef4ff;
            color: #2563eb;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .report-notes {
            color: #6b7280;
            font-size: 13px;
            line-height: 1.7;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #f0f2f5;
        }

        .report-actions {
            display: flex;
            gap: 7px;
            margin-top: 13px;
        }

        .edit-btn,
        .delete-btn {
            border-radius: 6px;
            padding: 5px 11px;
            font-size: 12px;
            background: #ffffff;
            transition: 0.2s;
        }

        .edit-btn {
            border: 1px solid #2563eb;
            color: #2563eb;
        }

        .edit-btn:hover {
            background: #2563eb;
            color: #ffffff;
        }

        .delete-btn {
            border: 1px solid #dc3545;
            color: #dc3545;
        }

        .delete-btn:hover {
            background: #dc3545;
            color: #ffffff;
        }

        .empty-reports,
        .empty-students {
            text-align: center;
            padding: 40px 20px;
            color: #9ca3af;
        }

        @media (max-width: 991px) {
            .navbar-custom {
                padding: 10px 20px;
            }

            .nav-link {
                padding: 12px 10px !important;
            }

            .main-container {
                padding: 25px 15px 40px;
            }

            .student-header {
                flex-direction: column;
                align-items: stretch;
            }
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
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
                <form action="{{ route('logout') }}" method="POST" class="m-0">
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

        <!-- Page Header -->
        <div class="page-header">
            <h2>المتغيرات اليومية</h2>
            <p>متابعة وإدارة التقارير اليومية الخاصة بالأطفال المسندين إليك.</p>
        </div>

        <!-- Alerts -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger rounded-3 mb-4">
            <strong>يرجى تصحيح الأخطاء التالية:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- بطاقة إضافة المتغيرات اليومية --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px; overflow: hidden; background: #fff;">
            <div class="card-header bg-white border-bottom p-4">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #eef4ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                        <i class="bi bi-clipboard2-pulse"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold text-dark">إضافة المتغيرات اليومية</h5>
                        <p class="text-muted mb-0 small">اختر الصف والطفل، ثم أدخل تفاصيل التقرير اليومي.</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('teacher.daily_store', 0) }}" method="POST" id="dailyReportForm">
                    @csrf

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="classFilter" class="form-label fw-bold text-secondary small">
                                <i class="bi bi-door-open me-1 text-primary"></i> الصف الدراسي
                            </label>
                            <select id="classFilter" class="form-select" required>
                                <option value="">اختر الصف</option>
                                @foreach($students->pluck('class')->filter()->unique()->sort() as $className)
                                <option value="{{ $className }}">{{ $className }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="studentFilter" class="form-label fw-bold text-secondary small">
                                <i class="bi bi-person me-1 text-primary"></i> اسم الطفل
                            </label>
                            <select id="studentFilter" class="form-select" required disabled>
                                <option value="">اختر الصف أولاً</option>
                                @foreach($students as $student)
                                <option value="{{ $student->id }}" data-class="{{ $student->class }}">
                                    {{ $student->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr class="text-muted opacity-25 my-4">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="topic" class="form-label fw-bold text-secondary small">موضوع النشاط / التقرير</label>
                            <input type="text" name="topic" id="topic" class="form-control" placeholder="مثال: التعرف على الألوان" required>
                        </div>

                        <div class="col-md-6">
                            <label for="result" class="form-label fw-bold text-secondary small">النتيجة (من 100)</label>
                            <input type="number" name="result" id="result" class="form-control" placeholder="مثال: 85" min="0" max="100" step="0.01">
                        </div>

                        <div class="col-md-6">
                            <label for="report_date" class="form-label fw-bold text-secondary small">تاريخ التقرير اليومي</label>
                            <input type="date" name="report_date" id="report_date" class="form-control" value="{{ date('Y-m-d') }}" lang="en" style="direction: ltr; text-align: right;" required>
                        </div>

                        <div class="col-12">
                            <label for="notes" class="form-label fw-bold text-secondary small">ملاحظات المعلم</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="اكتب ملاحظاتك حول أداء الطفل..."></textarea>
                        </div>

                        <div class="col-12 text-end mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2" id="saveReportBtn" disabled>
                                <i class="bi bi-check-circle me-1"></i> حفظ التقرير اليومي
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Students & Daily Reports List -->
        @forelse($students as $student)
        <div class="student-card">
            <div class="student-header">
                <div class="student-main-info">
                    <div class="student-avatar-large">
                        <i class="bi bi-person"></i>
                    </div>
                    <div class="student-info">
                        <h4>{{ $student->name }}</h4>
                        <div class="student-meta">
                            <span><i class="bi bi-mortarboard"></i> الصف: {{ $student->class ?? 'غير محدد' }}</span>
                            <span><i class="bi bi-calendar3"></i> العمر: {{ $student->age ?? 'غير محدد' }}</span>
                            <span><i class="bi bi-journal-text"></i> {{ $student->dailyVariables->count() }} تقرير</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="reports-container">
                <div class="reports-header">
                    <div class="reports-title">
                        <i class="bi bi-journal-text"></i> التقارير اليومية السابقة
                    </div>
                    <span class="report-count">{{ $student->dailyVariables->count() }} سجل</span>
                </div>

                @forelse($student->dailyVariables->sortByDesc('report_date') as $daily)
                <div class="report-item">
                    <div class="report-top">
                        <div class="report-topic">
                            <i class="bi bi-bookmark text-primary me-1"></i> {{ $daily->topic }}
                        </div>
                        <div class="report-date">
                            <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($daily->report_date)->format('Y-m-d H:i') }}
                        </div>
                    </div>

                    <div class="report-details">
                        <span class="result-badge">
                            <i class="bi bi-bar-chart"></i> النتيجة: {{ $daily->result ?? 'غير محددة' }}
                        </span>
                    </div>

                    @if($daily->notes)
                    <div class="report-notes">
                        <strong>الملاحظات: </strong>{{ $daily->notes }}
                    </div>
                    @endif

                    <div class="report-actions">
                        <button type="button" class="edit-btn" data-bs-toggle="modal" data-bs-target="#editReportModal{{ $daily->id }}">
                            <i class="bi bi-pencil me-1"></i> تعديل
                        </button>

                        <form action="{{ route('teacher.daily_delete', $daily->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا التقرير؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn">
                                <i class="bi bi-trash me-1"></i> حذف
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editReportModal{{ $daily->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header border-bottom">
                                <h5 class="modal-title fw-bold">تعديل التقرير اليومي</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="{{ route('teacher.daily_update', $daily->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-secondary small">موضوع النشاط</label>
                                        <input type="text" name="topic" class="form-control" value="{{ $daily->topic }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-secondary small">النتيجة</label>
                                        <input type="number" name="result" class="form-control" min="0" max="100" step="0.01" value="{{ $daily->result }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-secondary small">الملاحظات</label>
                                        <textarea name="notes" class="form-control" rows="3">{{ $daily->notes }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-secondary small">تاريخ التقرير</label>
                                        <input type="datetime-local" name="report_date" class="form-control" value="{{ \Carbon\Carbon::parse($daily->report_date)->format('Y-m-d\TH:i') }}" required>
                                    </div>
                                </div>

                                <div class="modal-footer border-top">
                                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">إلغاء</button>
                                    <button type="submit" class="btn btn-primary px-4">حفظ التعديلات</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @empty
                <div class="empty-reports">
                    <i class="bi bi-journal-x display-6 d-block mb-2 text-muted"></i>
                    <div>لا توجد تقارير يومية لهذا الطفل حتى الآن.</div>
                </div>
                @endforelse
            </div>
        </div>
        @empty
        <div class="empty-students bg-white rounded-3 border p-5">
            <i class="bi bi-people display-4 text-muted d-block mb-3"></i>
            <h5>لا يوجد طلاب مسندون إليك</h5>
            <p class="text-muted">لا يمكنك إضافة تقرير يومي قبل وجود أطفال مرتبطين بك.</p>
        </div>
        @endforelse

    </main>

    <!-- Modal تحذير حذف الحساب -->
    <div class="modal fade" id="deleteTeacherModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fs-6">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> تحذير: حذف الحساب
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bi bi-trash3-fill text-danger display-4 mb-3 d-block"></i>
                    <h6 class="fw-bold text-dark mb-2">هل أنت متأكد من حذف حسابك؟</h6>
                    <p class="text-muted small mb-0">سيتم حذف حساب المعلم نهائياً ولا يمكن التراجع عن هذه العملية.</p>
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

    <!-- Script Filtering & Form Action Handler -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const classFilter = document.getElementById('classFilter');
            const studentFilter = document.getElementById('studentFilter');
            const reportForm = document.getElementById('dailyReportForm');
            const saveButton = document.getElementById('saveReportBtn');

            const allStudentOptions = Array.from(studentFilter.options)
                .filter(option => option.value !== '')
                .map(option => option.cloneNode(true));

            classFilter.addEventListener('change', function() {
                const selectedClass = this.value;
                studentFilter.innerHTML = '';

                const placeholder = document.createElement('option');
                placeholder.value = '';
                placeholder.textContent = selectedClass ? 'اختر الطفل' : 'اختر الصف أولاً';
                studentFilter.appendChild(placeholder);

                if (selectedClass) {
                    allStudentOptions.forEach(function(option) {
                        if (option.dataset.class === selectedClass) {
                            studentFilter.appendChild(option.cloneNode(true));
                        }
                    });
                    studentFilter.disabled = false;
                } else {
                    studentFilter.disabled = true;
                }
                saveButton.disabled = true;
            });

            studentFilter.addEventListener('change', function() {
                saveButton.disabled = !this.value;
            });

            // تحديث رابط الـ action في النموذج ديناميكياً ليطابق مسار الروت الصحيح تماماً
            reportForm.addEventListener('submit', function(event) {
                const studentId = studentFilter.value;
                if (!studentId) {
                    event.preventDefault();
                    alert('يرجى اختيار الصف والطفل أولاً.');
                    return;
                }
                // بناء المسار بالطريقة الصحيحة المتوافقة مع الروت: /teacher/students/{id}/daily-variable
                reportForm.action = "{{ url('/teacher/students') }}/" + encodeURIComponent(studentId) + "/daily-variable";
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>