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
                            <a class="dropdown-item rounded-2 py-2 fw-bold" href="{{ route('manager.profile') }}">
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

<!-- Content -->
<div class="container my-5" style="max-width: 750px;">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger shadow-sm" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">

        <!-- Title & Avatar -->
        <div class="d-flex align-items-center gap-3 mb-4">
            <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 70px; height: 70px; background-color: var(--primary-color) !important; font-size: 30px;">
                <i class="bi bi-person-fill"></i>
            </div>

            <div>
                <h3 class="fw-bold m-0 text-dark" style="font-size: 22px;">
                    {{ $manager->name }}
                </h3>
                <p class="text-muted m-0 small mt-1">
                    مدير الروضة
                </p>
            </div>
        </div>

        <div class="card border-0 bg-light rounded-4 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-3">
                    <i class="bi bi-person-vcard ms-2" style="color: var(--primary-color);"></i>
                    المعلومات الشخصية
                </h5>
                <p class="text-muted small mb-4">يمكنك تعديل معلوماتك مباشرة من هذه الصفحة.</p>

                <form action="{{ route('manager.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="manager_name" class="form-label fw-semibold">الاسم</label>
                        <input id="manager_name" type="text" name="name" class="form-control"
                            value="{{ old('name', $manager->name) }}" maxlength="255" required>
                    </div>

                    <div class="mb-3">
                        <label for="manager_email" class="form-label fw-semibold">البريد الإلكتروني</label>
                        <input id="manager_email" type="email" name="email" class="form-control"
                            value="{{ old('email', $manager->email) }}" maxlength="255" required>
                    </div>

                    <div class="mb-4">
                        <label for="manager_phone" class="form-label fw-semibold">رقم الهاتف</label>
                        <input id="manager_phone" type="text" name="phone" class="form-control"
                            value="{{ old('phone', $manager->phone ?? '') }}" maxlength="20">
                    </div>

                    <button type="submit" class="btn text-white fw-bold px-4 py-2"
                        style="background-color: var(--primary-color); border-color: var(--primary-color); border-radius: 9px;">
                        <i class="bi bi-save ms-1"></i> حفظ المعلومات الشخصية
                    </button>
                </form>
            </div>
        </div>

        <div class="card border-0 bg-light rounded-4 mt-4">
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-3">
                    <i class="bi bi-palette-fill ms-2" style="color: var(--primary-color);"></i>
                    تخصيص الهوية البصرية
                </h5>
                <p class="text-muted small mb-4">عدّلي اسم المدرسة وشعارها ولون واجهة التطبيق.</p>

                <form action="{{ route('manager.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="school_name" class="form-label fw-semibold">اسم المدرسة / الروضة</label>
                        <input id="school_name" type="text" name="school_name" class="form-control"
                            value="{{ old('school_name', $manager->school_name ?? 'روضتي') }}" maxlength="255" required>
                    </div>

                    <div class="mb-3">
                        <label for="primary_color" class="form-label fw-semibold">لون التطبيق</label>
                        <input id="primary_color" type="color" name="primary_color"
                            class="form-control form-control-color"
                            value="{{ old('primary_color', $manager->primary_color ?? '#2563eb') }}" required>
                    </div>

                    @if($manager->school_logo)
                    <div class="mb-3">
                        <span class="form-label d-block">الشعار الحالي</span>
                        <img src="{{ asset('storage/' . $manager->school_logo) }}" alt="شعار المدرسة الحالي"
                            class="bg-white border rounded p-2" style="width: 90px; height: 90px; object-fit: contain;">
                    </div>
                    @endif

                    <div class="mb-4">
                        <label for="school_logo" class="form-label fw-semibold">شعار المدرسة</label>
                        <input id="school_logo" type="file" name="school_logo" class="form-control"
                            accept=".jpg,.jpeg,.png,.svg">
                        <small class="text-muted">يمكنكِ رفع صورة بصيغة JPG أو PNG أو SVG، بحجم أقصى 2 ميغابايت.</small>
                    </div>

                    <button type="submit" class="btn text-white fw-bold px-4 py-2"
                        style="background-color: var(--primary-color); border-color: var(--primary-color); border-radius: 9px;">
                        <i class="bi bi-save ms-1"></i> حفظ الهوية
                    </button>
                </form>
            </div>
        </div>

        <!-- الأزرار -->
        <div class="d-flex gap-2 mt-4 pt-2">
            <a href="{{ route('manager.dashboard') }}" class="btn btn-light border fw-semibold px-4 py-2" style="border-radius: 9px; color: #334155;">
                العودة للوحة التحكم
            </a>
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