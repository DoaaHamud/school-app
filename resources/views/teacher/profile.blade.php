@extends('layouts.app')

@section('content')
    <style>
        .main-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .profile-card {
            background: white;
            border: 1px solid #e8ebef;
            border-radius: 12px;
            padding: 30px;
        }

        .avatar-box {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: color-mix(in srgb, var(--primary-color) 10%, white);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
        }

        .profile-role-badge {
            background: color-mix(in srgb, var(--primary-color) 10%, white);
            color: var(--primary-color);
            border-color: color-mix(in srgb, var(--primary-color) 25%, white) !important;
        }

        .profile-title {
            color: var(--primary-color);
        }
    </style>

    <div class="container main-container">

        @if(session('success'))
        <div class="alert alert-success shadow-sm mb-4 alert-dismissible fade show">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0 profile-title">الملف الشخصي</h3>
            <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-right me-1"></i> العودة للرئيسية
            </a>
        </div>

        <div class="profile-card shadow-sm">
            <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-3">
                <div class="avatar-box">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1">{{ $teacher->name }}</h4>
                    <span class="badge border px-3 py-2 profile-role-badge">معلم</span>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="text-muted small d-block">الاسم الكامل</label>
                    <div class="fw-semibold fs-6 mt-1">{{ $teacher->name }}</div>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small d-block">البريد الإلكتروني</label>
                    <div class="fw-semibold fs-6 mt-1">{{ $teacher->email }}</div>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small d-block">رقم الهاتف</label>
                    <div class="fw-semibold fs-6 mt-1">{{ $teacher->phone ?? 'غير محدد' }}</div>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small d-block">اسم الروضة / المدرسة</label>
                    <div class="fw-semibold fs-6 mt-1">{{ $teacher->school_name ?? 'غير محدد' }}</div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex gap-2">
                <a href="{{ route('teacher.profile.edit') }}" class="btn btn-warning text-dark px-4">
                    <i class="bi bi-pencil-square me-1"></i> تعديل البيانات
                </a>
            </div>
        </div>
    </div>

@endsection