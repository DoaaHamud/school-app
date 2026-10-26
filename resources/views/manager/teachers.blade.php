@extends('layouts.app')

@section('content')

<style>
    /* تتبع الهوية البصرية المعرفة في layouts.app */
    .main-navbar {
        background-color: var(--primary-color) !important;
        min-height: 76px;
    }

    .main-navbar .brand-name,
    .main-navbar .dashboard-subtitle,
    .main-navbar .nav-link,
    .main-navbar .nav-link i,
    .main-navbar .navbar-brand,
    .main-navbar .navbar-brand span {
        color: #ffffff !important;
    }

    .main-navbar .brand-name {
        font-size: 18px;
        font-weight: 800;
    }

    .main-navbar .dashboard-subtitle {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.85) !important;
    }

    .main-navbar .nav-link {
        opacity: 0.85;
        border-radius: 8px;
        transition: background-color 0.2s ease, opacity 0.2s ease;
    }

    .main-navbar .nav-link:hover,
    .main-navbar .nav-link.active {
        opacity: 1;
        background-color: rgba(255, 255, 255, 0.2);
    }

    .main-navbar .account-toggle {
        background-color: rgba(255, 255, 255, 0.16) !important;
        color: #ffffff !important;
    }

    .main-navbar .account-toggle .account-name,
    .main-navbar .account-toggle .account-subtitle {
        color: #ffffff !important;
    }

    .main-navbar .navbar-toggler {
        border: 0;
        box-shadow: none;
    }

    .primary-soft-badge {
        background-color: color-mix(in srgb, var(--primary-color) 12%, white);
        color: var(--primary-color);
    }

    .btn-deactivate {
        background-color: color-mix(in srgb, var(--primary-color) 16%, white);
        border-color: color-mix(in srgb, var(--primary-color) 35%, white);
        color: var(--primary-color);
    }

    .btn-deactivate:hover,
    .btn-deactivate:focus {
        background-color: color-mix(in srgb, var(--primary-color) 26%, white);
        border-color: color-mix(in srgb, var(--primary-color) 45%, white);
        color: var(--primary-color);
    }

    .page-heading {
        color: #1f2937;
    }
</style>



<!-- Main Content -->

