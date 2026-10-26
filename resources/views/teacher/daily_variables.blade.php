@extends('layouts.app')

@section('content')

<style>
    * {
        box-sizing: border-box;
    }

    /* Navbar */
    .navbar-custom {
        background: var(--primary-color);
        min-height: 70px;
        padding: 0 35px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
    }

    .navbar-brand {
        font-size: 22px;
        font-weight: 700;
        color: #ffffff;
        margin-left: 30px;
        text-decoration: none;
    }

    .nav-link {
        color: rgba(255, 255, 255, 0.85);
        font-size: 15px;
        font-weight: 500;
        padding: 24px 15px !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .nav-link:hover,
    .nav-link.active {
        color: #ffffff;
        background-color: rgba(255, 255, 255, 0.16);
    }

    .nav-link.active {
        border-bottom: 2px solid #ffffff;
    }

    .navbar-toggler-icon {
        filter: brightness(0) invert(1);
    }

    /* حساب المعلم */
    .teacher-profile-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        background: transparent;
        border: none;
        padding: 6px 12px;
        cursor: pointer;
        border-radius: 10px;
        transition: background-color 0.2s;
    }

    .teacher-profile-btn:hover {
        background-color: rgba(255, 255, 255, 0.16);
    }

    .teacher-profile-btn .text-dark,
    .teacher-profile-btn .text-muted {
        color: #ffffff !important;
    }

    .teacher-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background-color: #ffffff;
        color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .teacher-dropdown {
        min-width: 230px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 8px;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.10);
    }

    .teacher-dropdown .dropdown-header {
        background-color: var(--primary-color);
        border-radius: 0.375rem;
        color: #ffffff;
    }

    .teacher-dropdown .dropdown-header strong,
    .teacher-dropdown .dropdown-header small {
        color: #ffffff !important;
    }

    .teacher-dropdown .dropdown-item:not(.text-danger):hover,
    .teacher-dropdown .dropdown-item:not(.text-danger):focus,
    .teacher-dropdown .dropdown-item:not(.text-danger):active {
        background-color: var(--primary-color);
        color: #ffffff;
    }

    .teacher-dropdown .dropdown-item:not(.text-danger):hover i,
    .teacher-dropdown .dropdown-item:not(.text-danger):focus i,
    .teacher-dropdown .dropdown-item:not(.text-danger):active i {
        color: #ffffff !important;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem color-mix(in srgb, var(--primary-color) 15%, transparent);
    }

    .btn-primary:hover,
    .btn-primary:focus,
    .btn-primary:active {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        opacity: 0.9;
    }

    .btn-primary:disabled,
    .btn-primary.disabled {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        color: #ffffff !important;
        opacity: 0.65;
    }

    .text-primary {
        color: var(--primary-color) !important;
    }

    .logout-btn {
        background: rgba(255, 255, 255, 0.16);
        border: 1px solid rgba(255, 255, 255, 0.5);
        color: #ffffff;
        border-radius: 7px;
        padding: 7px 15px;
        font-size: 14px;
        transition: 0.2s;
    }

    .logout-btn:hover {
        background: rgba(255, 255, 255, 0.28);
        color: #ffffff;
    }

    /* Main Container */
    .main-container {
        max-width: 1400px;
        margin: auto;
        padding: 40px 30px 60px;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 30px;
    }

    .page-header h2 {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .page-header p {
        color: #6b7280;
        margin: 0;
        font-size: 15px;
    }

    /* Student Card */
    .students-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 24px;
        align-items: start;
    }

    .student-card {
        background: #ffffff;
        border: 1px solid #e6eaf0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
        transition: 0.2s;
    }

    .empty-students {
        grid-column: 1 / -1;
    }

    .student-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 32px rgba(15, 23, 42, 0.09);
    }

    .student-header {
        padding: 22px 25px;
        background: linear-gradient(to left, #f8faff, #ffffff);
        border-bottom: 1px solid #edf0f4;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .student-toggle {
        width: 100%;
        border: 0;
        color: inherit;
        text-align: right;
        cursor: pointer;
    }

    .student-expand-icon {
        color: var(--primary-color);
        transition: transform 0.2s ease;
    }

    .student-toggle[aria-expanded="true"] .student-expand-icon {
        transform: rotate(180deg);
    }

    .latest-report-preview {
        padding: 16px 25px;
        background: #ffffff;
    }

    .latest-report-preview-label {
        color: #6b7280;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .latest-report-preview-topic {
        color: #1f2937;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .latest-report-preview-date {
        color: #6b7280;
        font-size: 12px;
    }

    .student-main-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .student-avatar-large {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        background: color-mix(in srgb, var(--primary-color) 12%, white);
        color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
        flex-shrink: 0;
    }

    .student-info h4 {
        margin: 0 0 8px;
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
    }

    .student-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .student-meta span {
        color: #6b7280;
        font-size: 13px;
    }

    .student-meta i {
        color: var(--primary-color);
        margin-left: 4px;
    }

    .report-count {
        background: #f1f5f9;
        color: #475569;
        border-radius: 20px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 600;
    }

    /* Reports List */
    .reports-container {
        padding: 22px 25px 25px;
    }

    .reports-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .reports-title {
        font-size: 15px;
        font-weight: 700;
        color: #374151;
        margin: 0;
    }

    .reports-title i {
        color: var(--primary-color);
        margin-left: 6px;
    }

    .report-item {
        border: 1px solid #e8ecf2;
        border-radius: 10px;
        padding: 17px 18px;
        margin-bottom: 12px;
        background: #ffffff;
        transition: 0.2s;
    }

    .report-item:last-child {
        margin-bottom: 0;
    }

    .report-item:hover {
        border-color: #d8e2f4;
        background: #fbfdff;
    }

    .report-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 12px;
    }

    .report-topic {
        font-weight: 700;
        color: #1f2937;
        font-size: 15px;
    }

    .report-date {
        color: #6b7280;
        font-size: 12px;
        white-space: nowrap;
    }

    .result-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: color-mix(in srgb, var(--primary-color) 12%, white);
        color: var(--primary-color);
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .report-notes {
        color: #6b7280;
        font-size: 13px;
        line-height: 1.7;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #f0f2f5;
    }

    .report-actions {
        display: flex;
        gap: 7px;
        margin-top: 13px;
        justify-content: flex-start;
    }

    .edit-btn,
    .delete-btn {
        border-radius: 6px;
        padding: 5px 11px;
        font-size: 12px;
        background: #ffffff;
        transition: 0.2s;
    }

    .edit-btn {
        border: 1px solid var(--primary-color);
        color: var(--primary-color);
    }

    .edit-btn:hover {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: #ffffff;
    }

    .delete-btn {
        border: 1px solid #dc3545;
        color: #dc3545;
    }

    .delete-btn:hover {
        background: #dc3545;
        color: #ffffff;
    }

    .empty-reports,
    .empty-students {
        text-align: center;
        padding: 40px 20px;
        color: #9ca3af;
    }

    @media (max-width: 991px) {
        .navbar-custom {
            padding: 10px 20px;
        }

        .nav-link {
            padding: 12px 10px !important;
        }

        .main-container {
            padding: 25px 15px 40px;
        }

        .student-header {
            flex-direction: column;
            align-items: stretch;
        }
    }

    @media (max-width: 768px) {
        .students-grid {
            grid-template-columns: 1fr;
            gap: 18px;
        }
    }
