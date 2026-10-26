@extends('layouts.app')

@section('content')

<style>
    * {
        box-sizing: border-box;
    }

    /* Navbar */
    .navbar-custom {
        background-color: var(--primary-color);
        min-height: 70px;
        padding: 0 35px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .navbar-brand {
        font-size: 22px;
        font-weight: 700;
        color: #ffffff;
        margin-left: 30px;
        text-decoration: none;
    }

    .navbar-toggler-icon {
        filter: brightness(0) invert(1);
    }

    .nav-link {
        color: rgba(255, 255, 255, 0.85);
        font-size: 15px;
        font-weight: 500;
        padding: 24px 15px !important;
        transition: 0.2s;
    }

    .nav-link:hover,
    .nav-link.active {
        color: #ffffff;
        background-color: rgba(255, 255, 255, 0.16);
    }

    .nav-link.active {
        border-bottom: 2px solid #ffffff;
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
        background-color: rgba(255, 255, 255, 0.16);
    }

    .teacher-profile-btn .text-dark,
    .teacher-profile-btn .text-muted {
        color: #ffffff !important;
    }

    .teacher-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background-color: #ffffff;
        color: var(--primary-color);
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

    .teacher-dropdown .dropdown-header {
        background-color: var(--primary-color);
        border-radius: 0.375rem;
        color: #ffffff;
    }

    .teacher-dropdown .dropdown-header strong,
    .teacher-dropdown .dropdown-header small {
        color: #ffffff !important;
    }

    .teacher-dropdown .dropdown-item:not(.text-danger):hover,
    .teacher-dropdown .dropdown-item:not(.text-danger):focus,
    .teacher-dropdown .dropdown-item:not(.text-danger):active {
        background-color: var(--primary-color);
        color: #ffffff;
    }

    .teacher-dropdown .dropdown-item:not(.text-danger):hover i,
    .teacher-dropdown .dropdown-item:not(.text-danger):focus i,
    .teacher-dropdown .dropdown-item:not(.text-danger):active i {
        color: #ffffff !important;
    }

    .logout-btn {
        background-color: rgba(255, 255, 255, 0.16);
        border: 1px solid rgba(255, 255, 255, 0.5);
        color: #ffffff;
        border-radius: 7px;
        padding: 7px 15px;
        font-size: 14px;
        transition: 0.2s;
    }

    .logout-btn:hover {
        background-color: rgba(255, 255, 255, 0.28);
        color: #ffffff;
    }

    /* Main Container */
    .main-container {
        max-width: 1300px;
        margin: auto;
        padding: 40px 30px;
    }

    .page-title {
        margin-bottom: 25px;
    }

    .page-title h2 {
        font-size: 26px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .page-title p {
        color: #6b7280;
        margin: 0;
        font-size: 15px;
    }

    /* Filter Box */
    .filter-box {
        background: #ffffff;
        border: 1px solid #e8ebef;
        border-radius: 18px;
        padding: 0;
        margin-bottom: 25px;
        box-shadow: 0 3px 10px rgba(15, 23, 42, 0.07);
        overflow: hidden;
    }

    .filter-heading {
        padding: 14px 18px;
        border-bottom: 1px solid #e8ebef;
        background: #f8f9fb;
        color: #64748b;
        font-weight: 700;
    }

    .filter-heading i {
        color: var(--primary-color);
    }

    .filter-form {
        padding: 18px;
    }

    /* Class Card */
    .class-card {
        border: 1px solid #e8ebef;
        border-radius: 18px;
        overflow: hidden;
        background-color: white;
        box-shadow: 0 3px 10px rgba(15, 23, 42, 0.07);
    }

    .class-header {
        background-color: var(--primary-color);
        color: #ffffff;
        padding: 14px 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .class-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover,
    .btn-primary:focus {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        opacity: 0.9;
    }

    .btn-daily-data {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: #ffffff;
    }

    .btn-daily-data:hover,
    .btn-daily-data:focus,
    .btn-daily-data:active {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: #ffffff;
        opacity: 0.9;
    }

    .class-header .btn-light {
        color: var(--primary-color) !important;
        border: 0;
        border-radius: 8px;
        font-size: 13px;
    }

    .class-header .btn-light:hover {
        background: #f8f9fa;
        filter: brightness(0.96);
    }

    .student-average-badge {
        background-color: var(--primary-color);
        color: #ffffff;
    }

    table {
        text-align: center;
        vertical-align: middle;
    }

    th {
        white-space: nowrap;
    }

    .class-card>.card-body table thead th {
        color: #111827;
        font-weight: 700;
        border-bottom-color: #d9dee5;
    }

    .class-card>.card-body>.table-responsive>table>tbody>tr>td {
        padding: 10px 12px;
    }

    .class-card>.card-body {
        padding: 0;
    }

    .class-card>.card-body>.table-responsive {
        padding: 0;
    }

    @media (max-width: 991px) {
        .navbar-custom {
            padding: 10px 20px;
        }

        .nav-link {
            padding: 12px 10px !important;
        }

        .main-container {
            padding: 25px 15px;
        }
    }
</style>


<!-- Main -->
<main class="main-container">

    <!-- Page Header -->
    <div class="page-title">
        <h2>صفوف المعلم</h2>
        <p>عرض الأطفال المرتبطين بك ضمن الصفوف الدراسية.</p>
    </div>

    <!-- Search Filter Form -->
    <div class="filter-box">
        <div class="filter-heading">
            <i class="bi bi-funnel-fill ms-1" style="color: var(--primary-color);"></i>
            البحث والتصفية
        </div>
        <form action="{{ route('teacher.classes') }}" method="GET" class="row g-3 align-items-end filter-form">

            <!-- البحث باسم الطالب -->
            <div class="col-md-2">
                <label class="form-label fw-bold small text-secondary">اسم الطالب</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                    <input type="text" name="search_name" class="form-control" placeholder="ابحث باسم الطالب..." value="{{ request('search_name') }}">
                </div>
            </div>

            <!-- قائمة منسدلة لأسماء الصفوف الموجودة -->
            <div class="col-md-2">
                <label class="form-label fw-bold small text-secondary">الصف الدراسي</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-mortarboard"></i></span>
                    <select name="search_class" class="form-select">
                        <option value="">-- كل الصفوف --</option>
                        @foreach($availableClasses as $classNameOption)
                        <option value="{{ $classNameOption }}" {{ $selectedClassOption === $classNameOption ? 'selected' : '' }}>
                            {{ $classNameOption }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold small text-secondary">الشعبة</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-people"></i></span>
                    <select name="search_section" class="form-select">
                        <option value="">-- كل الشُعَب --</option>
                        @foreach($availableSections as $sectionOption)
                        <option value="{{ $sectionOption }}" {{ $selectedSectionOption === $sectionOption ? 'selected' : '' }}>
                            {{ $sectionOption }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- البحث بالتاريخ -->
            <div class="col-md-2">
                <label class="form-label fw-bold small text-secondary">تاريخ التقرير اليومي</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-calendar-date"></i></span>
                    <input type="text" class="form-control" data-date-filter placeholder="يوم/شهر/سنة" inputmode="numeric" autocomplete="off" dir="ltr" style="text-align: left;">
                    <input type="hidden" name="search_date" value="{{ request('search_date') }}">
                </div>
            </div>

            <!-- أزرار الإجراءات -->
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-filter me-1"></i> بحث
                </button>
                <a href="{{ route('teacher.classes') }}" class="btn btn-outline-secondary" title="إعادة تعيين">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>
    </div>

    @if($classes->isEmpty())
    <!-- No Students -->
    <div class="alert alert-info text-center py-4">
        <i class="bi bi-info-circle fs-4 d-block mb-2"></i>
        لا توجد نتائج تطابق بحثك أو لا يوجد طلاب مرتبطون بك حالياً.
    </div>
    @else

    @foreach($classes as $classGroup)
    @php
    $className = $classGroup['className'];
    $sectionName = $classGroup['sectionName'];
    $children = $classGroup['children'];
    @endphp

    <!-- Class Card -->
    <div class="card class-card mb-4">

        <!-- Class Header -->
        <div class="class-header">
            <h4>
                <i class="bi bi-mortarboard me-1"></i>الصف: {{ $className }}
                <span class="me-2">— الشعبة: {{ $sectionName ?: 'غير محددة' }}</span>
            </h4>

            <!-- أزرار الانتقال إلى صفحات مستقلة لعرض العلامات والملاحظات مع دعم تمرير البحث -->
            <div class="d-flex gap-2">
                <a href="{{ route('teacher.classes.grades', ['class' => $className, 'search_name' => request('search_name'), 'search_date' => request('search_date')]) }}" class="btn btn-light btn-sm fw-bold text-primary px-3 text-decoration-none">
                    <i class="bi bi-award me-1"></i> عرض العلامات
                </a>
                <a href="{{ route('teacher.classes.notes', ['class' => $className, 'search_name' => request('search_name'), 'search_date' => request('search_date')]) }}" class="btn btn-light btn-sm fw-bold text-dark px-3 text-decoration-none">
                    <i class="bi bi-journal-text me-1"></i> عرض الملاحظات
                </a>
            </div>
        </div>

        <!-- Class Body (جدول الأطفال) -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>اسم الطالب</th>
                            <th>الجنس</th>
                            <th>العمر</th>
                            <th>الحالة الصحية</th>
                            <th>المعدل العام للطالب</th>
                            <th>ولي الأمر</th>
                            <th>المتغيرات اليومية</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($children as $index => $child)

                        <!-- معلومات الطفل -->
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $child->name }}</strong>
                            </td>
                            <td>
                                @if($child->gender == 'male')
                                ذكر
                                @elseif($child->gender == 'female')
                                أنثى
                                @else
                                -
                                @endif
                            </td>
                            <td>{{ $child->age ?? '-' }}</td>
                            <td>{{ $child->Health_status ?? '-' }}</td>

                            <!-- المعدل العام لكل طالب -->
                            <td>
                                @php
                                $studentResults = $child->dailyVariables->pluck('result')->filter(fn($val) => is_numeric($val));
                                $studentAverage = $studentResults->count() > 0 ? round($studentResults->average(), 1) : null;
                                @endphp

                                @if($studentAverage !== null)
                                <span class="badge student-average-badge fs-6 px-3 py-1">
                                    {{ $studentAverage }}
                                </span>
                                @else
                                <span class="text-muted small">لا توجد علامات</span>
                                @endif
                            </td>

                            <td>{{ $child->mother?->name ?? '-' }}</td>

                            <td>
                                @if($child->dailyVariables->count() > 0)
                                <a class="btn btn-daily-data btn-sm" href="{{ route('teacher.student.show', $child->id) }}">
                                    <i class="bi bi-eye me-1"></i> عرض البيانات ({{ $child->dailyVariables->count() }})
                                </a>
                                @else
                                <span class="text-muted">لا توجد بيانات</span>
                                @endif
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @endforeach

    @endif

</main>

@endsection