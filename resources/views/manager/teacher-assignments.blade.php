@extends('layouts.app')

@section('content')
<style>
    .assignment-page .class-assignment-card {
        border-top: 4px solid var(--primary-color) !important;
    }

    .assignment-page .teacher-badge {
        background: color-mix(in srgb, var(--primary-color) 12%, white);
        color: var(--primary-color);
    }

    .assignment-page .teacher-assignment-row {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .assignment-page .teacher-assignment-row .teacher-badge {
        grid-column: 1;
        justify-self: start;
    }

    .assignment-page .teacher-assignment-row form {
        grid-column: 2;
        justify-self: center;
    }

    .assignment-page .class-assignment-card .card-body>div {
        width: 100%;
    }

    .assignment-page .teacher-assignment-row form {
        margin: 0;
    }

    .assignment-page .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .assignment-page .btn-unassign {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: #fff;
    }

    .assignment-page .btn-unassign:hover,
    .assignment-page .btn-unassign:focus-visible {
        background-color: color-mix(in srgb, var(--primary-color) 85%, black);
        border-color: color-mix(in srgb, var(--primary-color) 85%, black);
        color: #fff;
    }

    .assignment-page .assignment-search-menu {
        top: 100% !important;
        bottom: auto !important;
        transform: none !important;
        min-width: 100%;
        max-height: 280px;
        overflow-y: auto;
        padding: 8px;
    }
</style>

@include('manager.partials.simple-navbar')

<main class="container py-3 assignment-page">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">تعيين المعلمين للصفوف</h1>
            <p class="text-muted mb-0">عيّن معلمًا لصف، وتابع المعلمين المسؤولين عن كل صف.</p>
        </div>
        <a href="{{ route('manager.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-right ms-1"></i> العودة إلى المهام
        </a>
    </div>

    <section class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 pt-3 px-4">
            <h2 class="h5 fw-bold mb-0">
                <i class="bi bi-person-badge-fill ms-1" style="color: var(--primary-color);"></i>
                تعيين أستاذ لصف دراسي
            </h2>
        </div>
        <div class="card-body px-4 pb-4">
            <form method="GET" action="{{ route('manager.teacher-assignments') }}" class="row g-3 align-items-end mb-4">
                <div class="col-sm-6 col-md-4">
                    <label for="yearFilter" class="form-label fw-semibold">السنة الدراسية</label>
                    <input id="yearFilter" type="number" name="year" class="form-control" min="2000" max="2100" value="{{ $year }}">
                </div>
                <div class="col-sm-6 col-md-3">
                    <button type="submit" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-search ms-1"></i> عرض السنة
                    </button>
                </div>
            </form>

            @if($approvedTeachers->isEmpty() || $classAssignments->isEmpty())
            <p class="text-muted mb-0">يلزم وجود معلمين مقبولين وصفوف مضافة لهذه السنة لإجراء التعيين.</p>
            @else
            <form action="{{ route('manager.assign.class.quick') }}" method="POST" class="row g-3 align-items-end">
                @csrf
                <input type="hidden" name="year" value="{{ $year }}">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">المعلم</label>
                    <div class="dropdown assignment-combobox" id="teacherCombobox">
                        <input type="hidden" name="teacher_id" id="teacherValue" value="{{ old('teacher_id') }}">
                        <button class="form-select text-start" type="button" id="teacherDropdown"
                            data-bs-toggle="dropdown" data-bs-display="static" data-bs-auto-close="outside" aria-expanded="false">
                            <span id="teacherSelectedLabel">-- اختر المعلم أو ابحث عن اسمه --</span>
                        </button>
                        <div class="dropdown-menu assignment-search-menu" aria-labelledby="teacherDropdown">
                            <input id="teacherSearch" type="search" class="form-control mb-2"
                                placeholder="ابحث عن اسم المعلم..." autocomplete="off" aria-label="ابحث عن اسم المعلم">
                            <div id="teacherOptions" class="d-grid gap-1">
                                @foreach($approvedTeachers as $teacher)
                                <button type="button" class="dropdown-item rounded-2 assignment-option"
                                    data-value="{{ $teacher->id }}" data-label="{{ $teacher->name }}">
                                    {{ $teacher->name }}
                                </button>
                                @endforeach
                            </div>
                            <small id="teacherSearchEmpty" class="form-text text-muted d-none">لا يوجد معلم بهذا الاسم.</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">الصف الدراسي</label>
                    <div class="dropdown assignment-combobox" id="classCombobox">
                        <input type="hidden" name="class" id="classValue" value="{{ old('class') }}">
                        <button class="form-select text-start" type="button" id="classDropdown"
                            data-bs-toggle="dropdown" data-bs-display="static" data-bs-auto-close="outside" aria-expanded="false">
                            <span id="classSelectedLabel">-- اختر الصف أو ابحث عن اسمه --</span>
                        </button>
                        <div class="dropdown-menu assignment-search-menu" aria-labelledby="classDropdown">
                            <input id="classSearch" type="search" class="form-control mb-2"
                                placeholder="ابحث عن اسم الصف..." autocomplete="off" aria-label="ابحث عن اسم الصف">
                            <div id="classOptions" class="d-grid gap-1">
                                @foreach($availableClasses as $className)
                                <button type="button" class="dropdown-item rounded-2 assignment-option"
                                    data-value="{{ $className }}" data-label="{{ $className }}">
                                    {{ $className }}
                                </button>
                                @endforeach
                            </div>
                            <small id="classSearchEmpty" class="form-text text-muted d-none">لا يوجد صف بهذا الاسم.</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">الشعبة</label>
                    <div class="dropdown assignment-combobox" id="sectionCombobox">
                        <input type="hidden" name="section" id="sectionValue" value="{{ old('section') }}">
                        <button class="form-select text-start" type="button" id="sectionDropdown"
                            data-bs-toggle="dropdown" data-bs-display="static" data-bs-auto-close="outside" aria-expanded="false">
                            <span id="sectionSelectedLabel">-- اختر الشعبة أو ابحث عن اسمها --</span>
                        </button>
                        <div class="dropdown-menu assignment-search-menu" aria-labelledby="sectionDropdown">
                            <input id="sectionSearch" type="search" class="form-control mb-2"
                                placeholder="ابحث عن اسم الشعبة..." autocomplete="off" aria-label="ابحث عن اسم الشعبة">
                            <div id="sectionOptions" class="d-grid gap-1">
                                @foreach($availableSections as $sectionName)
                                <button type="button" class="dropdown-item rounded-2 assignment-option"
                                    data-value="{{ $sectionName }}" data-label="{{ $sectionName }}">
                                    {{ $sectionName }}
                                </button>
                                @endforeach
                            </div>
                            <small id="sectionSearchEmpty" class="form-text text-muted d-none">لا توجد شعبة بهذا الاسم.</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary fw-bold w-100">
                        <i class="bi bi-check-lg ms-1"></i> تعيين
                    </button>
                </div>
                <div class="col-12">
                    <small class="text-muted">سيتم تعيين جميع طلاب الصف والشعبة المختارين لهذا المعلم تلقائيًا.</small>
                </div>
            </form>
            @endif
        </div>
    </section>

    <section aria-labelledby="classAssignmentsTitle">
        <h2 id="classAssignmentsTitle" class="h5 fw-bold mb-3">المعلمون المسؤولون عن الصفوف — {{ $year }}</h2>
        @forelse($classAssignments as $assignment)
        @php
        $className = $assignment['className'];
        $sectionName = $assignment['sectionName'];
        $teachers = $assignment['teachers'];
        @endphp
        <article class="card class-assignment-card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3 px-4">
                <div>
                    <h3 class="h6 fw-bold mb-2">
                        <i class="bi bi-mortarboard-fill ms-1" style="color: var(--primary-color);"></i>
                        {{ $className }} — {{ $sectionName ?: 'غير محددة' }}
                    </h3>
                    @forelse($teachers as $teacher)
                    <div class="teacher-assignment-row">
                        <span class="badge teacher-badge rounded-pill px-3 py-2">
                            <i class="bi bi-person-fill ms-1"></i>{{ $teacher->name }}
                            @if($teacher->status === 'deactivated')
                            <span class="text-muted">— غير مفعل</span>
                            @endif
                        </span>
                        <form action="{{ route('manager.unassign.class.quick') }}" method="POST" class="m-0"
                            onsubmit="return confirm('هل تريد إلغاء تعيين {{ $teacher->name }} من الصف {{ $className }} والشعبة {{ $sectionName }}؟ ستبقى بيانات الطلاب وتقاريرهم محفوظة.');">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                            <input type="hidden" name="class" value="{{ $className }}">
                            <input type="hidden" name="section" value="{{ $sectionName }}">
                            <input type="hidden" name="year" value="{{ $year }}">
                            <button type="submit" class="btn btn-sm btn-unassign">
                                <i class="bi bi-person-dash ms-1"></i> إلغاء التعيين
                            </button>
                        </form>
                    </div>
                    @empty
                    <span class="small text-muted">لا يوجد معلمون معينون لهذا الصف.</span>
                    @endforelse
                </div>
            </div>
        </article>
        @empty
        <div class="alert alert-info">لا توجد صفوف لهذه السنة الدراسية.</div>
        @endforelse
    </section>
</main>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const setupAssignmentCombobox = (config) => {
            const container = document.getElementById(config.containerId);
            const toggle = document.getElementById(config.toggleId);
            const selectedValue = document.getElementById(config.valueId);
            const selectedLabel = document.getElementById(config.labelId);
            const searchInput = document.getElementById(config.searchId);
            const optionButtons = Array.from(container.querySelectorAll('.assignment-option'));
            const emptyMessage = document.getElementById(config.emptyId);
            const dropdown = bootstrap.Dropdown.getOrCreateInstance(toggle);
            const selectedOption = optionButtons.find((option) => option.dataset.value === selectedValue.value);

            if (selectedOption) {
                selectedLabel.textContent = selectedOption.dataset.label;
            }

            const filterOptions = () => {
                const searchTerm = searchInput.value.trim().toLocaleLowerCase();
                let visibleOptions = 0;

                optionButtons.forEach((option) => {
                    const matches = option.dataset.label.toLocaleLowerCase().includes(searchTerm);
                    option.classList.toggle('d-none', !matches);
                    visibleOptions += Number(matches);
                });

                emptyMessage.classList.toggle('d-none', visibleOptions > 0);
            };

            searchInput.addEventListener('input', filterOptions);
            container.addEventListener('shown.bs.dropdown', () => searchInput.focus());
            optionButtons.forEach((option) => {
                option.addEventListener('click', () => {
                    selectedValue.value = option.dataset.value;
                    selectedLabel.textContent = option.dataset.label;
                    searchInput.setCustomValidity('');
                    dropdown.hide();
                });
            });

            searchInput.addEventListener('keydown', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    optionButtons.find((option) => !option.classList.contains('d-none'))?.click();
                }
            });

            return {
                selectedValue,
                searchInput,
                dropdown
            };
        };

        const teacherCombobox = setupAssignmentCombobox({
            containerId: 'teacherCombobox',
            toggleId: 'teacherDropdown',
            valueId: 'teacherValue',
            labelId: 'teacherSelectedLabel',
            searchId: 'teacherSearch',
            emptyId: 'teacherSearchEmpty'
        });
        const classCombobox = setupAssignmentCombobox({
            containerId: 'classCombobox',
            toggleId: 'classDropdown',
            valueId: 'classValue',
            labelId: 'classSelectedLabel',
            searchId: 'classSearch',
            emptyId: 'classSearchEmpty'
        });
        const sectionCombobox = setupAssignmentCombobox({
            containerId: 'sectionCombobox',
            toggleId: 'sectionDropdown',
            valueId: 'sectionValue',
            labelId: 'sectionSelectedLabel',
            searchId: 'sectionSearch',
            emptyId: 'sectionSearchEmpty'
        });

        document.querySelector('#teacherCombobox').closest('form').addEventListener('submit', (event) => {
            const invalidCombobox = [teacherCombobox, classCombobox, sectionCombobox]
                .find(({
                    selectedValue
                }) => !selectedValue.value);

            if (invalidCombobox) {
                event.preventDefault();
                invalidCombobox.searchInput.setCustomValidity(
                    invalidCombobox.searchInput.id === 'teacherSearch' ?
                    'اختاري اسم المعلم من القائمة.' :
                    invalidCombobox.searchInput.id === 'classSearch' ?
                    'اختاري الصف الدراسي من القائمة.' :
                    'اختاري الشعبة من القائمة.'
                );
                invalidCombobox.dropdown.show();
                invalidCombobox.searchInput.reportValidity();
            }
        });

        [teacherCombobox.searchInput, classCombobox.searchInput, sectionCombobox.searchInput].forEach((searchInput) => {
            searchInput.addEventListener('input', () => searchInput.setCustomValidity(''));
        });
    });
</script>
@endsection