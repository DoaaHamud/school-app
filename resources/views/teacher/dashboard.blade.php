@extends('layouts.app')

@section('content')

<style>
    * {
        box-sizing: border-box;
    }

    .main-container {
        max-width: 1400px;
        margin: auto;
        padding: 40px 30px;
    }

    .page-header h2 {
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #1f2937;
    }

    .page-header p {
        color: #6b7280;
        margin: 0;
        font-size: 15px;
    }

    .stat-card {
        background-color: #ffffff;
        border: 1px solid #e8ebef;
        border-radius: 10px;
        padding: 24px;
        height: 100%;
        transition: 0.2s;
    }

    .stat-card:hover {
        box-shadow: 0 5px 18px rgba(0, 0, 0, 0.06);
    }

    .stat-label {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .stat-number {
        color: #1f2937;
        font-size: 30px;
        font-weight: 700;
    }

    .stat-description {
        color: #9ca3af;
        font-size: 13px;
        margin-top: 5px;
    }

    .latest-section {
        background-color: #ffffff;
        border: 1px solid #e8ebef;
        border-radius: 10px;
        margin-top: 30px;
        overflow: hidden;
    }

    .section-header {
        padding: 20px 25px;
        border-bottom: 1px solid #e8ebef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .student-count {
        background-color: color-mix(in srgb, var(--primary-color) 12%, white);
        color: var(--primary-color);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    .latest-content {
        padding: 25px;
    }

    .latest-row {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .latest-item {
        flex: 1;
        min-width: 180px;
        background-color: #f8fafc;
        border-radius: 8px;
        padding: 15px;
    }

    .latest-label {
        color: #6b7280;
        font-size: 13px;
        margin-bottom: 6px;
    }

    .latest-value {
        color: #1f2937;
        font-size: 15px;
        font-weight: 600;
    }

    .latest-notes {
        margin-top: 15px;
        background-color: #f8fafc;
        border-radius: 8px;
        padding: 15px;
    }

    .no-latest {
        padding: 30px;
        text-align: center;
        color: #9ca3af;
    }

    @media (max-width: 767.98px) {
        .main-container {
            padding: 25px 15px;
        }

        .page-header h2 {
            font-size: 22px;
        }

        .section-header {
            padding: 16px;
        }

        .latest-content {
            padding: 16px;
        }

        .latest-item {
            min-width: 100%;
        }
    }
</style>

{{-- محتوى لوحة تحكم المعلم --}}
<div class="main-container">

    {{-- رسائل النجاح --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4"
        role="alert">

        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}

        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="إغلاق"></button>
    </div>
    @endif

    {{-- عنوان الصفحة --}}
    <div class="page-header mb-4">
        <h2>لوحة تحكم المعلم</h2>

        <p>
            مرحباً {{ $teacher->name }}،
            يمكنك متابعة الطلاب وإدارة سجلاتهم اليومية من هنا.
        </p>
    </div>

    {{-- الإحصائيات --}}
    <div class="row g-4 mb-4">

        {{-- عدد الطلاب --}}
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-label">عدد الطلاب</div>

                <div class="stat-number">
                    {{ $studentsCount }}
                </div>

                <div class="stat-description">
                    إجمالي الطلاب المسندين إليك
                </div>
            </div>
        </div>

        {{-- عدد الصفوف --}}
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-label">عدد الصفوف</div>

                <div class="stat-number">
                    {{ $classes->count() }}
                </div>

                <div class="stat-description">
                    الصفوف المرتبطة بطلابك
                </div>
            </div>
        </div>

        {{-- السجلات اليومية --}}
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-label">السجلات اليومية</div>

                <div class="stat-number">
                    {{ $dailyVariables->count() }}
                </div>

                <div class="stat-description">
                    إجمالي السجلات التي تم إدخالها
                </div>
            </div>
        </div>

    </div>

    {{-- آخر تحديث يومي --}}
    <div class="latest-section">

        <div class="section-header">
            <h4 class="mb-0">آخر تحديث يومي</h4>

            @if($latestDailyVariable)
            <span class="student-count">آخر سجل</span>
            @endif
        </div>

        @if($latestDailyVariable)

        <div class="latest-content">

            <div class="latest-row">

                {{-- الطالب --}}
                <div class="latest-item">
                    <div class="latest-label">الطالب</div>

                    <div class="latest-value">
                        {{ $latestDailyVariable->child->name ?? 'غير محدد' }}
                    </div>
                </div>

                {{-- الموضوع --}}
                <div class="latest-item">
                    <div class="latest-label">الموضوع</div>

                    <div class="latest-value">
                        {{ $latestDailyVariable->topic }}
                    </div>
                </div>

                {{-- النتيجة --}}
                <div class="latest-item">
                    <div class="latest-label">النتيجة</div>

                    <div class="latest-value">
                        {{ $latestDailyVariable->result !== null
                                ? $latestDailyVariable->result
                                : 'غير محددة' }}
                    </div>
                </div>

                {{-- تاريخ السجل --}}
                <div class="latest-item">
                    <div class="latest-label">تاريخ السجل</div>

                    <div class="latest-value">
                        {{ \Carbon\Carbon::parse(
                                $latestDailyVariable->report_date
                            )->format('Y-m-d H:i') }}
                    </div>
                </div>

            </div>

            {{-- الملاحظات --}}
            @if($latestDailyVariable->notes)
            <div class="latest-notes">

                <div class="latest-label">الملاحظات</div>

                <p class="mb-0">
                    {{ $latestDailyVariable->notes }}
                </p>

            </div>
            @endif

        </div>

        @else

        <div class="no-latest">
            لا توجد سجلات يومية حتى الآن.
        </div>

        @endif

    </div>

</div>

@endsection