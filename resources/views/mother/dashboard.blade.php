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

        .child-card {
            background: white;
            border: 1px solid #e5eaf0;
            border-radius: 15px;
            padding: 22px;
            margin-bottom: 20px;
            box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
        }

        .child-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .child-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .child-avatar {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            background: #eef4ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .child-name {
            font-size: 19px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .child-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            color: #6b7280;
            font-size: 13px;
        }

        .child-meta i {
            color: #2563eb;
            margin-left: 4px;
        }

        .details-btn {
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 17px;
            text-decoration: none;
            font-size: 14px;
        }

        .details-btn:hover {
            background: #1d4ed8;
            color: white;
        }

        .latest-report {
            margin-top: 20px;
            padding-top: 18px;
            border-top: 1px solid #edf0f4;
        }

        .latest-title {
            font-weight: 700;
            font-size: 14px;
            color: #374151;
            margin-bottom: 10px;
        }

        .report-box {
            background: #f8faff;
            border-radius: 10px;
            padding: 14px;
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
            background: #eef4ff;
            color: #2563eb;
            border-radius: 20px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .empty-box {
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

            .child-header {
                flex-direction: column;
                align-items: stretch;
            }

            .details-btn {
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <!-- حاوية الشعار -->
            <div style="width: 45px; height: 45px; flex-shrink: 0; border-radius: 12px; overflow: hidden; background: #eff6ff; display: flex; align-items: center; justify-content: center;">
                <img src="{{ asset('images/logo.jpeg') }}"
                    alt="شعار روضتي"
                    style="width: 100%; height: 100%; object-fit: contain;">
            </div>

            <!-- النصوص بجانب الشعار -->
            <div class="brand-text" style="display: flex; flex-direction: column; text-align: right;">
                <span style="font-size: 18px; font-weight: 800; color: #2563eb; line-height: 1.2;">روضتي</span>
                <span style="font-size: 12px; color: #64748b; margin-top: 2px; font-weight: 500;">لوحة الأم</span>
            </div>
            </a>

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

                <!-- قائمة حساب الأم (الملف الشخصي، التعديل، والحذف) -->
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
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('mother.profile.edit') }}">
                                <i class="bi bi-pencil-square me-1 text-warning"></i> تعديل البيانات
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <button type="button" class="dropdown-item py-2 text-danger" data-bs-toggle="modal" data-bs-target="#deleteMotherModal">
                                <i class="bi bi-trash me-1"></i> حذف الحساب
                            </button>
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
                يمكنكِ متابعة أطفالكِ والاطلاع على تقاريرهم اليومية.
            </p>
        </div>

        <h3 class="children-title">
            <i class="bi bi-people"></i>
            أطفالي
        </h3>

        @forelse($children as $child)
        <div class="child-card">
            <div class="child-header">
                <div class="child-info">
                    <div class="child-avatar">
                        @if($child->image)
                        <img src="{{ asset('images/children/' . $child->image) }}" alt="{{ $child->name }}" style="width:100%; height:100%; object-fit:cover; border-radius:14px;">
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
                لا يوجد تقرير يومي لهذا الطفل حتى الآن.
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
    </main>

    <!-- نافذة تأكيد حذف حساب الأم (Modal) -->
    <div class="modal fade" id="deleteMotherModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fs-6">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> تحذير: حذف الحساب
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bi bi-trash3-fill text-danger display-4 mb-3 d-block"></i>
                    <h6 class="fw-bold text-dark mb-2">هل أنت متأكد من حذف حسابكِ الشخصي؟</h6>
                    <p class="text-muted small mb-0">سيتم حذف الحساب نهائياً ولا يمكن التراجع عن هذه العملية.</p>
                </div>
                <div class="modal-footer bg-light justify-content-center border-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">إلغاء</button>
                    <!-- تأكد من مطابقة مسار الحذف لديك في الراوتس، مثلاً mother.profile.delete -->
                    <form action="{{ route('mother.profile.delete') }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4">
                            <i class="bi bi-trash3 me-1"></i> نعم، احذفي الحساب
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>