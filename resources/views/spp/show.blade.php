@extends('layouts.app')

@section('title', 'Detail Pembayaran SPP')

@section('content')
    <!-- ========== detail-wrapper start ========== -->
    <section class="detail-wrapper">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Detail Pembayaran SPP</h2>
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
                                        <a href="{{ route('spp.index') }}">Pembayaran SPP</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Detail Pembayaran</li>
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
                                    <p>{{ $spp->student_name }}</p>
                                </div>
                            </div>
                            <!-- end detail row -->

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Kelas</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $spp->class }}</p>
                                </div>
                            </div>
                            <!-- end detail row -->

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Jurusan</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $spp->major ?? '-' }}</p>
                                </div>
                            </div>
                            <!-- end detail row -->

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Bulan</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $spp->month }}</p>
                                </div>
                            </div>
                            <!-- end detail row -->

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Tanggal Jatuh Tempo</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $spp->due_date->format('d-m-Y') }}</p>
                                </div>
                            </div>
                            <!-- end detail row -->

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Jumlah Tagihan</h6>
                                </div>
                                <div class="detail-value">
                                    <p><strong>Rp {{ number_format($spp->amount, 0, ',', '.') }}</strong></p>
                                </div>
                            </div>
                            <!-- end detail row -->

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Jumlah Dibayar</h6>
                                </div>
                                <div class="detail-value">
                                    <p>Rp {{ number_format($spp->amount_paid, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <!-- end detail row -->

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Tanggal Bayar</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $spp->payment_date ? $spp->payment_date->format('d-m-Y') : '-' }}</p>
                                </div>
                            </div>
                            <!-- end detail row -->

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Status</h6>
                                </div>
                                <div class="detail-value">
                                    @php
                                        $statusClass = match ($spp->status) {
                                            'lunas' => 'success',
                                            'sebagian' => 'warning',
                                            default => 'danger'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">
                                        {{ ucfirst($spp->status) }}
                                    </span>
                                </div>
                            </div>
                            <!-- end detail row -->

                            <div class="detail-row mb-30 pb-30 border-bottom">
                                <div class="detail-label">
                                    <h6>Metode Pembayaran</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $spp->payment_method ?? '-' }}</p>
                                </div>
                            </div>
                            <!-- end detail row -->

                            <div class="detail-row mb-30">
                                <div class="detail-label">
                                    <h6>Catatan</h6>
                                </div>
                                <div class="detail-value">
                                    <p>{{ $spp->remarks ?? '-' }}</p>
                                </div>
                            </div>
                            <!-- end detail row -->

                            <div class="d-flex gap-2 mt-30 pt-30 border-top">
                                <a href="{{ route('spp.edit', $spp) }}" class="btn btn-primary">
                                    <span class="icon"><i class="lni lni-pencil"></i></span> Edit
                                </a>
                                <a href="{{ route('spp.index') }}" class="btn btn-secondary">
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