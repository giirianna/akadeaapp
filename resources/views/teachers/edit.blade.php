@extends('layouts.app')

@section('title', 'Edit Guru')

@section('content')
<<<<<<< HEAD
<section class="form-components">
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Edit Guru</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">Guru</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <form action="{{ route('teachers.update', $teacher) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label for="teacher_number">Nomor Guru/NIP <span class="text-danger">*</span></label>
                                    <input type="text" name="teacher_number" id="teacher_number" value="{{ old('teacher_number', $teacher->teacher_number) }}" required>
                                    @error('teacher_number')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label for="full_name">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $teacher->full_name) }}" required>
                                    @error('full_name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label for="teacher_role">Jabatan</label>
                                    <input type="text" name="teacher_role" id="teacher_role" value="{{ old('teacher_role', $teacher->teacher_role) }}" placeholder="Misal: Wali Kelas, Koordinator">
                                    @error('teacher_role')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label for="employment_status">Status Kepegawaian</label>
                                    <input type="text" name="employment_status" id="employment_status" value="{{ old('employment_status', $teacher->employment_status) }}" placeholder="PNS, Honorer, dll">
                                    @error('employment_status')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="input-style-1">
                                    <label for="gender">Jenis Kelamin</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="">Pilih</option>
                                        <option value="male" {{ (old('gender') ?? $teacher->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="female" {{ (old('gender') ?? $teacher->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('gender')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-style-1">
                                    <label for="religion">Agama</label>
                                    <input type="text" name="religion" id="religion" value="{{ old('religion', $teacher->religion) }}" placeholder="Islam, Kristen, dll">
                                    @error('religion')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-style-1">
                                    <label for="blood_type">Golongan Darah</label>
                                    <input type="text" name="blood_type" id="blood_type" value="{{ old('blood_type', $teacher->blood_type) }}" placeholder="A, B, AB, O">
                                    @error('blood_type')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label for="birth_date">Tanggal Lahir</label>
                                    <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $teacher->birth_date?->format('Y-m-d')) }}">
                                    @error('birth_date')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label for="phone_number">Nomor HP</label>
                                    <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $teacher->phone_number) }}" placeholder="0812...">
                                    @error('phone_number')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label for="highest_education">Pendidikan Terakhir</label>
                                    <input type="text" name="highest_education" id="highest_education" value="{{ old('highest_education', $teacher->highest_education) }}" placeholder="S1 Pendidikan">
                                    @error('highest_education')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label for="years_of_experience">Pengalaman (Tahun)</label>
                                    <input type="number" name="years_of_experience" id="years_of_experience" value="{{ old('years_of_experience', $teacher->years_of_experience) }}" min="0">
                                    @error('years_of_experience')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="input-style-1">
                                    <label for="address">Alamat</label>
                                    <textarea name="address" id="address" class="form-control" rows="2" placeholder="Jalan, Kota, Provinsi">{{ old('address', $teacher->address) }}</textarea>
                                    @error('address')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label for="photo">Ganti Foto Profil</label>
                                    <input type="file" name="photo" id="photo" accept="image/*">
                                    @error('photo')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                    @if($teacher->photo)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $teacher->photo) }}" alt="Foto saat ini" class="img-thumbnail" style="max-height: 100px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('teachers.index') }}" class="btn btn-light me-2">Batal</a>
                            <button type="submit" class="main-btn primary-btn btn-hover">Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
=======
    <!-- ========== tab components start ========== -->
    <section class="tab-components">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Edit Guru</h2>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('teachers.index') }}">Guru</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Guru</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== title-wrapper end ========== -->

            <!-- ========== form-elements-wrapper start ========== -->
            <div class="form-elements-wrapper">
                <div class="row">
                    <div class="col-lg-8">
                        <form action="{{ route('teachers.update', $teacher) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Full Name -->
                            <div class="card-style mb-30">
                                <div class="input-style-1">
                                    <label for="full_name">Nama Lengkap</label>
                                    <input type="text" name="full_name" id="full_name" placeholder="Masukkan nama lengkap"
                                        value="{{ old('full_name', $teacher->full_name) }}" required />
                                    @error('full_name')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Teacher Number -->
                            <div class="card-style mb-30">
                                <div class="input-style-1">
                                    <label for="teacher_number">Nomor Guru / NIP</label>
                                    <input type="text" name="teacher_number" id="teacher_number" placeholder="Masukkan nomor guru"
                                        value="{{ old('teacher_number', $teacher->teacher_number) }}" required />
                                    @error('teacher_number')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Role / Subjects (multiple checkboxes) -->
                            <div class="card-style mb-30">
                                <label class="mb-2 d-block">Mata Pelajaran</label>
                                @php
                                    $storedSubjects = $teacher->teacher_role ? explode(',', $teacher->teacher_role) : [];
                                    $selectedSubjects = old('teacher_role', $storedSubjects);
                                    if (!is_array($selectedSubjects)) {
                                        $selectedSubjects = [$selectedSubjects];
                                    }
                                @endphp
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="teacher_role[]" id="subject_religion"
                                                value="Religious Education & Character Education" {{ in_array('Religious Education & Character Education', $selectedSubjects) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="subject_religion">Pendidikan Agama & Budi Pekerti</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="teacher_role[]" id="subject_ppkn"
                                                value="PPKn" {{ in_array('PPKn', $selectedSubjects) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="subject_ppkn">PPKn (Pancasila & Kewarganegaraan)</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="teacher_role[]" id="subject_indonesian"
                                                value="Indonesian" {{ in_array('Indonesian', $selectedSubjects) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="subject_indonesian">Bahasa Indonesia</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="teacher_role[]" id="subject_english"
                                                value="English" {{ in_array('English', $selectedSubjects) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="subject_english">Bahasa Inggris</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="teacher_role[]" id="subject_math"
                                                value="Mathematics" {{ in_array('Mathematics', $selectedSubjects) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="subject_math">Matematika</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="teacher_role[]" id="subject_pjok"
                                                value="PJOK" {{ in_array('PJOK', $selectedSubjects) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="subject_pjok">PJOK</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="teacher_role[]" id="subject_history"
                                                value="Indonesian History" {{ in_array('Indonesian History', $selectedSubjects) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="subject_history">Sejarah Indonesia</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="teacher_role[]" id="subject_ict"
                                                value="Informatics / ICT" {{ in_array('Informatics / ICT', $selectedSubjects) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="subject_ict">Informatika / TIK</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="teacher_role[]" id="subject_arts"
                                                value="Arts and Culture" {{ in_array('Arts and Culture', $selectedSubjects) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="subject_arts">Seni Budaya</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="teacher_role[]" id="subject_crafts"
                                                value="Crafts / Sociology" {{ in_array('Crafts / Sociology', $selectedSubjects) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="subject_crafts">Keterampilan / Sosiologi (Peminatan)</label>
                                        </div>
                                    </div>
                                </div>
                                @error('teacher_role')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- end card -->

                            <!-- Employment Status -->
                            <div class="card-style mb-30">
                                <div class="select-style-1">
                                    <label for="employment_status">Status Kepegawaian</label>
                                    <div class="select-position">
                                        <select name="employment_status" id="employment_status">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="honorary" {{ old('employment_status', $teacher->employment_status) == 'honorary' ? 'selected' : '' }}>Honorer</option>
                                            <option value="permanent" {{ old('employment_status', $teacher->employment_status) == 'permanent' ? 'selected' : '' }}>Tetap</option>
                                        </select>
                                    </div>
                                    @error('employment_status')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Highest Education -->
                            <div class="card-style mb-30">
                                <div class="select-style-1">
                                    <label for="highest_education">Pendidikan Terakhir</label>
                                    <div class="select-position">
                                        <select name="highest_education" id="highest_education">
                                            <option value="">-- Pilih Pendidikan --</option>
                                            <option value="bachelor" {{ old('highest_education', $teacher->highest_education) == 'bachelor' ? 'selected' : '' }}>S1 (Sarjana)</option>
                                            <option value="master" {{ old('highest_education', $teacher->highest_education) == 'master' ? 'selected' : '' }}>S2 (Magister)</option>
                                            <option value="doctoral" {{ old('highest_education', $teacher->highest_education) == 'doctoral' ? 'selected' : '' }}>S3 (Doktor)</option>
                                        </select>
                                    </div>
                                    @error('highest_education')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Years of Experience -->
                            <div class="card-style mb-30">
                                <div class="input-style-1">
                                    <label for="years_of_experience">Pengalaman Mengajar (tahun)</label>
                                    <input type="number" name="years_of_experience" id="years_of_experience" min="0"
                                        value="{{ old('years_of_experience', $teacher->years_of_experience) }}" />
                                    @error('years_of_experience')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Gender -->
                            <div class="card-style mb-30">
                                <div class="select-style-1">
                                    <label for="gender">Jenis Kelamin</label>
                                    <div class="select-position">
                                        <select name="gender" id="gender" required>
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="male" {{ old('gender', $teacher->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="female" {{ old('gender', $teacher->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    @error('gender')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Religion -->
                            <div class="card-style mb-30">
                                <div class="select-style-1">
                                    <label for="religion">Agama</label>
                                    <div class="select-position">
                                        <select name="religion" id="religion">
                                            <option value="">-- Pilih Agama --</option>
                                            <option value="Islam" {{ old('religion', $teacher->religion) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Christian" {{ old('religion', $teacher->religion) == 'Christian' ? 'selected' : '' }}>Kristen</option>
                                            <option value="Catholic" {{ old('religion', $teacher->religion) == 'Catholic' ? 'selected' : '' }}>Katolik</option>
                                            <option value="Buddhist" {{ old('religion', $teacher->religion) == 'Buddhist' ? 'selected' : '' }}>Buddha</option>
                                            <option value="Protestant" {{ old('religion', $teacher->religion) == 'Protestant' ? 'selected' : '' }}>Protestan</option>
                                            <option value="Jewish" {{ old('religion', $teacher->religion) == 'Jewish' ? 'selected' : '' }}>Yahudi</option>
                                            <option value="Atheist" {{ old('religion', $teacher->religion) == 'Atheist' ? 'selected' : '' }}>Atheis</option>
                                        </select>
                                    </div>
                                    @error('religion')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Blood Type -->
                            <div class="card-style mb-30">
                                <div class="select-style-1">
                                    <label for="blood_type">Golongan Darah</label>
                                    <div class="select-position">
                                        <select name="blood_type" id="blood_type">
                                            <option value="">-- Pilih Golongan Darah --</option>
                                            <option value="A" {{ old('blood_type', $teacher->blood_type) == 'A' ? 'selected' : '' }}>A</option>
                                            <option value="B" {{ old('blood_type', $teacher->blood_type) == 'B' ? 'selected' : '' }}>B</option>
                                            <option value="AB" {{ old('blood_type', $teacher->blood_type) == 'AB' ? 'selected' : '' }}>AB</option>
                                            <option value="O" {{ old('blood_type', $teacher->blood_type) == 'O' ? 'selected' : '' }}>O</option>
                                        </select>
                                    </div>
                                    @error('blood_type')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Birth Date -->
                            <div class="card-style mb-30">
                                <div class="input-style-1">
                                    <label for="birth_date">Tanggal Lahir</label>
                                    <input type="date" name="birth_date" id="birth_date"
                                        value="{{ old('birth_date', $teacher->birth_date) }}" />
                                    @error('birth_date')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Address -->
                            <div class="card-style mb-30">
                                <label for="address">Alamat</label>
                                <textarea name="address" id="address" class="form-control" rows="4" placeholder="Masukkan alamat">{{ old('address', $teacher->address) }}</textarea>
                                @error('address')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- end card -->

                            <!-- Phone Number -->
                            <div class="card-style mb-30">
                                <div class="input-style-1">
                                    <label for="phone_number">No. Telepon</label>
                                    <input type="text" name="phone_number" id="phone_number" placeholder="Masukkan nomor telepon"
                                        value="{{ old('phone_number', $teacher->phone_number) }}" />
                                    @error('phone_number')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Photo -->
                            <div class="card-style mb-30">
                                <div class="input-style-1">
                                    <label for="teacher_photo">Foto Guru</label>
                                    <input type="file" name="teacher_photo" id="teacher_photo" accept="image/*" />
                                    @if($teacher->teacher_photo)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $teacher->teacher_photo) }}" alt="Foto Guru" style="max-width: 120px; border-radius: 8px;">
                                        </div>
                                    @endif
                                    @error('teacher_photo')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Buttons -->
                            <div class="card-style mb-30">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="icon"><i class="lni lni-save"></i></span> Update
                                    </button>
                                    <a href="{{ route('teachers.index') }}" class="btn btn-secondary">
                                        <span class="icon"><i class="lni lni-arrow-left"></i></span> Kembali
                                    </a>
                                </div>
                            </div>
                            <!-- end card -->
                        </form>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== form-elements-wrapper end ========== -->
        </div>
        <!-- end container-fluid -->
    </section>
    <!-- ========== tab components end ========== -->
@endsection
>>>>>>> 003c79269805b833399a5fc59703b21e24fe9c41
