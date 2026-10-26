@extends('layouts.app')

@section('content')

<div class="container my-4" style="max-width: 1200px;">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill ms-1"></i>
        {{ session('success') }}

        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close">
        </button>
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>
            <h1 class="h3 fw-bold mb-1" style="color: #1f2937;">
                المهام
            </h1>

            <p class="text-muted small mb-0">
                طلبات تسجيل المعلمين المعلقة وإدارة تعيينات الصفوف
            </p>
        </div>

        <a href="{{ route('manager.teacher-assignments') }}"
            class="btn text-white fw-bold"
            style="background-color: var(--primary-color); border-color: var(--primary-color);">

            <i class="bi bi-person-badge-fill ms-1"></i>
            تعيين المعلمين للصفوف

        </a>

    </div>

    {{-- طلبات تسجيل المعلمين --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">

        <div class="card-header bg-white py-3 border-bottom-0">
            <h5 class="card-title m-0 fw-bold"
                style="color: var(--primary-color);">

                <i class="bi bi-person-plus-fill ms-2"></i>
                طلبات تسجيل المعلمين المعلقة

            </h5>
        </div>

        <div class="card-body">

            @if($pendingTeachers->isEmpty())

            <div class="text-center py-4 text-muted">

                <i class="bi bi-check-circle fs-2 text-success d-block mb-2"></i>

                لا توجد طلبات معلقة حالياً.

            </div>

            @else

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>رقم الهاتف</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($pendingTeachers as $teacher)

                        <tr>

                            <td class="fw-bold">
                                {{ $teacher->name }}
                            </td>

                            <td>
                                {{ $teacher->email }}
                            </td>

                            <td>
                                {{ $teacher->phone }}
                            </td>

                            <td>

                                <form action="{{ route('manager.teachers.approve', $teacher->id) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="btn btn-success btn-sm ms-1">

                                        <i class="bi bi-check-lg"></i>
                                        موافقة

                                    </button>

                                </form>

                                <form action="{{ route('manager.teachers.reject', $teacher->id) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('هل أنت متأكد من رفض طلب المعلم؟')">

                                        <i class="bi bi-x-lg"></i>
                                        رفض

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            @endif

        </div>

    </div>

    {{-- طلبات أولياء الأمور --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">

        <div class="card-header bg-white py-3 border-bottom-0">

            <h5 class="card-title m-0 fw-bold"
                style="color: var(--primary-color);">

                <i class="bi bi-person-heart ms-2"></i>
                طلبات انضمام أولياء الأمور

            </h5>

        </div>

        <div class="card-body">

            @if($pendingMotherRequests->isEmpty())

            <div class="text-center py-4 text-muted">
                لا توجد طلبات انضمام معلقة حاليًا.
            </div>

            @else

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th>اسم وليّة الأمر</th>
                            <th>اسم المستخدم</th>
                            <th>البريد الإلكتروني</th>
                            <th>رقم الهاتف</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($pendingMotherRequests as $motherRequest)

                        <tr>

                            <td class="fw-bold">
                                {{ $motherRequest->mother->name }}
                            </td>

                            <td>
                                {{ $motherRequest->mother->username }}
                            </td>

                            <td>
                                {{ $motherRequest->mother->email }}
                            </td>

                            <td>
                                {{ $motherRequest->mother->phone }}
                            </td>

                            <td>

                                <form action="{{ route('manager.mothers.requests.approve', $motherRequest->id) }}"
                                    method="POST"
                                    class="d-inline">

                                    ass="bi bi-check-lg"></i>
                                    موافقة

                                    </button>

                                </form>

                                id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                    class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('هل تريد رفض طلب انضمام وليّة الأمر؟')">

                                    <i class="bi bi-x-lg"></i>
                                    رفض

                                </button>

                                </form>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            @endif

        </div>

    </div>

</div>

@endsection