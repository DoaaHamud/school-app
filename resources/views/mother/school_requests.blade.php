@extends('layouts.app')

@section('content')
<main class="container my-5" style="max-width: 850px;">
    <div class="d-flex align-items-center gap-3 mb-4">
        <div class="rounded-3 d-flex align-items-center justify-content-center text-white"
            style="width: 54px; height: 54px; background: var(--primary-color); font-size: 24px;">
            <i class="bi bi-building-add" aria-hidden="true"></i>
        </div>
        <div>
            <h1 class="h3 fw-bold mb-1">الانضمام إلى مدرسة جديدة</h1>
            <p class="text-muted mb-0">أرسلي طلبًا إلى المدرسة، وسيظهر حسابك للمعلمات بعد موافقة المدير.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill ms-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-exclamation-circle-fill ms-1"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger shadow-sm" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <section class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <h2 class="h5 fw-bold mb-2">اختيار المدرسة</h2>
            <p class="text-muted mb-3">حسابكِ لا يرتبط بمدرسة واحدة؛ يمكنكِ إرسال طلب لكل مدرسة تحتاجينها.</p>

            @if($availableSchools->isNotEmpty())
            <form action="{{ route('mother.school_requests.store') }}" method="POST" class="row g-3 align-items-end">
                @csrf
                <div class="col-md-8">
                    <label for="school_id" class="form-label fw-semibold">المدرسة</label>
                    <select id="school_id" name="school_id" class="form-select" required>
                        <option value="">اختاري المدرسة</option>
                        @foreach($availableSchools as $school)
                        <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                            {{ $school->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-auto">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-send ms-1"></i> إرسال الطلب
                    </button>
                </div>
            </form>
            @else
            <div class="alert alert-light border mb-0">لا توجد مدارس متاحة لطلب الانضمام إليها حاليًا.</div>
            @endif
        </div>
    </section>

    <section class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <h2 class="h5 fw-bold mb-3">طلبات الانضمام</h2>
            @if($schoolRequests->isEmpty())
            <p class="text-muted mb-0">لم ترسلي أي طلب انضمام حتى الآن.</p>
            @else
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>المدرسة</th>
                            <th>حالة الطلب</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schoolRequests as $schoolRequest)
                        <tr>
                            <td>{{ $schoolRequest->school->name }}</td>
                            <td>
                                @if($schoolRequest->status === 'pending')
                                <span class="badge text-bg-warning">بانتظار موافقة المدير</span>
                                @elseif($schoolRequest->status === 'approved')
                                <span class="badge text-bg-success">تمت الموافقة</span>
                                @else
                                <span class="badge text-bg-secondary">مرفوض</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </section>

    <a href="{{ route('mother.dashboard') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-right ms-1"></i> العودة إلى لوحة الأم
    </a>
</main>
@endsection
