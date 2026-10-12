<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>علامات صف {{ $className }} - روضتي</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-award text-primary me-2"></i> علامات وتقييمات طلاب الصف: {{ $className }}</h2>
            <a href="{{ route('manager.students') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-right me-1"></i> العودة لدليل الطلاب
            </a>
        </div>

        <!-- بطاقة البحث والتصفية -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('manager.classes.grades', $className) }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small text-secondary">اسم الطالب</label>
                        <input type="text" name="search_name" class="form-control" placeholder="ابحث باسم الطالب..." value="{{ $searchName ?? '' }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-secondary">اسم المادة / النشاط</label>
                        <input type="text" name="search_topic" class="form-control" placeholder="ابحث بالمادة..." value="{{ $searchTopic ?? '' }}">
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

        <!-- جدول النتائج -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>اسم الطالب</th>
                                <th>موضوع النشاط / المادة</th>
                                <th>النتيجة / العلامة</th>
                                <th>تاريخ التقييم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $counter = 1; @endphp
                            @forelse($students as $student)
                            @foreach($student->dailyVariables as $daily)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td class="fw-bold">{{ $student->name }}</td>
                                <td>{{ $daily->topic ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-success px-3 py-2" style="font-size: 13px;">{{ $daily->result ?? '-' }}</span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($daily->report_date)->format('Y-m-d') }}</td>
                            </tr>
                            @endforeach
                            @empty
                            <tr>
                                <td colspan="5" class="py-4 text-muted">لا توجد علامات مسجلة مطابقة للبحث.</td>
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