<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الأم - روضتي</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            margin: 0;
            background: #f5f7fb;
            font-family: "Segoe UI", Tahoma, Arial, sans-serif;
            color: #273142;
        }

        .navbar-custom {
            background: white;
            min-height: 70px;
            padding: 0 35px;
            border-bottom: 1px solid #e7ebf0;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
        }

        .mother-notifications-menu {
            width: min(340px, calc(100vw - 30px));
            padding: 8px;
        }

        .mother-notification-item {
            white-space: normal;
            border-radius: 8px;
        }

        .mother-notification-message {
            white-space: normal;
        }

        .navbar-brand {
            font-size: 22px;
            font-weight: 700;
            color: #1f2937;
            margin-left: 30px;
        }

        .nav-link {
            color: #4b5563;
            font-size: 15px;
            font-weight: 500;
            padding: 24px 15px !important;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #2563eb;
        }

        /* تنسيق قائمة الحساب الشخصي */
        .mother-account {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 6px 12px;
            margin-left: 15px;
        }

        .mother-profile-btn {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 6px 8px;
            border: none;
            background: transparent;
            cursor: pointer;
            border-radius: 10px;
        }

        .mother-profile-btn:hover {
            background: #f8fafc;
        }

        .mother-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .mother-info {
            display: flex;
            flex-direction: column;
            text-align: right;
        }

        .mother-label {
            font-size: 13px;
            font-weight: 700;
            color: #334155;
        }

        .mother-role {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 2px;
        }

        .mother-dropdown {
            min-width: 235px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 8px;
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.10);
        }

        .logout-btn {
            background: transparent;
            border: 1px solid #dc3545;
            color: #dc3545;
            border-radius: 7px;
            padding: 7px 15px;
            font-size: 13px;
            font-weight: 600;
        }

        .logout-btn:hover {
            background: #dc3545;
            color: white;
        }

        .main-container {
            max-width: 1250px;
            margin: auto;
            padding: 45px 25px;
        }

        .welcome-section {
            margin-bottom: 35px;
        }

        .welcome-section h2 {
            font-size: 28px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .welcome-section p {
            color: #6b7280;
            margin: 0;
        }

        .children-title {
            font-size: 21px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 20px;
        }

        .children-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 24px;
        }

        .child-card {
            position: relative;
            background: white;
            border: 1px solid #e8edf3;
            border-radius: 20px;
            padding: 24px;
            height: 100%;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.055);
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .child-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto;
            height: 5px;
            background: var(--school-color, #2563eb);
        }

        .child-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 32px rgba(15, 23, 42, 0.09);
        }

        .school-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding-bottom: 18px;
            margin-bottom: 20px;
            border-bottom: 1px solid #f0f2f5;
        }

        .child-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .child-info {
            display: flex;
            align-items: center;
            gap: 18px;
            min-width: 0;
        }

        .child-avatar {
            width: 76px;
            height: 76px;
            flex: 0 0 76px;
            border: 3px solid color-mix(in srgb, var(--school-color, #2563eb) 18%, white);
            border-radius: 22px;
            background: color-mix(in srgb, var(--school-color, #2563eb) 10%, white);
            color: var(--school-color, #2563eb);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            overflow: hidden;
        }

        .child-name {
            font-size: 21px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 12px;
        }

        .child-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            color: #6b7280;
            font-size: 12px;
        }

        .child-meta span {
            padding: 7px 10px;
            border: 1px solid #edf0f4;
            border-radius: 9px;
            background: #fafbfc;
        }

        .child-meta i {
            color: var(--school-color, #2563eb);
            margin-left: 4px;
        }

        .school-brand {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            color: var(--school-color, #2563eb);
            font-size: 13px;
            font-weight: 700;
        }

        .school-brand img,
        .school-brand-icon {
            width: 36px;
            height: 36px;
            border: 1px solid color-mix(in srgb, var(--school-color, #2563eb) 16%, white);
            border-radius: 10px;
            object-fit: contain;
            background: #fff;
        }

        .school-brand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: color-mix(in srgb, var(--school-color, #2563eb) 10%, white);
            font-size: 17px;
        }

        .school-caption {
            color: #94a3b8;
            font-size: 11px;
            font-weight: 500;
        }

        .details-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            flex: 0 0 auto;
            background: var(--school-color, #2563eb);
            color: white;
            border: none;
            border-radius: 11px;
            padding: 11px 17px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 4px 10px color-mix(in srgb, var(--school-color, #2563eb) 22%, transparent);
            transition: filter 0.2s ease, transform 0.2s ease;
        }

        .details-btn:hover {
            filter: brightness(0.9);
            color: white;
            transform: translateY(-1px);
        }

        .latest-report {
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid #f0f2f5;
        }

        .latest-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            font-size: 14px;
            color: #374151;
            margin-bottom: 10px;
        }

        .latest-title i {
            color: var(--school-color, #2563eb);
        }

        .report-box {
            background: color-mix(in srgb, var(--school-color, #2563eb) 5%, white);
            border: 1px solid color-mix(in srgb, var(--school-color, #2563eb) 12%, white);
            border-radius: 13px;
            padding: 16px;
        }

        .report-topic {
            font-weight: 600;
            color: #1f2937;
        }

        .report-date {
            color: #6b7280;
            font-size: 12px;
            margin-top: 5px;
        }

        .result-badge {
            white-space: nowrap;
            background: color-mix(in srgb, var(--school-color, #2563eb) 10%, white);
            color: var(--school-color, #2563eb);
            border-radius: 9px;
            padding: 8px 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .empty-box {
            grid-column: 1 / -1;
            background: white;
            border: 1px solid #e5eaf0;
            border-radius: 15px;
            text-align: center;
            padding: 70px 20px;
            color: #9ca3af;
        }

        .empty-box i {
            font-size: 50px;
            color: #cbd5e1;
        }

        @media (max-width: 768px) {
            .navbar-custom {
                padding: 10px 15px;
            }

            .nav-link {
                padding: 10px !important;
            }

            .main-container {
                padding: 30px 15px;
            }

            .children-grid {
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .child-card {
                padding: 19px;
            }

            .child-header {
                flex-direction: column;
                align-items: stretch;
            }

            .child-info {
                align-items: flex-start;
            }

            .child-avatar {
                width: 62px;
                height: 62px;
                flex-basis: 62px;
                border-radius: 18px;
            }

            .child-name {
                font-size: 18px;
            }

            .details-btn {
                display: block;
                text-align: center;
            }

            .school-card-header {
                align-items: flex-start;
            }

            .report-box .d-flex {
                flex-direction: column;
            }

            .result-badge {
                align-self: flex-start;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <!-- أيقونة محايدة للوحة الأم -->
            <div style="width: 45px; height: 45px; flex-shrink: 0; border-radius: 12px; background: #f1f5f9; color: #64748b; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                <i class="bi bi-grid-1x2-fill" aria-hidden="true"></i>
            </div>

            <!-- اسم لوحة الأم -->
            <div class="brand-text" style="display: flex; flex-direction: column; text-align: right;">
                <span style="font-size: 18px; font-weight: 800; color: #334155; line-height: 1.2;">لوحة الأم</span>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#motherNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="motherNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('mother.dashboard') }}">
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
                    <ul class="dropdown-menu dropdown-menu-end mother-dropdown mother-notifications-menu">
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

                <!-- قائمة حساب الأم -->
                <div class="dropdown mother-account">
                    <button class="mother-profile-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="mother-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="mother-info">
                            <span class="mother-label">{{ $mother->name }}</span>
                            <span class="mother-role">ولي أمر (أم)</span>
                        </div>
                        <i class="bi bi-chevron-down text-muted" style="font-size: 11px; margin-right: 4px;"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end mother-dropdown">
                        <li>
                            <div class="dropdown-header px-3 py-2">
                                <strong>{{ $mother->name }}</strong>
                                <small class="text-muted d-block">{{ $mother->email ?? '' }}</small>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('mother.profile') }}">
                                <i class="bi bi-person-circle me-1 text-primary"></i> الملف الشخصي
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- تسجيل الخروج -->
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="logout-btn">
                        تسجيل الخروج
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main -->
    <main class="main-container">
        <div class="welcome-section">
            <h2>
                أهلاً بكِ، {{ $mother->name }}
            </h2>
            <p>
                يمكنكِ متابعة أبنائك والاطلاع على تقاريرهم اليومية.
            </p>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill ms-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-circle-fill ms-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger shadow-sm" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <a href="{{ route('mother.school_requests') }}"
            class="card border-0 shadow-sm rounded-4 mb-4 text-decoration-none text-dark">
            <div class="card-body p-4 d-flex align-items-center gap-3">
                <span class="d-flex align-items-center justify-content-center rounded-3 text-white"
                    style="width: 52px; height: 52px; flex: 0 0 52px; background: #2563eb; font-size: 23px;">
                    <i class="bi bi-building-add" aria-hidden="true"></i>
                </span>
                <span>
                    <span class="d-block fw-bold">الانضمام إلى مدرسة جديدة</span>
                    <span class="d-block small text-muted mt-1">اختاري مدرسة وأرسلي طلب الانضمام إلى مديرها</span>
                </span>
                <i class="bi bi-chevron-left me-auto text-muted" aria-hidden="true"></i>
            </div>
        </a>

        <h3 class="children-title">
            <i class="bi bi-people"></i>
            أبنائي
        </h3>

        <div class="children-grid">
            @forelse($children as $child)
            @php
            $schoolColor = $child->school?->color;
            if (!is_string($schoolColor) || !preg_match('/^#[0-9A-Fa-f]{6}$/', $schoolColor)) {
            $schoolColor = '#2563eb';
            }
            @endphp
            <div class="child-card" style="--school-color: {{ $schoolColor }};">
                <div class="school-card-header">
                    <div class="school-brand mb-0">
                        @if($child->school?->logo)
                        <img src="{{ asset('storage/' . $child->school->logo) }}" alt="شعار {{ $child->school->name ?? 'المدرسة' }}">
                        @else
                        <span class="school-brand-icon"><i class="bi bi-mortarboard"></i></span>
                        @endif
                        <span>{{ $child->school?->name ?? 'المدرسة غير محددة' }}</span>
                    </div>
                    <span class="school-caption">بيانات المدرسة</span>
                </div>
                <div class="child-header">
                    <div class="child-info">
                        <div class="child-avatar">
                            @if($child->image)
                            <img src="{{ asset('images/children/' . $child->image) }}" alt="{{ $child->name }}" style="width:100%; height:100%; object-fit:cover; border-radius:inherit;">
                            @else
                            <i class="bi bi-person"></i>
                            @endif
                        </div>
                        <div>
                            <div class="child-name">
                                {{ $child->name }}
                            </div>
                            <div class="child-meta">
                                <span>
                                    <i class="bi bi-calendar3"></i>
                                    العمر:
                                    {{ $child->age ?? 'غير محدد' }}
                                </span>
                                <span>
                                    <i class="bi bi-mortarboard"></i>
                                    الصف:
                                    {{ $child->class ?? 'غير محدد' }}
                                </span>
                                <span>
                                    <i class="bi bi-heart"></i>
                                    الحالة الصحية:
                                    {{ $child->Health_status ?? 'غير محددة' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('mother.child_details', $child->id) }}" class="details-btn">
                        <i class="bi bi-eye"></i>
                        عرض التفاصيل
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                </div>

                @if($child->dailyVariables->count() > 0)
                @php
                $latestReport = $child->dailyVariables->first();
                @endphp
                <div class="latest-report">
                    <div class="latest-title">
                        <i class="bi bi-journal-text"></i>
                        آخر تقرير يومي
                    </div>
                    <div class="report-box">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <div>
                                <div class="report-topic">
                                    {{ $latestReport->topic }}
                                </div>
                                <div class="report-date">
                                    <i class="bi bi-calendar3"></i>
                                    {{ \Carbon\Carbon::parse($latestReport->report_date)->format('Y-m-d H:i') }}
                                </div>
                            </div>
                            <span class="result-badge">
                                النتيجة:
                                {{ $latestReport->result ?? 'غير محددة' }}
                            </span>
                        </div>

                        @if($latestReport->notes)
                        <div class="mt-3 text-muted">
                            <strong>
                                الملاحظات:
                            </strong>
                            {{ $latestReport->notes }}
                        </div>
                        @endif
                    </div>
                </div>
                @else
                <div class="latest-report text-muted">
                    <i class="bi bi-info-circle"></i>
                    لا يوجد تقرير يومي لهذا الطالب حتى الآن.
                </div>
                @endif

            </div>
            @empty
            <div class="empty-box">
                <i class="bi bi-people"></i>
                <h5 class="mt-3">
                    لا يوجد أطفال مسجلون
                </h5>
                <p class="mb-0">
                    لم يتم تسجيل أي طفل مرتبط بحسابكِ حتى الآن.
                </p>
            </div>
            @endforelse
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>