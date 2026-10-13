@extends('layouts.app')

@section('content')

    <style>
        .page-wrapper {
            max-width: 850px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .page-header {
            margin-bottom: 25px;
        }

        .page-header h2 {
            color: #1e293b;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #64748b;
            margin: 0;
        }

        .profile-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(15, 23, 42, 0.07);
            border: 1px solid #e5e7eb;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 10px;
            padding: 11px 13px;
            border: 1px solid #dbe1e8;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.15);
        }

        .btn-save {
            background: var(--primary-color);
            color: #ffffff;
            border: 1px solid var(--primary-color);
            border-radius: 10px;
            padding: 11px 25px;
        }

        .btn-save:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: #ffffff;
            opacity: 0.9;
        }

        .btn-back {
            border-radius: 10px;
            padding: 10px 22px;
        }

        .required {
            color: #dc2626;
        }
    </style>

    <div class="page-wrapper">

        <div class="page-header">
            <h2>
                <i class="bi bi-pencil-square"></i>
                تعديل بيانات الحساب
            </h2>

            <p>
                يمكنك تعديل اسم المدير والبريد الإلكتروني ورقم الهاتف.
            </p>
        </div>

        <div class="profile-card">

            {{-- رسائل الخطأ --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form
                action="{{ route('manager.profile.update') }}"
                method="POST">

                @csrf
                @method('PUT')

                {{-- الاسم --}}
                <div class="mb-4">
                    <label class="form-label">
                        الاسم
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $manager->name) }}"
                        required>
                </div>

                {{-- البريد --}}
                <div class="mb-4">
                    <label class="form-label">
                        البريد الإلكتروني
                        <span class="required">*</span>
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $manager->email) }}"
                        required>
                </div>

                {{-- رقم الهاتف --}}
                <div class="mb-4">
                    <label class="form-label">
                        رقم الهاتف
                    </label>

                    <input
                        type="text"
                        name="phone"
                        class="form-control"
                        value="{{ old('phone', $manager->phone ?? '') }}"
                        placeholder="أدخل رقم الهاتف">
                </div>

                {{-- الأزرار --}}
                <div class="d-flex gap-2 mt-4">

                    <button
                        type="submit"
                        class="btn btn-save">

                        <i class="bi bi-check-lg"></i>
                        حفظ التعديلات
                    </button>

                    <a
                        href="{{ route('manager.profile') }}"
                        class="btn btn-outline-secondary btn-back">

                        <i class="bi bi-arrow-right"></i>
                        إلغاء
                    </a>

                </div>

            </form>

        </div>

    </div>

@endsection