@extends('layouts.app')

@section('title', 'Detail Mata Pelajaran')

@section('content')
    <!-- ========== detail-wrapper start ========== -->
    <section class="detail-wrapper">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Detail Mata Pelajaran</h2>
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
                                        <a href="{{ route('subjects.index') }}">Mata Pelajaran</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Detail Mata Pelajaran</li>
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
                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Kode Mata Pelajaran</h6>
                                </div>
                                <div class="detail-value">
                                    <p><strong>{{ $subject->subject_code }}</strong></p>
                                </div>
                            </div>

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Nama Mata Pelajaran</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $subject->subject_name }}</p>
                                </div>
                            </div>

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Guru Pengajar</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $subject->teacher_name ?? '-' }}</p>
                                    @if($subject->teacher)
                                        <small class="text-muted">
                                            <a href="{{ route('teachers.show', $subject->teacher) }}" class="text-primary">
                                                <i class="lni lni-eye"></i> Lihat profil guru
                                            </a>
                                        </small>
                                    @endif
                                </div>
                            </div>

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Kelas</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $subject->class_level }}</p>
                                </div>
                            </div>

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Jurusan</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $subject->major }}</p>
                                </div>
                            </div>

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Status</h6>
                                </div>
                                <div class="detail-value">
                                    @if($subject->status === 'active')
                                        <span class="status-btn active-btn">Aktif</span>
                                    @else
                                        <span class="status-btn close-btn">Tidak Aktif</span>
                                    @endif
                                </div>
                            </div>

                            @if($subject->description)
                                <div class="detail-row mb-30">
                                    <div class="detail-label">
                                        <h6>Deskripsi</h6>
                                    </div>
                                    <div class="detail-value">
                                        <p>{{ $subject->description }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex gap-2 mt-30 pt-30 border-top">
                                <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-primary">
                                    <span class="icon"><i class="lni lni-pencil"></i></span> Edit
                                </a>
                                <a href="{{ route('subjects.index') }}" class="btn btn-secondary">
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
