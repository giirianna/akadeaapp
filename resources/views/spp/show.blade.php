@extends('layouts.app')

@section('title', 'Detail Pembayaran SPP')

@section('content')
<div class="card">
    <div class="card-header bg-info text-white">
        <h5>Detail Pembayaran SPP</h5>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nama Siswa</dt>
            <dd class="col-sm-9">{{ $spp->student_name }}</dd>

            <dt class="col-sm-3">ID Siswa</dt>
            <dd class="col-sm-9">{{ $spp->student_id }}</dd>

            <dt class="col-sm-3">Kelas</dt>
            <dd class="col-sm-9">{{ $spp->class }}</dd>

            <dt class="col-sm-3">Jurusan</dt>
            <dd class="col-sm-9">{{ $spp->major ?? '-' }}</dd>

            <dt class="col-sm-3">Bulan</dt>
            <dd class="col-sm-9">{{ $spp->month }}</dd>

            <dt class="col-sm-3">Tanggal Jatuh Tempo</dt>
            <dd class="col-sm-9">{{ $spp->due_date->format('d-m-Y') }}</dd>

            <dt class="col-sm-3">Jumlah Tagihan</dt>
            <dd class="col-sm-9">Rp {{ number_format($spp->amount, 0, ',', '.') }}</dd>

            <dt class="col-sm-3">Jumlah Dibayar</dt>
            <dd class="col-sm-9">Rp {{ number_format($spp->amount_paid, 0, ',', '.') }}</dd>

            <dt class="col-sm-3">Tanggal Bayar</dt>
            <dd class="col-sm-9">{{ $spp->payment_date ? $spp->payment_date->format('d-m-Y') : '-' }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                <span class="badge bg-{{ $spp->status == 'lunas' ? 'success' : ($spp->status == 'sebagian' ? 'warning' : 'danger') }}">
                    {{ ucfirst($spp->status) }}
                </span>
            </dd>

            <dt class="col-sm-3">Metode Pembayaran</dt>
            <dd class="col-sm-9">{{ $spp->payment_method ?? '-' }}</dd>

            <dt class="col-sm-3">Catatan</dt>
            <dd class="col-sm-9">{{ $spp->remarks ?? '-' }}</dd>
        </dl>

        <div class="d-flex gap-2">
            <a href="{{ route('spp.edit', $spp) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('spp.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection