@extends('layouts.app')

@section('title', 'Tambah Mata Pelajaran')

@section('content')
<section class="form-components">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Tambah Mata Pelajaran</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Mata Pelajaran</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ========== title-wrapper end ========== -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <form action="{{ route('subjects.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label for="teacher_id">Guru Pengajar <span class="text-danger">*</span></label>
                                    <select name="teacher_id" id="teacher_id" class="form-control" required>
                                        <option value="">Pilih Guru</option>
                                        @foreach ($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                                {{ $teacher->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('teacher_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label for="subject_code">Kode Mata Pelajaran <span class="text-danger">*</span></label>
                                    <input type="text" name="subject_code" id="subject_code" value="{{ old('subject_code') }}" placeholder="Contoh: MP-001" required>
                                    @error('subject_code')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label for="subject_name">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                                    <input type="text" name="subject_name" id="subject_name" value="{{ old('subject_name') }}" placeholder="Matematika, Bahasa Indonesia, dll" required>
                                    @error('subject_name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="input-style-1">
                                    <label for="class_level">Kelas <span class="text-danger">*</span></label>
                                    <select name="class_level" id="class_level" class="form-control" required>
                                        <option value="">Pilih Kelas</option>
                                        <option value="X" {{ old('class_level') == 'X' ? 'selected' : '' }}>X</option>
                                        <option value="XI" {{ old('class_level') == 'XI' ? 'selected' : '' }}>XI</option>
                                        <option value="XII" {{ old('class_level') == 'XII' ? 'selected' : '' }}>XII</option>
                                    </select>
                                    @error('class_level')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="input-style-1">
                                    <label for="major">Jurusan <span class="text-danger">*</span></label>
                                    <select name="major" id="major" class="form-control" required>
                                        <option value="">Pilih Jurusan</option>
                                        @foreach ($majors as $major)
                                            <option value="{{ $major }}" {{ old('major') == $major ? 'selected' : '' }}>
                                                {{ $major }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('major')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="input-style-1">
                                    <label for="description">Deskripsi</label>
                                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Opsional">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('subjects.index') }}" class="btn btn-light me-2">Batal</a>
                            <button type="submit" class="main-btn primary-btn btn-hover">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection