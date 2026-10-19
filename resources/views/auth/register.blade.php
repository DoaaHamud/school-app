<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب جديد</title>
    <style>
        :root {
            color-scheme: light;
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            font-family: "Segoe UI", Tahoma, Arial, sans-serif;
            color: #172b3a;
            background: #f3f7f8;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 40px 18px;
            display: grid;
            place-items: center;
            background:
                radial-gradient(ellipse at 12% 10%, rgba(37, 99, 235, 0.10), transparent 34%),
                radial-gradient(ellipse at 90% 88%, rgba(52, 108, 145, 0.09), transparent 32%),
                #f3f7f8;
        }

        .register-card {
            width: min(100%, 620px);
            overflow: hidden;
            background: #fff;
            border: 1px solid #e5ecee;
            border-radius: 20px;
            box-shadow: 0 18px 55px rgba(29, 54, 67, 0.10);
        }

        .register-header {
            padding: 30px 32px 27px;
            color: #fff;
            text-align: center;
            background: linear-gradient(125deg, #1d4ed8, var(--primary-color));
        }

        .register-mark {
            width: 46px;
            height: 46px;
            margin: 0 auto 13px;
            display: grid;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.13);
            font-size: 23px;
            font-weight: 700;
        }

        .register-header h1 {
            margin: 0;
            font-size: clamp(20px, 4vw, 24px);
            font-weight: 700;
            line-height: 1.5;
        }

        .register-body {
            padding: 30px 36px 26px;
        }

        .form-field {
            margin-bottom: 18px;
        }

        .form-field label {
            display: block;
            margin-bottom: 8px;
            color: #263e4c;
            font-size: 14px;
            font-weight: 600;
        }

        .form-field input,
        .form-field select {
            width: 100%;
            min-height: 46px;
            padding: 10px 13px;
            border: 1px solid #d7e1e4;
            border-radius: 10px;
            outline: none;
            background: #fbfdfd;
            color: #172b3a;
            font: inherit;
            font-size: 15px;
            transition: border-color 160ms ease, box-shadow 160ms ease, background-color 160ms ease;
        }

        .form-field input::placeholder {
            color: #86969d;
        }

        .form-field input:focus,
        .form-field select:focus {
            border-color: var(--primary-color);
            outline: 3px solid rgba(37, 99, 235, 0.14);
            background: #fff;
        }

        .password-input-wrap {
            position: relative;
        }

        .password-input-wrap input {
            padding-right: 48px;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 8px;
            width: 34px;
            height: 34px;
            padding: 0;
            display: grid;
            place-items: center;
            transform: translateY(-50%);
            border: 0;
            border-radius: 8px;
            background: transparent;
            color: #617a82;
            cursor: pointer;
        }

        .password-toggle:hover {
            background: #eff6ff;
            color: var(--primary-color);
        }

        .password-toggle:focus-visible {
            outline: 3px solid rgba(37, 99, 235, 0.35);
            outline-offset: 1px;
        }

        .password-toggle svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 1.8;
        }

        .password-toggle .eye-slash {
            display: none;
        }

        .password-toggle[aria-pressed="true"] .eye-slash {
            display: block;
        }

        .validation-errors {
            margin-bottom: 22px;
            padding: 13px 16px;
            border: 1px solid #f2c5c5;
            border-radius: 10px;
            background: #fff5f5;
            color: #9c3030;
        }

        .validation-errors ul {
            margin: 0;
            padding-right: 19px;
        }

        .submit-button {
            width: 100%;
            min-height: 49px;
            margin-top: 3px;
            border: 0;
            border-radius: 10px;
            background: var(--primary-color);
            color: #fff;
            cursor: pointer;
            font: inherit;
            font-size: 16px;
            font-weight: 700;
            transition: background-color 160ms ease, transform 160ms ease, box-shadow 160ms ease;
        }

        .submit-button:hover {
            background: var(--primary-hover);
            box-shadow: 0 7px 17px rgba(37, 99, 235, 0.20);
        }

        .submit-button:active {
            transform: translateY(1px);
        }

        .submit-button:focus-visible,
        .register-footer a:focus-visible {
            outline: 3px solid rgba(37, 99, 235, 0.35);
            outline-offset: 3px;
        }

        .register-footer {
            padding: 18px 24px;
            border-top: 1px solid #edf1f2;
            background: #fbfcfc;
            color: #61727a;
            text-align: center;
            font-size: 14px;
        }

        .register-footer a {
            color: var(--primary-color);
            font-weight: 700;
            text-decoration: none;
        }

        .register-footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 520px) {
            body {
                padding: 18px 12px;
            }

            .register-card {
                border-radius: 16px;
            }

            .register-header {
                padding: 25px 20px 22px;
            }

            .register-body {
                padding: 24px 20px 22px;
            }

            .form-field {
                margin-bottom: 16px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>

<body>
    <main class="register-card">
        <header class="register-header">
            <div class="register-mark" aria-hidden="true">+</div>
            <h1>إنشاء حساب جديد في النظام المدرسي</h1>
        </header>
        <section class="register-body">

            @if ($errors->any())
            <div class="validation-errors" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="form-field">
                    <label for="name">الاسم الكامل</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" autocomplete="name" required>
                </div>

                <div class="form-field">
                    <label for="username">اسم المستخدم (Username)</label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}" autocomplete="username" required>
                </div>

                <div class="form-field">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="email" required>
                </div>

                <div class="form-field">
                    <label for="phone">رقم الهاتف</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" autocomplete="tel" required>
                </div>

                <div class="form-field">
                    <label for="role">نوع الحساب</label>
                    <select name="role" id="role" required>
                        <option value="" selected disabled>اختر نوع الحساب...</option>
                        <option value="mother" {{ old('role') == 'mother' ? 'selected' : '' }}>ولي أمر (تفعيل فورياً)</option>
                        <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>أستاذ (بانتظار موافقة المدير)</option>
                        <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>مدير مدرسة (بانتظار موافقة الأدمن)</option>
                    </select>
                </div>

                <div class="form-field">
                    <label for="school_name">اسم المدرسة (مطلوب للمعلمات، اختياري للمدراء)</label>
                    <input type="text" name="school_name" id="school_name" list="approved-school-names" value="{{ old('school_name') }}" autocomplete="organization">
                    <datalist id="approved-school-names">
                        @foreach($schoolNames as $schoolName)
                        <option value="{{ $schoolName }}">
                        @endforeach
                    </datalist>
                </div>

                <div class="form-field">
                    <label for="password">كلمة المرور</label>
                    <div class="password-input-wrap">
                        <input type="password" name="password" id="password" autocomplete="new-password" required>
                        <button type="button" class="password-toggle" aria-label="إظهار كلمة المرور" aria-pressed="false" data-show-label="إظهار كلمة المرور" data-hide-label="إخفاء كلمة المرور">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                                <path class="eye-slash" d="m3 3 18 18"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="form-field">
                    <label for="password_confirmation">تأكيد كلمة المرور</label>
                    <div class="password-input-wrap">
                        <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" required>
                        <button type="button" class="password-toggle" aria-label="إظهار تأكيد كلمة المرور" aria-pressed="false" data-show-label="إظهار تأكيد كلمة المرور" data-hide-label="إخفاء تأكيد كلمة المرور">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                                <path class="eye-slash" d="m3 3 18 18"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="submit-button">إنشاء الحساب</button>
            </form>

        </section>
        <footer class="register-footer">
            لديك حساب بالفعل؟ <a href="{{ route('login') }}">تسجيل الدخول</a>
        </footer>
    </main>
    <script>
        const roleInput = document.getElementById('role');
        const schoolNameInput = document.getElementById('school_name');

        const updateSchoolRequirement = () => {
            const isTeacher = roleInput.value === 'teacher';
            schoolNameInput.required = isTeacher;
            schoolNameInput.setAttribute('aria-required', String(isTeacher));
        };

        roleInput.addEventListener('change', updateSchoolRequirement);
        updateSchoolRequirement();

        document.querySelectorAll('.password-toggle').forEach((toggle) => {
            toggle.addEventListener('click', () => {
                const passwordInput = toggle.parentElement.querySelector('input');
                const isPasswordHidden = passwordInput.type === 'password';

                passwordInput.type = isPasswordHidden ? 'text' : 'password';
                toggle.setAttribute('aria-pressed', String(isPasswordHidden));
                toggle.setAttribute('aria-label', isPasswordHidden ? toggle.dataset.hideLabel : toggle.dataset.showLabel);
                passwordInput.focus();
            });
        });
    </script>
</body>

</html>