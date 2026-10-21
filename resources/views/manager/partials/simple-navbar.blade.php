<nav class="navbar mb-4 shadow-sm" style="background-color: var(--primary-color);">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-3 m-0 text-white fw-bold"
            href="{{ route('manager.dashboard') }}">
            @if(auth()->user()->school_logo)
            <img src="{{ asset('storage/' . auth()->user()->school_logo) }}" alt="شعار المدرسة"
                class="rounded-3 bg-white p-1" style="width: 42px; height: 42px; object-fit: contain;">
            @endif
            <span>
                {{ auth()->user()->school_name ?? 'المدرسة' }}
                <small class="d-block fw-normal">لوحة تحكم المدير</small>
            </span>
        </a>
    </div>
</nav>
