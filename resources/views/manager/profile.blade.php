<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>الملف الشخصي - روضتي</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background: #f8fafc;
            font-family: Arial, sans-serif;
        }

        .profile-container {
            max-width: 750px;
            margin: 50px auto;
        }

        .profile-card {
            background: white;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.08);
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 30px;
        }

        .profile-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;

            background: #eef2ff;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #4f46e5;
            font-size: 30px;
        }

        .profile-header h3 {
            margin: 0;
            color: #1e293b;
            font-size: 22px;
        }

        .profile-header p {
            margin: 5px 0 0;
            color: #64748b;
            font-size: 14px;
        }

        .info-box {
            background: #f8fafc;
            border-radius: 12px;
            padding: 15px 18px;
            margin-bottom: 15px;
        }

        .info-label {
            display: block;
            color: #64748b;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .info-value {
            color: #1e293b;
            font-size: 15px;
            font-weight: 600;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn-edit {
            background: #4f46e5;
            color: white;
            border: none;
        }

        .btn-edit:hover {
            background: #4338ca;
            color: white;
        }

        .btn-back {
            background: #f1f5f9;
            color: #334155;
        }

        .btn-back:hover {
            background: #e2e8f0;
        }
    </style>

</head>

<body>

    <div class="container profile-container">

        <div class="profile-card">

            <!-- العنوان -->

            <div class="profile-header">

                <div class="profile-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>

                <div>

                    <h3>
                        {{ $manager->name }}
                    </h3>

                    <p>
                        مدير الروضة
                    </p>

                </div>

            </div>


            <!-- الاسم -->

            <div class="info-box">

                <span class="info-label">
                    الاسم
                </span>

                <span class="info-value">
                    {{ $manager->name }}
                </span>

            </div>


            <!-- البريد -->

            <div class="info-box">

                <span class="info-label">
                    البريد الإلكتروني
                </span>

                <span class="info-value">
                    {{ $manager->email }}
                </span>

            </div>


            <!-- رقم الهاتف -->

            <div class="info-box">

                <span class="info-label">
                    رقم الهاتف
                </span>

                <span class="info-value">

                    {{ $manager->phone ?? 'غير مضاف' }}

                </span>

            </div>


            <!-- الدور -->

            <div class="info-box">

                <span class="info-label">
                    الدور
                </span>

                <span class="info-value">
                    مدير
                </span>

            </div>


            <!-- الأزرار -->

            <div class="actions">

                <a
                    href="{{ route('manager.profile.edit') }}"
                    class="btn btn-edit">

                    <i class="bi bi-pencil-square"></i>

                    تعديل البيانات

                </a>


                <a
                    href="{{ route('manager.dashboard') }}"
                    class="btn btn-back">

                    العودة للوحة التحكم

                </a>

            </div>

        </div>

    </div>

</body>

</html>