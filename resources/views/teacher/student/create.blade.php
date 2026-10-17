@extends('layouts.app')

@section('content')

    <style>
        * {
            box-sizing: border-box;
        }

        /* =========================
           Navbar
        ========================= */

        .navbar-custom {
            background-color: var(--primary-color);
            min-height: 70px;
            padding: 0 35px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .navbar-brand {
            font-size: 22px;
            font-weight: 700;
            color: #1f2937;
            margin-left: 30px;
            text-decoration: none;
        }

        .navbar-brand:hover {
            color: #1f2937;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.85);
            font-size: 15px;
            font-weight: 500;
            padding: 24px 15px !important;
            transition: 0.2s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.16);
        }

        .nav-link.active {
            border-bottom: 2px solid #ffffff;
        }

        /* تنسيق زر وقائمة اسم المعلم */
        .teacher-profile-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background: transparent;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 10px;
            transition: background-color 0.2s;
        }

        .teacher-profile-btn:hover {
            background-color: rgba(255, 255, 255, 0.16);
        }

        .teacher-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: #ffffff;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .teacher-dropdown {
            min-width: 230px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 8px;
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.10);
        }

        .teacher-dropdown .dropdown-header {
            background-color: var(--primary-color);
            border-radius: 0.375rem;
            color: #ffffff;
        }

        .teacher-dropdown .dropdown-header strong,
        .teacher-dropdown .dropdown-header small {
            color: #ffffff !important;
        }

        .teacher-dropdown .dropdown-item:not(.text-danger):hover,
        .teacher-dropdown .dropdown-item:not(.text-danger):focus,
        .teacher-dropdown .dropdown-item:not(.text-danger):active {
            background-color: var(--primary-color);
            color: #ffffff;
        }

        .teacher-dropdown .dropdown-item:not(.text-danger):hover i,
        .teacher-dropdown .dropdown-item:not(.text-danger):focus i,
        .teacher-dropdown .dropdown-item:not(.text-danger):active i {
            color: #ffffff !important;
        }

        .logout-btn {
            background-color: transparent;
            border: 1px solid #dc3545;
            color: #dc3545;
            border-radius: 7px;
            padding: 7px 15px;
            font-size: 14px;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background-color: #dc3545;
            color: white;
        }

        /* =========================
           Main
        ========================= */

        .main-container {
            max-width: 1200px;
            margin: auto;
            padding: 40px 30px;
        }

        /* =========================
           Card
        ========================= */

        .student-card {
            background-color: white;
            border: 1px solid #e8ebef;
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header-custom {
            background-color: var(--primary-color);
            color: #ffffff;
            padding: 18px 25px;
            font-size: 18px;
            font-weight: 700;
        }

        .card-body {
            padding: 30px;
        }

        /* =========================
           Form
        ========================= */

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 7px;
        }

        .form-control,
        .form-select {
            border-radius: 7px;
            border: 1px solid #d1d5db;
            padding: 10px 12px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.15);
        }

        textarea.form-control {
            resize: vertical;
        }

        .save-btn {
            background-color: var(--primary-color);
            border: 1px solid var(--primary-color);
            color: #ffffff;
            border-radius: 7px;
            padding: 10px 22px;
            cursor: pointer;
        }

        .save-btn:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #ffffff;
            opacity: 0.9;
        }

        .card-header-custom {
            background-color: var(--primary-color);
        }

        .cancel-btn {
            background-color: white;
            border: 1px solid #6b7280;
            color: #4b5563;
            border-radius: 7px;
            padding: 10px 22px;
            text-decoration: none;
        }

        .cancel-btn:hover {
            background-color: #6b7280;
            color: white;
        }

        /* =========================
           Responsive
        ========================= */

        @media (max-width: 991px) {
            .navbar-custom {
                padding: 10px 20px;
            }

            .nav-link {
                padding: 12px 10px !important;
            }

            .main-container {
                padding: 25px 15px;
            }

            .card-body {
                padding: 20px;
            }
        }
    </style>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <!-- حاوية الشعار -->
            <div style="width: 45px; height: 45px; flex-shrink: 0; border-radius: 12px; overflow: hidden; background: #ffffff; display: flex; align-items: center; justify-content: center;">
                <img src="{{ $schoolBranding->school_logo ? asset('storage/' . $schoolBranding->school_logo) : asset('images/logo.jpeg') }}"
                    alt="شعار {{ $schoolBranding->school_name ?? 'روضتي' }}"
                    style="width: 100%; height: 100%; object-fit: contain;">
            </div>

            <!-- النصوص بجانب الشعار -->
            <div class="brand-text" style="display: flex; flex-direction: column; text-align: right;">
                <span style="font-size: 18px; font-weight: 800; color: #ffffff; line-height: 1.2;">{{ $schoolBranding->school_name ?? 'روضتي' }}</span>
                <span style="font-size: 12px; color: rgba(255, 255, 255, 0.85); margin-top: 2px; font-weight: 500;">لوحة تحكم المعلم</span>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#teacherNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="teacherNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}" href="{{ route('teacher.dashboard') }}">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('teacher.students.create') ? 'active' : '' }}" href="{{ route('teacher.students.create') }}">إضافة طفل جديد</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('teacher.classes') ? 'active' : '' }}" href="{{ route('teacher.classes') }}">الصفوف المتاحة</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('teacher.daily_variables') ? 'active' : '' }}" href="{{ route('teacher.daily_variables') }}">المتغيرات اليومية</a>
                    </li>
                </ul>

                <!-- قائمة حساب المعلم -->
                <div class="dropdown me-3">
                    <button class="teacher-profile-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="teacher-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-dark fs-6">{{ $teacher->name }}</div>
                            <small class="text-muted d-block" style="font-size: 11px;">معلم</small>
                        </div>
                        <i class="bi bi-chevron-down text-muted ms-1" style="font-size: 12px;"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end teacher-dropdown manager-account-menu">
                        <li>
                            <div class="dropdown-header px-3 py-2">
                                <div class="fw-bold text-white fs-6">{{ $teacher->name }}</div>
                                <small class="text-white">{{ $teacher->email }}</small>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('teacher.profile') }}">
                                <i class="bi bi-person-circle me-2"></i> الملف الشخصي
                            </a>
                        </li>
                        <li>
                    </ul>
                </div>

                <!-- تسجيل الخروج -->
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="bi bi-box-arrow-right me-1"></i> تسجيل الخروج
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-container">

        <div class="student-card shadow-sm">

            <!-- Header -->
            <div class="card-header-custom">
                <i class="bi bi-person-plus me-1"></i> إنشاء حساب طفل جديد
            </div>

            <!-- Body -->
            <div class="card-body">

                <!-- Errors -->
                @if($errors->any())
                <div class="alert alert-danger">
                    <strong>يرجى تصحيح الأخطاء التالية:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Form -->
                <form action="{{ route('teacher.students.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <!-- اسم الطفل -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم الطفل</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <!-- الجنس -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الجنس</label>
                            <select name="gender" class="form-select" required>
                                <option value="">اختر الجنس</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>أنثى</option>
                            </select>
                        </div>

                        <!-- العمر -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">العمر</label>
                            <input type="number" name="age" class="form-control" min="1" max="10" value="{{ old('age') }}" required>
                        </div>

                        <!-- الأم -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">أم الطفل</label>
                            <select name="mother_id" class="form-select" required>
                                <option value="">اختر أم الطفل</option>
                                @foreach($mothers as $mother)
                                <option value="{{ $mother->id }}" {{ old('mother_id') == $mother->id ? 'selected' : '' }}>
                                    {{ $mother->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- الصف -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الصف</label>
                            <input type="text" name="class" class="form-control" value="{{ old('class') }}" placeholder="مثال: KG1" required>
                        </div>

                        <!-- الحالة الصحية -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">الحالة الصحية</label>
                            <textarea name="health_status" class="form-control" rows="3" placeholder="اكتب الحالة الصحية للطفل إن وجدت...">{{ old('health_status') }}</textarea>
                        </div>

                        <!-- صورة الطفل -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">صورة الطفل</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="save-btn">
                            <i class="bi bi-check-circle me-1"></i> إنشاء حساب الطفل
                        </button>

                        <a href="{{ route('teacher.dashboard') }}" class="cancel-btn">إلغاء</a>
                    </div>

                </form>

            </div>

        </div>

    </main>

@endsection