@extends('layouts.app')

@section('content')
<style>
    .btn-deactivate {
        background-color: color-mix(in srgb, var(--primary-color) 16%, white);
        border-color: color-mix(in srgb, var(--primary-color) 35%, white);
        color: var(--primary-color);
    }

    .btn-deactivate:hover,
    .btn-deactivate:focus {
        background-color: color-mix(in srgb, var(--primary-color) 26%, white);
        border-color: color-mix(in srgb, var(--primary-color) 45%, white);
        color: var(--primary-color);
    }

    .class-toggle {
        color: #fff;
        text-align: right;
    }

    .class-toggle:hover,
    .class-toggle:focus {
        color: #fff;
    }

    .school-color-btn {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        color: #fff !important;
    }

    .school-color-btn:hover,
    .school-color-btn:focus {
        filter: brightness(0.9);
        color: #fff !important;
    }
</style>

<div class="container page-container my-4" style="max-width: 1300px;">

    @if(session('success'))
    <div class="alert alert-success shadow-sm mb-4">
        <i class="bi bi-check-circle-fill ms-1"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h1 class="page-title fw-bold mb-1" style="font-size: 26px; color: #1f2937;">
                دليل الطلاب
            </h1>
            <p class="page-subtitle text-muted small mb-0">
                عرض وإدارة بيانات الطلاب والتقارير اليومية بحسب الصفوف الدراسية
            </p>
        </div>

        <a href="{{ route('manager.students.deactivated') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-person-x ms-1"></i>
            الطلاب غير المفعلين
            <span class="badge bg-secondary ms-1">{{ $deactivatedStudentsCount }}</span>
        </a>
    </div>

    <div class="task-card shadow-sm rounded-4 mb-4" style="background: white; border: 1px solid #e8eaf0;">
        <div class="p-3 border-bottom bg-light fw-bold text-secondary rounded-top-4">
            <i class="bi bi-funnel-fill ms-1" style="color: var(--primary-color);"></i>
            البحث والتصفية
        </div>

        <div class="p-3">
            <form method="GET" action="{{ route('manager.students') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-secondary small">اسم الطالب</label>
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="ابحث باسم الطالب..."
                            value="{{ $search ?? '' }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-secondary small">الصف الدراسي</label>
                        <select name="class" class="form-select">
                            <option value="">-- كل الصفوف --</option>
                            @foreach($classes as $classNameOpt)
                            <option value="{{ $classNameOpt }}" {{ ($class ?? '') == $classNameOpt ? 'selected' : '' }}>
                                {{ $classNameOpt }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold text-secondary small">الشعبة</label>
                        <select name="section" class="form-select">
                            <option value="">-- كل الشُعَب --</option>
                            @foreach($sections as $sectionOption)
                            <option value="{{ $sectionOption }}" {{ ($selectedSection ?? '') === $sectionOption ? 'selected' : '' }}>
                                {{ $sectionOption }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold text-secondary small">السنة الدراسية</label>
                        <input
                            type="number"
                            name="year"
                            class="form-control"
                            value="{{ $year ?? date('Y') }}">
                    </div>

                    <div class="col-md-2">
                        <button
                            type="submit"
                            class="btn text-white fw-bold w-100 py-2"
                            style="background-color: var(--primary-color) !important; border-color: var(--primary-color) !important; border-radius: 9px;">
                            <i class="bi bi-search ms-1"></i>
                            بحث
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @php
    $studentsGroupedByClass = $groupedStudents->groupBy('className');
    @endphp

    @forelse($studentsGroupedByClass as $sectionsForClass)
    @php
    $className = $sectionsForClass->first()['className'];
    $classCollapseId = 'class-sections-' . $loop->index;
    @endphp

    <section class="task-card rounded-4 border shadow-sm mb-4 overflow-hidden bg-white">
        <h2 class="m-0">
            <button
                type="button"
                class="btn class-toggle w-100 text-end fw-bold p-3 d-flex align-items-center gap-2"
                style="background-color: var(--primary-color) !important;"
                data-bs-toggle="collapse"
                data-bs-target="#{{ $classCollapseId }}"
                aria-expanded="false"
                aria-controls="{{ $classCollapseId }}">
                <i class="bi bi-mortarboard-fill"></i>
                <span>الصف: {{ $className ?: 'غير محدد' }}</span>
                <span class="badge bg-light text-dark rounded-pill">
                    {{ $sectionsForClass->count() }} شعبة
                </span>
                <i class="bi bi-chevron-down me-auto"></i>
            </button>
        </h2>

        <div class="collapse" id="{{ $classCollapseId }}">
            <div class="p-3">
                @foreach($sectionsForClass as $sectionGroup)
                @php
                $sectionName = $sectionGroup['sectionName'];
                $classStudents = $sectionGroup['students'];
                $sectionCollapseId = $classCollapseId . '-students-' . $loop->index;
                @endphp

                <section class="border rounded-4 mb-3 overflow-hidden">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 p-3 bg-light">
                        <button
                            type="button"
                            class="btn btn-link text-dark text-decoration-none p-0 fw-bold d-flex align-items-center gap-2"
                            data-bs-toggle="collapse"
                            data-bs-target="#{{ $sectionCollapseId }}"
                            aria-expanded="false"
                            aria-controls="{{ $sectionCollapseId }}">
                            <i class="bi bi-diagram-3" style="color: var(--primary-color);"></i>
                            <span>الشعبة: {{ $sectionName ?: 'غير محددة' }}</span>
                            <span class="badge bg-secondary rounded-pill">
                                {{ $classStudents->count() }} طالب
                            </span>
                            <i class="bi bi-chevron-down"></i>
                        </button>

                        <div class="d-flex flex-wrap gap-2">
                            <a
                                href="{{ route('manager.classes.grades',[ 'className' => $className, 'section' => $sectionName]) }}"
                                class="btn btn-sm school-color-btn">
                                <i class="bi bi-award ms-1"></i>
                                عرض العلامات
                            </a>

                            <a
                                href="{{ route('manager.classes.notes',[ 'className' => $className, 'section' => $sectionName]) }}"
                                class="btn btn-sm school-color-btn">
                                <i class="bi bi-journal-text ms-1"></i>
                                عرض الملاحظات
                            </a>

                            <a
                                href="{{ route('manager.classes.mother-notes', ['className' => $className, 'section' => $sectionName]) }}"
                                class="btn btn-sm school-color-btn">
                                <i class="bi bi-chat-left-dots ms-1"></i>
                                ملاحظات الأهالي
                            </a>
                        </div>
                    </div>

                    <div class="collapse" id="{{ $sectionCollapseId }}">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>اسم الطالب</th>
                                        <th>الجنس</th>
                                        <th>العمر</th>
                                        <th>الحالة الصحية</th>
                                        <th>المعدل العام للطالب</th>
                                        <th>ولي الأمر</th>
                                        <th>المتغيرات اليومية</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($classStudents as $studentIndex => $student)
                                    @php
                                    $avgResult = $student->dailyVariables->isNotEmpty()
                                    ? number_format($student->dailyVariables->avg('result'), 1)
                                    : null;

                                    $genderArabic = '-';

                                    if (!empty($student->gender)) {
                                    $gender = strtolower(trim($student->gender));

                                    if (in_array($gender, ['male', 'ذكر', '1', 'm'])) {
                                    $genderArabic = 'ذكر';
                                    } elseif (in_array($gender, ['female', 'أنثى', '0', 'f'])) {
                                    $genderArabic = 'أنثى';
                                    } else {
                                    $genderArabic = $student->gender;
                                    }
                                    }
                                    @endphp

                                    <tr>
                                        <td>{{ $studentIndex + 1 }}</td>
                                        <td class="fw-bold text-dark">{{ $student->name }}</td>
                                        <td>{{ $genderArabic }}</td>
                                        <td>{{ $student->age ?? '-' }}</td>
                                        <td>{{ $student->health_status ?? 'جيدة' }}</td>
                                        <td>
                                            @if($avgResult)
                                            <span
                                                class="badge text-white px-3 py-2 rounded-pill fw-bold"
                                                style="background-color: var(--primary-color) !important;">
                                                {{ $avgResult }}
                                            </span>
                                            @else
                                            <span class="text-muted small">لا توجد علامات</span>
                                            @endif
                                        </td>
                                        <td>{{ $student->mother?->name ?? '-' }}</td>
                                        <td>
                                            @if($student->dailyVariables->isNotEmpty())
                                            <a
                                                href="{{ route('manager.students.profile', $student->id) }}"
                                                class="btn btn-sm text-white px-3 py-1 fw-bold"
                                                style="font-size: 12px; border-radius: 20px; background-color: var(--primary-color) !important;">
                                                <i class="bi bi-eye ms-1"></i>
                                                عرض البيانات ({{ $student->dailyVariables->count() }})
                                            </a>
                                            @else
                                            <span class="text-muted small">لا توجد بيانات</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-deactivate px-2 py-1"
                                                style="font-size: 12px; border-radius: 8px;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deactivateStudentModal{{ $student->id }}">
                                                <i class="bi bi-person-x"></i>
                                                إلغاء التفعيل
                                            </button>

                                            <div
                                                class="modal fade"
                                                id="deactivateStudentModal{{ $student->id }}"
                                                tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content border-0 shadow rounded-4">
                                                        <div class="modal-header bg-warning text-dark">
                                                            <h5 class="modal-title fs-6">
                                                                <i class="bi bi-exclamation-triangle-fill ms-1"></i>
                                                                تأكيد إلغاء التفعيل
                                                            </h5>
                                                            <button
                                                                type="button"
                                                                class="btn-close"
                                                                data-bs-dismiss="modal"
                                                                aria-label="إغلاق"></button>
                                                        </div>

                                                        <div class="modal-body text-center py-4">
                                                            <i class="bi bi-person-x-fill text-warning display-4"></i>
                                                            <h5 class="mt-3 mb-2 fw-bold text-dark">
                                                                هل تريد إلغاء تفعيل الطالب ({{ $student->name }})؟
                                                            </h5>
                                                            <p class="text-muted mb-0 small">
                                                                سيختفي من القوائم النشطة مع الاحتفاظ ببياناته وتقاريره، ويمكن إعادة تفعيله لاحقًا.
                                                            </p>
                                                        </div>

                                                        <div class="modal-footer justify-content-center border-0 bg-light">
                                                            <button
                                                                type="button"
                                                                class="btn btn-secondary px-4"
                                                                data-bs-dismiss="modal">
                                                                إلغاء
                                                            </button>

                                                            <form
                                                                action="{{ route('manager.students.deactivate', $student->id) }}"
                                                                method="POST"
                                                                class="d-inline">
                                                                @csrf
                                                                @method('PATCH')

                                                                <button type="submit" class="btn btn-deactivate px-4">
                                                                    <i class="bi bi-person-x"></i>
                                                                    نعم، إلغاء التفعيل
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                @endforeach
            </div>
        </div>
    </section>
    @empty
    <div class="task-card text-center py-5 rounded-4 bg-white border">
        <i class="bi bi-emoji-neutral fs-1 text-muted"></i>
        <div class="mt-2 text-muted">
            لا توجد نتائج مطابقة للبحث أو لا يوجد طلاب مضافون.
        </div>
    </div>
    @endforelse
</div>

<div
    class="modal fade"
    id="deleteManagerModal"
    tabindex="-1"
    aria-labelledby="deleteManagerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fs-6" id="deleteManagerModalLabel">
                    <i class="bi bi-exclamation-triangle-fill ms-1"></i>
                    حذف الحساب
                </h5>
                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"
                    aria-label="إغلاق"></button>
            </div>

            <div class="modal-body text-center py-4">
                <i class="bi bi-trash3-fill text-danger display-4 mb-3 d-block"></i>
                <h5 class="mb-2 fw-bold text-dark">هل أنت متأكد من حذف حسابك؟</h5>
                <p class="text-muted small mb-0">
                    سيتم حذف حساب المدير نهائيًا، ولا يمكن التراجع عن هذه العملية.
                </p>
            </div>

            <div class="modal-footer justify-content-center border-0 bg-light">
                <button
                    type="button"
                    class="btn btn-secondary px-4"
                    data-bs-dismiss="modal">
                    إلغاء
                </button>

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