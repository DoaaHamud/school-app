{{-- filepath: c:\Users\VICTUS\Desktop\school\resources\views\layouts\app.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    @php
    $schoolBranding = auth()->user()?->school;
    @endphp

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $schoolBranding?->name ?? 'رفيق' }}</title>

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
            margin: 0;
        }

        form[action$="/logout"] button[type="submit"],
        form[action$="/logout"] button[type="submit"]:hover,
        form[action$="/logout"] button[type="submit"]:focus,
        form[action$="/logout"] button[type="submit"]:active {
            background-color: #ffffff !important;
            border: 1px solid #d1d5db !important;
            color: #334155 !important;
        }

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

        /* ==========================================
           تنسيقات الناف بار المركزية (الموحدة لكل صفحات الأم)
           ========================================== */
        .navbar-custom {
            background: #ffffff;
            min-height: 70px;
            padding: 0 35px;
            border-bottom: 3px solid var(--primary-color, #2563eb);
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
        }

        .school-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--primary-color, #2563eb);
            font-weight: 700;
            text-decoration: none;
        }

        .school-logo {
            width: 44px;
            height: 44px;
            flex: 0 0 44px;
            padding: 4px;
            border: 1px solid color-mix(in srgb, var(--primary-color, #2563eb) 20%, white);
            border-radius: 12px;
            object-fit: contain;
            background: #fff;
        }

        .school-brand-name {
            font-size: 16px;
            line-height: 1.25;
        }

        .school-brand-caption {
            display: block;
            margin-top: 3px;
            color: #64748b;
            font-size: 11px;
            font-weight: 500;
        }

        .nav-link {
            color: #4b5563;
            font-size: 15px;
            font-weight: 500;
            padding: 24px 15px !important;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color, #2563eb);
        }

        .mother-account {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 6px 12px;
            margin-left: 15px;
        }

        .mother-profile-btn {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 6px 8px;
            border: none;
            background: transparent;
            cursor: pointer;
            border-radius: 10px;
        }

        .mother-profile-btn:hover {
            background: #f8fafc;
        }

        .mother-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #eff6ff;
            color: var(--primary-color, #2563eb);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .mother-info {
            display: flex;
            flex-direction: column;
            text-align: right;
        }

        .mother-label {
            font-size: 13px;
            font-weight: 700;
            color: #334155;
        }

        .mother-role {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 2px;
        }

        .mother-dropdown {
            min-width: 235px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 8px;
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.10);
        }

        .mother-notifications-menu {
            width: min(340px, calc(100vw - 30px));
            padding: 8px;
        }

        .mother-notification-item {
            white-space: normal;
            border-radius: 8px;
        }

        .logout-btn {
            background: transparent;
            border: 1px solid #dc3545;
            color: #dc3545;
            border-radius: 7px;
            padding: 7px 15px;
            font-size: 13px;
            font-weight: 600;
        }

        .logout-btn:hover {
            background: #dc3545;
            color: white;
        }
    </style>
</head>

<body style="--primary-color: {{ $schoolBranding?->color ?? '#2563eb' }};">

    {{-- تضمين ناف بار الأم تلقائياً في صفحات الأم لتوحيد التصميم مركزياً --}}
    @auth

    @if(auth()->user()->role === 'mother' || request()->is('mother*'))
    @include('mother.navbar')
    @endif

    @if(auth()->user()->role === 'manager' || request()->is('manager*'))
    @include('manager.navbar')
    @endif


    @if(auth()->user()->role === 'teacher' || request()->is('teacher/*'))
    @include('teacher.navbar')
    @endif

    @endauth

    <main>
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelectorAll('[data-date-filter]').forEach((dateInput) => {
            const form = dateInput.closest('form');
            const dateValue = form.querySelector('input[type="hidden"][name="search_date"]');
            const isoDate = /^(\d{4})-(\d{2})-(\d{2})$/.exec(dateValue.value);

            if (isoDate) {
                dateInput.value = `${isoDate[3]}/${isoDate[2]}/${isoDate[1]}`;
            }

            form.addEventListener('submit', (event) => {
                const value = dateInput.value.trim();

                if (!value) {
                    dateValue.value = '';
                    return;
                }

                const dateParts = /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/.exec(value);

                if (!dateParts) {
                    event.preventDefault();
                    dateInput.setCustomValidity('أدخل التاريخ بالصيغة يوم/شهر/سنة.');
                    dateInput.reportValidity();
                    return;
                }

                const [, day, month, year] = dateParts;
                const date = new Date(0);
                date.setUTCHours(0, 0, 0, 0);
                date.setUTCFullYear(Number(year), Number(month) - 1, Number(day));

                if (
                    date.getUTCFullYear() !== Number(year) ||
                    date.getUTCMonth() !== Number(month) - 1 ||
                    date.getUTCDate() !== Number(day)
                ) {
                    event.preventDefault();
                    dateInput.setCustomValidity('أدخل تاريخًا صحيحًا بصيغة يوم/شهر/سنة.');
                    dateInput.reportValidity();
                    return;
                }

                dateInput.setCustomValidity('');
                dateValue.value = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
            });

            dateInput.addEventListener('input', () => dateInput.setCustomValidity(''));
        });
    </script>
</body>

</html>