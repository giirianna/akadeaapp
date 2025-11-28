@extends('layouts.app')

@section('title', 'Detail Guru')

@section('content')
<section class="form-components">
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Detail Guru</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">Guru</a></li>
                                <li class="breadcrumb-item active">Detail</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card-style mb-30 p-4">
                    <div class="text-center mb-4">
                        @if($teacher->photo)
                            <img src="{{ asset('storage/' . $teacher->photo) }}" alt="{{ $teacher->full_name }}" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <img src="{{ asset('assets/images/profile/profile-image.png') }}" alt="default" class="rounded-circle mb-3" style="width: 120px; height: 120px;">
                        @endif
                        <h4>{{ $teacher->full_name }}</h4>
                        <p class="text-muted">{{ $teacher->teacher_role ?? 'Guru' }}</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nomor Guru:</strong> {{ $teacher->teacher_number }}</p>
                            <p><strong>Status Kepegawaian:</strong> {{ $teacher->employment_status ?? '—' }}</p>
                            <p><strong>Jenis Kelamin:</strong> {{ $teacher->gender == 'male' ? 'Laki-laki' : ($teacher->gender == 'female' ? 'Perempuan' : '—') }}</p>
                            <p><strong>Agama:</strong> {{ $teacher->religion ?? '—' }}</p>
                            <p><strong>Golongan Darah:</strong> {{ $teacher->blood_type ?? '—' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tgl Lahir:</strong> {{ $teacher->birth_date ? $teacher->birth_date->format('d M Y') : '—' }}</p>
                            <p><strong>HP:</strong> {{ $teacher->phone_number ?? '—' }}</p>
                            <p><strong>Pendidikan Terakhir:</strong> {{ $teacher->highest_education ?? '—' }}</p>
                            <p><strong>Pengalaman:</strong> {{ $teacher->years_of_experience ? $teacher->years_of_experience . ' tahun' : '—' }}</p>
                        </div>
                    </div>

                    <div class="mt-3">
                        <strong>Alamat:</strong>
                        <p>{{ $teacher->address ?? '—' }}</p>
                    </div>

                    @if($teacher->subjects->count() > 0)
                        <div class="mt-4">
                            <h6>Mata Pelajaran yang Diajar:</h6>
                            <ul class="list-unstyled">
                                @foreach($teacher->subjects as $subject)
                                    <li>• {{ $subject->subject_name }} ({{ $subject->class_level }} - {{ $subject->major }})</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="d-flex justify-content-center mt-4 gap-2">
                        <a href="{{ route('teachers.edit', $teacher) }}" class="main-btn warning-btn btn-hover">Edit</a>
                        <a href="{{ route('teachers.index') }}" class="main-btn secondary-btn btn-hover">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection