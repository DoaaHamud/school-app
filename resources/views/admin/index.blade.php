<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة المؤشرات والتحليلات - روضتي</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background-color: #f7f8fc;
            font-family: Arial, sans-serif;
            color: #1f2937;
        }

        .stat-card {
            height: 100%;
            padding: 20px;
            background: #fff;
            border-top: 4px solid #2563eb;
            border-radius: 14px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.04);
        }

        .chart-card {
            height: 100%;
            padding: 24px;
            background: #fff;
            border: 0;
            border-radius: 18px;
            box-shadow: 0 4px 18px rgba(31, 41, 55, 0.06);
        }

        .chart-title {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            font-size: 1.05rem;
            font-weight: 700;
        }

        .chart-container {
            position: relative;
            width: 100%;
            height: 300px;
        }

        .activity-list .list-group-item {
            background: transparent;
        }

        @media (max-width: 576px) {
            .chart-card {
                padding: 18px;
            }

            .chart-container {
                height: 250px;
            }
        }
    </style>
</head>

<body>
    @include('admin.navbar')

    <main class="container py-4" style="max-width: 1300px;">
        <div class="row g-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <h6 class="text-muted small">إجمالي المدارس</h6>
                    <h3 class="fw-bold text-primary mb-0">{{ $stats['schools_count'] }}</h3>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="stat-card" style="border-top-color: #16a6b6;">
                    <h6 class="text-muted small">إجمالي الطلاب</h6>
                    <h3 class="fw-bold text-info mb-0">{{ $stats['students_count'] }}</h3>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="stat-card" style="border-top-color: #f59e0b;">
                    <h6 class="text-muted small">الأساتذة المعتمدون</h6>
                    <h3 class="fw-bold text-warning mb-0">{{ $stats['teachers_count'] }}</h3>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="stat-card" style="border-top-color: #19a66a;">
                    <h6 class="text-muted small">عدد الأهالي</h6>
                    <h3 class="fw-bold text-success mb-0">{{ $stats['mothers_count'] }}</h3>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-12 col-lg-6">
                <section class="chart-card">
                    <h2 class="chart-title text-primary">
                        <i class="bi bi-buildings" aria-hidden="true"></i>
                        نمو عدد المدارس عبر الزمن
                    </h2>
                    <div class="chart-container">
                        <canvas id="schoolsChart" role="img" aria-label="مخطط المدارس المسجلة شهريًا"></canvas>
                    </div>
                </section>
            </div>

            <div class="col-12 col-lg-6">
                <section class="chart-card">
                    <h2 class="chart-title text-info">
                        <i class="bi bi-people" aria-hidden="true"></i>
                        نمو عدد الطلاب عبر الزمن
                    </h2>
                    <div class="chart-container">
                        <canvas id="studentsChart" role="img" aria-label="مخطط الطلاب المسجلين شهريًا"></canvas>
                    </div>
                </section>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-12 col-lg-6">
                <section class="chart-card">
                    <h2 class="chart-title text-warning">
                        <i class="bi bi-person-badge" aria-hidden="true"></i>
                        نمو عدد المعلمين عبر الزمن
                    </h2>
                    <div class="chart-container">
                        <canvas id="teachersChart" role="img" aria-label="مخطط المعلمين المسجلين شهريًا"></canvas>
                    </div>
                </section>
            </div>

            <div class="col-12 col-lg-6">
                <section class="chart-card">
                    <h2 class="chart-title text-success">
                        <i class="bi bi-person-hearts" aria-hidden="true"></i>
                        عدد الأهالي المسجلين عبر الزمن
                    </h2>
                    <div class="chart-container">
                        <canvas id="mothersChart" role="img" aria-label="مخطط الأهالي المسجلين شهريًا"></canvas>
                    </div>
                </section>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-12 col-lg-6">
                <section class="chart-card">
                    <h2 class="chart-title text-primary">
                        <i class="bi bi-chat-left-text" aria-hidden="true"></i>
                        ملاحظات الأهالي
                    </h2>
                    <div class="chart-container">
                        <canvas id="motherNotesChart" role="img" aria-label="مخطط ملاحظات الأهالي شهريًا"></canvas>
                    </div>
                </section>
            </div>

            <div class="col-12 col-lg-6">
                <section class="chart-card">
                    <h2 class="chart-title text-success">
                        <i class="bi bi-chat-left-dots" aria-hidden="true"></i>
                        ردود المعلمات
                    </h2>
                    <div class="chart-container">
                        <canvas id="teacherRepliesChart" role="img" aria-label="مخطط ردود المعلمات شهريًا"></canvas>
                    </div>
                </section>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-6">
                <section class="chart-card">
                    <h2 class="chart-title text-info">
                        <i class="bi bi-journal-check" aria-hidden="true"></i>
                        المتغيرات اليومية المسجلة
                    </h2>
                    <div class="chart-container">
                        <canvas id="dailyVariablesChart" role="img" aria-label="مخطط المتغيرات اليومية المسجلة شهريًا"></canvas>
                    </div>
                </section>
            </div>

            <div class="col-12 col-lg-6">
                <section class="chart-card">
                    <h2 class="chart-title text-success">
                        <i class="bi bi-graph-up-arrow" aria-hidden="true"></i>
                        التفاعل والتقارير
                    </h2>

                    <ul class="list-group list-group-flush activity-list">
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span>ملاحظات الأهالي</span>
                            <span class="badge bg-primary rounded-pill px-3 py-2">
                                {{ $stats['mother_notes_count'] }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span>ردود المعلمات</span>
                            <span class="badge bg-success rounded-pill px-3 py-2">
                                {{ $stats['teacher_replies_count'] }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span>المتغيرات اليومية المسجلة</span>
                            <span class="badge bg-info rounded-pill px-3 py-2">
                                {{ $stats['daily_variables_count'] }}
                            </span>
                        </li>
                    </ul>
                </section>
            </div>
        </div>
    </main>

    <script>
        const schoolsData = @json($schoolsTimeline);
        const studentsData = @json($studentsTimeline);
        const teachersData = @json($teachersTimeline);
        const mothersData = @json($mothersTimeline);
        const motherNotesData = @json($motherNotesTimeline);
        const teacherRepliesData = @json($teacherRepliesTimeline);
        const dailyVariablesData = @json($dailyVariablesTimeline);

        const createChartOptions = () => ({
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    rtl: true,
                    textDirection: 'rtl',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 20,
                        font: {
                            family: 'Arial',
                            size: 12
                        }
                    }
                },
                tooltip: {
                    rtl: true,
                    textDirection: 'rtl',
                    padding: 12,
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
        });

        const createLineChart = (canvasId, timeline, label, color, backgroundColor) => {
            new Chart(document.getElementById(canvasId), {
                type: 'line',
                data: {
                    labels: timeline.map(item => item.month),
                    datasets: [{
                        label,
                        data: timeline.map(item => Number(item.count)),
                        borderColor: color,
                        backgroundColor,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.35,
                        pointRadius: 4,
                        pointHoverRadius: 7,
                        pointBackgroundColor: color,
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }]
                },
                options: createChartOptions()
            });
        };

        const createBarChart = (canvasId, timeline, label, color, hoverColor) => {
            new Chart(document.getElementById(canvasId), {
                type: 'bar',
                data: {
                    labels: timeline.map(item => item.month),
                    datasets: [{
                        label,
                        data: timeline.map(item => Number(item.count)),
                        backgroundColor: color,
                        hoverBackgroundColor: hoverColor,
                        borderRadius: 8,
                        borderSkipped: false,
                        maxBarThickness: 48
                    }]
                },
                options: createChartOptions()
            });
        };

        createLineChart(
            'schoolsChart',
            schoolsData,
            'المدارس المسجلة',
            '#2563eb',
            'rgba(37, 99, 235, 0.12)'
        );

        createBarChart(
            'studentsChart',
            studentsData,
            'الطلاب المسجلون',
            'rgba(22, 166, 182, 0.8)',
            '#128b99'
        );

        createLineChart(
            'teachersChart',
            teachersData,
            'المعلمون المسجلون',
            '#f59e0b',
            'rgba(245, 158, 11, 0.14)'
        );

        createLineChart(
            'mothersChart',
            mothersData,
            'الأهالي المسجلون',
            '#19a66a',
            'rgba(25, 166, 106, 0.12)'
        );

        createBarChart(
            'motherNotesChart',
            motherNotesData,
            'ملاحظات الأهالي',
            'rgba(37, 99, 235, 0.8)',
            '#1d4ed8'
        );

        createBarChart(
            'teacherRepliesChart',
            teacherRepliesData,
            'ردود المعلمات',
            'rgba(22, 163, 74, 0.8)',
            '#15803d'
        );

        createBarChart(
            'dailyVariablesChart',
            dailyVariablesData,
            'المتغيرات اليومية المسجلة',
            'rgba(22, 166, 182, 0.8)',
            '#128b99'
        );
    </script>
</body>

</html>