@extends('layouts.app')

@section('title', 'Edit Pembayaran SPP')

@section('content')
<div class="card">
    <div class="card-header bg-warning text-dark">
        <h5>Edit Pembayaran SPP</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('spp.update', $spp) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="student_id" class="form-label">Siswa</label>
                <select name="student_id" id="student_id" class="form-select" required>
                    <option value="">Pilih Siswa</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" data-name="{{ $student->name }}" data-class="{{ $student->class }}" data-major="{{ $student->major }}"
                            {{ $student->id == $spp->student_id ? 'selected' : '' }}>
                            {{ $student->name }} ({{ $student->class }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="student_name" class="form-label">Nama Siswa</label>
                <input type="text" name="student_name" id="student_name" class="form-control" value="{{ $spp->student_name }}" required>
            </div>

            <div class="mb-3">
                <label for="class" class="form-label">Kelas</label>
                <input type="text" name="class" id="class" class="form-control" value="{{ $spp->class }}" required>
            </div>

            <div class="mb-3">
                <label for="major" class="form-label">Jurusan</label>
                <input type="text" name="major" id="major" class="form-control" value="{{ $spp->major }}">
            </div>

            <div class="mb-3">
                <label for="month" class="form-label">Bulan</label>
                <input type="text" name="month" id="month" class="form-control" value="{{ $spp->month }}" required>
            </div>

            <div class="mb-3">
                <label for="due_date" class="form-label">Tanggal Jatuh Tempo</label>
                <input type="date" name="due_date" id="due_date" class="form-control" value="{{ $spp->due_date->format('Y-m-d') }}" required>
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">Jumlah Tagihan (Rp)</label>
                <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ $spp->amount }}" required min="0">
            </div>

            <div class="mb-3">
                <label for="amount_paid" class="form-label">Jumlah Dibayar (Rp)</label>
                <input type="number" step="0.01" name="amount_paid" id="amount_paid" class="form-control" value="{{ $spp->amount_paid }}" min="0">
            </div>

            <div class="mb-3">
                <label for="payment_date" class="form-label">Tanggal Bayar</label>
                <input type="date" name="payment_date" id="payment_date" class="form-control" value="{{ $spp->payment_date ? $spp->payment_date->format('Y-m-d') : '' }}">
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="belum_lunas" {{ $spp->status == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    <option value="lunas" {{ $spp->status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="sebagian" {{ $spp->status == 'sebagian' ? 'selected' : '' }}>Sebagian</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="payment_method" class="form-label">Metode Pembayaran</label>
                <input type="text" name="payment_method" id="payment_method" class="form-control" value="{{ $spp->payment_method }}">
            </div>

            <div class="mb-3">
                <label for="remarks" class="form-label">Catatan</label>
                <textarea name="remarks" id="remarks" class="form-control" rows="3">{{ $spp->remarks }}</textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">Update</button>
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