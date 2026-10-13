@extends('layouts.app')

@section('content')

<!-- Navbar ملون بالكامل باللون المختار -->
<nav class="navbar navbar-expand-lg main-navbar mb-4" style="background-color: var(--primary-color) !important;">
    <div class="container">
        <!-- الشعار واسم الروضة -->
        <a class="navbar-brand d-flex align-items-center gap-3 m-0" href="{{ route('manager.dashboard') }}">
            <div style="width: 45px; height: 45px; flex-shrink: 0; border-radius: 12px; overflow: hidden; background: #ffffff; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                @if(auth()->user()->school_logo)
                <img src="{{ asset('storage/' . auth()->user()->school_logo) }}" alt="شعار المدرسة" style="width: 100%; height: 100%; object-fit: contain;">
                @else
                <img src="{{ asset('images/logo.jpeg') }}" alt="شعار روضتي" style="width: 100%; height: 100%; object-fit: contain;">
                @endif
            </div>

            <div class="d-flex flex-column text-end">
                <span class="brand-name" style="color: #ffffff !important; font-size: 18px; font-weight: 800;">{{ auth()->user()->school_name ?? 'روضتي' }}</span>
                <span class="dashboard-subtitle" style="font-size: 12px; color: rgba(255, 255, 255, 0.85);">لوحة تحكم المدير</span>
            </div>
        </a>

        <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#managerNavbar">
            <i class="bi bi-list fs-2 text-white"></i>
        </button>

        <div class="collapse navbar-collapse" id="managerNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link text-white opacity-75 {{ request()->routeIs('manager.dashboard') ? 'opacity-100 fw-bold' : '' }}" href="{{ route('manager.dashboard') }}">
                        <i class="bi bi-check2-square ms-1"></i> المهام
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white opacity-75 {{ request()->routeIs('manager.teachers.*') ? 'opacity-100 fw-bold' : '' }}" href="{{ route('manager.teachers.index') }}">
                        <i class="bi bi-people-fill ms-1"></i> دليل الأساتذة
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white opacity-75 {{ request()->routeIs('manager.students') ? 'opacity-100 fw-bold' : '' }}" href="{{ route('manager.students') }}">
                        <i class="bi bi-mortarboard-fill ms-1"></i> دليل الطلاب
                    </a>
                </li>
            </ul>

            <!-- Manager Account -->
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="dropdown">
                    <button class="btn d-flex align-items-center gap-2 border-0 dropdown-toggle py-1 px-2 rounded-3 text-white" style="background: rgba(255,255,255,0.2);" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-white" style="width: 36px; height: 36px; color: var(--primary-color);">
                            <i class="bi bi-person-fill fs-6"></i>
                        </div>
                        <div class="d-flex flex-column text-end">
                            <span class="fw-bold" style="font-size: 13px;">{{ auth()->user()->name }}</span>
                            <span style="font-size: 11px; color: rgba(255,255,255,0.85);">إدارة الروضة</span>
                        </div>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2 manager-account-menu" style="min-width: 220px; border-radius: 12px;">
                        <li>
                            <div class="dropdown-header px-2 py-1">
                                <strong class="text-dark">{{ auth()->user()->name }}</strong><br>
                                <small class="text-muted" style="font-size: 11px;">{{ auth()->user()->email }}</small>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider my-2">
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2" href="{{ route('manager.profile') }}">
                                <i class="bi bi-person-circle ms-1"></i> الملف الشخصي
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2" href="{{ route('manager.profile.edit') }}">
                                <i class="bi bi-pencil-square ms-1"></i> تعديل البيانات
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider my-2">
                        </li>
                        <li>
                            <button type="button" class="dropdown-item rounded-2 py-2 text-danger" data-bs-toggle="modal" data-bs-target="#deleteManagerModal">
                                <i class="bi bi-trash ms-1"></i> حذف الحساب
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Logout -->
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm px-3 py-2 text-white" style="background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.4); border-radius: 9px; font-weight: 600; font-size: 13px;">
                        <i class="bi bi-box-arrow-right"></i> خروج
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Content -->
<div class="container my-4" style="max-width: 1200px;">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="h4 fw-bold m-0 text-dark">
            <i class="bi bi-award me-2" style="color: var(--primary-color);"></i> علامات وتقييمات طلاب الصف: {{ $className }}
        </h2>
        <a href="{{ route('manager.students') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 rounded-3 fw-semibold">
            <i class="bi bi-arrow-right ms-1"></i> العودة لدليل الطلاب
        </a>
    </div>

    <!-- بطاقة البحث والتصفية -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('manager.classes.grades', $className) }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold small text-secondary">اسم الطالب</label>
                    <input type="text" name="search_name" class="form-control" placeholder="ابحث باسم الطالب..." value="{{ $searchName ?? '' }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold small text-secondary">اسم المادة / النشاط</label>
                    <input type="text" name="search_topic" class="form-control" placeholder="ابحث بالمادة..." value="{{ $searchTopic ?? '' }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold small text-secondary">العام الدراسي</label>
                    <select name="year" class="form-select">
                        @for($i = date('Y') - 5; $i <= date('Y') + 1; $i++)
                            <option value="{{ $i }}" {{ (int)($selectedYear ?? date('Y')) == $i ? 'selected' : '' }}>
                            العام الدراسي {{ $i }}
                            </option>
                            @endfor
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn text-white fw-bold w-100 py-2" style="background-color: var(--primary-color) !important; border-color: var(--primary-color) !important; border-radius: 9px;">
                        <i class="bi bi-search ms-1"></i> بحث
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- جدول النتائج -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>اسم الطالب</th>
                            <th>موضوع النشاط / المادة</th>
                            <th>النتيجة / العلامة</th>
                            <th>تاريخ التقييم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $counter = 1; @endphp
                        @forelse($students as $student)
                        @foreach($student->dailyVariables as $daily)
                        <tr>
                            <td>{{ $counter++ }}</td>
                            <td class="fw-bold text-dark">{{ $student->name }}</td>
                            <td>{{ $daily->topic ?? '-' }}</td>
                            <td>
                                <span class="badge text-white px-3 py-2 rounded-pill fw-bold" style="background-color: var(--primary-color) !important; font-size: 13px;">{{ $daily->result ?? '-' }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($daily->report_date)->format('Y-m-d') }}</td>
                        </tr>
                        @endforeach
                        @empty
                        <tr>
                            <td colspan="5" class="py-4 text-muted">لا توجد علامات مسجلة مطابقة للبحث.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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