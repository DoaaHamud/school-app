@extends('layouts.app')

@section('content')
<style>
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
</style>

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
                    <a class="nav-link text-white {{ request()->routeIs('manager.students*') ? 'opacity-100 fw-bold bg-white-10' : 'opacity-75' }}" href="{{ route('manager.students') }}" style="background: rgba(255,255,255,0.15); border-radius: 8px;">
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

<!-- Main Content -->
<div class="container page-container my-4" style="max-width: 1300px;">

    @if(session('success'))
    <div class="alert alert-success shadow-sm mb-4">
        <i class="bi bi-check-circle-fill ms-1"></i> {{ session('success') }}
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h1 class="page-title fw-bold mb-1" style="font-size: 26px; color: #1f2937;">دليل الطلاب</h1>
            <p class="page-subtitle text-muted small mb-0">عرض وإدارة بيانات الطلاب والتقارير اليومية بحسب الصفوف الدراسية</p>
        </div>
        <a href="{{ route('manager.students.deactivated') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-person-x ms-1"></i> الطلاب غير المفعلين
            <span class="badge bg-secondary ms-1">{{ $deactivatedStudentsCount }}</span>
        </a>
    </div>

    <!-- Search & Filter Card -->
    <div class="task-card shadow-sm rounded-4 mb-4" style="background: white; border: 1px solid #e8eaf0;">
        <div class="p-3 border-bottom bg-light fw-bold text-secondary rounded-top-4">
            <i class="bi bi-funnel-fill ms-1" style="color: var(--primary-color);"></i> البحث والتصفية
        </div>
        <div class="p-3">
            <form method="GET" action="{{ route('manager.students') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary small">اسم الطالب</label>
                        <input type="text" name="search" class="form-control" placeholder="ابحث باسم الطالب..." value="{{ $search ?? '' }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-secondary small">الصف الدراسي</label>
                        <select name="class" class="form-select">
                            <option value="">-- كل الصفوف --</option>
                            @foreach($classes as $classNameOpt)
                            <option value="{{ $classNameOpt }}" {{ ($class ?? '') == $classNameOpt ? 'selected' : '' }}>
                                {{ $classNameOpt }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-secondary small">السنة الدراسية</label>
                        <input type="number" name="year" class="form-control" value="{{ $year ?? date('Y') }}">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn text-white fw-bold w-100 py-2" style="background-color: var(--primary-color) !important; border-color: var(--primary-color) !important; border-radius: 9px;">
                            <i class="bi bi-search ms-1"></i> بحث
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Students Grouped By Classes -->
    @forelse($groupedStudents as $className => $classStudents)
    <div class="task-card rounded-4 border shadow-sm mb-4 overflow-hidden" style="background: #ffffff;">
        <!-- Header الخاص بالصف (شامل زر العلامات والملاحظات بالموقع الأصلي المظبوط) -->
        <div class="p-3 d-flex align-items-center justify-content-between flex-wrap gap-2 text-white" style="background-color: var(--primary-color) !important;">
            <h2 class="h6 m-0 fw-bold text-white d-flex align-items-center gap-2">
                <i class="bi bi-mortarboard-fill"></i> الصف: {{ $className ?: 'غير محدد' }}
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('manager.classes.grades', $className) }}" class="btn btn-sm btn-light fw-bold px-3 py-1 text-primary d-inline-flex align-items-center gap-1" style="color: var(--primary-color) !important; border-radius: 8px; font-size: 13px;">
                    <i class="bi bi-award"></i> عرض العلامات
                </a>
                <a href="{{ route('manager.classes.notes', $className) }}" class="btn btn-sm btn-light fw-bold px-3 py-1 text-primary d-inline-flex align-items-center gap-1" style="color: var(--primary-color) !important; border-radius: 8px; font-size: 13px;">
                    <i class="bi bi-journal-text"></i> عرض الملاحظات
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>اسم الطالب</th>
                        <th>الجنس</th>
                        <th>العمر</th>
                        <th>الحالة الصحية</th>
                        <th>المعدل العام للطالب</th>
                        <th>ولي الأمر</th>
                        <th>المتغيرات اليومية</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classStudents as $index => $student)
                    @php
                    $avgResult = $student->dailyVariables->isNotEmpty() ? number_format($student->dailyVariables->avg('result'), 1) : null;

                    $genderArabic = '-';
                    if (!empty($student->gender)) {
                    $g = strtolower(trim($student->gender));
                    if (in_array($g, ['male', 'ذكر', '1', 'm'])) {
                    $genderArabic = 'ذكر';
                    } elseif (in_array($g, ['female', 'أنثى', '0', 'f'])) {
                    $genderArabic = 'أنثى';
                    } else {
                    $genderArabic = $student->gender;
                    }
                    }
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <span class="fw-bold text-dark">{{ $student->name }}</span>
                        </td>
                        <td>{{ $genderArabic }}</td>
                        <td>{{ $student->age ?? '-' }}</td>
                        <td>{{ $student->health_status ?? 'جيدة' }}</td>
                        <td>
                            @if($avgResult)
                            <span class="badge text-white px-3 py-2 rounded-pill fw-bold" style="background-color: var(--primary-color) !important;">{{ $avgResult }}</span>
                            @else
                            <span class="text-muted small">لا توجد علامات</span>
                            @endif
                        </td>
                        <td>{{ $student->mother?->name ?? '-' }}</td>
                        <td>
                            @if($student->dailyVariables->isNotEmpty())
                            <a href="{{ route('manager.students.profile', $student->id) }}" class="btn btn-sm text-white px-3 py-1 fw-bold" style="font-size: 12px; border-radius: 20px; background-color: var(--primary-color) !important;">
                                <i class="bi bi-eye ms-1"></i> عرض البيانات ({{ $student->dailyVariables->count() }})
                            </a>
                            @else
                            <span class="text-muted small">لا توجد بيانات</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-deactivate px-2 py-1" style="font-size: 12px; border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#deactivateStudentModal{{ $student->id }}">
                                <i class="bi bi-person-x"></i> إلغاء التفعيل
                            </button>

                            <div class="modal fade" id="deactivateStudentModal{{ $student->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow rounded-4">
                                        <div class="modal-header bg-warning text-dark">
                                            <h5 class="modal-title fs-6">
                                                <i class="bi bi-exclamation-triangle-fill ms-1"></i> تأكيد إلغاء التفعيل
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                                        </div>
                                        <div class="modal-body text-center py-4">
                                            <div class="mb-3">
                                                <i class="bi bi-person-x-fill text-warning display-4"></i>
                                            </div>
                                            <h5 class="mb-2 fw-bold text-dark">هل تريد إلغاء تفعيل الطالب ({{ $student->name }})؟</h5>
                                            <p class="text-muted mb-0 small">سيختفي من القوائم النشطة مع الاحتفاظ ببياناته وتقاريره، ويمكن إعادة تفعيله لاحقًا.</p>
                                        </div>
                                        <div class="modal-footer justify-content-center border-0 bg-light">
                                            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">إلغاء</button>
                                            <form action="{{ route('manager.students.deactivate', $student->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-deactivate px-4">
                                                    <i class="bi bi-person-x"></i> نعم، إلغاء التفعيل
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @empty
    <div class="task-card text-center py-5 rounded-4 bg-white border">
        <i class="bi bi-emoji-neutral fs-1 text-muted"></i>
        <div class="mt-2 text-muted">لا توجد نتائج مطابقة للبحث أو لا يوجد طلاب مضافون.</div>
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