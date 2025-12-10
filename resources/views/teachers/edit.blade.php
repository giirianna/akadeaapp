@if (!request()->ajax())
    @extends('layouts.app')
    @section('title', __('app.edit_teacher'))
    @section('content')
@endif

<section class="tab-components">
    <div class="container-fluid">
        @if (!request()->ajax())
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ __('app.edit_teacher') }}</h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('teachers.index') }}">{{ __('app.teachers') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ __('app.edit_teacher') }}
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
                    <form
                        action="{{ route('teachers.update', $teacher) }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        @method('PUT')

                        <!-- {{ __('app.personal_information') }} -->
                        <div class="card-style mb-4 rounded-3 shadow-sm border-0" style="background: #ffffff;">
                            <h5 class="mb-4 pb-2 border-bottom" style="color: #4a5568;">
                                <i class="lni lni-user me-2 text-primary"></i> {{ __('app.personal_information') }}
                            </h5>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label for="full_name" class="form-label fw-medium">{{ __('app.full_name') }}</label>
                                        <input
                                            type="text"
                                            name="full_name"
                                            id="full_name"
                                            placeholder="{{ __('app.enter_full_name') }}"
                                            value="{{ old('full_name', $teacher->full_name) }}"
                                            required
                                            class="form-control"
                                        />
                                        @error('full_name')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label for="teacher_number" class="form-label fw-medium">{{ __('app.teacher_number') }}</label>
                                        <input
                                            type="text"
                                            name="teacher_number"
                                            id="teacher_number"
                                            placeholder="{{ __('app.enter_teacher_id') }}"
                                            value="{{ old('teacher_number', $teacher->teacher_number) }}"
                                            required
                                            class="form-control"
                                        />
                                        @error('teacher_number')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Photo -->
                            <div class="mb-4">
                                <label class="form-label fw-medium">{{ __('app.teacher_photo') }}</label>
                                <input
                                    type="file"
                                    name="teacher_photo"
                                    id="teacher_photo"
                                    accept="image/*"
                                    class="form-control"
                                />
                                @if ($teacher->photo)
                                    <div class="mt-2">
                                        <img
                                            src="{{ asset('storage/' . $teacher->photo) }}"
                                            alt="{{ __('app.teacher_photo') }}"
                                            class="img-thumbnail rounded"
                                            style="max-width: 120px; height: auto; border: 2px solid #e2e8f0;"
                                        >
                                    </div>
                                @endif
                                @error('teacher_photo')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- {{ __('app.professional_information') }} -->
                        <div class="card-style mb-4 rounded-3 shadow-sm border-0" style="background: #ffffff;">
                            <h5 class="mb-4 pb-2 border-bottom" style="color: #4a5568;">
                                <i class="lni lni-briefcase me-2 text-primary"></i> {{ __('app.professional_information') }}
                            </h5>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label for="employment_status" class="form-label fw-medium">{{ __('app.employment_status') }}</label>
                                        <select name="employment_status" id="employment_status" class="form-select">
                                            <option value="">-- {{ __('app.select_status') }} --</option>
                                            <option value="honorary" {{ old('employment_status', $teacher->employment_status) == 'honorary' ? 'selected' : '' }}>
                                                Honorary
                                            </option>
                                            <option value="permanent" {{ old('employment_status', $teacher->employment_status) == 'permanent' ? 'selected' : '' }}>
                                                Permanent
                                            </option>
                                        </select>
                                        @error('employment_status')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label for="highest_education" class="form-label fw-medium">{{ __('app.highest_education') }}</label>
                                        <select name="highest_education" id="highest_education" class="form-select">
                                            <option value="">-- {{ __('app.select_education_level') }} --</option>
                                            <option value="bachelor" {{ old('highest_education', $teacher->highest_education) == 'bachelor' ? 'selected' : '' }}>
                                                {{ __('app.bachelors_degree') }}
                                            </option>
                                            <option value="master" {{ old('highest_education', $teacher->highest_education) == 'master' ? 'selected' : '' }}>
                                                {{ __('app.masters_degree') }}
                                            </option>
                                            <option value="doctoral" {{ old('highest_education', $teacher->highest_education) == 'doctoral' ? 'selected' : '' }}>
                                                {{ __('app.doctoral_degree') }}
                                            </option>
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
                                        <label for="years_of_experience" class="form-label fw-medium">{{ __('app.years_of_experience') }}</label>
                                        <input
                                            type="number"
                                            name="years_of_experience"
                                            id="years_of_experience"
                                            min="0"
                                            value="{{ old('years_of_experience', $teacher->years_of_experience) }}"
                                            class="form-control"
                                        />
                                        @error('years_of_experience')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label for="gender" class="form-label fw-medium"{{ __('app.gender') }}</label>
                                        <select name="gender" id="gender" required class="form-select">
                                            <option value="">-- {{ __('app.select_gender') }} --</option>
                                            <option value="male" {{ old('gender', $teacher->gender) == 'male' ? 'selected' : '' }}>
                                                Male
                                            </option>
                                            <option value="female" {{ old('gender', $teacher->gender) == 'female' ? 'selected' : '' }}>
                                                Female
                                            </option>
                                        </select>
                                        @error('gender')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- {{ __('app.personal_details') }} -->
                        <div class="card-style mb-4 rounded-3 shadow-sm border-0" style="background: #ffffff;">
                            <h5 class="mb-4 pb-2 border-bottom" style="color: #4a5568;">
                                <i class="lni lni-calendar me-2 text-primary"></i> {{ __('app.personal_details') }}
                            </h5>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-style-1">
                                        <label for="birth_date" class="form-label fw-medium">{{ __('app.date_of_birth') }}</label>
                                        <input
                                            type="date"
                                            name="birth_date"
                                            id="birth_date"
                                            value="{{ old('birth_date', $teacher->birth_date) }}"
                                            class="form-control"
                                        />
                                        @error('birth_date')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="input-style-1">
                                        <label for="religion" class="form-label fw-medium"{{ __('app.religion') }}</label>
                                        <select name="religion" id="religion" class="form-select">
                                            <option value="">-- {{ __('app.select_religion') }} --</option>
                                            <option value="Islam" {{ old('religion', $teacher->religion) == 'Islam' ? 'selected' : '' }}>
                                                Islam
                                            </option>
                                            <option value="Christian" {{ old('religion', $teacher->religion) == 'Christian' ? 'selected' : '' }}>
                                                Christian
                                            </option>
                                            <option value="Catholic" {{ old('religion', $teacher->religion) == 'Catholic' ? 'selected' : '' }}>
                                                Catholic
                                            </option>
                                            <option value="Buddhist" {{ old('religion', $teacher->religion) == 'Buddhist' ? 'selected' : '' }}>
                                                Buddhist
                                            </option>
                                            <option value="Protestant" {{ old('religion', $teacher->religion) == 'Protestant' ? 'selected' : '' }}>
                                                Protestant
                                            </option>
                                            <option value="Jewish" {{ old('religion', $teacher->religion) == 'Jewish' ? 'selected' : '' }}>
                                                Jewish
                                            </option>
                                            <option value="Atheist" {{ old('religion', $teacher->religion) == 'Atheist' ? 'selected' : '' }}>
                                                Atheist
                                            </option>
                                        </select>
                                        @error('religion')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="input-style-1">
                                        <label for="blood_type" class="form-label fw-medium">{{ __('app.blood_type') }}</label>
                                        <select name="blood_type" id="blood_type" class="form-select">
                                            <option value="">-- Select {{ __('app.blood_type') }} --</option>
                                            <option value="A" {{ old('blood_type', $teacher->blood_type) == 'A' ? 'selected' : '' }}>
                                                A
                                            </option>
                                            <option value="B" {{ old('blood_type', $teacher->blood_type) == 'B' ? 'selected' : '' }}>
                                                B
                                            </option>
                                            <option value="AB" {{ old('blood_type', $teacher->blood_type) == 'AB' ? 'selected' : '' }}>
                                                AB
                                            </option>
                                            <option value="O" {{ old('blood_type', $teacher->blood_type) == 'O' ? 'selected' : '' }}>
                                                O
                                            </option>
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
                                        <label for="address" class="form-label fw-medium"{{ __('app.address') }}</label>
                                        <textarea
                                            name="address"
                                            id="address"
                                            class="form-control"
                                            rows="2"
                                            placeholder="{{ __('app.enter_address') }}"
                                        >{{ old('address', $teacher->address) }}</textarea>
                                        @error('address')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="input-style-1">
                                        <label for="phone_number" class="form-label fw-medium">{{ __('app.phone_number') }}</label>
                                        <input
                                            type="text"
                                            name="phone_number"
                                            id="phone_number"
                                            placeholder="{{ __('app.enter_phone_number') }}"
                                            value="{{ old('phone_number', $teacher->phone_number) }}"
                                            class="form-control"
                                        />
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
                                $storedSubjects = $teacher->teacher_role ? explode(',', $teacher->teacher_role) : [];
                                $selectedSubjects = old('teacher_role', $storedSubjects);
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
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="teacher_role[]"
                                                id="subject_{{ Str::slug($subject['value']) }}"
                                                value="{{ $subject['value'] }}"
                                                {{ in_array($subject['value'], $selectedSubjects) ? 'checked' : '' }}
                                            >
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
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="teacher_role[]"
                                                id="subject_{{ Str::slug($subject['value']) }}"
                                                value="{{ $subject['value'] }}"
                                                {{ in_array($subject['value'], $selectedSubjects) ? 'checked' : '' }}
                                            >
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
                            <button type="submit" class="btn btn-success px-4 py-2 shadow-sm">
                                <i class="lni lni-save me-1"></i> Update
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
