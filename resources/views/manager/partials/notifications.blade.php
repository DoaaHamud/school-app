@php
    $managerNotifications = auth()->user()->notifications()->latest()->take(5)->get();
    $unreadNotificationsCount = auth()->user()->unreadNotifications()->count();
@endphp

<style>
    .manager-notification-btn {
        position: relative;
        display: inline-flex;
        width: 42px;
        height: 42px;
        align-items: center;
        justify-content: center;
        border: 0;
        background: transparent;
        color: #fff;
    }

    .manager-notification-btn:hover,
    .manager-notification-btn:focus {
        background: transparent;
        color: #fff;
        opacity: 0.8;
    }

    .manager-notifications-menu {
        width: min(360px, calc(100vw - 30px));
        max-height: 420px;
        overflow-y: auto;
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

    .manager-notification-item i {
        color: var(--primary-color) !important;
    }

    .manager-notification-item:hover,
    .manager-notification-item:focus {
        background-color: #f1f5f9 !important;
    }
</style>

<div class="dropdown">
    <button class="manager-notification-btn rounded-2" type="button"
        data-bs-toggle="dropdown" aria-expanded="false" aria-label="الإشعارات">
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
                        <span class="d-block fw-semibold">{{ $notification->data['teacher_name'] ?? 'إشعار جديد' }}</span>
                        <span class="notification-message d-block small">{{ $notification->data['message'] ?? 'لديك إشعار جديد.' }}</span>
                        <small>{{ $notification->created_at->diffForHumans() }}</small>
                    </span>
                </span>
            </a>
        </li>
        @empty
        <li class="px-3 py-2 small text-muted">لا توجد إشعارات حتى الآن.</li>
        @endforelse
    </ul>
</div>
