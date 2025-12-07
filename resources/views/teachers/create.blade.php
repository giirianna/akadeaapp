@if (!request()->ajax())
    @extends('layouts.app')
    @section('title', 'Add Teacher')
    @section('content')
@endif

<section class="tab-components">
    <div class="container-fluid">
        @if (!request()->ajax())
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2 class="title">Add Teacher</h2>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="breadcrumb" class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">Teachers</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Teacher</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        @endif

        <div class="form-elements-wrapper">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Personal Info -->
                        <div class="card-style mb-4 rounded-3 shadow-sm border-0" style="background: #ffffff;">
                            <h5 class="mb-4 pb-2 border-bottom" style="color: #4a5568;">
                                <i class="lni lni-user me-2 text-primary"></i> Personal Information
                            </h5>

                            <!-- Full Name -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label for="full_name" class="form-label fw-medium">Full Name</label>
                                        <input type="text" name="full_name" id="full_name" placeholder="Enter full name"
                                            value="{{ old('full_name') }}" required class="form-control" />
                                        @error('full_name')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Teacher Number -->
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label for="teacher_number" class="form-label fw-medium">Teacher ID / NIP</label>
                                        <input type="text" name="teacher_number" id="teacher_number" placeholder="Enter teacher ID"
                                            value="{{ old('teacher_number') }}" required class="form-control" />
                                        @error('teacher_number')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Photo -->
                            <div class="mb-4">
                                <label class="form-label fw-medium">Teacher Photo</label>
                                <input type="file" name="teacher_photo" id="teacher_photo" accept="image/*" class="form-control" />
                                @error('teacher_photo')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Professional Info -->
                        <div class="card-style mb-4 rounded-3 shadow-sm border-0" style="background: #ffffff;">
                            <h5 class="mb-4 pb-2 border-bottom" style="color: #4a5568;">
                                <i class="lni lni-briefcase me-2 text-primary"></i> Professional Information
                            </h5>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label for="employment_status" class="form-label fw-medium">Employment Status</label>
                                        <select name="employment_status" id="employment_status" class="form-select" required>
                                            <option value="">-- Select Status --</option>
                                            <option value="honorary" {{ old('employment_status') == 'honorary' ? 'selected' : '' }}>Honorary</option>
                                            <option value="permanent" {{ old('employment_status') == 'permanent' ? 'selected' : '' }}>Permanent</option>
                                        </select>
                                        @error('employment_status')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label for="highest_education" class="form-label fw-medium">Highest Education</label>
                                        <select name="highest_education" id="highest_education" class="form-select">
                                            <option value="">-- Select Education Level --</option>
                                            <option value="bachelor" {{ old('highest_education') == 'bachelor' ? 'selected' : '' }}>Bachelor's Degree (S1)</option>
                                            <option value="master" {{ old('highest_education') == 'master' ? 'selected' : '' }}>Master's Degree (S2)</option>
                                            <option value="doctoral" {{ old('highest_education') == 'doctoral' ? 'selected' : '' }}>Doctoral Degree (S3)</option>
                                        </select>
                                        @error('highest_education')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label for="years_of_experience" class="form-label fw-medium">Years of Experience</label>
                                        <input type="number" name="years_of_experience" id="years_of_experience" min="0"
                                            value="{{ old('years_of_experience', 0) }}" class="form-control" />
                                        @error('years_of_experience')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label for="gender" class="form-label fw-medium">Gender</label>
                                        <select name="gender" id="gender" required class="form-select">
                                            <option value="">-- Select Gender --</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        @error('gender')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Personal Details -->
                        <div class="card-style mb-4 rounded-3 shadow-sm border-0" style="background: #ffffff;">
                            <h5 class="mb-4 pb-2 border-bottom" style="color: #4a5568;">
                                <i class="lni lni-calendar me-2 text-primary"></i> Personal Details
                            </h5>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="input-style-1">
                                        <label for="birth_date" class="form-label fw-medium">Date of Birth</label>
                                        <input type="date" name="birth_date" id="birth_date"
                                            value="{{ old('birth_date') }}" class="form-control" />
                                        @error('birth_date')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-style-1">
                                        <label for="religion" class="form-label fw-medium">Religion</label>
                                        <select name="religion" id="religion" class="form-select">
                                            <option value="">-- Select Religion --</option>
                                            <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Christian" {{ old('religion') == 'Christian' ? 'selected' : '' }}>Christian</option>
                                            <option value="Catholic" {{ old('religion') == 'Catholic' ? 'selected' : '' }}>Catholic</option>
                                            <option value="Buddhist" {{ old('religion') == 'Buddhist' ? 'selected' : '' }}>Buddhist</option>
                                            <option value="Protestant" {{ old('religion') == 'Protestant' ? 'selected' : '' }}>Protestant</option>
                                            <option value="Jewish" {{ old('religion') == 'Jewish' ? 'selected' : '' }}>Jewish</option>
                                            <option value="Atheist" {{ old('religion') == 'Atheist' ? 'selected' : '' }}>Atheist</option>
                                        </select>
                                        @error('religion')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-style-1">
                                        <label for="blood_type" class="form-label fw-medium">Blood Type</label>
                                        <select name="blood_type" id="blood_type" class="form-select">
                                            <option value="">-- Select Blood Type --</option>
                                            <option value="A" {{ old('blood_type') == 'A' ? 'selected' : '' }}>A</option>
                                            <option value="B" {{ old('blood_type') == 'B' ? 'selected' : '' }}>B</option>
                                            <option value="AB" {{ old('blood_type') == 'AB' ? 'selected' : '' }}>AB</option>
                                            <option value="O" {{ old('blood_type') == 'O' ? 'selected' : '' }}>O</option>
                                        </select>
                                        @error('blood_type')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="input-style-1">
                                        <label for="address" class="form-label fw-medium">Address</label>
                                        <textarea name="address" id="address" class="form-control" rows="2" placeholder="Enter address">{{ old('address') }}</textarea>
                                        @error('address')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-style-1">
                                        <label for="phone_number" class="form-label fw-medium">Phone Number</label>
                                        <input type="text" name="phone_number" id="phone_number" placeholder="Enter phone number"
                                            value="{{ old('phone_number') }}" class="form-control" />
                                        @error('phone_number')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Subjects -->
                        <div class="card-style mb-4 rounded-3 shadow-sm border-0" style="background: #ffffff;">
                            <h5 class="mb-4 pb-2 border-bottom" style="color: #4a5568;">
                                <i class="lni lni-book me-2 text-primary"></i> Subjects
                            </h5>
                            @php
                                $selectedSubjects = old('teacher_role', []);
                                $selectedSubjects = is_array($selectedSubjects) ? $selectedSubjects : [$selectedSubjects];
                            @endphp
                            <div class="row g-2">
                                <div class="col-md-6">
                                    @foreach([
                                        ['value' => 'Religious Education & Character Education', 'label' => 'Religious Education & Character Education'],
                                        ['value' => 'PPKn', 'label' => 'PPKn (Pancasila & Citizenship)'],
                                        ['value' => 'Indonesian', 'label' => 'Indonesian Language'],
                                        ['value' => 'English', 'label' => 'English Language'],
                                        ['value' => 'Mathematics', 'label' => 'Mathematics']
                                    ] as $subject)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="teacher_role[]"
                                                id="subject_{{ Str::slug($subject['value']) }}"
                                                value="{{ $subject['value'] }}"
                                                {{ in_array($subject['value'], $selectedSubjects) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="subject_{{ Str::slug($subject['value']) }}">
                                                {{ $subject['label'] }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-6">
                                    @foreach([
                                        ['value' => 'PJOK', 'label' => 'Physical Education (PJOK)'],
                                        ['value' => 'Indonesian History', 'label' => 'Indonesian History'],
                                        ['value' => 'Informatics / ICT', 'label' => 'Informatics / ICT'],
                                        ['value' => 'Arts and Culture', 'label' => 'Arts and Culture'],
                                        ['value' => 'Crafts / Sociology', 'label' => 'Crafts / Sociology (Elective)']
                                    ] as $subject)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="teacher_role[]"
                                                id="subject_{{ Str::slug($subject['value']) }}"
                                                value="{{ $subject['value'] }}"
                                                {{ in_array($subject['value'], $selectedSubjects) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="subject_{{ Str::slug($subject['value']) }}">
                                                {{ $subject['label'] }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @error('teacher_role')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm">
                                <i class="lni lni-save me-1"></i> Simpan
                            </button>
                            @if (!request()->ajax())
                                <a href="{{ route('teachers.index') }}" class="btn btn-outline-secondary px-4 py-2">
                                    <i class="lni lni-arrow-left me-1"></i> Back
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@if (!request()->ajax())
    @endsection
@endif