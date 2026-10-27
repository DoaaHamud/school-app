@extends('layouts.app')

@section('content')
<div class="container my-4" style="max-width: 1200px;">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h1 class="h4 fw-bold m-0">
            <i class="bi bi-chat-left-dots ms-1" style="color: var(--primary-color);"></i>
            ملاحظات الأهالي — صف {{ $className }}
        </h1>

        <a href="{{ route('manager.students') }}"
            class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-right ms-1"></i>
            العودة إلى دليل الطلاب
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>اسم الطالب</th>
                        <th>ولي الأمر</th>
                        <th>ملاحظة ولي الأمر</th>
                        <th>رد المعلمة</th>
                        <th>تاريخ الملاحظة</th>
                        <th>تاريخ الرد</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($childNotes as $index => $item) <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $item->student_name }}</td>
                        <td>{{ $item->mother_name ?? 'غير متوفر' }}</td>
                        <td class="text-start" style="min-width: 220px;">
                            {{ $item->note }}
                        </td>
                        <td class="text-start" style="min-width: 220px;">
                            @if($item->reply)
                            <div>{{ $item->reply }}</div>
                            <small class="text-muted">
                                {{ $item->teacher_name ?? 'المعلمة' }}
                            </small>
                            @else
                            <span class="text-muted">لم يتم الرد بعد</span>
                            @endif
                        </td>
                        <td>
                            {{ $item->created_at
                                    ? \Carbon\Carbon::parse($item->created_at)->format('Y-m-d H:i')
                                    : '-' }}
                        </td>
                        <td>
                            {{ $item->replied_at
                                    ? \Carbon\Carbon::parse($item->replied_at)->format('Y-m-d H:i')
                                    : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-5 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                            لا توجد ملاحظات من الأهالي لهذا الصف.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection