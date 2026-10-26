@extends('layouts.app')

@section('content')


<!-- Content -->
<div class="container my-5" style="max-width: 750px;">

    <!-- زر العودة إلى لوحة التحكم -->
    <div class="mb-4">
        <a href="{{ route('manager.dashboard') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 rounded-3 px-3 py-2 shadow-sm">
            <i class="bi bi-arrow-right"></i>
            <span>العودة إلى لوحة التحكم</span>
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger shadow-sm rounded-3" role="alert">
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
            <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm" style="width: 70px; height: 70px; background-color: var(--primary-color) !important; font-size: 30px;">
                <i class="bi bi-person-fill"></i>
            </div>

            <div>
                <h3 class="fw-bold m-0 text-dark" style="font-size: 22px;">
                    {{ $manager->name }}
                </h3>
                <p class="text-muted m-0 small mt-1">
                    مدير الروضة / المدرسة
                </p>
            </div>
        </div>

        <!-- 1. نموذج المعلومات الشخصية للمدير -->
        <div class="card border-0 bg-light rounded-4 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-3">
                    <i class="bi bi-person-vcard ms-2" style="color: var(--primary-color);"></i>
                    المعلومات الشخصية
                </h5>
                <p class="text-muted small mb-4">يمكنك تعديل معلوماتك الحسابية مباشرة من هنا.</p>

                <form action="{{ route('manager.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="manager_name" class="form-label fw-semibold">الاسم</label>
                        <input id="manager_name" type="text" name="name" class="form-control rounded-3"
                            value="{{ old('name', $manager->name) }}" maxlength="255" required>
                    </div>

                    <div class="mb-3">
                        <label for="manager_email" class="form-label fw-semibold">البريد الإلكتروني</label>
                        <input id="manager_email" type="email" name="email" class="form-control rounded-3"
                            value="{{ old('email', $manager->email) }}" maxlength="255" required>
                    </div>

                    <div class="mb-4">
                        <label for="manager_phone" class="form-label fw-semibold">رقم الهاتف</label>
                        <input id="manager_phone" type="text" name="phone" class="form-control rounded-3"
                            value="{{ old('phone', $manager->phone ?? '') }}" maxlength="20">
                    </div>

                    <button type="submit" class="btn text-white fw-bold px-4 py-2"
                        style="background-color: var(--primary-color); border-color: var(--primary-color); border-radius: 9px;">
                        <i class="bi bi-save ms-1"></i> حفظ المعلومات الشخصية
                    </button>
                </form>
            </div>
        </div>

        <!-- 2. نموذج تخصيص الهوية والهيكلة التعليمية للمدرسة -->
        <div class="card border-0 bg-light rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-3">
                    <i class="bi bi-building-gear ms-2" style="color: var(--primary-color);"></i>
                    تخصيص معلومات وهيكلة المدرسة
                </h5>
                <p class="text-muted small mb-4">عدّلي اسم المدرسة وشعارها ولونها بالإضافة إلى الصفوف وشعبها والمواد الدراسية.</p>

                <form action="{{ route('manager.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- اسم المدرسة -->
                    <div class="mb-3">
                        <label for="school_name" class="form-label fw-semibold">اسم المدرسة / الروضة</label>
                        <input id="school_name" type="text" name="school_name" class="form-control rounded-3"
                            value="{{ old('school_name', $manager->school?->name ?? 'روضتي') }}"
                            maxlength="255" required>
                    </div>

                    <!-- الصفوف المدرسية -->
                    <div class="mb-3">
                        <label for="classes" class="form-label fw-semibold">الصفوف المدرسية</label>
                        <textarea id="classes" name="classes" class="form-control rounded-3" rows="2"
                            placeholder="مثال: روضة، بستان، تمهيدي، الأول، الثاني...">{{ old('classes', implode('، ', $manager->school?->classes ?? [])) }}</textarea>
                        <small class="text-muted">افصلي بين الصفوف بفارزة أو سطر جديد.</small>
                    </div>

                    <!-- الشعب -->
                    <div class="mb-3">
                        <label for="sections" class="form-label fw-semibold">الشُعَب</label>
                        <textarea id="sections" name="sections" class="form-control rounded-3" rows="2"
                            placeholder="مثال: الشعبة الأولى، الشعبة الثانية، A، B...">{{ old('sections', implode('، ', $manager->school?->sections ?? [])) }}</textarea>
                    </div>

                    <!-- المواد الدراسية -->
                    <div class="mb-3">
                        <label for="subjects" class="form-label fw-semibold">المواد الدراسية</label>
                        <textarea id="subjects" name="subjects" class="form-control rounded-3" rows="2"
                            placeholder="مثال: اللغة العربية، الرياضيات، العلوم، الإنجليزي...">{{ old('subjects', $manager->school?->subjects) }}</textarea>
                    </div>

                    <!-- لون التطبيق -->
                    <div class="mb-3">
                        <label for="primary_color" class="form-label fw-semibold">لون التطبيق</label>
                        <input id="primary_color" type="color" name="primary_color"
                            class="form-control form-control-color rounded-3 w-100"
                            value="{{ old('primary_color', $manager->school?->color ?? '#2563eb') }}">
                    </div>

                    <!-- الشعار الحالي -->
                    @if($manager->school?->logo)
                    <div class="mb-3">
                        <span class="form-label d-block fw-semibold">الشعار الحالي</span>
                        <img src="{{ asset('storage/' . $manager->school->logo) }}"
                            alt="شعار المدرسة الحالي"
                            class="bg-white border rounded-3 p-2 shadow-sm"
                            style="width: 90px; height: 90px; object-fit: contain;">
                    </div>
                    @endif

                    <!-- رفع الشعار -->
                    <div class="mb-4">
                        <label for="school_logo" class="form-label fw-semibold">شعار المدرسة</label>
                        <input id="school_logo" type="file" name="school_logo" class="form-control rounded-3"
                            accept=".jpg,.jpeg,.png,.svg">
                        <small class="text-muted">يمكنك رفع صورة بصيغة JPG أو PNG أو SVG، بحجم أقصى 2 ميغابايت.</small>
                    </div>

                    <button type="submit" class="btn text-white fw-bold px-4 py-2"
                        style="background-color: var(--primary-color); border-color: var(--primary-color); border-radius: 9px;">
                        <i class="bi bi-save ms-1"></i> حفظ إعدادات المدرسة
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection