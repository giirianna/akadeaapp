@extends('layouts.app')

@section('title', 'Tambah Guru')

@section('content')
    <!-- ========== tab components start ========== -->
    <section class="tab-components">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Tambah Guru</h2>
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
                                    <li class="breadcrumb-item active" aria-current="page">Tambah Guru</li>
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
                        <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Full Name -->
                            <div class="card-style mb-30">
                                <div class="input-style-1">
                                    <label for="full_name">Nama Lengkap</label>
                                    <input type="text" name="full_name" id="full_name" placeholder="Masukkan nama lengkap"
                                        value="{{ old('full_name') }}" required />
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
                                        value="{{ old('teacher_number') }}" required />
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
                                    $selectedSubjects = old('teacher_role', []);
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
                                            <option value="honorary" {{ old('employment_status') == 'honorary' ? 'selected' : '' }}>Honorer</option>
                                            <option value="permanent" {{ old('employment_status') == 'permanent' ? 'selected' : '' }}>Tetap</option>
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
                                            <option value="bachelor" {{ old('highest_education') == 'bachelor' ? 'selected' : '' }}>S1 (Sarjana)</option>
                                            <option value="master" {{ old('highest_education') == 'master' ? 'selected' : '' }}>S2 (Magister)</option>
                                            <option value="doctoral" {{ old('highest_education') == 'doctoral' ? 'selected' : '' }}>S3 (Doktor)</option>
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
                                        value="{{ old('years_of_experience', 0) }}" />
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
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
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
                                            <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Christian" {{ old('religion') == 'Christian' ? 'selected' : '' }}>Kristen</option>
                                            <option value="Catholic" {{ old('religion') == 'Catholic' ? 'selected' : '' }}>Katolik</option>
                                            <option value="Buddhist" {{ old('religion') == 'Buddhist' ? 'selected' : '' }}>Buddha</option>
                                            <option value="Protestant" {{ old('religion') == 'Protestant' ? 'selected' : '' }}>Protestan</option>
                                            <option value="Jewish" {{ old('religion') == 'Jewish' ? 'selected' : '' }}>Yahudi</option>
                                            <option value="Atheist" {{ old('religion') == 'Atheist' ? 'selected' : '' }}>Atheis</option>
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
                                            <option value="A" {{ old('blood_type') == 'A' ? 'selected' : '' }}>A</option>
                                            <option value="B" {{ old('blood_type') == 'B' ? 'selected' : '' }}>B</option>
                                            <option value="AB" {{ old('blood_type') == 'AB' ? 'selected' : '' }}>AB</option>
                                            <option value="O" {{ old('blood_type') == 'O' ? 'selected' : '' }}>O</option>
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
                                    <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" />
                                    @error('birth_date')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Address -->
                            <div class="card-style mb-30">
                                <label for="address">Alamat</label>
                                <textarea name="address" id="address" class="form-control" rows="4" placeholder="Masukkan alamat">{{ old('address') }}</textarea>
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
                                        value="{{ old('phone_number') }}" />
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
                                        <span class="icon"><i class="lni lni-save"></i></span> Simpan
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
