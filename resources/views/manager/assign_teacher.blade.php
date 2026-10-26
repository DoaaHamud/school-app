@extends('layouts.app')

@section('content')

<style>
    .page-title {
        font-weight: 800;
        color: #1e293b;
    }

    .card {
        border-radius: 16px;
    }

    .teacher-icon {
        width: 55px;
        height: 55px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--primary-color);
        color: #ffffff;
        font-size: 25px;
    }

    .student-card {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        background: #fff;
    }

    .student-card {
        border-color: var(--primary-color);
        background: color-mix(in srgb, var(--primary-color) 10%, white);
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .student-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--primary-color);
        color: #ffffff;
        font-size: 20px;
    }

    .check-icon {
        color: var(--primary-color);
        font-size: 20px;
    }

    .filter-card {
        background: white;
    }

    .btn-primary {
        background: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background: var(--primary-color);
        border-color: var(--primary-color);
        opacity: 0.9;
    }
</style>


<div class="container py-4">

    {{-- عنوان الصفحة --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="page-title mb-1">توزيع الطلاب</h3>
            <p class="text-muted mb-0">
                توزيع الطلاب على المعلم: <strong>{{ $teacher->name }}</strong>
            </p>
        </div>

        <a href="{{ route('manager.teachers.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-right me-1"></i> العودة
        </a>
    </div>

    {{-- رسالة النجاح --}}
    @if(session('success'))
    <div class="alert alert-success d-flex align-items-center mb-4">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- معلومات المعلم --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3">
                        <div class="teacher-icon">
                            <i class="bi bi-person-workspace"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-2">{{ $teacher->name }}</h5>
                            <div class="text-muted">
                                <i class="bi bi-envelope me-1"></i>
                                {{ $teacher->email }}
                            </div>
                            @if($teacher->phone)
                            <div class="text-muted mt-1">
                                <i class="bi bi-telephone me-1"></i>
                                {{ $teacher->phone }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <span class="badge bg-success-subtle text-success px-3 py-2">
                        <i class="bi bi-check-circle me-1"></i> معلم مقبول
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- اختيار السنة والصف والشعبة (تصفية للمسند لهذا الأستاذ فقط) --}}
    <div class="card filter-card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">
                <i class="bi bi-funnel me-1"></i> تحديد الصف والشعبة المسندين للأستاذ
            </h5>

            <form method="GET" action="{{ route('manager.teachers.assign', $teacher->id) }}">
                <div class="row g-3">
                    {{-- السنة --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">السنة الدراسية</label>
                        <select name="year" class="form-select" onchange="this.form.submit()">
                            @for($i = date('Y') - 5; $i <= date('Y') + 1; $i++)
                                <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>
                                {{ $i }}
                                </option>
                                @endfor
                        </select>
                    </div>

                    {{-- الصف (يعرض فقط الصفوف المسندة لهذا الأستاذ) --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">الصفوف المسندة له</label>
                        <select name="class" class="form-select" onchange="this.form.section.value=''; this.form.submit()">
                            @forelse($classes as $class)
                            <option value="{{ $class }}" {{ $selectedClass == $class ? 'selected' : '' }}>
                                {{ $class }}
                            </option>
                            @empty
                            <option value="">لا توجد صفوف مسندة لهذا المعلم</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">الشُعَب المسندة له</label>
                        <select name="section" class="form-select" onchange="this.form.submit()" {{ $sections->isEmpty() ? 'disabled' : '' }}>
                            <option value="">كل الشُعَب</option>
                            @foreach($sections as $section)
                            <option value="{{ $section }}" {{ $selectedSection === $section ? 'selected' : '' }}>
                                {{ $section }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- الطلاب --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-1">
                        طلاب {{ $selectedClass ?? 'الصف' }}{{ $selectedSection ? ' / ' . $selectedSection : '' }}
                    </h5>
                    <small class="text-muted">
                        {{ $students->count() }} طالب
                    </small>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if($students->count() > 0)
            <div class="row g-3">
                @foreach($students as $student)
                <div class="col-md-6 col-lg-4">
                    <div class="student-card">
                        <div class="student-info">
                            <div class="student-icon">
                                <i class="bi bi-person"></i>
                            </div>

                            <div>
                                <div class="fw-bold">
                                    {{ $student->name }}
                                </div>
                                <small class="text-muted">
                                    {{ $student->class }}{{ $student->section ? ' / ' . $student->section : '' }}
                                </small>
                            </div>
                        </div>

                        <i class="bi bi-check-circle-fill check-icon" aria-label="مسند للمعلم"></i>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-people fs-1 text-muted"></i>
                <h5 class="mt-3">لا يوجد طلاب</h5>
                <p class="text-muted mb-0">لا يوجد طلاب ضمن هذا الصف والسنة المحددة، أو لم يتم تحديد صف مسند معلم للأساس.</p>
            </div>
            @endif
        </div>
    </div>

</div>

@endsection