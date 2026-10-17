@extends('layouts.app')

@section('content')
<nav class="navbar navbar-expand-lg mb-4 shadow-sm" style="background-color: var(--primary-color);">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="{{ route('manager.dashboard') }}">
            {{ auth()->user()->school_name ?? 'المدرسة' }}
            <span class="d-block small fw-normal">لوحة تحكم المدير</span>
        </a>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('manager.profile') }}" class="btn btn-sm text-white border border-light">الملف الشخصي</a>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-light">تسجيل الخروج</button>
            </form>
        </div>
    </div>
</nav>

<div class="container page-container my-4" style="max-width: 1100px;">
    @if(session('success'))
    <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">الطلاب غير المفعلين</h1>
            <p class="text-muted mb-0">يمكنك إعادة تفعيل الطالب في أي وقت، وستبقى بياناته وتقاريره محفوظة.</p>
        </div>
        <a href="{{ route('manager.students') }}" class="btn btn-outline-secondary">
            <i class="bi bi-people ms-1"></i> دليل الطلاب
        </a>
    </div>

    <form method="GET" action="{{ route('manager.students.deactivated') }}" class="mb-4">
        <div class="input-group">
            <input type="search" name="search" class="form-control" value="{{ $search ?? '' }}" placeholder="ابحث باسم الطالب">
            <button type="submit" class="btn text-white" style="background-color: var(--primary-color);">
                <i class="bi bi-search ms-1"></i> بحث
            </button>
        </div>
    </form>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center mb-0">
                <thead class="table-light">
                    <tr>
                        <th>اسم الطالب</th>
                        <th>الصف</th>
                        <th>تاريخ إلغاء التفعيل</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    <tr>
                        <td class="fw-bold">{{ $student->name }}</td>
                        <td>{{ $student->class }}</td>
                        <td>{{ $student->deleted_at->format('Y-m-d') }}</td>
                        <td>
                            <form action="{{ route('manager.students.reactivate', $student->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="bi bi-person-check ms-1"></i> إعادة التفعيل
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-muted py-5">لا يوجد طلاب غير مفعلين.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
