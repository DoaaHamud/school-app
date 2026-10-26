<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الأدمن - روضتي</title>

    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #f7f8fc;
            font-family: Arial, sans-serif;
            color: #1f2937;
        }

        /* Navbar */
        .main-navbar {
            background: #ffffff;
            border-bottom: 1px solid #e9edf3;
            box-shadow: 0 3px 18px rgba(30, 41, 59, 0.06);
            min-height: 76px;
            padding: 0 25px;
        }

        .brand-icon {
            width: 46px;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: white;
            font-size: 20px;
            box-shadow: 0 5px 12px rgba(37, 99, 235, 0.20);
        }

        .dashboard-name {
            font-size: 16px;
            color: #64748b;
            font-weight: 700;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #334155;
            font-size: 14px;
            font-weight: 600;
        }

        /* Cards & Tables */
        .task-card {
            background: #ffffff;
            border: 1px solid #e8eaf0;
            border-radius: 14px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.04);
            margin-bottom: 30px;
            overflow: hidden;
        }

        .task-header {
            padding: 16px 22px;
            background: #2563eb;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .task-title {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: white;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table {
            margin-bottom: 0;
            text-align: center;
        }

        .table th {
            color: #4b5563;
            font-size: 13px;
            font-weight: 600;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            padding: 12px;
        }

        .table td {
            color: #374151;
            font-size: 13px;
            vertical-align: middle;
            padding: 12px;
        }

        /* Buttons & Badges */
        .btn-custom-warning {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #dbeafe;
            font-size: 13px;
            font-weight: 600;
            border-radius: 9px;
            padding: 8px 14px;
            text-decoration: none;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-custom-warning:hover {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .logout-btn {
            border: none;
            background: #fff1f2;
            color: #dc2626;
            padding: 8px 14px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background: #fee2e2;
            color: #b91c1c;
        }

        .empty-message {
            text-align: center;
            padding: 40px 10px;
            color: #9ca3af;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar main-navbar mb-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center gap-3">
                <div class="brand-icon">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <div>
                    <div class="dashboard-name">لوحة تحكم الأدمن</div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <!-- زر المدراء غير المفعلين -->
                <a href="{{ route('admin.managers.deactivated') }}" class="btn-custom-warning position-relative">
                    <i class="bi bi-person-exclamation"></i> المدراء غير المفعلين
                    @if($deactivatedCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                        {{ $deactivatedCount }}
                    </span>
                    @endif
                </a>

                <!-- أيقونة وقائمة الإشعارات -->
                @php
                $admin = auth()->user();
                $unreadCount = $admin ? $admin->unreadNotifications()->count() : 0;
                $latestNotifications = $admin ? $admin->notifications()->latest()->take(5)->get() : collect();
                @endphp

                <div class="dropdown">
                    <button class="btn btn-light position-relative rounded-circle p-0 d-flex align-items-center justify-content-center shadow-sm"
                        type="button"
                        id="adminNotificationsDropdown"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        style="width: 42px; height: 42px; background: #f8fafc; border: 1px solid #e2e8f0;">
                        <i class="bi bi-bell-fill text-primary fs-5"></i>
                        @if($unreadCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                        </span>
                        @endif
                    </button>

                    <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2 p-0" aria-labelledby="adminNotificationsDropdown" style="width: 330px; border-radius: 14px; overflow: hidden;">
                        <div class="d-flex align-items-center justify-content-between p-3 bg-light border-bottom">
                            <strong class="text-dark fs-6">
                                <i class="bi bi-bell ms-1 text-primary"></i> الإشعارات
                            </strong>
                            <span class="badge bg-primary rounded-pill">
                                {{ $unreadCount }} غير مقروء
                            </span>
                        </div>

                        <div style="max-height: 300px; overflow-y: auto;">
                            @forelse($latestNotifications as $notification)
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item p-3 border-bottom text-wrap {{ $notification->read_at === null ? 'bg-light' : '' }}">
                                <div class="d-flex align-items-start gap-2">
                                    <i class="bi bi-person-plus-fill text-primary fs-5 mt-1"></i>
                                    <div class="flex-grow-1">
                                        <div class="text-dark small fw-semibold">
                                            {{ $notification->data['message'] ?? 'لديك إشعار جديد' }}
                                        </div>
                                        <div class="text-muted mt-1" style="font-size: 11px;">
                                            <i class="bi bi-clock ms-1"></i> {{ $notification->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    @if($notification->read_at === null)
                                    <span class="rounded-circle bg-primary mt-2" style="width: 7px; height: 7px; flex-shrink: 0;"></span>
                                    @endif
                                </div>
                            </a>
                            @empty
                            <div class="text-center p-4 text-muted small">
                                <i class="bi bi-bell-slash fs-3 d-block mb-1"></i>
                                لا توجد إشعارات حتى الآن.
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- معلومات الأدمن -->
                <div class="admin-info">
                    <i class="bi bi-person-circle fs-5 text-primary"></i>
                    <span>مرحباً، <strong>{{ auth()->user()->name }}</strong></span>
                </div>

                <!-- زر الخروج -->
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="bi bi-box-arrow-right me-1"></i> خروج
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container py-3" style="max-width: 1300px;">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- الطلبات المعلقة -->
        <div class="task-card">
            <div class="task-header">
                <h5 class="task-title">
                    <i class="bi bi-clock-history"></i> طلبات تسجيل المدراء المعلقة
                </h5>
                <span class="badge bg-white text-primary px-3 py-2" style="font-size: 13px;">{{ $pendingManagers->count() }}</span>
            </div>
            <div class="card-body p-0">
                @if($pendingManagers->isEmpty())
                <div class="empty-message">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    لا توجد طلبات مدراء معلقة حالياً.
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>الاسم</th>
                                <th>اسم المستخدم</th>
                                <th>البريد الإلكتروني</th>
                                <th>اسم المدرسة</th>
                                <th>الهاتف</th>
                                <th style="width: 180px;">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingManagers as $index => $manager)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-bold">{{ $manager->name }}</td>
                                <td>{{ $manager->username }}</td>
                                <td>{{ $manager->email }}</td>
                                <td>{{ $manager->school?->name ?? $manager->school_name ?? '-' }}</td>
                                <td>{{ $manager->phone ?? '-' }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <form action="{{ route('admin.managers.approve', $manager->id) }}" method="POST" class="m-0">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm px-3" style="border-radius: 8px;">
                                                <i class="bi bi-check-lg"></i> موافقة
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.managers.reject', $manager->id) }}" method="POST" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2" style="border-radius: 8px;" onclick="return confirm('هل أنت متأكد من رفض هذا الطلب وحذفه؟')">
                                                <i class="bi bi-trash"></i> رفض
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>

        <!-- قائمة المدراء المفعلين -->
        <div class="task-card">
            <div class="task-header" style="background: #1e293b;">
                <h5 class="task-title">
                    <i class="bi bi-people-fill"></i> قائمة المدراء المفعلين
                </h5>
                <span class="badge bg-white text-dark px-3 py-2" style="font-size: 13px;">{{ $approvedManagerCount }}</span>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.dashboard') }}" method="GET" class="row g-2 align-items-end mb-3">
                    <div class="col-md-8">
                        <label for="managerSearch" class="form-label fw-bold small text-secondary">البحث باسم المدير</label>
                        <input type="search" id="managerSearch" name="manager_search" class="form-control"
                            value="{{ is_string($managerSearch) ? $managerSearch : '' }}" placeholder="اكتب اسم المدير">
                    </div>
                    <div class="col-md-auto d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search ms-1"></i> بحث
                        </button>
                        @if(is_string($managerSearch) && $managerSearch !== '')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">مسح</a>
                        @endif
                    </div>
                </form>

                @if($approvedManagerCount === 0)
                <div class="empty-message">
                    <i class="bi bi-people fs-1 d-block mb-2"></i>
                    لا يوجد مدراء مفعلون حالياً.
                </div>
                @elseif($approvedManagers->isEmpty())
                <div class="empty-message">
                    <i class="bi bi-search fs-1 d-block mb-2"></i>
                    لا يوجد مدير بهذا الاسم.
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>الاسم</th>
                                <th>اسم المستخدم</th>
                                <th>البريد الإلكتروني</th>
                                <th>اسم المدرسة</th>
                                <th>الحالة</th>
                                <th style="width: 150px;">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($approvedManagers as $index => $manager)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-bold">{{ $manager->name }}</td>
                                <td>{{ $manager->username }}</td>
                                <td>{{ $manager->email }}</td>
                                <td>{{ $manager->school?->name ?? $manager->school_name ?? '-' }}</td>
                                <td><span class="badge bg-success bg-opacity-10 text-success px-3 py-2">نشط</span></td>
                                <td>
                                    <form action="{{ route('admin.managers.deactivate', $manager->id) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-warning btn-sm px-3 text-dark fw-semibold" style="border-radius: 8px;" onclick="return confirm('هل أنت متأكد من إلغاء تفعيل هذا الحساب؟')">
                                            <i class="bi bi-slash-circle"></i> إلغاء التفعيل
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>