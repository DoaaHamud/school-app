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
        background: rgba(255,255,255,0.2) !important;
        font-weight: bold;
    }
</style>

<nav class="navbar navbar-expand-lg main-navbar-custom mb-4"
     style="background-color: var(--primary-color) !important;">

    <div class="container">

        <a class="navbar-brand d-flex align-items-center gap-3 m-0"
           href="{{ route('manager.dashboard') }}">

            <div style="width:46px;height:46px;flex-shrink:0;border-radius:12px;
                        overflow:hidden;background:#ffffff;display:flex;
                        align-items:center;justify-content:center;
                        box-shadow:0 2px 8px rgba(0,0,0,0.15);">

                @if(auth()->user()->school_logo)
                    <img src="{{ asset('storage/' . auth()->user()->school_logo) }}"
                         alt="شعار المدرسة"
                         style="width:100%;height:100%;object-fit:contain;">
                @else
                    <img src="{{ asset('images/logo.jpeg') }}"
                         alt="شعار المدرسة"
                         style="width:100%;height:100%;object-fit:contain;">
                @endif

            </div>

            <div class="d-flex flex-column text-end">
                <span class="brand-name" style="font-size:18px;font-weight:800;">
                    {{ auth()->user()->school_name ?? 'روضتي' }}
                </span>

                <span class="dashboard-subtitle"
                      style="font-size:12px;opacity:0.85;">
                    لوحة تحكم المدير
                </span>
            </div>

        </a>

        <button class="navbar-toggler border-0 text-white"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#managerNavbar">

            <i class="bi bi-list fs-2 text-white"></i>

        </button>

        <div class="collapse navbar-collapse" id="managerNavbar">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}"
                       href="{{ route('manager.dashboard') }}">

                        <i class="bi bi-check2-square ms-1"></i>
                        المهام

                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('manager.teachers.*') ? 'active' : '' }}"
                       href="{{ route('manager.teachers.index') }}">

                        <i class="bi bi-people-fill ms-1"></i>
                        دليل الأساتذة

                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('manager.students') ? 'active' : '' }}"
                       href="{{ route('manager.students') }}">

                        <i class="bi bi-mortarboard-fill ms-1"></i>
                        دليل الطلاب

                    </a>
                </li>

            </ul>

            <div class="d-flex align-items-center gap-3 flex-wrap">

                @include('manager.partials.notifications')

                <div class="dropdown">

                    <button
                        class="btn d-flex align-items-center gap-2 border-0 dropdown-toggle py-1 px-2 rounded-3 text-white"
                        style="background: rgba(255,255,255,0.2);"
                        type="button"
                        data-bs-toggle="dropdown">

                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-white"
                             style="width:36px;height:36px;">

                            <i class="bi bi-person-fill fs-6"
                               style="color: var(--primary-color) !important;"></i>

                        </div>

                        <div class="d-flex flex-column text-end">
                            <span class="fw-bold text-white"
                                  style="font-size:13px;">
                                {{ auth()->user()->name }}
                            </span>

                            <span style="font-size:11px;color:rgba(255,255,255,0.85);">
                                إدارة الروضة
                            </span>
                        </div>

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2 manager-account-menu"
                        style="min-width:220px;border-radius:12px;">

                        <li>
                            <div class="dropdown-header px-2 py-2 rounded-2 mb-1">
                                <strong>{{ auth()->user()->name }}</strong>
                                <br>
                                <small style="font-size:11px;opacity:0.85;">
                                    {{ auth()->user()->email }}
                                </small>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider my-2">
                        </li>

                        <li>
                            <a class="dropdown-item rounded-2 py-2"
                               href="{{ route('manager.profile') }}">

                                <i class="bi bi-person-circle ms-1"></i>
                                الملف الشخصي

                            </a>
                        </li>

                    </ul>

                </div>

                <form action="{{ route('logout') }}"
                      method="POST"
                      class="m-0">

                    @csrf

                    <button type="submit"
                            class="btn btn-sm px-3 py-2 text-white"
                            style="
                                background: rgba(255,255,255,0.2);
                                border: 1px solid rgba(255,255,255,0.4);
                                border-radius: 9px;
                                font-weight: 600;
                                font-size: 13px;">

                        <i class="bi bi-box-arrow-right"></i>
                        خروج

                    </button>

                </form>

            </div>

        </div>

    </div>

</nav>