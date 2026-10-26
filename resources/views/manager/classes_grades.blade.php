@extends('layouts.app')

@section('content')


<!-- Content -->
<div class="container my-4" style="max-width: 1200px;">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="h4 fw-bold m-0 text-dark">
            <i class="bi bi-award me-2" style="color: var(--primary-color);"></i> علامات وتقييمات طلاب الصف: {{ $className }}
        </h2>
        <a href="{{ route('manager.students') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 rounded-3 fw-semibold">
            <i class="bi bi-arrow-right ms-1"></i> العودة لدليل الطلاب
        </a>
    </div>

    <!-- بطاقة البحث والتصفية -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('manager.classes.grades', $className) }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold small text-secondary">اسم الطالب</label>
                    <input type="text" name="search_name" class="form-control" placeholder="ابحث باسم الطالب..." value="{{ $searchName ?? '' }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold small text-secondary">اسم المادة / النشاط</label>
                    <input type="text" name="search_topic" class="form-control" placeholder="ابحث بالمادة..." value="{{ $searchTopic ?? '' }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold small text-secondary">العام الدراسي</label>
                    <select name="year" class="form-select">
                        @for($i = date('Y') - 5; $i <= date('Y') + 1; $i++)
                            <option value="{{ $i }}" {{ (int)($selectedYear ?? date('Y')) == $i ? 'selected' : '' }}>
                            العام الدراسي {{ $i }}
                            </option>
                            @endfor
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn text-white fw-bold w-100 py-2" style="background-color: var(--primary-color) !important; border-color: var(--primary-color) !important; border-radius: 9px;">
                        <i class="bi bi-search ms-1"></i> بحث
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- جدول النتائج -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>اسم الطالب</th>
                            <th>موضوع النشاط / المادة</th>
                            <th>النتيجة / العلامة</th>
                            <th>تاريخ التقييم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $counter = 1; @endphp
                        @forelse($students as $student)
                        @foreach($student->dailyVariables as $daily)
                        <tr>
                            <td>{{ $counter++ }}</td>
                            <td class="fw-bold text-dark">{{ $student->name }}</td>
                            <td>{{ $daily->topic ?? '-' }}</td>
                            <td>
                                <span class="badge text-white px-3 py-2 rounded-pill fw-bold" style="background-color: var(--primary-color) !important; font-size: 13px;">{{ $daily->result ?? '-' }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($daily->report_date)->format('Y-m-d') }}</td>
                        </tr>
                        @endforeach
                        @empty
                        <tr>
                            <td colspan="5" class="py-4 text-muted">لا توجد علامات مسجلة مطابقة للبحث.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Delete Manager Account Modal -->
<div class="modal fade" id="deleteManagerModal" tabindex="-1" aria-labelledby="deleteManagerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fs-6" id="deleteManagerModalLabel"><i class="bi bi-exclamation-triangle-fill ms-1"></i> حذف الحساب</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="bi bi-trash3-fill text-danger display-4 mb-3 d-block"></i>
                <h5 class="mb-2 fw-bold text-dark">هل أنت متأكد من حذف حسابك؟</h5>
                <p class="text-muted small mb-0">سيتم حذف حساب المدير نهائيًا، ولا يمكن التراجع عن هذه العملية.</p>
            </div>
            <div class="modal-footer justify-content-center border-0 bg-light">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">إلغاء</button>
                <form action="{{ route('manager.profile.delete') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4">نعم، حذف الحساب</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection