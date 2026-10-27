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

    /* بطاقات الصفوف */
    .class-card {
        border: 1px solid #e8ebef;
        border-radius: 18px;
        overflow: hidden;
        background-color: #ffffff;
        box-shadow: 0 3px 10px rgba(15, 23, 42, 0.07);
    }

    .class-toggle {
        width: 100%;
        border: 0;
        background-color: var(--primary-color);
        color: #ffffff;
        text-align: right;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: filter 0.2s;
    }

    .class-toggle:hover,
    .class-toggle:focus {
        color: #ffffff;
        filter: brightness(0.94);
    }

    .class-toggle:focus-visible,
    .section-toggle:focus-visible {
        outline: 3px solid rgba(255, 255, 255, 0.75);
        outline-offset: -5px;
    }

    .class-toggle .class-title {
        font-size: 18px;
        font-weight: 700;
    }

    .class-toggle .toggle-icon,
    .section-toggle .toggle-icon {
        margin-right: auto;
        transition: transform 0.2s ease;
    }

    .class-toggle[aria-expanded="true"] .toggle-icon,
    .section-toggle[aria-expanded="true"] .toggle-icon {
        transform: rotate(180deg);
    }

    .class-content {
        padding: 16px;
        background-color: #f8fafc;
    }

    /* بطاقات الشعب */
    .section-card {
        border: 1px solid #e3e8ef;
        border-radius: 14px;
        overflow: hidden;
        background-color: #ffffff;
    }

    .section-card+.section-card {
        margin-top: 14px;
    }

    .section-header {
        padding: 12px 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        background-color: #ffffff;
    }

    .section-toggle {
        border: 0;
        background: transparent;
        color: #1f2937;
        padding: 4px 0;
        display: inline-flex;
        align-items: center;
        gap: 9px;
        font-weight: 700;
        text-align: right;
    }

    .section-toggle:hover,
    .section-toggle:focus {
        color: var(--primary-color);
    }

    .section-toggle .section-icon {
        color: var(--primary-color);
    }

    .section-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .school-color-btn,
    .school-color-btn:hover,
    .school-color-btn:focus {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        color: #ffffff !important;
    }

    .school-color-btn:hover,
    .school-color-btn:focus {
        filter: brightness(0.9);
    }

    .section-students {
        border-top: 1px solid #e8ebef;
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

    .section-students table thead th {
        color: #111827;
        font-weight: 700;
        border-bottom-color: #d9dee5;
    }

    .section-students table tbody td {
        padding: 10px 12px;
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

    @media (max-width: 576px) {
        .class-toggle {
            width: 100%;
            border: 0;
            background-color: var(--primary-color);
            color: #ffffff;
            text-align: right;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: filter 0.2s;
        }

        .class-toggle:hover,
        .class-toggle:focus {
            color: #ffffff;
            filter: brightness(0.94);
        }

        .class-toggle .class-title {
            font-size: 16px;
            font-weight: 700;
        }

        .class-content {
            padding: 12px;
            background-color: #f8fafc;
        }

        .section-header {
            align-items: flex-start;
        }

        .section-actions {
            width: 100%;
        }

        .section-actions .btn {
            flex: 1 1 auto;
        }
    }
</style>

<main class="main-container">

    <div class="page-title">
        <h2>صفوف المعلم</h2>
        <p>اختر الصف ثم الشعبة لعرض الطلاب المرتبطين بك.</p>
    </div>

    <div class="filter-box">
        <div class="filter-heading">
            <i class="bi bi-funnel-fill ms-1"></i>
            البحث والتصفية
        </div>

        <form action="{{ route('teacher.classes') }}" method="GET" class="row g-3 align-items-end filter-form">

            <div class="col-md-2">
                <label class="form-label fw-bold small text-secondary">اسم الطالب</label>
                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="bi bi-search"></i>
                    </span>
                    <input
                        type="text"
                        name="search_name"
                        class="form-control"
                        placeholder="ابحث باسم الطالب..."
                        value="{{ request('search_name') }}">
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold small text-secondary">الصف الدراسي</label>
                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="bi bi-mortarboard"></i>
                    </span>
                    <select name="search_class" class="form-select">
                        <option value="">-- كل الصفوف --</option>
                        @foreach($availableClasses as $classNameOption)
                        <option
                            value="{{ $classNameOption }}"
                            {{ $selectedClassOption === $classNameOption ? 'selected' : '' }}>
                            {{ $classNameOption }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold small text-secondary">الشعبة</label>
                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="bi bi-people"></i>
                    </span>
                    <select name="search_section" class="form-select">
                        <option value="">-- كل الشُعَب --</option>
                        @foreach($availableSections as $sectionOption)
                        <option
                            value="{{ $sectionOption }}"
                            {{ $selectedSectionOption === $sectionOption ? 'selected' : '' }}>
                            {{ $sectionOption }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold small text-secondary">تاريخ التقرير اليومي</label>
                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="bi bi-calendar-date"></i>
                    </span>
                    <input
                        type="text"
                        class="form-control"
                        data-date-filter
                        placeholder="يوم/شهر/سنة"
                        inputmode="numeric"
                        autocomplete="off"
                        dir="ltr"
                        style="text-align: left;">
                    <input
                        type="hidden"
                        name="search_date"
                        value="{{ request('search_date') }}">
                </div>
            </div>

            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-filter me-1"></i>
                    بحث
                </button>
                <a
                    href="{{ route('teacher.classes') }}"
                    class="btn btn-outline-secondary"
                    title="إعادة تعيين">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>
    </div>

    @if($classes->isEmpty())
    <div class="alert alert-info text-center py-4">
        <i class="bi bi-info-circle fs-4 d-block mb-2"></i>
        لا توجد نتائج تطابق بحثك أو لا يوجد طلاب مرتبطون بك حالياً.
    </div>
    @else

    @php
    $classesGroupedByName = $classes->groupBy('className');
    @endphp

    @foreach($classesGroupedByName as $sectionsForClass)
    @php
    $className = $sectionsForClass->first()['className'];
    $classCollapseId = 'teacher-class-' . $loop->index;
    @endphp

    <section class="class-card mb-4">
        <h3 class="m-0">
            <button
                type="button"
                class="class-toggle"
                data-bs-toggle="collapse"
                data-bs-target="#{{ $classCollapseId }}"
                aria-expanded="false"
                aria-controls="{{ $classCollapseId }}">
                <i class="bi bi-mortarboard-fill"></i>
                <span class="class-title">الصف: {{ $className ?: 'غير محدد' }}</span>
                <span class="badge bg-light text-dark rounded-pill">
                    {{ $sectionsForClass->count() }} شعبة
                </span>
                <i class="bi bi-chevron-down toggle-icon"></i>
            </button>
        </h3>

        <div class="collapse" id="{{ $classCollapseId }}">
            <div class="class-content">

                @foreach($sectionsForClass as $sectionGroup)
                @php
                $sectionName = $sectionGroup['sectionName'];
                $children = $sectionGroup['children'];
                $sectionCollapseId = $classCollapseId . '-section-' . $loop->index;
                @endphp

                <section class="section-card">
                    <div class="section-header">
                        <button
                            type="button"
                            class="section-toggle"
                            data-bs-toggle="collapse"
                            data-bs-target="#{{ $sectionCollapseId }}"
                            aria-expanded="false"
                            aria-controls="{{ $sectionCollapseId }}">
                            <i class="bi bi-diagram-3 section-icon"></i>
                            <span>الشعبة: {{ $sectionName ?: 'غير محددة' }}</span>
                            <span class="badge bg-secondary rounded-pill">
                                {{ $children->count() }} طالب
                            </span>
                            <i class="bi bi-chevron-down toggle-icon"></i>
                        </button>

                        <div class="section-actions">
                            <!-- زر عرض العلامات (محدد حسب الصف والشعبة) -->
                            <a
                                href="{{ route('teacher.classes.grades', ['class' => $className, 'section' => $sectionName]) }}"
                                class="btn btn-sm school-color-btn">
                                <i class="bi bi-award ms-1"></i>
                                عرض العلامات
                            </a>

                            <!-- زر عرض الملاحظات (محدد حسب الصف والشعبة) -->
                            <a
                                href="{{ route('teacher.classes.notes', ['class' => $className, 'section' => $sectionName]) }}"
                                class="btn btn-sm school-color-btn">
                                <i class="bi bi-journal-text ms-1"></i>
                                عرض الملاحظات
                            </a>
                        </div>
                    </div>

                    <div class="collapse section-students" id="{{ $sectionCollapseId }}">
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
                                    @php
                                    $studentResults = $child->dailyVariables
                                    ->pluck('result')
                                    ->filter(fn($value) => is_numeric($value));

                                    $studentAverage = $studentResults->count() > 0
                                    ? round($studentResults->average(), 1)
                                    : null;
                                    @endphp

                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $child->name }}</strong>
                                        </td>
                                        <td>
                                            @if($child->gender === 'male')
                                            ذكر
                                            @elseif($child->gender === 'female')
                                            أنثى
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td>{{ $child->age ?? '-' }}</td>
                                        <td>{{ $child->Health_status ?? '-' }}</td>
                                        <td>
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
                                            <a
                                                class="btn btn-daily-data btn-sm"
                                                href="{{ route('teacher.student.show', $child->id) }}">
                                                <i class="bi bi-eye me-1"></i>
                                                عرض البيانات ({{ $child->dailyVariables->count() }})
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
                </section>
                @endforeach

            </div>
        </div>
    </section>
    @endforeach

    @endif
</main>

@endsection