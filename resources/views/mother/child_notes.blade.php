<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملاحظاتي - {{ $child->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background: #f5f7fb; color: #273142; font-family: "Segoe UI", Tahoma, Arial, sans-serif; }
        .main-container { max-width: 1000px; margin: auto; padding: 35px 20px; }
        .note-card { background: #fff; border: 1px solid #e5eaf0; border-radius: 14px; padding: 22px; margin-bottom: 16px; }
        .note-text { white-space: pre-wrap; line-height: 1.8; }
    </style>
</head>

<body>
    <main class="main-container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h1 class="h4 fw-bold mb-1">ملاحظاتي وردود المعلمات</h1>
                <p class="text-muted mb-0">الطفل: {{ $child->name }}</p>
            </div>
            <a href="{{ route('mother.child_details', $child->id) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-right ms-1"></i> العودة إلى تفاصيل الطفل
            </a>
        </div>

        @forelse($childNotes as $childNote)
        <article class="note-card">
            <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-3">
                <div>
                    <span class="fw-bold">إلى المعلمة: {{ $childNote->teacher->name }}</span>
                    <div class="small text-muted">{{ $childNote->created_at->format('Y-m-d H:i') }}</div>
                </div>
                @if($childNote->replied_at)
                <span class="badge text-bg-success">تم الرد</span>
                @else
                <span class="badge text-bg-secondary">بانتظار الرد</span>
                @endif
            </div>
            <div class="note-text border rounded p-3 bg-light">{{ $childNote->note }}</div>
            @if($childNote->reply)
            <div class="mt-3">
                <div class="fw-bold text-primary mb-2">
                    <i class="bi bi-reply-fill ms-1"></i>
                    رد المعلمة {{ $childNote->teacher->name }}
                    <span class="small text-muted fw-normal">— {{ $childNote->replied_at->format('Y-m-d H:i') }}</span>
                </div>
                <div class="note-text border rounded p-3 bg-primary-subtle">{{ $childNote->reply }}</div>
            </div>
            @endif
        </article>
        @empty
        <div class="text-center bg-white border rounded-3 p-5 text-muted">
            <i class="bi bi-chat-square-text fs-1 d-block mb-3"></i>
            لم ترسلي أي ملاحظات لهذا الطفل حتى الآن.
        </div>
        @endforelse
    </main>
</body>

</html>
