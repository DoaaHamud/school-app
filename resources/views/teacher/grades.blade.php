@extends('layouts.app')

@section('content')
    <style>
        .main-container {
            max-width: 1200px;
            margin: auto;
            padding: 40px 20px;
        }

        .card-custom {
            border-radius: 14px;
            border: 1px solid #e8ebef;
            background: #fff;
            overflow: hidden;
        }

        .card-header-custom {
            background-color: var(--primary-color);
            color: #fff;
            padding: 20px 25px;
        }

        .main-container .text-primary {
            color: var(--primary-color) !important;
        }

        .main-container .btn-primary,
        .main-container .badge.bg-primary {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }

        table {
            text-align: center;
            vertical-align: middle;
        }
    </style>
    <div class="main-container">

        <!-- أزرار الرجوع والعنوان -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('teacher.classes') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-right me-1"></i> العودة للصفوف
            </a>
            <h4 class="fw-bold m-0 text-primary">سجل علامات صف: {{ $className }}</h4>
        </div>

        <!-- نموذج البحث المخصص للعلامات (اسم الطالب، اسم المادة، التاريخ) -->
        <div class="card card-custom mb-4 p-3 shadow-sm">
            <form action="{{ route('teacher.classes.grades', ['class' => $className]) }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-secondary">اسم الطالب</label>
                    <input type="text" name="search_name" class="form-control" placeholder="ابحث باسم الطالب..." value="{{ request('search_name') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-secondary">اسم المادة / الموضوع</label>
                    <input type="text" name="search_topic" class="form-control" placeholder="ابحث باسم المادة..." value="{{ request('search_topic') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-secondary">تاريخ التقرير</label>
                    <input type="text" class="form-control" data-date-filter placeholder="يوم/شهر/سنة" inputmode="numeric" autocomplete="off" dir="ltr" style="text-align: left;">
                    <input type="hidden" name="search_date" value="{{ request('search_date') }}">
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> بحث</button>
                    <a href="{{ route('teacher.classes.grades', ['class' => $className]) }}" class="btn btn-outline-secondary" title="إعادة تعيين"><i class="bi bi-arrow-counterclockwise"></i></a>
                </div>
            </form>
        </div>

        <!-- جدول العلامات -->
        <div class="card card-custom shadow-sm">
            <div class="card-header-custom">
                <h5 class="m-0 fw-bold"><i class="bi bi-award me-2"></i> العلامات والمواد</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>اسم الطالب</th>
                                <th>اسم المادة / الموضوع</th>
                                <th>العلامة</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $count = 1; $hasData = false; @endphp
                            @foreach($students as $student)
                            @foreach($student->dailyVariables as $daily)
                            @if(isset($daily->result))
                            @php $hasData = true; @endphp
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td class="fw-bold">{{ $student->name }}</td>
                                <td>{{ $daily->topic ?? '-' }}</td>
                                <td><span class="badge bg-primary fs-6 px-3 py-2">{{ $daily->result }}</span></td>
                                <td class="text-muted small">{{ \Carbon\Carbon::parse($daily->report_date)->format('Y-m-d') }}</td>
                            </tr>
                            @endif
                            @endforeach
                            @endforeach

                            @if(!$hasData)
                            <tr>
                                <td colspan="5" class="py-4 text-muted text-center">لا توجد علامات تطابق البحث.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection