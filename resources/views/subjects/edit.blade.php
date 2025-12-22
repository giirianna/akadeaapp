@extends('layouts.app')

@section('title', 'Edit Mata Pelajaran')

@push('styles')
    <style>
        .input-style-1 select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M0 3l6 6 6-6z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 35px;
        }

        .input-style-1 select option {
            padding: 10px;
        }

        .input-style-1 select option:checked {
            background: linear-gradient(#4a6cf7, #4a6cf7);
            background-color: #4a6cf7 !important;
            color: white;
        }
    </style>
@endpush

@section('content')
    <section class="form-components">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Edit Mata Pelajaran</h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Mata Pelajaran</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                        <form action="{{ route('subjects.update', $subject) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label for="subject_code">Kode Mata Pelajaran <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="subject_code" id="subject_code"
                                            value="{{ old('subject_code', $subject->subject_code) }}"
                                            placeholder="Contoh: MP-001" required>
                                        @error('subject_code')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label for="subject_name">Nama Mata Pelajaran <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="subject_name" id="subject_name"
                                            value="{{ old('subject_name', $subject->subject_name) }}"
                                            placeholder="Matematika, Bahasa Indonesia, dll" required>
                                        @error('subject_name')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label for="class_level">Kelas <span class="text-danger">*</span></label>
                                        <select name="class_level" id="class_level" class="form-control" required>
                                            <option value="">Pilih Kelas</option>
                                            @foreach($classLevels as $level)
                                                <option value="{{ $level }}" {{ old('class_level', $subject->class_level) == $level ? 'selected' : '' }}>Kelas {{ $level }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('class_level')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label for="major_id">Jurusan <span class="text-danger">*</span></label>
                                        <select name="major_id" id="major_id" class="form-control" required>
                                            <option value="">Pilih Jurusan</option>
                                            @foreach ($majors as $major)
                                                <option value="{{ $major->id }}" {{ old('major_id', $subject->major_id) == $major->id ? 'selected' : '' }}>
                                                    {{ $major->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('major_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="input-style-1">
                                        <label for="description">Deskripsi</label>
                                        <textarea name="description" id="description" class="form-control" rows="3"
                                            placeholder="Opsional">{{ old('description', $subject->description) }}</textarea>
                                        @error('description')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="active" {{ old('status', $subject->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                            <option value="inactive" {{ old('status', $subject->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('subjects.index') }}" class="btn btn-light me-2">Batal</a>
                                <button type="submit" class="main-btn primary-btn btn-hover">Perbarui</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection