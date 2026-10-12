<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي - روضتي</title>
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

        .profile-card {
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
            <a href="{{ route('mother.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-right me-1"></i> العودة للرئيسية
            </a>
        </div>
    </nav>

    <div class="main-container">
        @if(session('success'))
        <div class="alert alert-success shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
        </div>
        @endif

        <div class="profile-card">
            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                <div style="width: 60px; height: 60px; border-radius: 50%; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 26px;">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-1">{{ $mother->name }}</h3>
                    <span class="text-muted small">حساب ولي أمر (أم)</span>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="text-muted small d-block">الاسم الكامل</label>
                    <span class="fw-bold fs-6 text-dark">{{ $mother->name }}</span>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small d-block">البريد الإلكتروني</label>
                    <span class="fw-bold fs-6 text-dark">{{ $mother->email }}</span>
                </div>
                <div class="col-md-6 mt-3">
                    <label class="text-muted small d-block">رقم الهاتف</label>
                    <span class="fw-bold fs-6 text-dark">{{ $mother->phone ?? 'غير متوفر' }}</span>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex gap-2">
                <a href="{{ route('mother.profile.edit') }}" class="btn btn-primary">
                    <i class="bi bi-pencil-square me-1"></i> تعديل البيانات
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>