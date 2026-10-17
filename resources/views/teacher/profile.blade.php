@extends('layouts.app')

@section('content')

<div class="container my-5" style="max-width: 750px;">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill ms-1"></i> {{ session('success') }}
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
        <div class="d-flex align-items-center gap-3 mb-4">
            <div class="rounded-circle d-flex align-items-center justify-content-center text-white"
                style="width: 70px; height: 70px; background-color: var(--primary-color) !important; font-size: 30px;">
                <i class="bi bi-person-fill"></i>
            </div>

            <div>
                <h3 class="fw-bold m-0 text-dark" style="font-size: 22px;">{{ $teacher->name }}</h3>
                <p class="text-muted m-0 small mt-1">معلم</p>
            </div>
        </div>

        <div class="card border-0 bg-light rounded-4 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-3">
                    <i class="bi bi-person-vcard ms-2" style="color: var(--primary-color);"></i>
                    المعلومات الشخصية
                </h5>
                <p class="text-muted small mb-4">يمكنك تعديل معلوماتك مباشرة من هذه الصفحة.</p>

                <form action="{{ route('teacher.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">الاسم الكامل</label>
                        <input id="name" type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $teacher->name) }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">البريد الإلكتروني</label>
                        <input id="email" type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $teacher->email) }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label fw-semibold">رقم الهاتف</label>
                        <input id="phone" type="text" name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $teacher->phone) }}">
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="school_name" class="form-label fw-semibold">اسم الروضة / المدرسة</label>
                        <input id="school_name" type="text" class="form-control"
                            value="{{ $teacher->school_name ?? 'غير محدد' }}" disabled>
                    </div>

                    <button type="submit" class="btn text-white fw-bold px-4 py-2"
                        style="background-color: var(--primary-color); border-color: var(--primary-color); border-radius: 9px;">
                        <i class="bi bi-save ms-1"></i> حفظ التغييرات
                    </button>
                </form>
            </div>
        </div>

        <div class="d-flex gap-2 mt-2 pt-2">
            <a href="{{ route('teacher.dashboard') }}" class="btn btn-light border fw-semibold px-4 py-2"
                style="border-radius: 9px; color: #334155;">
                العودة للوحة التحكم
            </a>
        </div>
    </div>
</div>

@endsection