</style>



<!-- Main Content -->
<main class="main-container">

    <!-- Page Header -->
    <div class="page-header">
        <h2>المتغيرات اليومية</h2>
        <p>متابعة وإدارة التقارير اليومية الخاصة بالطلاب المسندين إليك.</p>
    </div>

    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger rounded-3 mb-4">
        <strong>يرجى تصحيح الأخطاء التالية:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- بطاقة إضافة المتغيرات اليومية (بنفس الكود الأصلي تماماً) --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px; overflow: hidden; background: #fff;">
        <div class="card-header bg-white border-bottom p-4">
            <div class="d-flex align-items-center gap-3">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: color-mix(in srgb, var(--primary-color) 12%, white); color: var(--primary-color); display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                    <i class="bi bi-clipboard2-pulse"></i>
                </div>
                <div>
                    <h5 class="mb-1 fw-bold text-dark">إضافة المتغيرات اليومية</h5>
                    <p class="text-muted mb-0 small">اختر الصف الطالب ثم أدخل تفاصيل التقرير اليومي.</p>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('teacher.daily_store', 0) }}" method="POST" id="dailyReportForm">
                @csrf

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label for="classFilter" class="form-label fw-bold text-secondary small">
                            <i class="bi bi-door-open me-1" style="color: var(--primary-color);"></i> الصف الدراسي
                        </label>
                        <select id="classFilter" class="form-select" required>
                            <option value="">اختر الصف</option>
                            @foreach($students->pluck('class')->filter()->unique()->sort() as $className)
                            <option value="{{ $className }}">{{ $className }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="sectionFilterContainer" class="col-md-4 d-none">
                        <label for="sectionFilter" class="form-label fw-bold text-secondary small">
                            <i class="bi bi-people me-1" style="color: var(--primary-color);"></i> الشعبة
                        </label>
                        <select id="sectionFilter" class="form-select" disabled>
                            <option value="">اختر الشعبة</option>
                            @foreach($sections as $section)
                            <option value="{{ $section }}">{{ $section }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="studentFilter" class="form-label fw-bold text-secondary small">
                            <i class="bi bi-person me-1" style="color: var(--primary-color);"></i> اسم الطالب
                        </label>
                        <select id="studentFilter" class="form-select" required disabled>
                            <option value="">اختر الصف أولاً</option>
                            @foreach($students as $student)
                            <option value="{{ $student->id }}" data-class="{{ $student->class }}" data-section="{{ $student->section }}">
                                {{ $student->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr class="text-muted opacity-25 my-4">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="topic_subject" class="form-label fw-bold text-secondary small">موضوع النشاط / التقرير</label>
                        <select name="topic_subject" id="topic_subject" class="form-select" required>
                            <option value="">اختر مادة أو موضوعًا مخصصًا</option>
                            @foreach($subjects as $subject)
                            <option value="{{ $subject }}" {{ old('topic_subject') === $subject ? 'selected' : '' }}>
                                {{ $subject }}
                            </option>
                            @endforeach
                            <option value="__custom__" {{ old('topic_subject') === '__custom__' ? 'selected' : '' }}>
                                كتابة موضوع مخصص
                            </option>
                        </select>
                        <input type="text" name="custom_topic" id="custom_topic" class="form-control mt-2"
                            value="{{ old('custom_topic') }}" placeholder="اكتب موضوع النشاط"
                            {{ old('topic_subject') === '__custom__' ? '' : 'hidden' }}
                            {{ old('topic_subject') === '__custom__' ? 'required' : '' }}>
                    </div>

                    <div class="col-md-6">
                        <label for="result" class="form-label fw-bold text-secondary small">النتيجة (من 100)</label>
                        <input type="number" name="result" id="result" class="form-control" placeholder="مثال: 85" min="0" max="100" step="0.01">
                    </div>

                    <div class="col-md-6">
                        <label for="report_date" class="form-label fw-bold text-secondary small">تاريخ التقرير اليومي</label>
                        <input type="date" name="report_date" id="report_date" class="form-control" value="{{ date('Y-m-d') }}" lang="en" style="direction: ltr; text-align: right;" required>
                    </div>

                    <div class="col-12">
                        <label for="notes" class="form-label fw-bold text-secondary small">ملاحظات المعلم</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="اكتب ملاحظاتك حول أداء الطالب..."></textarea>
                    </div>

                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4 py-2" id="saveReportBtn" disabled>
                            <i class="bi bi-check-circle me-1"></i> حفظ التقرير اليومي
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Students & Daily Reports List (مع إضافة خانة البحث حسب الشعبة بجانبهم) -->
    @if($students->isNotEmpty())
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <label for="studentNameSearch" class="form-label fw-bold text-secondary small">
                <i class="bi bi-search me-1" style="color: var(--primary-color);"></i> البحث باسم الطالب
            </label>
            <input type="search" id="studentNameSearch" class="form-control" placeholder="اكتب اسم الطالب">
        </div>
        <div class="col-md-4">
            <label for="studentClassSearch" class="form-label fw-bold text-secondary small">
                <i class="bi bi-mortarboard me-1" style="color: var(--primary-color);"></i> البحث حسب الصف
            </label>
            <input type="search" id="studentClassSearch" class="form-control" placeholder="اكتب اسم الصف">
        </div>
        <div class="col-md-4">
            <label for="studentSectionSearch" class="form-label fw-bold text-secondary small">
                <i class="bi bi-people me-1" style="color: var(--primary-color);"></i> البحث حسب الشعبة
            </label>
            <input type="search" id="studentSectionSearch" class="form-control" placeholder="اكتب اسم الشعبة">
        </div>
    </div>
    <div id="noStudentSearchResults" class="alert alert-light border text-center d-none" role="status" aria-live="polite">
        لا توجد بطاقات تطابق البحث.
    </div>
    @endif

    <div class="students-grid">
        @forelse($students as $student)
        @php
        $latestDaily = $student->latestDailyVariable;
        @endphp
        <div class="student-card"
            data-student-name="{{ $student->name }}"
            data-student-class="{{ $student->class ?? '' }}"
            data-student-section="{{ $student->section ?? '' }}">
            <button type="button" class="student-header student-toggle" data-bs-toggle="collapse"
                data-bs-target="#studentReports{{ $student->id }}" aria-expanded="false"
                aria-controls="studentReports{{ $student->id }}">
                <div class="student-main-info">
                    <div class="student-avatar-large">
                        <i class="bi bi-person"></i>
                    </div>
                    <div class="student-info">
                        <h4>{{ $student->name }}</h4>
                        <div class="student-meta">
                            <span><i class="bi bi-mortarboard"></i> الصف: {{ $student->class ?? 'غير محدد' }}</span>
                            <span><i class="bi bi-people"></i> الشعبة: {{ $student->section ?? 'غير محدد' }}</span>
                            <span><i class="bi bi-calendar3"></i> العمر: {{ $student->age ?? 'غير محدد' }}</span>
                            <span><i class="bi bi-journal-text"></i> {{ $student->daily_variables_count }} تقرير</span>
                        </div>
                    </div>
                </div>
                <i class="bi bi-chevron-down student-expand-icon" aria-hidden="true"></i>
            </button>

            <div class="latest-report-preview">
                @if($latestDaily)
                <div class="latest-report-preview-label">آخر تحديث للمتغيرات اليومية</div>
                <div class="latest-report-preview-topic">
                    <i class="bi bi-bookmark text-primary me-1"></i> {{ $latestDaily->topic }}
                </div>
                <div class="latest-report-preview-date">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ \Carbon\Carbon::parse($latestDaily->report_date)->format('Y-m-d H:i') }}
                    @if(!is_null($latestDaily->result))
                    <span class="mx-1">|</span> النتيجة: {{ $latestDaily->result }}
                    @endif
                </div>
                @else
                <div class="latest-report-preview-label mb-0">لا توجد تقارير يومية لهذا الطفل حتى الآن.</div>
                @endif
            </div>

            <div class="collapse" id="studentReports{{ $student->id }}"
                data-reports-url="{{ route('teacher.student.daily_reports', $student->id) }}" data-loaded="false">
                <div class="reports-container">
                    <div class="reports-header">
                        <div class="reports-title">
                            <i class="bi bi-journal-text"></i> التقارير اليومية السابقة
                        </div>
                        <span class="report-count">{{ $student->daily_variables_count }} سجل</span>
                    </div>
                    <div class="report-items"></div>
                    <div class="report-loading text-center text-muted py-3 d-none" role="status" aria-live="polite"></div>
                    <button type="button" class="btn btn-outline-primary btn-sm w-100 mt-2 load-more-reports d-none">
                        تحميل المزيد
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-students bg-white rounded-3 border p-5">
            <i class="bi bi-people display-4 text-muted d-block mb-3"></i>
            <h5>لا يوجد طلاب مسندون إليك</h5>
            <p class="text-muted">لا يمكنك إضافة تقرير يومي قبل وجود أطفال مرتبطين بك.</p>
        </div>
        @endforelse
    </div>

</main>

<!-- Script Filtering & Form Action Handler -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const classFilter = document.getElementById('classFilter');
        const sectionFilterContainer = document.getElementById('sectionFilterContainer');
        const sectionFilter = document.getElementById('sectionFilter');
        const studentFilter = document.getElementById('studentFilter');
        const reportForm = document.getElementById('dailyReportForm');
        const saveButton = document.getElementById('saveReportBtn');
        const topicSubject = document.getElementById('topic_subject');
        const customTopic = document.getElementById('custom_topic');

        const studentNameSearch = document.getElementById('studentNameSearch');
        const studentClassSearch = document.getElementById('studentClassSearch');
        const studentSectionSearch = document.getElementById('studentSectionSearch');
        const noStudentSearchResults = document.getElementById('noStudentSearchResults');

        const studentOptions = Array.from(studentFilter.options).slice(1);

        const updateStudentOptions = function() {
            const selectedClass = classFilter.value;
            const selectedSection = sectionFilter.value;

            studentFilter.innerHTML = '<option value="">اختر الطفل</option>';
            saveButton.disabled = true;

            let filteredStudents = studentOptions.filter(option => {
                const matchesClass = !selectedClass || option.dataset.class === selectedClass;
                const matchesSection = !selectedSection || option.dataset.section === selectedSection;
                return matchesClass && matchesSection;
            });

            if (selectedClass && filteredStudents.length > 0) {
                filteredStudents.forEach(option => studentFilter.appendChild(option.cloneNode(true)));
                studentFilter.disabled = false;
            } else {
                studentFilter.disabled = true;
                if (!selectedClass) {
                    studentFilter.innerHTML = '<option value="">اختر الصف أولاً</option>';
                } else {
                    studentFilter.innerHTML = '<option value="">لا يوجد أطفال في هذا الخيار</option>';
                }
            }
        };

        classFilter.addEventListener('change', function() {
            const selectedClass = this.value;
            if (selectedClass) {
                sectionFilterContainer.classList.remove('d-none');
                sectionFilter.disabled = false;
            } else {
                sectionFilterContainer.classList.add('d-none');
                sectionFilter.disabled = true;
                sectionFilter.value = '';
            }
            updateStudentOptions();
        });

        sectionFilter.addEventListener('change', updateStudentOptions);

        // تم إرجاع الكود الأصلي تماماً لضبط مسار الحفظ عبر route('teacher.daily_store', studentId) الصحيح
        studentFilter.addEventListener('change', function() {
            const studentId = this.value;
            if (studentId) {
                reportForm.action = "{{ route('teacher.daily_store', ':id') }}".replace(':id', studentId);
                saveButton.disabled = false;
            } else {
                reportForm.action = "{{ route('teacher.daily_store', 0) }}";
                saveButton.disabled = true;
            }
        });

        topicSubject.addEventListener('change', function() {
            const isCustom = this.value === '__custom__';
            customTopic.hidden = !isCustom;
            customTopic.required = isCustom;
            if (!isCustom) {
                customTopic.value = '';
            }
        });

        // سكربت تحميل التقارير القديمة AJAX
        const loadStudentReports = async function(collapse, page) {
            if (collapse.dataset.loading === 'true') {
                return;
            }

            const reportItems = collapse.querySelector('.report-items');
            const reportStatus = collapse.querySelector('.report-loading');
            const loadMoreButton = collapse.querySelector('.load-more-reports');

            collapse.dataset.loading = 'true';
            reportStatus.classList.remove('d-none');
            reportStatus.textContent = 'جاري تحميل التقارير...';
            loadMoreButton.disabled = true;

            try {
                const response = await fetch(`${collapse.dataset.reportsUrl}?page=${page}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    throw new Error('تعذر تحميل التقارير اليومية.');
                }

                const result = await response.json();
                const template = document.createElement('template');
                template.innerHTML = result.html;
                const pageItems = template.content.querySelector('.report-page-items');
                const pageModals = template.content.querySelector('.report-page-modals');

                if (!pageItems || !pageModals) {
                    throw new Error('تعذر عرض التقارير اليومية.');
                }

                reportItems.append(...pageItems.childNodes);
                document.body.append(...pageModals.childNodes);

                collapse.dataset.loaded = 'true';
                collapse.dataset.nextPage = result.next_page;
                loadMoreButton.classList.toggle('d-none', !result.has_more);
                reportStatus.textContent = '';
                reportStatus.classList.toggle('d-none', result.total > 0);

                if (result.total === 0) {
                    reportStatus.textContent = 'لا توجد تقارير يومية لهذا الطفل حتى الآن.';
                }
            } catch (error) {
                reportStatus.replaceChildren(document.createTextNode('تعذر تحميل التقارير اليومية. '));
                const retryButton = document.createElement('button');
                retryButton.type = 'button';
                retryButton.className = 'btn btn-link btn-sm p-0 retry-reports';
                retryButton.textContent = 'إعادة المحاولة';
                retryButton.addEventListener('click', function() {
                    loadStudentReports(collapse, page);
                });
                reportStatus.appendChild(retryButton);
                reportStatus.classList.remove('d-none');
            } finally {
                collapse.dataset.loading = 'false';
                loadMoreButton.disabled = false;
            }
        };

        document.querySelectorAll('.collapse[data-reports-url]').forEach(function(collapse) {
            collapse.addEventListener('shown.bs.collapse', function() {
                if (collapse.dataset.loaded !== 'true') {
                    loadStudentReports(collapse, 1);
                }
            });

            collapse.querySelector('.load-more-reports').addEventListener('click', function() {
                loadStudentReports(collapse, Number(collapse.dataset.nextPage || 2));
            });
        });

        // سكربت البحث الثلاثي (الاسم، الصف، الشعبة)
        if (studentNameSearch && studentClassSearch && studentSectionSearch && noStudentSearchResults) {
            const studentCards = Array.from(document.querySelectorAll('.student-card'));
            const normalizeSearchValue = value => value
                .toLocaleLowerCase()
                .replace(/[\u064B-\u065F\u0670\u0640]/g, '')
                .trim();

            const filterStudentCards = function() {
                const nameQuery = normalizeSearchValue(studentNameSearch.value);
                const classQuery = normalizeSearchValue(studentClassSearch.value);
                const sectionQuery = normalizeSearchValue(studentSectionSearch.value);
                let visibleCards = 0;

                studentCards.forEach(function(card) {
                    const matchesName = normalizeSearchValue(card.dataset.studentName || '').includes(nameQuery);
                    const matchesClass = normalizeSearchValue(card.dataset.studentClass || '').includes(classQuery);
                    const matchesSection = normalizeSearchValue(card.dataset.studentSection || '').includes(sectionQuery);

                    const isVisible = matchesName && matchesClass && matchesSection;

                    card.hidden = !isVisible;
                    if (isVisible) {
                        visibleCards++;
                    }
                });

                noStudentSearchResults.classList.toggle('d-none', visibleCards > 0);
            };

            studentNameSearch.addEventListener('input', filterStudentCards);
            studentClassSearch.addEventListener('input', filterStudentCards);
            studentSectionSearch.addEventListener('input', filterStudentCards);
        }
    });
</script>
@endsection