@extends('layouts.app')

@section('content')

<style>
    .student-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--primary-color);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .student-card {
        border-radius: 14px;
        border: 1px solid #e5e7eb;
    }

    .student-table th {
        background-color: #f9fafb;
        color: #4b5563;
        font-size: 14px;
        font-weight: 600;
        white-space: nowrap;
    }

    .student-table td {
        color: #4b5563;
        font-size: 14px;
        vertical-align: middle;
    }
</style>

<div class="container py-5">
    <div class="card student-card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="student-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-1">{{ $student->name }}</h3>
                    <span class="text-muted">ملف الطالب وسجلاته اليومية</span>
                </div>
            </div>

            <div class="row g-3 border-top pt-3">
                <div class="col-md-4">
                    <div class="text-muted small">العمر</div>
                    <div class="fw-bold fs-6">{{ $student->age ?? '-' }} سنة</div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted small">الصف الدراسي</div>
                    <div class="fw-bold fs-6">
                        <span class="badge bg-light text-dark border px-2 py-1">{{ $student->class ?? '-' }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted small">ولي الأمر</div>
                    <div class="fw-bold fs-6">{{ $student->mother?->name ?? '-' }}</div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted small">الجنس</div>
                    <div class="fw-bold fs-6">
                        @if($student->gender === 'male')
                        ذكر
                        @elseif($student->gender === 'female')
                        أنثى
                        @else
                        -
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted small">الحالة الصحية</div>
                    <div class="fw-bold fs-6">{{ $student->Health_status ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card student-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-journal-text me-1 text-primary-custom"></i>
                سجل المتغيرات والتقييمات اليومية
            </h5>
        </div>
        <div class="card-body p-0">
            @if($student->dailyVariables->isNotEmpty())
            <div class="table-responsive">
                <table class="table student-table table-hover mb-0 text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>التاريخ</th>
                            <th>الموضوع / النشاط</th>
                            <th>النتيجة / العلامة</th>
                            <th>الملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($student->dailyVariables as $index => $daily)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $daily->report_date ? \Carbon\Carbon::parse($daily->report_date)->format('Y-m-d H:i') : '-' }}</td>
                            <td>{{ $daily->topic ?? '-' }}</td>
                            <td>
                                <span class="badge px-3 py-2" style="background-color: var(--primary-color); color: #ffffff;">
                                    {{ $daily->result ?? '-' }}
                                </span>
                            </td>
                            <td>{{ $daily->notes ?? ($daily->comment ?? 'لا توجد ملاحظات') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                لا توجد متغيرات يومية مسجلة لهذا الطالب حتى الآن.
            </div>
            @endif
        </div>
    </div>

    <a href="{{ route('teacher.classes') }}" class="btn btn-outline-secondary px-4">
        <i class="bi bi-arrow-right me-1"></i> العودة إلى الصفوف
    </a>
</div>

@endsection
