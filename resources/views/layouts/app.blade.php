<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    @php
        $schoolBranding = auth()->user();

        if ($schoolBranding && $schoolBranding->role !== 'manager' && $schoolBranding->school_name) {
            $schoolBranding = \App\Models\User::where('role', 'manager')
                ->where('school_name', $schoolBranding->school_name)
                ->first() ?? $schoolBranding;
        }
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $schoolBranding->school_name ?? 'روضتي' }}</title>

    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        html body .dropdown-menu.manager-account-menu .dropdown-header {
            background-color: var(--primary-color) !important;
            border-radius: 0.375rem;
            color: #ffffff !important;
        }

        html body .dropdown-menu.manager-account-menu .dropdown-header strong,
        html body .dropdown-menu.manager-account-menu .dropdown-header small {
            color: #ffffff !important;
        }

        html body .dropdown-menu.manager-account-menu .dropdown-item:not(.text-danger):hover,
        html body .dropdown-menu.manager-account-menu .dropdown-item:not(.text-danger):focus,
        html body .dropdown-menu.manager-account-menu .dropdown-item:not(.text-danger):active {
            background-color: var(--primary-color) !important;
            color: #ffffff !important;
            -webkit-tap-highlight-color: transparent;
        }

        html body .dropdown-menu.manager-account-menu .dropdown-item:not(.text-danger):hover i,
        html body .dropdown-menu.manager-account-menu .dropdown-item:not(.text-danger):focus i,
        html body .dropdown-menu.manager-account-menu .dropdown-item:not(.text-danger):active i {
            color: #ffffff !important;
        }

        body {
            background-color: #f7f8fc;
            font-family: system-ui, -apple-system, sans-serif;
            color: #1f2937;
        }

        form[action$="/logout"] button[type="submit"],
        form[action$="/logout"] button[type="submit"]:hover,
        form[action$="/logout"] button[type="submit"]:focus,
        form[action$="/logout"] button[type="submit"]:active {
            background-color: #ffffff !important;
            border: 1px solid #d1d5db !important;
            color: #334155 !important;
        }

        /* تخصيص الروابط والأيقونات والعناصر لتأخذ اللون الأساسي تلقائياً */
        .text-primary-custom {
            color: var(--primary-color) !important;
        }

        .btn-primary-custom {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: #ffffff !important;
        }

        .btn-primary-custom:hover {
            opacity: 0.9;
            color: #ffffff !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.15);
        }
    </style>
</head>

<body style="--primary-color: {{ $schoolBranding->primary_color ?? '#2563eb' }};">

    <main>
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>