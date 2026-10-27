<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المدراء غير المفعلين</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body class="bg-light">

    @include('admin.navbar')


    <div class="container">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card border-secondary">
            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">الحسابات المعطلة</h5>
                <span class="badge bg-light text-dark">{{ $deactivatedManagers->count() }}</span>
            </div>
            <div class="card-body">
                @if($deactivatedManagers->isEmpty())
                <p class="text-center text-muted mb-0">لا يوجد مدراء ملغى تفعيلهم حالياً.</p>
                @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>اسم المستخدم</th>
                                <th>البريد الإلكتروني</th>
                                <th>اسم المدرسة</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($deactivatedManagers as $index => $manager)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $manager->name }}</td>
                                <td>{{ $manager->username }}</td>
                                <td>{{ $manager->email }}</td>
                                <td>{{ $manager->school?->name ?? 'غير محددة' }}</td>
                                <td><span class="badge bg-danger">معطل</span></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <!-- إعادة التفعيل -->
                                        <form action="{{ route('admin.managers.reactivate', $manager->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm">إعادة تفعيل</button>
                                        </form>

                                        <!-- الحذف النهائي -->
                                        <form action="{{ route('admin.managers.destroy', $manager->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت تأكد من حذف هذا الحساب نهائياً من قاعدة البيانات؟')">حذف نهائي</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>