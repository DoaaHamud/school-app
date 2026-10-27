@extends('layouts.app')

@section('content')
<style>
    .home-chart-card {
        height: 100%;
        padding: 24px;
        background: #fff;
        border: 0;
        border-radius: 18px;
        box-shadow: 0 4px 18px rgba(31, 41, 55, 0.06);
    }

    .home-chart-title {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
        font-size: 1.05rem;
        font-weight: 700;
    }

    .home-chart-container {
        position: relative;
        width: 100%;
        height: 300px;
    }

    @media (max-width: 576px) {
        .home-chart-card {
            padding: 18px;
        }

        .home-chart-container {
            height: 250px;
        }
    }
</style>

<main class="container py-4" style="max-width: 1200px;">
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">الرئيسية</h1>
        <p class="text-muted mb-0">
            ملخص سريع عن {{ auth()->user()->school_name ?? 'الروضة' }}
        </p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-md-4">
            <section class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="text-muted mb-2">
                        <i class="bi bi-mortarboard-fill ms-1" aria-hidden="true"></i>
                        إجمالي الطلاب
                    </div>
                    <div class="h2 fw-bold text-primary mb-0">
                        {{ $stats['students_count'] }}
                    </div>
                </div>
            </section>
        </div>

        <div class="col-12 col-md-4">
            <section class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="text-muted mb-2">
                        <i class="bi bi-people-fill ms-1" aria-hidden="true"></i>
                        إجمالي الأساتذة المعتمدين
                    </div>
                    <div class="h2 fw-bold text-success mb-0">
                        {{ $stats['teachers_count'] }}
                    </div>
                </div>
            </section>
        </div>

        <div class="col-12 col-md-4">
            <section class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="text-muted mb-2">
                        <i class="bi bi-person-hearts ms-1" aria-hidden="true"></i>
                        إجمالي الأهالي المرتبطين بالمدرسة
                    </div>
                    <div class="h2 fw-bold text-info mb-0">
                        {{ $stats['mothers_count'] }}
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-4">
            <section class="home-chart-card">
                <h2 class="home-chart-title text-success">
                    <i class="bi bi-people-fill" aria-hidden="true"></i>
                    الأساتذة المسجلون شهريًا
                </h2>
                <div class="home-chart-container">
                    <canvas id="teachersChart"
                        role="img"
                        aria-label="مخطط عدد الأساتذة المسجلين شهريًا"></canvas>
                </div>
            </section>
        </div>

        <div class="col-12 col-lg-4">
            <section class="home-chart-card">
                <h2 class="home-chart-title text-primary">
                    <i class="bi bi-mortarboard-fill" aria-hidden="true"></i>
                    الطلاب المسجلون شهريًا
                </h2>
                <div class="home-chart-container">
                    <canvas id="studentsChart"
                        role="img"
                        aria-label="مخطط عدد الطلاب المسجلين شهريًا"></canvas>
                </div>
            </section>
        </div>

        <div class="col-12 col-lg-4">
            <section class="home-chart-card">
                <h2 class="home-chart-title text-info">
                    <i class="bi bi-person-hearts" aria-hidden="true"></i>
                    الأهالي المرتبطون شهريًا
                </h2>
                <div class="home-chart-container">
                    <canvas id="mothersChart"
                        role="img"
                        aria-label="مخطط عدد الأهالي المرتبطين بالمدرسة شهريًا"></canvas>
                </div>
            </section>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-4">
            <section class="home-chart-card">
                <h2 class="home-chart-title text-primary">
                    <i class="bi bi-chat-left-text" aria-hidden="true"></i>
                    ملاحظات الأهالي شهريًا
                </h2>
                <div class="home-chart-container">
                    <canvas id="motherNotesChart"
                        role="img"
                        aria-label="مخطط ملاحظات الأهالي حسب الشهر"></canvas>
                </div>
            </section>
        </div>

        <div class="col-12 col-lg-4">
            <section class="home-chart-card">
                <h2 class="home-chart-title text-success">
                    <i class="bi bi-chat-left-dots" aria-hidden="true"></i>
                    ردود المعلمين شهريًا
                </h2>
                <div class="home-chart-container">
                    <canvas id="teacherRepliesChart"
                        role="img"
                        aria-label="مخطط ردود المعلمين حسب الشهر"></canvas>
                </div>
            </section>
        </div>

        <div class="col-12 col-lg-4">
            <section class="home-chart-card">
                <h2 class="home-chart-title text-info">
                    <i class="bi bi-journal-check" aria-hidden="true"></i>
                    المتغيرات اليومية شهريًا
                </h2>
                <div class="home-chart-container">
                    <canvas id="dailyVariablesChart"
                        role="img"
                        aria-label="مخطط المتغيرات اليومية حسب الشهر"></canvas>
                </div>
            </section>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const teachersData = @json($teachersTimeline);
    const studentsData = @json($studentsTimeline);
    const mothersData = @json($mothersTimeline);
    const motherNotesData = @json($motherNotesTimeline);
    const teacherRepliesData = @json($teacherRepliesTimeline);
    const dailyVariablesData = @json($dailyVariablesTimeline);

    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                rtl: true,
                textDirection: 'rtl',
                titleFont: {
                    family: 'Arial'
                },
                bodyFont: {
                    family: 'Arial'
                }
            }
        },
        scales: {
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    autoSkip: true,
                    maxRotation: 0,
                    font: {
                        family: 'Arial'
                    }
                },
                border: {
                    display: false
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0,
                    font: {
                        family: 'Arial'
                    }
                },
                grid: {
                    color: 'rgba(31, 41, 55, 0.07)'
                },
                border: {
                    display: false,
                    dash: [4, 4]
                }
            }
        }
    };

    const createMonthlyChart = (canvasId, timeline, label, color) => {
        new Chart(document.getElementById(canvasId), {
            type: 'bar',
            data: {
                labels: timeline.map(item => item.month),
                datasets: [{
                    label,
                    data: timeline.map(item => Number(item.count)),
                    backgroundColor: color,
                    borderRadius: 8,
                    borderSkipped: false,
                    maxBarThickness: 48
                }]
            },
            options: chartOptions
        });
    };

    createMonthlyChart(
        'teachersChart',
        teachersData,
        'الأساتذة',
        'rgba(25, 166, 106, 0.8)'
    );

    createMonthlyChart(
        'studentsChart',
        studentsData,
        'الطلاب',
        'rgba(37, 99, 235, 0.8)'
    );

    createMonthlyChart(
        'mothersChart',
        mothersData,
        'الأهالي',
        'rgba(22, 166, 182, 0.8)'
    );

    createMonthlyChart(
        'motherNotesChart',
        motherNotesData,
        'ملاحظات الأهالي',
        'rgba(37, 99, 235, 0.8)'
    );

    createMonthlyChart(
        'teacherRepliesChart',
        teacherRepliesData,
        'ردود المعلمين',
        'rgba(25, 166, 106, 0.8)'
    );

    createMonthlyChart(
        'dailyVariablesChart',
        dailyVariablesData,
        'المتغيرات اليومية',
        'rgba(22, 166, 182, 0.8)'
    );
</script>
@endsection