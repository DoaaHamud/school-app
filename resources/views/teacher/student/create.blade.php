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



<!-- Main Content -->
<main class="main-container">

    <div class="student-card shadow-sm">

        <!-- Header -->
        <div class="card-header-custom">
            <i class="bi bi-person-plus me-1"></i> إنشاء حساب طالب جديد
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

                    <!-- اسم الطالب -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">اسم الطالب</label>
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

                    <!-- أم الطالب -->
                    <div class="col-md-12 mb-3">
                        <label for="school-mother-select" class="form-label">أم الطالب</label>
                        <select id="school-mother-select" name="mother_id" class="form-select" required>
                            <option value="">اختر أمًا تمت الموافقة على طلبها للمدرسة</option>
                            @foreach($schoolMothers as $mother)
                            <option value="{{ $mother->id }}" {{ old('mother_id') == $mother->id ? 'selected' : '' }}>
                                {{ $mother->name }} — {{ '@' . $mother->username }}
                            </option>
                            @endforeach
                        </select>
                        @if($schoolMothers->isEmpty())
                        <small class="text-muted d-block mt-1">لا توجد أمهات تمت الموافقة على طلباتهن لهذه المدرسة بعد.</small>
                        @endif
                    </div>

                    <!-- الصف -->
                    <div class="col-md-3 mb-3">
                        <label for="student-class" class="form-label">الصف</label>
                        <select id="student-class" name="class" class="form-select" required>
                            <option value="">اختر الصف</option>
                            @foreach($classes as $class)
                            <option value="{{ $class }}" {{ old('class') === $class ? 'selected' : '' }}>
                                {{ $class }}
                            </option>
                            @endforeach
                        </select>
                        @if(empty($classes))
                        <small class="text-muted d-block mt-1">لم يحدد المدير الصفوف المدرسية بعد.</small>
                        @endif
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="student-section" class="form-label">الشعبة</label>
                        <select id="student-section" name="section" class="form-select" required>
                            <option value="">اختر الشعبة</option>
                            @foreach($sections as $section)
                            <option value="{{ $section }}" {{ old('section') === $section ? 'selected' : '' }}>
                                {{ $section }}
                            </option>
                            @endforeach
                        </select>
                        @if(empty($sections))
                        <small class="text-muted d-block mt-1">لم يحدد المدير الشُعَب المدرسية بعد.</small>
                        @endif
                    </div>

                    <!-- الحالة الصحية -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">الحالة الصحية</label>
                        <textarea name="health_status" class="form-control" rows="3" placeholder="اكتب الحالة الصحية للطالب إن وجدت...">{{ old('health_status') }}</textarea>
                    </div>

                    <!-- صورة الطفل -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">صورة الطالب</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="save-btn">
                        <i class="bi bi-check-circle me-1"></i> إنشاء حساب الطالب
                    </button>

                    <a href="{{ route('teacher.dashboard') }}" class="cancel-btn">إلغاء</a>
                </div>

            </form>

        </div>

    </div>

</main>

@endsection