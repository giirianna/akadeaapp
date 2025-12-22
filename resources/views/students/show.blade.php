@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')
    <!-- ========== detail-wrapper start ========== -->
    <section class="detail-wrapper">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Detail Siswa</h2>
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
                                        <a href="{{ route('students.index') }}">Siswa</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Detail Siswa</li>
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
                                    <h6>Nama Siswa</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $student->name }}</p>
                                </div>
                            </div>
                            <!-- end detail row -->

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>NIS</h6>
                                </div>
                                <div class="detail-value">
                                    <p><strong>{{ $student->nis }}</strong></p>
                                </div>
                            </div>
                            <!-- end detail row -->

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Kelas</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $student->class }}</p>
                                </div>
                            </div>
                            <!-- end detail row -->

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Jurusan</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $student->major?->name ?? '-' }}</p>
                                </div>
                            </div>
                            <!-- end detail row -->

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Tanggal Lahir</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ optional($student->birth_date)->format('d-m-Y') ?? '-' }}</p>
                                </div>
                            </div>
                            <!-- end detail row -->

                            <div class="detail-row mb-30">
                                <div class="detail-label">
                                    <h6>Alamat</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $student->address ?? '-' }}</p>
                                </div>
                            </div>
                            <!-- end detail row -->

                            <div class="d-flex gap-2 mt-30 pt-30 border-top">
                                <a href="{{ route('students.edit', $student) }}" class="btn btn-primary">
                                    <span class="icon"><i class="lni lni-pencil"></i></span> Edit
                                </a>
                                <a href="{{ route('students.index') }}" class="btn btn-secondary">
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
