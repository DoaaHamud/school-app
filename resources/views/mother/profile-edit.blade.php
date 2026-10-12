<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل البيانات الشخصية - روضتي</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            margin: 0;
            background: #f5f7fb;
            font-family: "Segoe UI", Tahoma, Arial, sans-serif;
            color: #273142;
        }

        .navbar-custom {
            background: white;
            min-height: 70px;
            padding: 0 35px;
            border-bottom: 1px solid #e7ebf0;
        }

        .navbar-brand {
            font-size: 22px;
            font-weight: 700;
            color: #1f2937;
        }

        .main-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .form-card {
            background: white;
            border: 1px solid #e5eaf0;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('mother.dashboard') }}">روضتي</a>
            <a href="{{ route('mother.profile') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-right me-1"></i> العودة للملف الشخصي
            </a>
        </div>
    </nav>

    <div class="main-container">
        <div class="form-card">
            <h4 class="fw-bold mb-4">
                <i class="bi bi-pencil-square text-primary me-2"></i> تعديل البيانات الشخصية
            </h4>

            @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('mother.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">الاسم الكامل</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $mother->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $mother->email) }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">رقم الهاتف</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $mother->phone) }}">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-lg me-1"></i> حفظ التعديلات
                    </button>
                    <a href="{{ route('mother.profile') }}" class="btn btn-light px-4 border">إلغاء</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>