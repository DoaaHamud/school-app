@extends('layouts.app')

@section('content')

<style>
    .main-navbar-custom {
        background-color: var(--primary-color) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        min-height: 75px;
    }

    .main-navbar-custom .brand-name,
    .main-navbar-custom .dashboard-subtitle,
    .main-navbar-custom .nav-link,
    .main-navbar-custom i,
    .main-navbar-custom span {
        color: #ffffff !important;
    }

    .main-navbar-custom .nav-link {
        opacity: 0.88;
        padding: 8px 16px !important;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .main-navbar-custom .nav-link:hover,
    .main-navbar-custom .nav-link.active {
        opacity: 1 !important;
        background: rgba(255, 255, 255, 0.2) !important;
        font-weight: bold;
    }

    .manager-notifications-menu {
        width: min(340px, calc(100vw - 30px));
        padding: 8px;
    }

    .manager-notification-item {
        white-space: normal;
        border-radius: 8px;
    }

    .manager-notification-item,
    .manager-notification-item span,
    .manager-notification-item small {
        color: #334155 !important;
    }

    .manager-notification-item .notification-message {
        color: #64748b !important;
    }

</style>

<!-- Navbar المدير الملون بلون التطبيق المختار -->
<nav class="navbar navbar-expand-lg main-navbar-custom mb-4" style="background-color: var(--primary-color) !important;">
    <div class="container">

        <!-- الشعار واسم الروضة -->
        <!-- <a class="navbar-brand d-flex align-items-center gap-3 m-0" href="{{ route('manager.dashboard') }}"> -->
            <div style="width: 46px; height: 46px; flex-shrink: 0; border-radius: 12px; overflow: hidden; background: #ffffff; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                @if(auth()->user()->school_logo)
                <img src="{{ asset('storage/' . auth()->user()->school_logo) }}" alt="شعار المدرسة" style="width: 100%; height: 100%; object-fit: contain;">
                @else
                <img src="{{ asset('images/logo.jpeg') }}" alt="شعار روضتي" style="width: 100%; height: 100%; object-fit: contain;">
                @endif
            </div>

            <div class="d-flex flex-column text-end">
                <span class="brand-name" style="font-size: 18px; font-weight: 800;">{{ auth()->user()->school_name ?? 'روضتي' }}</span>
                <span class="dashboard-subtitle" style="font-size: 12px; opacity: 0.85;">لوحة تحكم المدير</span>
            </div>
        </a>

        <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#managerNavbar">
            <i class="bi bi-list fs-2 text-white"></i>
        </button>

        <!-- روابط القائمة -->
        <div class="collapse navbar-collapse" id="managerNavbar">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}" href="{{ route('manager.dashboard') }}">
                        <i class="bi bi-check2-square ms-1"></i> المهام
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('manager.teachers.*') ? 'active' : '' }}" href="{{ route('manager.teachers.index') }}">
                        <i class="bi bi-people-fill ms-1"></i> دليل الأساتذة
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('manager.students') ? 'active' : '' }}" href="{{ route('manager.students') }}">
                        <i class="bi bi-mortarboard-fill ms-1"></i> دليل الطلاب
                    </a>
                </li>
            </ul>

            <!-- حساب المدير وزر الخروج -->
            <div class="d-flex align-items-center gap-3 flex-wrap">

                <div class="dropdown">
                    <button class="btn position-relative d-flex align-items-center gap-2 text-white"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="الإشعارات">
                        <i class="bi bi-bell fs-5"></i>
                        @if($unreadNotificationsCount > 0)
                        <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">
                            {{ $unreadNotificationsCount }}
                        </span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end manager-notifications-menu">
                        <li class="dropdown-header fw-bold">الإشعارات</li>
                        @forelse($managerNotifications as $notification)
                        <li>
                            <a class="dropdown-item manager-notification-item py-2 {{ $notification->read_at ? '' : 'bg-light' }}"
                                href="{{ route('manager.notifications.open', $notification->id) }}">
                                <span class="d-flex align-items-start gap-2">
                                    <i class="bi bi-person-plus-fill text-primary mt-1"></i>
                                    <span>
                                        <span class="d-block fw-semibold">{{ $notification->data['teacher_name'] ?? 'معلم جديد' }}</span>
                                        <span class="notification-message d-block small">{{ $notification->data['message'] ?? 'يوجد طلب انضمام معلم جديد بانتظار المراجعة.' }}</span>
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

                <div class="dropdown">
                    <button class="btn d-flex align-items-center gap-2 border-0 dropdown-toggle py-1 px-2 rounded-3 text-white" style="background: rgba(255,255,255,0.2);" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-white" style="width: 36px; height: 36px;">
                            <i class="bi bi-person-fill fs-6" style="color: var(--primary-color) !important;"></i>
                        </div>
                        <div class="d-flex flex-column text-end">
                            <span class="fw-bold text-white" style="font-size: 13px;">{{ auth()->user()->name }}</span>
                            <span style="font-size: 11px; color: rgba(255,255,255,0.85);">إدارة الروضة</span>
                        </div>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2 manager-account-menu" style="min-width: 220px; border-radius: 12px;">
                        <li>
                            <div class="dropdown-header px-2 py-2 rounded-2 mb-1" style="background-color: var(--primary-color); color: #ffffff;">
                                <strong class="text-white">{{ auth()->user()->name }}</strong><br>
                                <small class="text-white" style="font-size: 11px; opacity: 0.85;">{{ auth()->user()->email }}</small>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider my-2">
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2" href="{{ route('manager.profile') }}">
                                <i class="bi bi-person-circle ms-1"></i> الملف الشخصي
                            </a>
                        </li>
                    </ul>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm px-3 py-2 text-white" style="background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.4); border-radius: 9px; font-weight: 600; font-size: 13px;">
                        <i class="bi bi-box-arrow-right"></i> خروج
                    </button>
                </form>

            </div>

        </div>
    </div>
</nav>

<!-- محتوى الداشبورد -->
<div class="container my-4" style="max-width: 1200px;">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill ms-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color: #1f2937;">المهام</h1>
            <p class="text-muted small mb-0">طلبات تسجيل المعلمين المعلقة وإدارة تعيينات الصفوف</p>
        </div>
        <a href="{{ route('manager.teacher-assignments') }}" class="btn text-white fw-bold"
            style="background-color: var(--primary-color); border-color: var(--primary-color);">
            <i class="bi bi-person-badge-fill ms-1"></i> تعيين المعلمين للصفوف
        </a>
    </div>

    <!-- طلبات تسجيل المعلمين المعلقة -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
        <div class="card-header bg-white py-3 border-bottom-0">
            <h5 class="card-title m-0 fw-bold" style="color: var(--primary-color);"><i class="bi bi-person-plus-fill ms-2"></i>طلبات تسجيل المعلمين المعلقة</h5>
        </div>
        <div class="card-body">
            @if($pendingTeachers->isEmpty())
            <div class="text-center py-4 text-muted">
                <i class="bi bi-check-circle fs-2 text-success d-block mb-2"></i>
                لا توجد طلبات معلقة حالياً.
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>رقم الهاتف</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingTeachers as $teacher)
                        <tr>
                            <td class="fw-bold">{{ $teacher->name }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>{{ $teacher->phone }}</td>
                            <td>
                                <form action="{{ route('manager.teachers.approve', $teacher->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm ms-1">
                                        <i class="bi bi-check-lg"></i> موافقة
                                    </button>
                                </form>

                                <form action="{{ route('manager.teachers.reject', $teacher->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('هل أنت متأكد من رفض طلب المعلم؟')">
                                        <i class="bi bi-x-lg"></i> رفض
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

<!-- Modal تحذير حذف الحساب -->
<div class="modal fade" id="deleteManagerModal" tabindex="-1" aria-labelledby="deleteManagerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fs-6" id="deleteManagerModalLabel">
                    <i class="bi bi-exclamation-triangle-fill ms-1"></i> تحذير: حذف الحساب
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="bi bi-trash-fill text-danger display-4 mb-3 d-block"></i>
                <h6 class="fw-bold text-dark mb-2">هل أنت متأكد تماماً من رغبتك في حذف الحساب؟</h6>
                <p class="text-muted small mb-0">سيؤدي هذا الإجراء إلى حذف حسابك كمدير بشكل نهائي.</p>
            </div>
            <div class="modal-footer bg-light justify-content-center border-0">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">إلغاء</button>
                <form action="{{ route('manager.profile.delete') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4">نعم، احذف الحساب</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection