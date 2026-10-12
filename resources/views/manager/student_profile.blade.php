<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملف الطالب - {{ $student->name }} - روضتي</title>

    {{-- Bootstrap RTL --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #f8fafc;
            font-family: Arial, sans-serif;
            color: #1f2937;
        }

        .card {
            border-radius: 14px;
            border: 1px solid #e5e7eb;
        }

        .student-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .table th {
            background-color: #f9fafb;
            color: #4b5563;
            font-size: 14px;
            font-weight: 600;
        }

        .table td {
            color: #4b5563;
            font-size: 14px;
            vertical-align: middle;
        }

        .badge-custom {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="container py-5">

        {{-- معلومات الطالب الأساسية --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="student-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-1">{{ $student->name }}</h3>
                        <span class="text-muted">ملف متابعة الطالب والتقييمات اليومية</span>
                    </div>
                </div>

                <div class="row g-3 border-top pt-3">
                    <div class="col-md-4">
                        <div class="text-muted small">العمر</div>
                        <div class="fw-bold fs-6">{{ $student->age ?? '-' }} سنة</div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted small">الصف الدراسي</div>
                        <div class="fw-bold fs-6"><span class="badge bg-light text-dark border px-2 py-1">{{ $student->class ?? '-' }}</span></div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted small">المعلم المسؤول</div>
                        <div class="fw-bold fs-6">
                            @if($student->teachers->isNotEmpty())
                            {{ $student->teachers->pluck('name')->implode(', ') }}
                            @else
                            <span class="text-muted">غير مسند</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- جدول المتغيرات اليومية بكامل التفاصيل --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-journal-text me-1 text-primary"></i> سجل المتغيرات والتقييمات اليومية</h5>
            </div>

            <div class="card-body p-0">
                @if($student->dailyVariables->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>التاريخ</th>
                                <th>النتيجة / العلامة</th>
                                <th>المادة / النشاط</th>
                                <th>الملاحظات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($student->dailyVariables as $index => $daily)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <i class="bi bi-calendar-event text-muted me-1"></i>
                                    {{ $daily->created_at?->format('Y-m-d') ?? '-' }}
                                </td>
                                <td>
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                                        {{ $daily->result ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    {{ $daily->topic ?? '-' }}
                                </td>
                                <td>
                                    <span class="text-secondary">{{ $daily->notes ?? ($daily->comment ?? 'لا توجد ملاحظات') }}</span>
                                </td>
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

        {{-- زر العودة --}}
        <div>
            <a href="{{ route('manager.students') }}" class="btn btn-outline-secondary px-4">
                <i class="bi bi-arrow-right me-1"></i> العودة إلى دليل الطلاب
            </a>
        </div>

    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>