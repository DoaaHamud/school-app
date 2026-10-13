@extends('layouts.app')

@section('content')
    <style>
        .main-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .edit-card {
            background: white;
            border: 1px solid #e8ebef;
            border-radius: 12px;
            padding: 30px;
        }

        .profile-edit-title,
        .profile-edit-card label {
            color: var(--primary-color);
        }
    </style>
    <div class="container main-container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0 profile-edit-title">تعديل البيانات الشخصية</h3>
            <a href="{{ route('teacher.profile') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-right me-1"></i> إلغاء ورجوع
            </a>
        </div>

        <div class="edit-card profile-edit-card shadow-sm">
            <form action="{{ route('teacher.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">الاسم الكامل</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $teacher->name) }}" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $teacher->email) }}" required>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">رقم الهاتف</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $teacher->phone) }}">
                    @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 border-top pt-3">
                    <button type="submit" class="btn btn-primary-custom px-4">
                        <i class="bi bi-check2-circle me-1"></i> حفظ التغييرات
                    </button>
                    <a href="{{ route('teacher.profile') }}" class="btn btn-light px-4">إلغاء</a>
                </div>
            </form>
        </div>
    </div>

@endsection