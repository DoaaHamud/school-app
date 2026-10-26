@extends('layouts.app')

@section('content')
<style>
    .mother-notes-navbar {
        min-height: 70px;
        padding: 0 35px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        background-color: var(--primary-color);
    }

    .mother-notes-navbar .nav-link {
        padding: 24px 15px !important;
        color: rgba(255, 255, 255, 0.85);
        font-size: 15px;
        font-weight: 500;
        transition: 0.2s;
    }

    .mother-notes-navbar .nav-link:hover,
    .mother-notes-navbar .nav-link.active {
        background-color: rgba(255, 255, 255, 0.16);
        color: #fff;
    }

    .mother-notes-navbar .teacher-profile-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 12px;
        border: 0;
        border-radius: 10px;
        background: transparent;
        cursor: pointer;
    }

    .mother-notes-navbar .teacher-profile-btn:hover {
        background-color: rgba(255, 255, 255, 0.16);
    }

    .mother-notes-navbar .teacher-avatar {
        display: flex;
        width: 38px;
        height: 38px;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: #fff;
        color: var(--primary-color);
        font-size: 18px;
    }

    .mother-notes-navbar .teacher-dropdown {
        min-width: 230px;
        padding: 8px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.1);
    }

    .mother-notes-navbar .teacher-dropdown .dropdown-header {
        border-radius: 0.375rem;
        background-color: var(--primary-color);
        color: #fff;
    }

    .mother-notes-navbar .teacher-dropdown .dropdown-header strong,
    .mother-notes-navbar .teacher-dropdown .dropdown-header small {
        color: #fff !important;
    }

    .mother-notes-navbar .teacher-dropdown .dropdown-item:hover,
    .mother-notes-navbar .teacher-dropdown .dropdown-item:focus {
        background-color: var(--primary-color);
        color: #fff;
    }

    .mother-notes-navbar .teacher-dropdown .dropdown-item:hover i,
    .mother-notes-navbar .teacher-dropdown .dropdown-item:focus i {
        color: #fff !important;
    }

    .mother-notes-navbar .logout-btn {
        padding: 7px 15px;
        border: 1px solid #dc3545;
        border-radius: 7px;
        background: transparent;
        color: #dc3545;
        font-size: 14px;
        transition: 0.2s;
    }

    .mother-notes-navbar .logout-btn:hover {
        background-color: #dc3545;
        color: #fff;
    }

    @media (max-width: 991.98px) {
        .mother-notes-navbar {
            padding: 0 12px;
        }

        .mother-notes-navbar .nav-link {
            padding: 12px !important;
        }
    }

    .mother-notes-page .notes-title i,
    .mother-notes-page .reply-label {
        color: var(--primary-color);
    }

    .mother-notes-page .mother-note-card {
        border-top: 4px solid var(--primary-color) !important;
    }

    .mother-notes-page .note-content,
    .mother-notes-page .reply-content {
        background-color: color-mix(in srgb, var(--primary-color) 7%, white);
        border-color: color-mix(in srgb, var(--primary-color) 20%, white) !important;
    }

    .mother-notes-page .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .mother-notes-page .btn-primary:hover {
        filter: brightness(0.9);
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .mother-notes-page .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem color-mix(in srgb, var(--primary-color) 20%, transparent);
    }

    .mother-notes-page .notes-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
    }

    .mother-notes-page .mother-note-card {
        margin-bottom: 0;
    }

    @media (max-width: 767.98px) {
        .mother-notes-page .notes-grid {
            grid-template-columns: 1fr;
        }
    }
</style>



<div class="container py-4 mother-notes-page" dir="rtl">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h4 fw-bold mb-1 notes-title"><i class="bi bi-chat-left-text ms-1"></i>ملاحظات أولياء الأمور</h1>
            <p class="text-muted mb-0">يمكنك الاطلاع على الملاحظات والرد على وليّة الأمر.</p>
        </div>
        <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-right ms-1"></i> العودة إلى لوحة المعلمة
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="notes-grid">
        @forelse($childNotes as $childNote)
        <article class="card border-0 shadow-sm mother-note-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                    <div>
                        <h2 class="h6 fw-bold mb-1">{{ $childNote->child->name }} — {{ $childNote->child->class ?? 'غير محدد' }}</h2>
                        <div class="small text-muted">من وليّة الأمر: {{ $childNote->mother->name }} · {{ $childNote->created_at->format('Y-m-d H:i') }}</div>
                    </div>
                    @if($childNote->replied_at)
                    <span class="badge text-bg-success">تم الرد</span>
                    @else
                    <span class="badge text-bg-warning">بانتظار ردك</span>
                    @endif
                </div>
                <div class="border rounded p-3 note-content mb-3" style="white-space: pre-wrap;">{{ $childNote->note }}</div>

                @if($childNote->reply)
                <div class="border rounded p-3 reply-content mb-3">
                    <strong class="reply-label">ردك السابق:</strong>
                    <div class="mt-2" style="white-space: pre-wrap;">{{ $childNote->reply }}</div>
                </div>
                @endif

                <form action="{{ route('teacher.mother_notes.reply', $childNote->id) }}" method="POST">
                    @csrf
                    <label for="reply{{ $childNote->id }}" class="form-label fw-semibold">
                        {{ $childNote->reply ? 'تعديل الرد' : 'اكتبي ردًا لوليّة الأمر' }}
                    </label>
                    <textarea id="reply{{ $childNote->id }}" name="reply" class="form-control mb-2" rows="3" maxlength="2000" required>{{ old('reply_note_id') == $childNote->id ? old('reply') : '' }}</textarea>
                    <input type="hidden" name="reply_note_id" value="{{ $childNote->id }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send ms-1"></i> إرسال الرد
                    </button>
                </form>
            </div>
        </article>
        @empty
        <div class="text-center bg-white rounded-3 shadow-sm p-5 text-muted">
            <i class="bi bi-chat-square-text fs-1 d-block mb-3"></i>
            لا توجد ملاحظات من أولياء الأمور حتى الآن.
        </div>
        @endforelse
    </div>
</div>
@endsection