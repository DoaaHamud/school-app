@extends('layouts.app')

@section('content')


<main class="container my-4" style="max-width: 1100px;">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">المعلمون غير المفعلين</h1>
            <p class="text-muted mb-0">إدارة حسابات المعلمين غير المفعلة في {{ auth()->user()->school_name }}.</p>
        </div>
        <a href="{{ route('manager.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-right ms-1"></i> العودة للوحة المدير
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            @if($teachers->isEmpty())
            <div class="text-center text-muted py-5">
                <i class="bi bi-person-check fs-1 d-block mb-2"></i>
                لا يوجد معلمون غير مفعلين حالياً.
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>رقم الهاتف</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teachers as $teacher)
                        <tr>
                            <td class="fw-bold">{{ $teacher->name }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>{{ $teacher->phone }}</td>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary border rounded-pill px-3 py-2">
                                    غير مفعل
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('manager.teachers.reactivate', $teacher->id) }}"
                                    method="POST" class="d-inline"
                                    onsubmit="return confirm('هل تريدين إعادة تفعيل حساب هذا المعلم؟')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="bi bi-person-check ms-1"></i> إعادة التفعيل
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</main>

@endsection