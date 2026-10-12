<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>ملاحظات صف {{ $className }} - روضتي</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #f7f8fc;
            font-family: Arial, sans-serif;
            color: #1f2937;
        }

        .card {
            border-radius: 14px;
            border: 1px solid #e8eaf0;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>

<body class="py-5">
    <div class="container" style="max-width: 1000px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-journal-text text-primary me-2"></i> ملاحظات طلاب الصف: {{ $className }}</h2>
            <a href="{{ route('manager.students') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-right me-1"></i> العودة لدليل الطلاب
            </a>
        </div>

        <!-- بطاقة البحث والتصفية -->
        <div class="card border-0 mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('manager.classes.notes', $className) }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small text-secondary">اسم الطالب</label>
                        <input type="text" name="search_name" class="form-control" placeholder="ابحث باسم الطالب..." value="{{ $searchName ?? '' }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-secondary">البحث في الملاحظة</label>
                        <input type="text" name="search_notes" class="form-control" placeholder="ابحث في نص الملاحظة..." value="{{ $searchNotes ?? '' }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-secondary">العام الدراسي</label>
                        <select name="year" class="form-select">
                            @for($i = date('Y') - 5; $i <= date('Y') + 1; $i++)
                                <option value="{{ $i }}" {{ (int)($selectedYear ?? date('Y')) == $i ? 'selected' : '' }}>
                                العام الدراسي {{ $i }}
                                </option>
                                @endfor
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search me-1"></i> بحث
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- جدول الملاحظات -->
        <div class="card border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th style="width: 25%;">اسم الطالب</th>
                                <th class="text-start">الملاحظة</th>
                                <th style="width: 180px;">التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $counter = 1; @endphp
                            @forelse($students as $student)
                            @foreach($student->dailyVariables as $daily)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td class="fw-bold text-dark">{{ $student->name }}</td>
                                <td class="text-start text-secondary">{{ $daily->notes ?? 'لا توجد ملاحظات' }}</td>
                                <td>{{ \Carbon\Carbon::parse($daily->report_date)->format('Y-m-d H:i') }}</td>
                            </tr>
                            @endforeach
                            @empty
                            <tr>
                                <td colspan="4" class="py-4 text-muted">لا توجد ملاحظات مسجلة مطابقة للبحث.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>