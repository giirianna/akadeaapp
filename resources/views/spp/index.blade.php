@extends('layouts.app')

@section('title', 'Daftar Pembayaran SPP')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Pembayaran SPP</h2>
    <a href="{{ route('spp.create') }}" class="btn btn-primary">Tambah Pembayaran SPP</a>
</div>

@if($spps->isEmpty())
    <div class="alert alert-info text-center">
        Belum ada data pembayaran SPP. Silakan tambahkan data baru.
    </div>
@else
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Bulan</th>
                    <th>Jumlah Tagihan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($spps as $spp)
                <tr>
                    <td>{{ ($spps->currentPage() - 1) * $spps->perPage() + $loop->iteration }}</td>
                    <td>{{ $spp->student_name }}</td>
                    <td>{{ $spp->class }}</td>
                    <td>{{ $spp->month }}</td>
                    <td>Rp {{ number_format($spp->amount, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge bg-{{ $spp->status == 'lunas' ? 'success' : ($spp->status == 'sebagian' ? 'warning' : 'danger') }}">
                            {{ ucfirst($spp->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('spp.show', $spp) }}" class="btn btn-sm btn-outline-info">Detail</a>
                        <a href="{{ route('spp.edit', $spp) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                        <form action="{{ route('spp.destroy', $spp) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $spps->links() }}
@endif
@endsection