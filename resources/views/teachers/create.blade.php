@if (!request()->ajax())
    @extends('layouts.app')
    @section('title', __('app.add_teacher'))
    @section('content')
@endif

<section class="tab-components">
    <style>
        /* Modern Form Styling for Teacher Modal/Page */
        .teacher-form-wrapper {
            padding: 8px;
        }

        .teacher-form-wrapper .section-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 20px;
            margin-bottom: 20px;
        }

        .teacher-form-wrapper .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid #f1f5f9;
        }

        .teacher-form-wrapper .section-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .teacher-form-wrapper .section-icon.green { background: #dcfce7; color: #16a34a; }
        .teacher-form-wrapper .section-icon.blue { background: #dbeafe; color: #2563eb; }
        .teacher-form-wrapper .section-icon.purple { background: #ede9fe; color: #7c3aed; }
        .teacher-form-wrapper .section-icon.orange { background: #ffedd5; color: #ea580c; }
        .teacher-form-wrapper .section-icon.pink { background: #fce7f3; color: #db2777; }

        .teacher-form-wrapper .section-title {
            font-size: 1rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
        }

        .teacher-form-wrapper .section-subtitle {
            font-size: 0.8125rem;
            color: #6b7280;
            margin: 2px 0 0 0;
        }

        /* Info Box */
        .teacher-form-wrapper .info-box {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 14px;
            background: #eff6ff;
            border-radius: 8px;
            border-left: 3px solid #3b82f6;
            margin-bottom: 16px;
        }

        .teacher-form-wrapper .info-box i {
            color: #3b82f6;
            font-size: 16px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .teacher-form-wrapper .info-box p {
            margin: 0;
            font-size: 0.8125rem;
            color: #1e40af;
            line-height: 1.4;
        }

        /* Form Grid */
        .teacher-form-wrapper .form-grid {
            display: grid;
            gap: 16px;
        }

        .teacher-form-wrapper .form-grid.cols-2 {
            grid-template-columns: repeat(2, 1fr);
        }

        .teacher-form-wrapper .form-grid.cols-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        @media (max-width: 640px) {
            .teacher-form-wrapper .form-grid.cols-2,
            .teacher-form-wrapper .form-grid.cols-3 {
                grid-template-columns: 1fr;
            }
        }

        /* Form Field */
        .teacher-form-wrapper .form-field {
            margin-bottom: 0;
        }

        .teacher-form-wrapper .form-field label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }

        .teacher-form-wrapper .form-field label .req {
            color: #ef4444;
            margin-left: 2px;
        }

        .teacher-form-wrapper .form-field input[type="text"],
        .teacher-form-wrapper .form-field input[type="email"],
        .teacher-form-wrapper .form-field input[type="password"],
        .teacher-form-wrapper .form-field input[type="number"],
        .teacher-form-wrapper .form-field input[type="date"],
        .teacher-form-wrapper .form-field select,
        .teacher-form-wrapper .form-field textarea {
            width: 100%;
            padding: 10px 12px;
            font-size: 0.875rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #fff;
            color: #1f2937;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .teacher-form-wrapper .form-field input:focus,
        .teacher-form-wrapper .form-field select:focus,
        .teacher-form-wrapper .form-field textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .teacher-form-wrapper .form-field input::placeholder,
        .teacher-form-wrapper .form-field textarea::placeholder {
            color: #9ca3af;
        }

        .teacher-form-wrapper .form-field select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 36px;
        }

        /* Photo Upload */
        .teacher-form-wrapper .photo-upload {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            background: #f9fafb;
            border: 1px dashed #d1d5db;
            border-radius: 10px;
            margin-top: 8px;
        }

        .teacher-form-wrapper .photo-preview-box {
            width: 72px;
            height: 72px;
            border-radius: 10px;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .teacher-form-wrapper .photo-preview-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .teacher-form-wrapper .photo-preview-box i {
            font-size: 28px;
            color: #9ca3af;
        }

        .teacher-form-wrapper .photo-upload-info {
            flex: 1;
        }

        .teacher-form-wrapper .photo-upload-info .title {
            font-weight: 600;
            font-size: 0.875rem;
            color: #1f2937;
            margin-bottom: 2px;
        }

        .teacher-form-wrapper .photo-upload-info .desc {
            font-size: 0.75rem;
            color: #6b7280;
            margin-bottom: 10px;
        }

        .teacher-form-wrapper .upload-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 0.8125rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .teacher-form-wrapper .upload-btn:hover {
            background: #2563eb;
        }

        /* Subjects Grid */
        .teacher-form-wrapper .subjects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 10px;
            max-height: 280px;
            overflow-y: auto;
            padding: 4px;
        }

        .teacher-form-wrapper .subject-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .teacher-form-wrapper .subject-item:hover {
            border-color: #3b82f6;
            background: #f8fafc;
        }

        .teacher-form-wrapper .subject-item.selected {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .teacher-form-wrapper .subject-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #3b82f6;
            cursor: pointer;
            flex-shrink: 0;
        }

        .teacher-form-wrapper .subject-item .subject-details {
            flex: 1;
            min-width: 0;
        }

        .teacher-form-wrapper .subject-item .subject-name {
            font-weight: 500;
            font-size: 0.875rem;
            color: #1f2937;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .teacher-form-wrapper .subject-item .subject-meta {
            font-size: 0.75rem;
            color: #6b7280;
        }

        /* Warning Box */
        .teacher-form-wrapper .warning-box {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 14px;
            background: #fffbeb;
            border-radius: 8px;
            border-left: 3px solid #f59e0b;
        }

        .teacher-form-wrapper .warning-box i {
            color: #f59e0b;
            font-size: 16px;
            flex-shrink: 0;
        }

        .teacher-form-wrapper .warning-box p {
            margin: 0;
            font-size: 0.8125rem;
            color: #92400e;
        }

        .teacher-form-wrapper .warning-box a {
            color: #92400e;
            font-weight: 600;
            text-decoration: underline;
        }

        /* Error Message */
        .teacher-form-wrapper .error-msg {
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 4px;
            font-size: 0.75rem;
            color: #dc2626;
        }

        /* Action Buttons */
        .teacher-form-wrapper .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            padding-top: 8px;
        }

        .teacher-form-wrapper .btn-save {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            background: #10b981;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .teacher-form-wrapper .btn-save:hover {
            background: #059669;
        }

        .teacher-form-wrapper .btn-cancel {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 18px;
            background: #f3f4f6;
            color: #4b5563;
            border: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s ease;
        }

        .teacher-form-wrapper .btn-cancel:hover {
            background: #e5e7eb;
            color: #374151;
        }
    </style>

    <div class="container-fluid">
        @if (!request()->ajax())
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2 class="title">{{ __('app.add_teacher') }}</h2>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="breadcrumb" class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">{{ __('app.teachers') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('app.add_teacher') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        @endif

        <div class="teacher-form-wrapper">
            <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data" id="teacherForm">
                @csrf

                <!-- Account Credentials -->
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-icon green">
                            <i class="lni lni-key"></i>
                        </div>
                        <div>
                            <h3 class="section-title">Akun Login Guru</h3>
                            <p class="section-subtitle">Kredensial untuk akses ke dashboard</p>
                        </div>
                    </div>
                    
                    <div class="info-box">
                        <i class="lni lni-information-circle"></i>
                        <p>Akun ini akan digunakan oleh guru untuk login ke dashboard dan mengakses fitur-fitur khusus guru.</p>
                    </div>

                    <div class="form-grid cols-3">
                        <div class="form-field">
                            <label for="email">Email <span class="req">*</span></label>
                            <input type="email" name="email" id="email" placeholder="contoh@email.com" value="{{ old('email') }}" required />
                            @error('email')
                                <span class="error-msg"><i class="lni lni-warning"></i> {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-field">
                            <label for="password">Password <span class="req">*</span></label>
                            <input type="password" name="password" id="password" placeholder="Minimal 8 karakter" required />
                            @error('password')
                                <span class="error-msg"><i class="lni lni-warning"></i> {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-field">
                            <label for="password_confirmation">Konfirmasi Password <span class="req">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password" required />
                        </div>
                    </div>
                </div>

                <!-- Personal Info -->
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-icon blue">
                            <i class="lni lni-user"></i>
                        </div>
                        <div>
                            <h3 class="section-title">{{ __('app.personal_information') }}</h3>
                            <p class="section-subtitle">Informasi dasar dan identitas guru</p>
                        </div>
                    </div>

                    <div class="form-grid cols-2">
                        <div class="form-field">
                            <label for="full_name">{{ __('app.full_name') }} <span class="req">*</span></label>
                            <input type="text" name="full_name" id="full_name" placeholder="{{ __('app.enter_full_name') }}" value="{{ old('full_name') }}" required />
                            @error('full_name')
                                <span class="error-msg"><i class="lni lni-warning"></i> {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-field">
                            <label for="teacher_number">{{ __('app.teacher_number') }} <span class="req">*</span></label>
                            <input type="text" name="teacher_number" id="teacher_number" placeholder="{{ __('app.enter_teacher_id') }}" value="{{ old('teacher_number') }}" required />
                            @error('teacher_number')
                                <span class="error-msg"><i class="lni lni-warning"></i> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Photo Upload -->
                    <div class="form-field" style="margin-top: 16px;">
                        <label>{{ __('app.teacher_photo') }}</label>
                        <div class="photo-upload">
                            <div class="photo-preview-box" id="photoPreview">
                                <i class="lni lni-camera"></i>
                            </div>
                            <div class="photo-upload-info">
                                <div class="title">Upload Foto Profil</div>
                                <div class="desc">Format: JPG, PNG, atau GIF. Maksimal 2MB.</div>
                                <label class="upload-btn">
                                    <i class="lni lni-upload"></i>
                                    <span>Pilih Foto</span>
                                    <input type="file" name="teacher_photo" id="teacher_photo" accept="image/*" style="display: none;" onchange="previewPhoto(this)" />
                                </label>
                            </div>
                        </div>
                        @error('teacher_photo')
                            <span class="error-msg"><i class="lni lni-warning"></i> {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Professional Info -->
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-icon purple">
                            <i class="lni lni-briefcase"></i>
                        </div>
                        <div>
                            <h3 class="section-title">{{ __('app.professional_information') }}</h3>
                            <p class="section-subtitle">Status kepegawaian dan riwayat pendidikan</p>
                        </div>
                    </div>

                    <div class="form-grid cols-2">
                        <div class="form-field">
                            <label for="employment_status">{{ __('app.employment_status') }} <span class="req">*</span></label>
                            <select name="employment_status" id="employment_status" required>
                                <option value="">-- {{ __('app.select_status') }} --</option>
                                <option value="honorary" {{ old('employment_status') == 'honorary' ? 'selected' : '' }}>{{ __('app.honorary') }}</option>
                                <option value="permanent" {{ old('employment_status') == 'permanent' ? 'selected' : '' }}>{{ __('app.permanent') }}</option>
                            </select>
                            @error('employment_status')
                                <span class="error-msg"><i class="lni lni-warning"></i> {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-field">
                            <label for="highest_education">{{ __('app.highest_education') }}</label>
                            <select name="highest_education" id="highest_education">
                                <option value="">-- {{ __('app.select_education_level') }} --</option>
                                <option value="bachelor" {{ old('highest_education') == 'bachelor' ? 'selected' : '' }}>{{ __('app.bachelors_degree') }}</option>
                                <option value="master" {{ old('highest_education') == 'master' ? 'selected' : '' }}>{{ __('app.masters_degree') }}</option>
                                <option value="doctoral" {{ old('highest_education') == 'doctoral' ? 'selected' : '' }}>{{ __('app.doctoral_degree') }}</option>
                            </select>
                            @error('highest_education')
                                <span class="error-msg"><i class="lni lni-warning"></i> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-grid cols-2" style="margin-top: 16px;">
                        <div class="form-field">
                            <label for="years_of_experience">{{ __('app.years_of_experience') }}</label>
                            <input type="number" name="years_of_experience" id="years_of_experience" min="0" value="{{ old('years_of_experience', 0) }}" />
                            @error('years_of_experience')
                                <span class="error-msg"><i class="lni lni-warning"></i> {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-field">
                            <label for="gender">{{ __('app.gender') }} <span class="req">*</span></label>
                            <select name="gender" id="gender" required>
                                <option value="">-- {{ __('app.select_gender') }} --</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>{{ __('app.male') }}</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>{{ __('app.female') }}</option>
                            </select>
                            @error('gender')
                                <span class="error-msg"><i class="lni lni-warning"></i> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Personal Details -->
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-icon orange">
                            <i class="lni lni-calendar"></i>
                        </div>
                        <div>
                            <h3 class="section-title">{{ __('app.personal_details') }}</h3>
                            <p class="section-subtitle">Data pribadi dan kontak</p>
                        </div>
                    </div>

                    <div class="form-grid cols-3">
                        <div class="form-field">
                            <label for="birth_date">{{ __('app.date_of_birth') }}</label>
                            <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" />
                            @error('birth_date')
                                <span class="error-msg"><i class="lni lni-warning"></i> {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-field">
                            <label for="religion">{{ __('app.religion') }}</label>
                            <select name="religion" id="religion">
                                <option value="">-- {{ __('app.select_religion') }} --</option>
                                <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>{{ __('app.islam') }}</option>
                                <option value="Christian" {{ old('religion') == 'Christian' ? 'selected' : '' }}>{{ __('app.christian') }}</option>
                                <option value="Catholic" {{ old('religion') == 'Catholic' ? 'selected' : '' }}>{{ __('app.catholic') }}</option>
                                <option value="Buddhist" {{ old('religion') == 'Buddhist' ? 'selected' : '' }}>{{ __('app.buddhist') }}</option>
                                <option value="Protestant" {{ old('religion') == 'Protestant' ? 'selected' : '' }}>{{ __('app.protestant') }}</option>
                                <option value="Jewish" {{ old('religion') == 'Jewish' ? 'selected' : '' }}>{{ __('app.jewish') }}</option>
                                <option value="Atheist" {{ old('religion') == 'Atheist' ? 'selected' : '' }}>{{ __('app.atheist') }}</option>
                            </select>
                            @error('religion')
                                <span class="error-msg"><i class="lni lni-warning"></i> {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-field">
                            <label for="blood_type">{{ __('app.blood_type') }}</label>
                            <select name="blood_type" id="blood_type">
                                <option value="">-- {{ __('app.select_blood_type') }} --</option>
                                <option value="A" {{ old('blood_type') == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('blood_type') == 'B' ? 'selected' : '' }}>B</option>
                                <option value="AB" {{ old('blood_type') == 'AB' ? 'selected' : '' }}>AB</option>
                                <option value="O" {{ old('blood_type') == 'O' ? 'selected' : '' }}>O</option>
                            </select>
                            @error('blood_type')
                                <span class="error-msg"><i class="lni lni-warning"></i> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-grid cols-2" style="margin-top: 16px;">
                        <div class="form-field">
                            <label for="address">{{ __('app.address') }}</label>
                            <textarea name="address" id="address" rows="3" placeholder="{{ __('app.enter_address') }}">{{ old('address') }}</textarea>
                            @error('address')
                                <span class="error-msg"><i class="lni lni-warning"></i> {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-field">
                            <label for="phone_number">{{ __('app.phone_number') }}</label>
                            <input type="text" name="phone_number" id="phone_number" placeholder="{{ __('app.enter_phone_number') }}" value="{{ old('phone_number') }}" />
                            @error('phone_number')
                                <span class="error-msg"><i class="lni lni-warning"></i> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Subjects Section -->
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-icon pink">
                            <i class="lni lni-book"></i>
                        </div>
                        <div>
                            <h3 class="section-title">Mata Pelajaran yang Diampu <span class="req">*</span></h3>
                            <p class="section-subtitle">Pilih satu atau lebih mata pelajaran</p>
                        </div>
                    </div>

                    @php
                        $selectedSubjects = old('subjects', []);
                    @endphp
                    
                    @if($subjects->count() > 0)
                        <div class="subjects-grid">
                            @foreach($subjects as $subject)
                                <label class="subject-item {{ in_array($subject->id, $selectedSubjects) ? 'selected' : '' }}" for="subject_{{ $subject->id }}" onclick="toggleSubject(this)">
                                    <input type="checkbox" name="subjects[]" id="subject_{{ $subject->id }}" value="{{ $subject->id }}" {{ in_array($subject->id, $selectedSubjects) ? 'checked' : '' }}>
                                    <div class="subject-details">
                                        <div class="subject-name">{{ $subject->subject_name }}</div>
                                        <div class="subject-meta">Kelas {{ $subject->class_level }} - {{ $subject->major }}</div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <div class="warning-box">
                            <i class="lni lni-warning"></i>
                            <p>Belum ada mata pelajaran yang tersedia. Silakan tambahkan mata pelajaran terlebih dahulu di <a href="{{ route('subjects.index') }}">modul Mata Pelajaran</a>.</p>
                        </div>
                    @endif
                    @error('subjects')
                        <span class="error-msg"><i class="lni lni-warning"></i> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="form-actions">
                    @if (!request()->ajax())
                        <a href="{{ route('teachers.index') }}" class="btn-cancel">
                            <i class="lni lni-arrow-left"></i> {{ __('app.back') }}
                        </a>
                    @endif
                    <button type="submit" class="btn-save">
                        <i class="lni lni-save"></i> {{ __('app.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Photo Preview Function
        function previewPhoto(input) {
            var preview = document.getElementById('photoPreview');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Toggle Subject Selection Visual
        function toggleSubject(label) {
            var checkbox = label.querySelector('input[type="checkbox"]');
            setTimeout(function() {
                if (checkbox.checked) {
                    label.classList.add('selected');
                } else {
                    label.classList.remove('selected');
                }
            }, 10);
        }
    </script>
</section>

@if (!request()->ajax())
    @endsection
@endif