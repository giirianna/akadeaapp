@extends('layouts.app')

@section('title', 'Tambah Pembayaran SPP')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5>Tambah Pembayaran SPP</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('spp.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="student_id" class="form-label">Siswa</label>
                <select name="student_id" id="student_id" class="form-select" required>
                    <option value="">Pilih Siswa</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" data-name="{{ $student->name }}" data-class="{{ $student->class }}" data-major="{{ $student->major }}">
                            {{ $student->name }} ({{ $student->class }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="student_name" class="form-label">Nama Siswa</label>
                <input type="text" name="student_name" id="student_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="class" class="form-label">Kelas</label>
                <input type="text" name="class" id="class" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="major" class="form-label">Jurusan</label>
                <input type="text" name="major" id="major" class="form-control">
            </div>

            <div class="mb-3">
                <label for="month" class="form-label">Bulan</label>
                <input type="text" name="month" id="month" class="form-control" required placeholder="Januari, Februari, dst">
            </div>

            <div class="mb-3">
                <label for="due_date" class="form-label">Tanggal Jatuh Tempo</label>
                <input type="date" name="due_date" id="due_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">Jumlah Tagihan (Rp)</label>
                <input type="number" step="0.01" name="amount" id="amount" class="form-control" required min="0">
            </div>

            <div class="mb-3">
                <label for="amount_paid" class="form-label">Jumlah Dibayar (Rp)</label>
                <input type="number" step="0.01" name="amount_paid" id="amount_paid" class="form-control" min="0">
            </div>

            <div class="mb-3">
                <label for="payment_date" class="form-label">Tanggal Bayar</label>
                <input type="date" name="payment_date" id="payment_date" class="form-control">
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="belum_lunas">Belum Lunas</option>
                    <option value="lunas">Lunas</option>
                    <option value="sebagian">Sebagian</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="payment_method" class="form-label">Metode Pembayaran</label>
                <input type="text" name="payment_method" id="payment_method" class="form-control">
            </div>

            <div class="mb-3">
                <label for="remarks" class="form-label">Catatan</label>
                <textarea name="remarks" id="remarks" class="form-control" rows="3"></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('spp.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('student_id').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    document.getElementById('student_name').value = selected.getAttribute('data-name');
    document.getElementById('class').value = selected.getAttribute('data-class');
    document.getElementById('major').value = selected.getAttribute('data-major') || '';
});
</script>
@endsection