<div class="container my-4" style="max-width: 1200px;">

    @if(session('success'))

    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">

        <i class="bi bi-check-circle-fill ms-1"></i> {{ session('success') }}

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

    </div>

    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color: #1f2937;">دليل الأساتذة</h1>
            <p class="text-muted small mb-0">عرض المعلمين المقبولين والطلاب والصفوف المسندة إليها</p>
        </div>
        <a href="{{ route('manager.teachers.deactivated') }}" class="btn btn-outline-secondary">
            <i class="bi bi-person-x ms-1"></i>
            المعلمون غير المفعلين
            <span class="badge bg-secondary ms-1">{{ $deactivatedTeachersCount }}</span>
        </a>
    </div>

    <!-- Filter & Search Card -->

    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">

        <form method="GET" action="{{ route('manager.teachers.index') }}" class="row g-3 align-items-end">

            <div class="col-md-5">

                <label class="form-label fw-bold small text-secondary">البحث عن أستاذ</label>

                <div class="input-group">

                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>

                    <input type="text" name="search" class="form-control border-start-0" placeholder="ادخل اسم الأستاذ..." value="{{ $search ?? '' }}">

                </div>

            </div>

            <div class="col-md-4">

                <label class="form-label fw-bold small text-secondary">العام الدراسي</label>

                <select name="year" class="form-select">

                    @for($i = date('Y') - 5; $i <= date('Y') + 1; $i++)

                        <option value="{{ $i }}" {{ (int) ($year ?? date('Y')) === $i ? 'selected' : '' }}>

                        العام الدراسي {{ $i }}

                        </option>

                        @endfor

                </select>

            </div>

            <div class="col-md-3">

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" style="background-color: var(--primary-color) !important; border-color: var(--primary-color) !important;">

                    <i class="bi bi-filter ms-1"></i> تصفية وبحث

                </button>

            </div>

        </form>

    </div>

    <!-- Teachers List -->

    @forelse($teachers as $teacher)

    <div class="card border-0 shadow-sm rounded-4 mb-3 overflow-hidden bg-white">

        <div class="card-body p-4">

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 pb-3 border-bottom">

                <div class="d-flex align-items-center gap-3">

                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px; background-color: var(--primary-color) !important; font-size: 20px;">

                        <i class="bi bi-person-fill"></i>

                    </div>

                    <div>

                        <h5 class="fw-bold mb-1 text-dark">{{ $teacher->name }}</h5>

                        <span class="text-muted small">{{ $teacher->email }}</span>

                    </div>

                </div>

                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-semibold">

                    <i class="bi bi-check-circle-fill ms-1"></i> مقبول

                </span>

            </div>

            <div class="row mt-3 align-items-center">

                <div class="col-md-4">

                    <span class="d-block text-muted small mb-1">رقم الهاتف</span>

                    <span class="fw-bold text-secondary">{{ $teacher->phone ?? 'غير متوفر' }}</span>

                </div>

                <div class="col-md-4">

                    <span class="d-block text-muted small mb-1">عدد الطلاب</span>

                    <span class="badge primary-soft-badge px-3 py-2 rounded-pill fw-bold">

                        <i class="bi bi-people-fill ms-1"></i> {{ $teacher->childrenAsTeacher->count() }} طالب

                    </span>

                </div>

                <div class="col-md-4">

                    <span class="d-block text-muted small mb-1">الصفوف المسندة</span>

                    @forelse($teacher->assigned_class_sections as $classSection)

                    <span class="badge bg-light text-dark border px-2 py-1 me-1">{{ $classSection }}</span>

                    @empty

                    <span class="text-muted small">لا يوجد صفوف مسندة</span>

                    @endforelse

                </div>

            </div>

            <div class="mt-4 pt-3 border-top d-flex gap-2 flex-wrap">

                <a href="{{ route('manager.teachers.assign', ['teacher' => $teacher->id, 'year' => $year ?? date('Y')]) }}" class="btn btn-primary btn-sm px-3 py-2 fw-bold" style="background-color: var(--primary-color) !important; border-color: var(--primary-color) !important;">

                    <i class="bi bi-people-fill ms-1"></i> عرض الطلاب

                </a>

                <form action="{{ route('manager.teachers.deactivate', $teacher->id) }}"
                    method="POST" class="d-inline"
                    onsubmit="return confirm('هل أنت متأكد من إلغاء تفعيل حساب هذا المعلم؟')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-deactivate btn-sm px-3 py-2 fw-bold">
                        <i class="bi bi-person-x ms-1"></i> إلغاء التفعيل
                    </button>
                </form>

            </div>

        </div>

    </div>

    @empty

    <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">

        <i class="bi bi-people display-4 text-muted mb-3 d-block"></i>

        <h6 class="text-muted">لا يوجد معلمون مطابقون لشروط البحث.</h6>

    </div>

    @endforelse

</div>

<!-- Delete Manager Account Modal -->

<div class="modal fade" id="deleteManagerModal" tabindex="-1" aria-labelledby="deleteManagerModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow rounded-4">

            <div class="modal-header bg-danger text-white">

                <h5 class="modal-title fs-6" id="deleteManagerModalLabel"><i class="bi bi-exclamation-triangle-fill ms-1"></i> حذف الحساب</h5>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>

            </div>

            <div class="modal-body text-center py-4">

                <i class="bi bi-trash3-fill text-danger display-4 mb-3 d-block"></i>

                <h5 class="mb-2 fw-bold text-dark">هل أنت متأكد من حذف حسابك؟</h5>

                <p class="text-muted small mb-0">سيتم حذف حساب المدير نهائيًا، ولا يمكن التراجع عن هذه العملية.</p>

            </div>

            <div class="modal-footer justify-content-center border-0 bg-light">

                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">إلغاء</button>

                <form action="{{ route('manager.profile.delete') }}" method="POST" class="d-inline">

                    @csrf

                    @method('DELETE')

                    <button type="submit" class="btn btn-danger px-4">نعم، حذف الحساب</button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection