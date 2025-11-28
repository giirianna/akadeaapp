@extends('layouts.app')

@section('title', 'Edit Guru')

@section('content')
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