<div class="report-page-items">
    @foreach($reports as $daily)
    <div class="report-item">
        <div class="report-top">
            <div class="report-topic">
                <i class="bi bi-bookmark text-primary me-1"></i> {{ $daily->topic }}
            </div>
            <div class="report-date">
                <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($daily->report_date)->format('Y-m-d H:i') }}
            </div>
        </div>

        <div class="report-details">
            <span class="result-badge">
                <i class="bi bi-bar-chart"></i> النتيجة: {{ $daily->result ?? 'غير محددة' }}
            </span>
        </div>

        @if($daily->notes)
        <div class="report-notes">
            <strong>الملاحظات: </strong>{{ $daily->notes }}
        </div>
        @endif

        <div class="report-actions">
            <button type="button" class="edit-btn" data-bs-toggle="modal" data-bs-target="#editReportModal{{ $daily->id }}">
                <i class="bi bi-pencil me-1"></i> تعديل
            </button>

            <form action="{{ route('teacher.daily_delete', $daily->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا التقرير؟');">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn">
                    <i class="bi bi-trash me-1"></i> حذف
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>

<div class="report-page-modals">
    @foreach($reports as $daily)
    <div class="modal fade" id="editReportModal{{ $daily->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">تعديل التقرير اليومي</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('teacher.daily_update', $daily->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">موضوع النشاط</label>
                            <input type="text" name="topic" class="form-control" list="report-topics-{{ $daily->id }}"
                                value="{{ $daily->topic }}" required>
                            <datalist id="report-topics-{{ $daily->id }}">
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject }}">
                                @endforeach
                            </datalist>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">النتيجة</label>
                            <input type="number" name="result" class="form-control" min="0" max="100" step="0.01" value="{{ $daily->result }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">الملاحظات</label>
                            <textarea name="notes" class="form-control" rows="3">{{ $daily->notes }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">تاريخ التقرير</label>
                            <input type="datetime-local" name="report_date" class="form-control" value="{{ \Carbon\Carbon::parse($daily->report_date)->format('Y-m-d\TH:i') }}" required>
                        </div>
                    </div>

                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary px-4">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
