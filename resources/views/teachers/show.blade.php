@if (!request()->ajax())
    @extends('layouts.app')
    @section('title', 'Teacher Detail')
    @section('content')
@endif

<section class="detail-wrapper">
    <div class="container-fluid">
        @if (!request()->ajax())
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Teacher Detail</h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('teachers.index') }}">Teachers</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Teacher Detail
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="form-elements-wrapper">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Profile Card -->
                    <div class="card-style mb-4 rounded-3 shadow-sm border-0 text-center" style="background: #ffffff;">
                        @if ($teacher->teacher_photo)
                            <img
                                src="{{ asset('storage/' . $teacher->teacher_photo) }}"
                                alt="Teacher Photo"
                                class="img-fluid rounded-circle mx-auto"
                                style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #e2e8f0;"
                            >
                        @else
                            <div
                                class="avatar-placeholder mx-auto"
                                style="width: 120px; height: 120px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center;"
                            >
                                <i class="lni lni-user text-muted" style="font-size: 40px;"></i>
                            </div>
                        @endif
                        <h4 class="mt-3 mb-1">{{ $teacher->full_name }}</h4>
                        <p class="text-muted mb-0"><strong>{{ $teacher->teacher_number }}</strong></p>
                    </div>

                    <!-- Personal Information -->
                    <div class="card-style mb-4 rounded-3 shadow-sm border-0" style="background: #ffffff;">
                        <h5 class="mb-4 pb-2 border-bottom" style="color: #4a5568;">
                            <i class="lni lni-user me-2 text-primary"></i> Personal Information
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="me-3" style="min-width: 24px;">
                                        <i class="lni lni-id-badge text-secondary"></i>
                                    </div>
                                    <div>
                                        <label class="fw-medium text-muted d-block">Full Name</label>
                                        <p class="mb-0">{{ $teacher->full_name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="me-3" style="min-width: 24px;">
                                        <i class="lni lni-bookmark text-secondary"></i>
                                    </div>
                                    <div>
                                        <label class="fw-medium text-muted d-block">Teacher ID</label>
                                        <p class="mb-0"><strong>{{ $teacher->teacher_number }}</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="me-3" style="min-width: 24px;">
                                        <i class="lni lni-calendar text-secondary"></i>
                                    </div>
                                    <div>
                                        <label class="fw-medium text-muted d-block">Date of Birth</label>
                                        <p class="mb-0">{{ optional($teacher->birth_date)->format('d-m-Y') ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="me-3" style="min-width: 24px;">
                                        <i class="lni lni-gender text-secondary"></i>
                                    </div>
                                    <div>
                                        <label class="fw-medium text-muted d-block">Gender</label>
                                        <p class="mb-0">{{ $teacher->gender ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="me-3" style="min-width: 24px;">
                                        <i class="lni lni-religion text-secondary"></i>
                                    </div>
                                    <div>
                                        <label class="fw-medium text-muted d-block">Religion</label>
                                        <p class="mb-0">{{ $teacher->religion ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="me-3" style="min-width: 24px;">
                                        <i class="lni lni-droplet text-secondary"></i>
                                    </div>
                                    <div>
                                        <label class="fw-medium text-muted d-block">Blood Type</label>
                                        <p class="mb-0">{{ $teacher->blood_type ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex align-items-start">
                                <div class="me-3" style="min-width: 24px;">
                                    <i class="lni lni-map-marker text-secondary"></i>
                                </div>
                                <div>
                                    <label class="fw-medium text-muted d-block">Address</label>
                                    <p class="mb-0">{{ $teacher->address ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex align-items-start">
                                <div class="me-3" style="min-width: 24px;">
                                    <i class="lni lni-phone text-secondary"></i>
                                </div>
                                <div>
                                    <label class="fw-medium text-muted d-block">Phone Number</label>
                                    <p class="mb-0">{{ $teacher->phone_number ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Information -->
                    <div class="card-style mb-4 rounded-3 shadow-sm border-0" style="background: #ffffff;">
                        <h5 class="mb-4 pb-2 border-bottom" style="color: #4a5568;">
                            <i class="lni lni-briefcase me-2 text-primary"></i> Professional Information
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="me-3" style="min-width: 24px;">
                                        <i class="lni lni-graduation text-secondary"></i>
                                    </div>
                                    <div>
                                        <label class="fw-medium text-muted d-block">Highest Education</label>
                                        <p class="mb-0">{{ $teacher->highest_education ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="me-3" style="min-width: 24px;">
                                        <i class="lni lni-timer text-secondary"></i>
                                    </div>
                                    <div>
                                        <label class="fw-medium text-muted d-block">Teaching Experience</label>
                                        <p class="mb-0">{{ $teacher->years_of_experience ?? 0 }} year(s)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="me-3" style="min-width: 24px;">
                                        <i class="lni lni-checkmark-circle text-secondary"></i>
                                    </div>
                                    <div>
                                        <label class="fw-medium text-muted d-block">Employment Status</label>
                                        <p class="mb-0">{{ $teacher->employment_status ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="me-3" style="min-width: 24px;">
                                        <i class="lni lni-book text-secondary"></i>
                                    </div>
                                    <div>
                                        <label class="fw-medium text-muted d-block">Subjects Taught</label>
                                        @if ($teacher->subjects->count() > 0)
                                            <ul class="mb-0 ps-3">
                                                @foreach ($teacher->subjects as $subject)
                                                    <li>{{ $subject->subject_name }} (Kelas {{ $subject->class_level }})</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="mb-0 text-muted">—</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 justify-content-end">
                        @if (!request()->ajax())
                            <a
                                href="{{ route('teachers.edit', $teacher) }}"
                                class="btn btn-warning px-4 py-2 shadow-sm"
                            >
                                <i class="lni lni-pencil me-1"></i> Edit
                            </a>
                            <a
                                href="{{ route('teachers.index') }}"
                                class="btn btn-outline-secondary px-4 py-2"
                            >
                                <i class="lni lni-arrow-left me-1"></i> Back
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if (!request()->ajax())
    @endsection
@endif
