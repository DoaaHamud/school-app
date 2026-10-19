<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>تفاصيل {{ $child->name }} - {{ $child->manager?->school_name ?? 'روضتي' }}</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f5f7fb;
            font-family: "Segoe UI", Tahoma, Arial, sans-serif;
            color: #273142;
            --school-color: #2563eb;
        }

        /* Navbar */

        .navbar-custom {
            background: #ffffff;
            min-height: 70px;
            padding: 0 35px;
            border-bottom: 3px solid var(--school-color);
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
        }

        .school-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--school-color);
            font-weight: 700;
            text-decoration: none;
        }

        .school-logo {
            width: 44px;
            height: 44px;
            flex: 0 0 44px;
            padding: 4px;
            border: 1px solid color-mix(in srgb, var(--school-color) 20%, white);
            border-radius: 12px;
            object-fit: contain;
            background: #fff;
        }

        .school-brand-name {
            font-size: 16px;
            line-height: 1.25;
        }

        .school-brand-caption {
            display: block;
            margin-top: 3px;
            color: #64748b;
            font-size: 11px;
            font-weight: 500;
        }

        .nav-link {
            color: #4b5563;
            font-size: 15px;
            font-weight: 500;
            padding: 24px 15px !important;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--school-color);
        }

        .child-notes-link {
            color: var(--school-color);
            border-color: var(--school-color);
        }

        .child-notes-link:hover,
        .child-notes-link:focus {
            color: #fff;
            background-color: var(--school-color);
            border-color: var(--school-color);
        }

        .mother-account {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-left: 16px;
            padding: 6px 12px 6px 14px;
            border: 1px solid #e8edf3;
            border-radius: 14px;
            background: #f8fafc;
        }

        .mother-avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            flex: 0 0 36px;
            border-radius: 11px;
            background: color-mix(in srgb, var(--school-color) 11%, white);
            color: var(--school-color);
            font-size: 17px;
        }

        .mother-account-info {
            display: flex;
            flex-direction: column;
            line-height: 1.35;
        }

        .mother-account-name {
            color: #334155;
            font-size: 13px;
            font-weight: 700;
        }

        .mother-account-role {
            color: #94a3b8;
            font-size: 10px;
            margin-top: 2px;
        }

        .mother-notifications-menu {
            width: min(340px, calc(100vw - 30px));
            padding: 8px;
        }

        .mother-notification-item,
        .mother-notification-message {
            white-space: normal;
        }

        .mother-notification-item {
            border-radius: 8px;
        }

        .logout-btn {
            background: transparent;
            border: 1px solid #dc3545;
            color: #dc3545;
            border-radius: 7px;
            padding: 7px 15px;
            font-size: 14px;
        }

        .logout-btn:hover {
            background: #dc3545;
            color: white;
        }

        /* Main */

        .main-container {
            max-width: 1200px;
            margin: auto;
            padding: 40px 25px 60px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--school-color);
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .back-link:hover {
            filter: brightness(0.85);
        }

        /* Child information */

        .child-card {
            background: #ffffff;
            border: 1px solid #e5eaf0;
            border-top: 4px solid var(--school-color);
            border-radius: 15px;
            padding: 28px;
            box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
            margin-bottom: 30px;
        }

        .child-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 28px;
        }

        .child-image {
            width: 90px;
            height: 90px;
            border-radius: 16px;
            background: color-mix(in srgb, var(--school-color) 10%, white);
            color: var(--school-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .child-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .child-name {
            font-size: 26px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 7px;
        }

        .child-subtitle {
            color: #6b7280;
            font-size: 14px;
        }

        /* Information boxes */

        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .info-box {
            background: color-mix(in srgb, var(--school-color) 4%, white);
            border: 1px solid color-mix(in srgb, var(--school-color) 12%, white);
            border-radius: 10px;
            padding: 15px;
        }

        .info-label {
            color: #6b7280;
            font-size: 12px;
            margin-bottom: 6px;
        }

        .info-value {
            color: #1f2937;
            font-weight: 600;
            font-size: 14px;
        }

        .info-value i {
            color: var(--school-color);
            margin-left: 5px;
        }

        /* Reports */

        .section-title {
            font-size: 21px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 18px;
        }

        .section-title i {
            color: var(--school-color);
            margin-left: 7px;
        }

        .report-card {
            background: #ffffff;
            border: 1px solid color-mix(in srgb, var(--school-color) 16%, white);
            border-right: 4px solid var(--school-color);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        }

        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .report-topic {
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
        }

        .report-topic i {
            color: var(--school-color);
            margin-left: 5px;
        }

        .result-badge {
            background: color-mix(in srgb, var(--school-color) 10%, white);
            color: var(--school-color);
            border-radius: 20px;
            padding: 7px 13px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .report-date {
            color: #6b7280;
            font-size: 12px;
            margin-bottom: 12px;
        }

        .report-notes {
            background: color-mix(in srgb, var(--school-color) 4%, white);
            border-radius: 8px;
            padding: 12px 14px;
            color: #4b5563;
            font-size: 13px;
            line-height: 1.8;
        }

        .report-notes strong {
            color: #374151;
        }

        .empty-reports {
            background: #ffffff;
            border: 1px solid #e5eaf0;
            border-radius: 12px;
            text-align: center;
            padding: 50px 20px;
            color: #9ca3af;
        }

        .empty-reports i {
            font-size: 42px;
            color: #cbd5e1;
        }

        /* Responsive */

        @media (max-width: 768px) {

            .navbar-custom {
                padding: 10px 15px;
            }

            .nav-link {
                padding: 10px !important;
            }

            .main-container {
                padding: 25px 15px 40px;
            }

            .child-card {
                padding: 20px;
            }

            .child-header {
                align-items: flex-start;
            }

            .child-name {
                font-size: 22px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .report-header {
                flex-direction: column;
                align-items: flex-start;
            }

        }
    </style>

</head>

@php
    $schoolColor = $child->manager?->primary_color;
    if (!is_string($schoolColor) || !preg_match('/^#[0-9A-Fa-f]{6}$/', $schoolColor)) {
        $schoolColor = '#2563eb';
    }
@endphp
<body style="--school-color: {{ $schoolColor }};">

    <!-- Navbar -->

    <nav class="navbar navbar-expand-lg navbar-custom">

        <div class="container-fluid">
            <!-- حاوية الشعار -->
            <div class="school-brand">
                <img class="school-logo"
                    src="{{ $child->manager?->school_logo ? asset('storage/' . $child->manager->school_logo) : asset('images/logo.jpeg') }}"
                    alt="شعار {{ $child->manager?->school_name ?? 'روضتي' }}">
                <span class="school-brand-name">
                    {{ $child->manager?->school_name ?? 'روضتي' }}
                    <small class="school-brand-caption">تقارير الطفل</small>
                </span>
            </div>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#motherNavbar">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div
                class="collapse navbar-collapse"
                id="motherNavbar">

                <ul class="navbar-nav me-auto">

                    <li class="nav-item">

                        <a
                            class="nav-link active"
                            href="{{ route('mother.dashboard') }}">

                            الرئيسية

                        </a>

                    </li>

                </ul>

                <div class="dropdown me-lg-3">
                    <button class="btn position-relative d-flex align-items-center gap-2 text-secondary"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="الإشعارات">
                        <i class="bi bi-bell fs-5"></i>
                        <span class="d-lg-none">الإشعارات</span>
                        @if($unreadNotificationsCount > 0)
                        <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">
                            {{ $unreadNotificationsCount }}
                        </span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end mother-notifications-menu">
                        <li class="dropdown-header fw-bold">الإشعارات</li>
                        @forelse($motherNotifications as $notification)
                        <li>
                            <a class="dropdown-item mother-notification-item py-2 {{ $notification->read_at ? '' : 'bg-light' }}"
                                href="{{ route('mother.notifications.open', $notification->id) }}">
                                <span class="d-flex align-items-start gap-2">
                                    <i class="bi {{ ($notification->data['type'] ?? '') === 'mother_child_note_reply' ? 'bi-chat-left-text-fill' : 'bi-file-earmark-text' }} text-primary mt-1"></i>
                                    <span>
                                        <span class="d-block fw-semibold">{{ $notification->data['child_name'] ?? 'طفلكِ' }}</span>
                                        <span class="mother-notification-message d-block small text-muted">{{ $notification->data['message'] ?? 'تمت إضافة تقرير جديد.' }}</span>
                                        <small class="text-secondary">{{ $notification->created_at->diffForHumans() }}</small>
                                    </span>
                                </span>
                            </a>
                        </li>
                        @empty
                        <li class="px-3 py-2 small text-muted">لا توجد إشعارات حتى الآن.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="mother-account">
                    <span class="mother-avatar" aria-hidden="true">
                        <i class="bi bi-person-fill"></i>
                    </span>
                    <span class="mother-account-info">
                        <span class="mother-account-name">{{ auth()->user()->name }}</span>
                        <span class="mother-account-role">وليّة أمر</span>
                    </span>
                </div>

                <form
                    action="{{ route('logout') }}"
                    method="POST">

                    @csrf

                    <button
                        type="submit"
                        class="logout-btn">

                        تسجيل الخروج

                    </button>

                </form>

            </div>

        </div>

    </nav>


    <!-- Main -->

    <main class="main-container">

        <!-- Back -->

        <a
            href="{{ route('mother.dashboard') }}"
            class="back-link">

            <i class="bi bi-arrow-right"></i>

            العودة إلى لوحة الأم

        </a>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif


        <!-- Child information -->

        <div class="child-card">

            <div class="child-header">

                <div class="child-image">

                    @if($child->image)

                    <img
                        src="{{ asset('images/children/' . $child->image) }}"
                        alt="{{ $child->name }}">

                    @else

                    <i class="bi bi-person"></i>

                    @endif

                </div>

                <div>

                    <div class="child-name">

                        {{ $child->name }}

                    </div>

                    <div class="child-subtitle">

                        معلومات الطفل والتقارير اليومية

                    </div>

                </div>

            </div>


            <!-- Child details -->

            <div class="info-grid">

                <div class="info-box">

                    <div class="info-label">
                        الجنس
                    </div>

                    <div class="info-value">

                        <i class="bi bi-person"></i>

                        @if($child->gender === 'male')
                        ذكر
                        @elseif($child->gender === 'female')
                        أنثى
                        @else
                        غير محدد
                        @endif

                    </div>

                </div>


                <div class="info-box">

                    <div class="info-label">
                        العمر
                    </div>

                    <div class="info-value">

                        <i class="bi bi-calendar3"></i>

                        {{ $child->age ?? 'غير محدد' }}

                    </div>

                </div>


                <div class="info-box">

                    <div class="info-label">
                        الصف
                    </div>

                    <div class="info-value">

                        <i class="bi bi-mortarboard"></i>

                        {{ $child->class ?? 'غير محدد' }}

                    </div>

                </div>


                <div class="info-box">

                    <div class="info-label">
                        الحالة الصحية
                    </div>

                    <div class="info-value">

                        <i class="bi bi-heart"></i>

                        {{ $child->Health_status ?? 'غير محددة' }}

                    </div>

                </div>


                <div class="info-box">

                    <div class="info-label">
                        عدد التقارير
                    </div>

                    <div class="info-value">

                        <i class="bi bi-journal-text"></i>

                        {{ $child->dailyVariables->count() }}

                    </div>

                </div>

            </div>

        </div>

        <section class="child-card" aria-labelledby="sendChildNoteTitle">
            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
            <h3 id="sendChildNoteTitle" class="section-title">
                <i class="bi bi-chat-left-text"></i>
                إرسال ملاحظة للمعلمين
            </h3>
                <a href="{{ route('mother.child_notes.index', $child->id) }}" class="btn child-notes-link">
                    <i class="bi bi-chat-square-text ms-1"></i>
                    ملاحظاتي وردود المعلمات
                </a>
            </div>
            @if($child->teachers->isNotEmpty())
            <form action="{{ route('mother.child_notes.store', $child->id) }}" method="POST">
                @csrf
                <label for="childTeacher" class="form-label fw-semibold">إرسال إلى</label>
                <select id="childTeacher" name="teacher_id" class="form-select mb-3">
                    <option value="">جميع المعلمين</option>
                    @foreach($child->teachers as $teacher)
                    <option value="{{ $teacher->id }}" @selected(old('teacher_id') == $teacher->id)>
                        {{ $teacher->name }}
                    </option>
                    @endforeach
                </select>
                <label for="childNote" class="form-label fw-semibold">نص الملاحظة</label>
                <textarea id="childNote" name="note" class="form-control mb-2" rows="4" maxlength="2000"
                    placeholder="اكتبي ملاحظة أو رسالة للمعلمين المسؤولين..." required>{{ old('note') }}</textarea>
                <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                    <small class="text-muted">حد أقصى 2000 حرف</small>
                    <button type="submit" class="btn btn-primary" style="background: var(--school-color); border-color: var(--school-color);">
                        <i class="bi bi-send ms-1"></i> إرسال الملاحظة
                    </button>
                </div>
            </form>
            @else
            <p class="text-muted mb-0">لا يوجد معلمون معينون لهذا الطفل حاليًا، لذلك لا يمكن إرسال ملاحظة.</p>
            @endif
        </section>


        <!-- Daily reports -->

        <h3 class="section-title">

            <i class="bi bi-journal-text"></i>

            التقارير اليومية

        </h3>


        @forelse($child->dailyVariables as $daily)

        <div class="report-card">

            <div class="report-header">

                <div class="report-topic">

                    <i class="bi bi-bookmark"></i>

                    {{ $daily->topic }}

                </div>

                <span class="result-badge">

                    <i class="bi bi-bar-chart"></i>

                    النتيجة:
                    {{ $daily->result ?? 'غير محددة' }}

                </span>

            </div>


            <div class="report-date">

                <i class="bi bi-calendar3"></i>

                تاريخ التقرير:

                {{ \Carbon\Carbon::parse($daily->report_date)->format('Y-m-d H:i') }}

            </div>


            @if($daily->notes)

            <div class="report-notes">

                <strong>
                    <i class="bi bi-chat-left-text"></i>
                    ملاحظات المعلم:
                </strong>

                {{ $daily->notes }}

            </div>

            @else

            <div class="report-notes text-muted">

                لا توجد ملاحظات لهذا التقرير.

            </div>

            @endif

        </div>

        @empty

        <div class="empty-reports">

            <i class="bi bi-journal-x"></i>

            <h5 class="mt-3">

                لا توجد تقارير يومية

            </h5>

            <p class="mb-0">

                لم تتم إضافة أي تقارير لهذا الطفل حتى الآن.

            </p>

        </div>

        @endforelse

    </main>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>