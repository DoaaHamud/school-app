<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm px-4 py-3 mb-4" style="border-radius: 12px;">
    <div class="container-fluid p-0">
        <!-- Bootstrap 5 RTL -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <!-- اليمين: عنوان اللوحة والروابط الرئيسية (الرئيسية + المهام والطلبات) -->
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-primary text-white p-2 rounded-3">
                    <i class="bi bi-speedometer2 fs-5"></i>
                </div>
                <h5 class="m-0 fw-bold">روضتي</h5>
            </div>

            <div class="vr mx-2 text-muted"></div>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.dashboard') }}" class="btn {{ request()->routeIs('admin.dashboard') ? 'btn-primary' : 'btn-outline-primary' }} fw-semibold px-3 py-2" style="border-radius: 9px;">
                    <i class="bi bi-house-door"></i> الرئيسية
                </a>

                <a href="{{ route('admin.tasks') }}" class="btn {{ request()->routeIs('admin.tasks') ? 'btn-primary' : 'btn-outline-primary' }} fw-semibold px-3 py-2" style="border-radius: 9px;">
                    <i class="bi bi-list-task"></i> المهام والطلبات
                </a>
            </div>
        </div>

        <!-- اليسار: الإشعارات، المدراء غير المفعلين، اسم الأدمن، وزر الخروج -->
        <div class="d-flex align-items-center gap-3">

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

            <!-- زر المدراء غير المفعلين (على اليسار تماماً كما طلبت) -->
            @if(Route::has('admin.deactivated.managers'))
            <a href="{{ route('admin.deactivated.managers') }}" class="btn btn-outline-warning text-dark fw-semibold d-flex align-items-center gap-2 px-3 py-2" style="border-radius: 9px;">
                <i class="bi bi-person-slash fs-5 text-warning"></i>
                <span>المدراء غير المفعلين</span>
                @if(isset($deactivatedCount) && $deactivatedCount > 0)
                <span class="badge bg-warning text-dark rounded-pill">{{ $deactivatedCount }}</span>
                @endif
            </a>
            @endif

            <div class="fw-semibold text-secondary d-none d-md-flex align-items-center gap-1 px-2">
                <i class="bi bi-person-circle text-primary"></i> {{ auth()->user()->name }}
            </div>

            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm px-3 py-2 fw-semibold" style="border-radius: 8px;">خروج</button>
            </form>

        </div>

    </div>
</nav>