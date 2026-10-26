<!-- resources/views/mother/navbar.blade.php -->
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <!-- حاوية الشعار / اسم الصفحة -->
        <div class="school-brand">
            @if(isset($child) && $child->school)
            <img class="school-logo"
                src="{{ $child->school->logo ? asset('storage/' . $child->school->logo) : asset('images/logo.jpeg') }}"
                alt="شعار {{ $child->school->name }}">
            <span class="school-brand-name">
                {{ $child->school->name }}
                <small class="school-brand-caption">تقارير الطالب</small>
            </span>
            @else
            <div class="brand-icon-box">
                <i class="bi bi-grid-1x2-fill" aria-hidden="true"></i>
            </div>
            <div class="brand-text">
                <span class="brand-title">لوحة الأم</span>
            </div>
            @endif
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#motherNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="motherNavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('mother.dashboard') ? 'active' : '' }}" href="{{ route('mother.dashboard') }}">
                        الرئيسية
                    </a>
                </li>
            </ul>

            <!-- قسم الإشعارات -->
            <div class="dropdown me-lg-3">
                <button class="btn position-relative d-flex align-items-center gap-2 text-secondary"
                    type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="الإشعارات">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="d-lg-none">الإشعارات</span>
                    @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                    <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">
                        {{ $unreadNotificationsCount }}
                    </span>
                    @endif
                </button>
                <ul class="dropdown-menu dropdown-menu-end mother-dropdown mother-notifications-menu">
                    <li class="dropdown-header fw-bold">الإشعارات</li>
                    @forelse($motherNotifications ?? [] as $notification)
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

            <!-- قائمة الحساب الشخصي للأم -->
            <div class="dropdown mother-account">
                <button class="mother-profile-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="mother-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="mother-info">
                        <span class="mother-label">{{ auth()->user()->name }}</span>
                        <span class="mother-role">ولي أمر (أم)</span>
                    </div>
                    <i class="bi bi-chevron-down text-muted" style="font-size: 11px; margin-right: 4px;"></i>
                </button>

                <ul class="dropdown-menu dropdown-menu-end mother-dropdown">
                    <li>
                        <div class="dropdown-header px-3 py-2">
                            <strong>{{ auth()->user()->name }}</strong>
                            <small class="text-muted d-block">{{ auth()->user()->email ?? '' }}</small>
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
            <form action="{{ route('logout') }}" method="POST" class="m-0 ms-lg-2">
                @csrf
                <button type="submit" class="logout-btn">
                    تسجيل الخروج
                </button>
            </form>
        </div>
    </div>
</nav>