@extends('layouts.app')

@section('title', 'Detail Guru')

@section('content')
    <!-- ========== detail-wrapper start ========== -->
    <section class="detail-wrapper">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Detail Guru</h2>
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
                                    <li class="breadcrumb-item active" aria-current="page">Detail Guru</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== title-wrapper end ========== -->

            <!-- ========== detail-content start ========== -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card-style">
                        <div class="detail-content">
                            @if($teacher->teacher_photo)
                                <div class="detail-row mb-30 pb-30 border-bottom text-center">
                                    <div class="detail-value">
                                        <img src="{{ asset('storage/' . $teacher->teacher_photo) }}" alt="Foto Guru" style="max-width: 150px; border-radius: 8px;">
                                    </div>
                                </div>
                            @endif

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Nama Lengkap</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $teacher->full_name }}</p>
                                </div>
                            </div>

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Nomor Guru</h6>
                                </div>
                                <div class="detail-value">
                                    <p><strong>{{ $teacher->teacher_number }}</strong></p>
                                </div>
                            </div>

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Peran / Mata Pelajaran</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $teacher->teacher_role }}</p>
                                </div>
                            </div>

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Status Kepegawaian</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $teacher->employment_status ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Pendidikan Terakhir</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $teacher->highest_education ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Pengalaman Mengajar (tahun)</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $teacher->years_of_experience ?? 0 }}</p>
                                </div>
                            </div>

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Jenis Kelamin</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $teacher->gender }}</p>
                                </div>
                            </div>

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Agama</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $teacher->religion ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Golongan Darah</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $teacher->blood_type ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Tanggal Lahir</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ optional($teacher->birth_date)->format('d-m-Y') ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="detail-row mb-30">
                                <div class="detail-label">
                                    <h6>Alamat</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $teacher->address ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="detail-row mb-30">
                                <div class="detail-label">
                                    <h6>No. Telepon</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $teacher->phone_number ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-30 pt-30 border-top">
                                <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-primary">
                                    <span class="icon"><i class="lni lni-pencil"></i></span> Edit
                                </a>
                                <a href="{{ route('teachers.index') }}" class="btn btn-secondary">
                                    <span class="icon"><i class="lni lni-arrow-left"></i></span> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- ========== detail-content end ========== -->
        </div>
        <!-- end container-fluid -->
    </section>
    <!-- ========== detail-wrapper end ========== -->
@endsection
