{{-- resources/views/teacher/navbar.blade.php --}}

@php
    $teacher = auth()->user();
    $schoolBranding = $teacher?->school;
@endphp

<style>
    .navbar-custom {
        background-color: var(--primary-color);
        min-height: 70px;
        padding: 0 35px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .navbar-custom .nav-link {
        color: rgba(255, 255, 255, 0.85);
        font-size: 15px;
        font-weight: 500;
        padding: 24px 15px !important;
        transition: 0.2s;
    }

    .navbar-custom .nav-link:hover,
    .navbar-custom .nav-link.active {
        color: #ffffff;
        background-color: rgba(255, 255, 255, 0.16);
    }

    .teacher-profile-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        background: transparent;
        border: none;
        padding: 6px 12px;
        cursor: pointer;
        border-radius: 10px;
    }

    .teacher-profile-btn:hover {
        background-color: rgba(255, 255, 255, 0.16);
    }

    .teacher-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background-color: #ffffff;
        color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .teacher-dropdown {
        min-width: 230px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 8px;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.10);
    }

    .teacher-notifications-menu {
        width: min(340px, calc(100vw - 30px));
        padding: 8px;
    }

    .teacher-notification-item {
        white-space: normal;
        border-radius: 8px;
    }

    .teacher-notification-btn {
        position: relative;
        border: 0;
        background: transparent;
        color: #ffffff;
        padding: 8px 12px;
    }

    .teacher-notification-btn:hover {
        color: #ffffff;
        background-color: rgba(255, 255, 255, 0.16);
    }

    .teacher-dropdown .dropdown-header {
        background-color: var(--primary-color);
        border-radius: 0.375rem;
        color: #ffffff;
    }

    .teacher-dropdown .dropdown-header strong,
    .teacher-dropdown .dropdown-header small {
        color: #ffffff !important;
    }

    .teacher-dropdown .dropdown-item:not(.text-danger):hover,
    .teacher-dropdown .dropdown-item:not(.text-danger):focus,
    .teacher-dropdown .dropdown-item:not(.text-danger):active {
        background-color: var(--primary-color);
        color: #ffffff;
    }

    .teacher-dropdown .dropdown-item:not(.text-danger):hover i,
    .teacher-dropdown .dropdown-item:not(.text-danger):focus i,
    .teacher-dropdown .dropdown-item:not(.text-danger):active i {
        color: #ffffff !important;
    }

    .teacher-logout-btn {
        background-color: transparent;
        border: 1px solid #dc3545;
        color: #dc3545;
        border-radius: 7px;
        padding: 7px 15px;
        font-size: 14px;
        transition: 0.2s;
    }

    .teacher-logout-btn:hover {
        background-color: #dc3545;
        color: white;
    }

    @media (max-width: 991.98px) {
        .navbar-custom {
            padding: 10px 15px;
        }

        .navbar-custom .nav-link {
            padding: 12px 15px !important;
        }

        .teacher-profile-btn {
            padding: 8px;
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">

        {{-- شعار الروضة --}}
        <a href="{{ route('teacher.dashboard') }}"
            class="d-flex align-items-center gap-2 text-decoration-none flex-shrink-0">

            <div style="width:45px;height:45px;flex-shrink:0;border-radius:12px;overflow:hidden;background:#fff;display:flex;align-items:center;justify-content:center;">
                <img
                    src="{{ $schoolBranding?->logo ? asset('storage/' . $schoolBranding->logo) : asset('images/logo.jpeg') }}"
                    alt="شعار {{ $schoolBranding?->name ?? 'روضتي' }}"
                    style="width:100%;height:100%;object-fit:contain;">
            </div>

            <div class="d-flex flex-column text-end">
                <span style="font-size:18px;font-weight:800;color:#fff;line-height:1.2;">
                    {{ $schoolBranding?->name ?? 'روضتي' }}
                </span>
                <span style="font-size:12px;color:rgba(255,255,255,.85);margin-top:2px;font-weight:500;">
                    لوحة تحكم المعلم
                </span>
            </div>
        </a>

        <button
            class="navbar-toggler bg-white"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#teacherNavbar"
            aria-controls="teacherNavbar"
            aria-expanded="false"
            aria-label="فتح القائمة">

            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="teacherNavbar">

            {{-- روابط المعلم --}}
            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}"
                        href="{{ route('teacher.dashboard') }}">
                        الرئيسية
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('teacher.students.create') ? 'active' : '' }}"
                        href="{{ route('teacher.students.create') }}">
                        إضافة طالب جديد
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('teacher.classes') ? 'active' : '' }}"
                        href="{{ route('teacher.classes') }}">
                        الصفوف المتاحة
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('teacher.daily_variables') ? 'active' : '' }}"
                        href="{{ route('teacher.daily_variables') }}">
                        المتغيرات اليومية
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('teacher.mother_notes*') ? 'active' : '' }}"
                        href="{{ route('teacher.mother_notes') }}">
                        ملاحظات أولياء الأمور
                    </a>
                </li>

            </ul>

            {{-- الإشعارات --}}
            @include('teacher.partials.notifications')

            {{-- حساب المعلم --}}
            <div class="dropdown me-lg-3 my-2 my-lg-0">

                <button
                    class="teacher-profile-btn"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">

                    <div class="teacher-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>

                    <div class="text-end">
                        <div class="fw-bold text-white fs-6">
                            {{ $teacher->name }}
                        </div>

                        <small class="d-block" style="font-size:11px;color:rgba(255,255,255,.85);">
                            معلم
                        </small>
                    </div>

                    <i class="bi bi-chevron-down ms-1" style="font-size:12px;color:#fff;"></i>
                </button>

                <ul class="dropdown-menu dropdown-menu-end teacher-dropdown manager-account-menu">

                    <li>
                        <div class="dropdown-header px-3 py-2">
                            <div class="fw-bold fs-6">
                                {{ $teacher->name }}
                            </div>
                            <small>{{ $teacher->email }}</small>
                        </div>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item py-2" href="{{ route('teacher.profile') }}">
                            <i class="bi bi-person-circle me-2"></i>
                            الملف الشخصي
                        </a>
                    </li>

                </ul>
            </div>

            {{-- تسجيل الخروج --}}
            <form action="{{ route('logout') }}" method="POST" class="my-2 my-lg-0">
                @csrf

                <button type="submit" class="teacher-logout-btn">
                    <i class="bi bi-box-arrow-right me-1"></i>
                    تسجيل الخروج
                </button>
            </form>

        </div>
    </div>
</nav>
