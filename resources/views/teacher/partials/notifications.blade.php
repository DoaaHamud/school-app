@php
    $teacherNotifications = auth()->user()->notifications()->latest()->take(5)->get();
    $unreadNotificationsCount = auth()->user()->unreadNotifications()->count();
@endphp

<style>
    .teacher-notification-btn {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        color: #fff;
        background: transparent;
        border: 0;
    }

    .teacher-notification-btn:hover,
    .teacher-notification-btn:focus {
        color: #fff;
        background: transparent;
        opacity: 0.8;
    }

    .teacher-notifications-menu {
        width: min(360px, calc(100vw - 30px));
        max-height: 420px;
        overflow-y: auto;
    }

    .teacher-notification-item {
        white-space: normal;
        border-radius: 8px;
    }

    .teacher-notification-item .teacher-notification-icon {
        color: var(--primary-color) !important;
    }

    .teacher-notification-item,
    .teacher-notification-item span,
    .teacher-notification-item small {
        color: #334155 !important;
    }

    .teacher-notification-item .notification-message {
        color: #64748b !important;
    }
</style>

<div class="dropdown me-lg-3">
    <button class="teacher-notification-btn rounded-2" type="button"
        data-bs-toggle="dropdown" aria-expanded="false" aria-label="الإشعارات">
        <i class="bi bi-bell fs-5"></i>
        @if($unreadNotificationsCount > 0)
        <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">
            {{ $unreadNotificationsCount }}
        </span>
        @endif
    </button>
    <ul class="dropdown-menu dropdown-menu-end teacher-dropdown teacher-notifications-menu">
        <li class="dropdown-header fw-bold">الإشعارات</li>
        @forelse($teacherNotifications as $notification)
        <li>
            <a class="dropdown-item teacher-notification-item py-2 {{ $notification->read_at ? '' : 'bg-light' }}"
                href="{{ route('teacher.notifications.open', $notification->id) }}">
                <span class="d-flex align-items-start gap-2">
                    <i class="bi teacher-notification-icon {{ ($notification->data['type'] ?? '') === 'mother_child_note' ? 'bi-chat-left-text-fill' : 'bi-person-plus-fill' }} mt-1"></i>
                    <span>
                        <span class="d-block">{{ $notification->data['message'] ?? 'تم إسناد طلاب جدد إليكِ.' }}</span>
                        @if(($notification->data['type'] ?? '') === 'mother_child_note')
                        <span class="d-block small mt-1 text-wrap">{{ $notification->data['note'] ?? '' }}</span>
                        @endif
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
