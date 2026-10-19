@extends('layouts.app')

@section('content')
<style>
    .welcome-page {
        --welcome-ink: #172033;
        --welcome-muted: #667085;
        overflow: hidden;
        background:
            radial-gradient(circle at 8% 10%, rgba(250, 204, 116, 0.18), transparent 25rem),
            radial-gradient(circle at 92% 25%, color-mix(in srgb, var(--primary-color) 13%, transparent), transparent 28rem),
            #fbfcff;
        color: var(--welcome-ink);
    }

    .welcome-page a {
        text-decoration: none;
    }

    .welcome-nav {
        min-height: 82px;
    }

    .welcome-brand-mark {
        display: grid;
        width: 46px;
        height: 46px;
        place-items: center;
        border-radius: 16px;
        background: var(--primary-color);
        box-shadow: 0 10px 24px color-mix(in srgb, var(--primary-color) 26%, transparent);
        color: white;
        font-size: 1.35rem;
    }

    .welcome-brand-name {
        color: var(--welcome-ink);
        font-size: 1.15rem;
        font-weight: 850;
    }

    .welcome-brand-caption {
        color: var(--welcome-muted);
        font-size: 0.76rem;
    }

    .welcome-login {
        color: var(--welcome-ink);
        font-weight: 700;
    }

    .welcome-primary-button {
        border: 0;
        background: var(--primary-color);
        box-shadow: 0 10px 22px color-mix(in srgb, var(--primary-color) 24%, transparent);
        color: #fff;
        font-weight: 750;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .welcome-primary-button:hover,
    .welcome-primary-button:focus-visible {
        transform: translateY(-2px);
        background: var(--primary-color);
        box-shadow: 0 14px 28px color-mix(in srgb, var(--primary-color) 32%, transparent);
        color: #fff;
    }

    .welcome-hero {
        position: relative;
        padding-top: clamp(3rem, 7vw, 6.5rem);
        padding-bottom: clamp(4rem, 8vw, 7rem);
    }

    .welcome-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.55rem 0.9rem;
        border: 1px solid color-mix(in srgb, var(--primary-color) 18%, white);
        border-radius: 999px;
        background: #fff;
        color: var(--primary-color);
        font-size: 0.88rem;
        font-weight: 750;
    }

    .welcome-title {
        max-width: 700px;
        margin-top: 1.25rem;
        font-size: clamp(2.4rem, 5.7vw, 4.5rem);
        font-weight: 900;
        line-height: 1.23;
        letter-spacing: -0.045em;
    }

    .welcome-title span {
        color: var(--primary-color);
    }

    .welcome-description {
        max-width: 590px;
        margin-top: 1.2rem;
        color: var(--welcome-muted);
        font-size: clamp(1rem, 1.6vw, 1.15rem);
        line-height: 1.95;
    }

    .welcome-hero-art {
        position: relative;
        display: grid;
        min-height: 390px;
        place-items: center;
    }

    .welcome-art-orbit {
        position: absolute;
        width: min(88%, 390px);
        aspect-ratio: 1;
        border: 1px dashed color-mix(in srgb, var(--primary-color) 25%, transparent);
        border-radius: 50%;
    }

    .welcome-art-card {
        position: relative;
        z-index: 1;
        width: min(86%, 380px);
        padding: 1.35rem;
        border: 1px solid rgba(255, 255, 255, 0.8);
        border-radius: 28px;
        background: rgba(255, 255, 255, 0.92);
        box-shadow: 0 28px 70px rgba(31, 41, 55, 0.13);
        transform: rotate(-2deg);
    }

    .welcome-art-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 1rem;
        border-bottom: 1px solid #edf0f5;
    }

    .welcome-art-avatar {
        display: grid;
        width: 47px;
        height: 47px;
        place-items: center;
        border-radius: 16px;
        background: #fff0d8;
        color: #d89122;
        font-size: 1.5rem;
    }

    .welcome-art-lines {
        flex: 1;
        margin-right: 0.8rem;
    }

    .welcome-art-lines span,
    .welcome-art-line {
        display: block;
        height: 9px;
        border-radius: 20px;
        background: #edf0f5;
    }

    .welcome-art-lines span:first-child {
        width: 62%;
        margin-bottom: 8px;
        background: #dfe5ee;
    }

    .welcome-art-lines span:last-child {
        width: 40%;
        height: 7px;
    }

    .welcome-art-report {
        margin-top: 1rem;
        padding: 1rem;
        border-radius: 19px;
        background: #f7f9fc;
    }

    .welcome-art-report-heading {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        margin-bottom: 0.9rem;
        color: var(--welcome-ink);
        font-size: 0.88rem;
        font-weight: 800;
    }

    .welcome-art-report-heading i {
        color: var(--primary-color);
        font-size: 1.1rem;
    }

    .welcome-art-line {
        width: 100%;
        margin-top: 8px;
    }

    .welcome-art-line.short {
        width: 72%;
    }

    .welcome-art-note {
        display: flex;
        align-items: flex-start;
        gap: 0.65rem;
        margin-top: 0.9rem;
        padding: 0.8rem;
        border-radius: 15px;
        background: color-mix(in srgb, var(--primary-color) 8%, white);
        color: #455064;
        font-size: 0.8rem;
        line-height: 1.7;
    }

    .welcome-art-note i {
        color: var(--primary-color);
        font-size: 1rem;
    }

    .welcome-float {
        position: absolute;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.75rem 1rem;
        border: 1px solid #f0f1f4;
        border-radius: 16px;
        background: white;
        box-shadow: 0 14px 35px rgba(31, 41, 55, 0.1);
        color: var(--welcome-ink);
        font-size: 0.85rem;
        font-weight: 750;
    }

    .welcome-float i {
        color: var(--primary-color);
        font-size: 1.15rem;
    }

    .welcome-float-one {
        top: 11%;
        right: 0;
    }

    .welcome-float-two {
        bottom: 11%;
        left: 0;
    }

    .welcome-section {
        padding: clamp(3rem, 6vw, 5.5rem) 0;
    }

    .welcome-section-heading {
        max-width: 670px;
        margin: 0 auto 2.5rem;
        text-align: center;
    }

    .welcome-section-heading h2 {
        font-size: clamp(1.8rem, 3vw, 2.5rem);
        font-weight: 850;
    }

    .welcome-section-heading p {
        margin: 0.8rem 0 0;
        color: var(--welcome-muted);
        line-height: 1.8;
    }

    .welcome-feature-card {
        height: 100%;
        padding: 1.6rem;
        border: 1px solid #eef0f4;
        border-radius: 22px;
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 12px 34px rgba(31, 41, 55, 0.045);
    }

    .welcome-feature-icon {
        display: grid;
        width: 52px;
        height: 52px;
        margin-bottom: 1.1rem;
        place-items: center;
        border-radius: 17px;
        background: color-mix(in srgb, var(--primary-color) 10%, white);
        color: var(--primary-color);
        font-size: 1.35rem;
    }

    .welcome-feature-card h3 {
        font-size: 1.05rem;
        font-weight: 800;
    }

    .welcome-feature-card p {
        margin: 0;
        color: var(--welcome-muted);
        line-height: 1.8;
    }

    .welcome-steps {
        border-radius: 28px;
        background: #fff;
        box-shadow: 0 16px 45px rgba(31, 41, 55, 0.06);
    }

    .welcome-step-number {
        display: grid;
        width: 42px;
        height: 42px;
        margin-bottom: 0.9rem;
        place-items: center;
        border-radius: 50%;
        background: var(--primary-color);
        color: #fff;
        font-weight: 850;
    }

    .welcome-step h3 {
        font-size: 1rem;
        font-weight: 800;
    }

    .welcome-step p {
        margin: 0;
        color: var(--welcome-muted);
        line-height: 1.75;
    }

    .welcome-cta {
        position: relative;
        overflow: hidden;
        border-radius: 28px;
        background: var(--primary-color);
        color: #fff;
    }

    .welcome-cta::after {
        position: absolute;
        top: -100px;
        left: -60px;
        width: 260px;
        height: 260px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        content: "";
    }

    .welcome-cta p {
        color: rgba(255, 255, 255, 0.82);
    }

    .welcome-footer {
        color: var(--welcome-muted);
    }

    @media (max-width: 767.98px) {
        .welcome-hero {
            padding-top: 2.5rem;
        }

        .welcome-hero-art {
            min-height: 330px;
            margin-top: 1rem;
        }

        .welcome-float-one {
            right: 1%;
        }

        .welcome-float-two {
            left: 1%;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .welcome-primary-button {
            transition: none;
        }
    }
</style>

<div class="welcome-page">
    <header class="container">
        <nav class="welcome-nav d-flex align-items-center justify-content-between" aria-label="القائمة الرئيسية">
            <a href="{{ route('home') }}" class="d-flex align-items-center gap-2">
                <span class="welcome-brand-mark"><i class="bi bi-balloon-heart-fill" aria-hidden="true"></i></span>
                <span class="d-flex flex-column">
                    <span class="welcome-brand-name">رفيق</span>
                    <span class="welcome-brand-caption">معًا لنموٍ أجمل</span>
                </span>
            </a>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('login') }}" class="welcome-login d-none d-sm-inline">تسجيل الدخول</a>
                <a href="{{ route('register') }}" class="btn welcome-primary-button rounded-pill px-4 py-2">إنشاء حساب</a>
            </div>
        </nav>
    </header>

    <main>
        <section class="welcome-hero container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <span class="welcome-eyebrow"><i class="bi bi-stars" aria-hidden="true"></i> رعاية وتعليم في مكان واحد</span>
                    <h1 class="welcome-title">لكل مرحلة دراسية، <span>خطوة أجمل</span></h1>
                    <p class="welcome-description">
                        منصة رفيق تجمع أولياء الأمور والمعلمين وإدارة المدرسة، لمتابعة تعلم الطلاب وتفاصيل يومهم والتواصل بسهولة واطمئنان.
                    </p>
                    <div class="d-flex flex-wrap align-items-center gap-3 mt-4">
                        <a href="{{ route('register') }}" class="btn welcome-primary-button rounded-pill px-4 py-3">
                            ابدأ رحلتك الآن <i class="bi bi-arrow-left me-2" aria-hidden="true"></i>
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary rounded-pill px-4 py-3">لديك حساب؟ ادخل</a>
                    </div>
                    <div class="d-flex flex-wrap gap-4 mt-4 text-secondary small">
                        <span><i class="bi bi-check-circle-fill ms-1 text-success" aria-hidden="true"></i> متابعة يومية واضحة</span>
                        <span><i class="bi bi-check-circle-fill ms-1 text-success" aria-hidden="true"></i> تواصل مباشر وآمن</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="welcome-hero-art" aria-hidden="true">
                        <div class="welcome-art-orbit"></div>
                        <div class="welcome-float welcome-float-one"><i class="bi bi-chat-heart-fill"></i> تواصل مع المعلمة</div>
                        <div class="welcome-float welcome-float-two"><i class="bi bi-emoji-smile-fill"></i> يوم مليء بالتعلّم</div>
                        <div class="welcome-art-card">
                            <div class="welcome-art-top">
                                <div class="welcome-art-avatar"><i class="bi bi-person-fill"></i></div>
                                <div class="welcome-art-lines"><span></span><span></span></div>
                                <i class="bi bi-bell-fill text-warning"></i>
                            </div>
                            <div class="welcome-art-report">
                                <div class="welcome-art-report-heading"><i class="bi bi-calendar2-check-fill"></i> ملخص اليوم الدراسي</div>
                                <div class="welcome-art-line"></div>
                                <div class="welcome-art-line short"></div>
                                <div class="welcome-art-note">
                                    <i class="bi bi-chat-square-heart-fill"></i>
                                    <span>شارك في الأنشطة وتعلّم شيئًا جديدًا اليوم!</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="welcome-section bg-white">
            <div class="container">
                <div class="welcome-section-heading">
                    <h2>كل ما يحتاجه مجتمع المدرسة</h2>
                    <p>أدوات بسيطة تساعد الأسرة والمعلمين والإدارة على متابعة الطلاب والتعاون من أجل تجربة تعليمية أفضل.</p>
                </div>
                <div class="row g-3 g-lg-4">
                    <div class="col-md-6 col-lg-4">
                        <article class="welcome-feature-card">
                            <span class="welcome-feature-icon"><i class="bi bi-journal-richtext" aria-hidden="true"></i></span>
                            <h3>متابعة اليوم الدراسي</h3>
                            <p>اطّلعوا على الأنشطة والتقارير اليومية وملاحظات المعلمين في مكان واحد.</p>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <article class="welcome-feature-card">
                            <span class="welcome-feature-icon"><i class="bi bi-chat-dots-fill" aria-hidden="true"></i></span>
                            <h3>تواصل متبادل</h3>
                            <p>أرسلوا ملاحظاتكم للمعلمة المختصة وتابعوا ردودها بسهولة.</p>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <article class="welcome-feature-card">
                            <span class="welcome-feature-icon"><i class="bi bi-people-fill" aria-hidden="true"></i></span>
                            <h3>إدارة منظمة</h3>
                            <p>تساعد المدرسة على تنظيم الصفوف والطلاب والمعلمين ومتابعة تقدمهم.</p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section class="welcome-section">
            <div class="container">
                <div class="welcome-section-heading">
                    <h2>بداية سهلة للجميع</h2>
                    <p>خطوات قليلة لتكونوا على اتصال دائم بالرحلة التعليمية لأبنائكم.</p>
                </div>
                <div class="welcome-steps p-4 p-lg-5">
                    <div class="row g-4">
                        <div class="col-md-4 welcome-step">
                            <span class="welcome-step-number">١</span>
                            <h3>أنشئ حسابك</h3>
                            <p>اختر نوع الحساب المناسب: ولي أمر أو معلم أو مدير مدرسة.</p>
                        </div>
                        <div class="col-md-4 welcome-step">
                            <span class="welcome-step-number">٢</span>
                            <h3>انضم إلى مجتمع مدرستك</h3>
                            <p>أكمل بياناتك، وسيتم ربطك بالمدرسة والصف المناسبين.</p>
                        </div>
                        <div class="col-md-4 welcome-step">
                            <span class="welcome-step-number">٣</span>
                            <h3>تابع وشارك</h3>
                            <p>تابع المستجدات اليومية وتواصل مع فريق المدرسة بكل سهولة.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="container pb-5">
            <div class="welcome-cta p-4 p-lg-5 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4">
                <div class="position-relative" style="z-index: 1;">
                    <h2 class="h3 fw-bold mb-2">جاهزون لرحلة تعليمية أجمل؟</h2>
                    <p class="mb-0">أنشئ حسابك وابدأ بالتواصل والمتابعة اليوم.</p>
                </div>
                <a href="{{ route('register') }}" class="btn btn-light rounded-pill px-4 py-3 fw-bold position-relative" style="z-index: 1;">
                    إنشاء حساب جديد <i class="bi bi-arrow-left me-2" aria-hidden="true"></i>
                </a>
            </div>
        </section>
    </main>

    <footer class="container welcome-footer py-4 border-top text-center small">
        رفيق — شراكة أقرب لمستقبل الطلاب
    </footer>
</div>
@endsection
