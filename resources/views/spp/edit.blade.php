@extends('layouts.app')

@section('title', 'Edit Pembayaran SPP')

@section('content')
<!-- ========== tab components start ========== -->
<section class="tab-components">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Edit Pembayaran SPP</h2>
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
                                <li class="breadcrumb-item active" aria-current="page">Edit Pembayaran</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- ========== title-wrapper end ========== -->

        <!-- ========== form-elements-wrapper start ========== -->
        <div class="form-elements-wrapper">
            <div class="row">
                <div class="col-lg-8">
                    <form action="{{ route('spp.update', $spp) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Student Selection -->
                        <div class="card-style mb-30">
                            <div class="select-style-1">
                                <label for="student_id">Pilih Siswa</label>
                                <div class="select-position">
                                    <select name="student_id" id="student_id" required>
                                        <option value="">-- Pilih Siswa --</option>
                                        @foreach($students as $student)
                                            <option value="{{ $student->id }}" data-name="{{ $student->name }}" data-class="{{ $student->class }}" data-major="{{ $student->major }}"
                                                {{ $student->id == $spp->student_id ? 'selected' : '' }}>
                                                {{ $student->name }} ({{ $student->class }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('student_id')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- end card -->

                        <!-- Student Name (Auto-filled) -->
                        <div class="card-style mb-30">
                            <div class="input-style-1">
                                <label for="student_name">Nama Siswa</label>
                                <input type="text" name="student_name" id="student_name" value="{{ $spp->student_name }}" readonly />
                                @error('student_name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- end card -->

                        <!-- Class (Auto-filled) -->
                        <div class="card-style mb-30">
                            <div class="input-style-1">
                                <label for="class">Kelas</label>
                                <input type="text" name="class" id="class" value="{{ $spp->class }}" readonly />
                                @error('class')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- end card -->

                        <!-- Major (Auto-filled) -->
                        <div class="card-style mb-30">
                            <div class="input-style-1">
                                <label for="major">Jurusan</label>
                                <input type="text" name="major" id="major" value="{{ $spp->major }}" readonly />
                                @error('major')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- end card -->

                        <!-- Month -->
                        <div class="card-style mb-30">
                            <div class="input-style-1">
                                <label for="month">Bulan</label>
                                <input type="text" name="month" id="month" value="{{ $spp->month }}" required />
                                @error('month')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- end card -->

                        <!-- Due Date -->
                        <div class="card-style mb-30">
                            <div class="input-style-1">
                                <label for="due_date">Tanggal Jatuh Tempo</label>
                                <input type="date" name="due_date" id="due_date" value="{{ $spp->due_date->format('Y-m-d') }}" required />
                                @error('due_date')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- end card -->

                        <!-- Amount Billed -->
                        <div class="card-style mb-30">
                            <div class="input-style-1">
                                <label for="amount">Jumlah Tagihan (Rp)</label>
                                <input type="number" step="0.01" name="amount" id="amount" value="{{ $spp->amount }}" required min="0" />
                                @error('amount')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- end card -->

                        <!-- Amount Paid -->
                        <div class="card-style mb-30">
                            <div class="input-style-1">
                                <label for="amount_paid">Jumlah Dibayar (Rp)</label>
                                <input type="number" step="0.01" name="amount_paid" id="amount_paid" value="{{ $spp->amount_paid }}" min="0" />
                                @error('amount_paid')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- end card -->

                        <!-- Payment Date -->
                        <div class="card-style mb-30">
                            <div class="input-style-1">
                                <label for="payment_date">Tanggal Bayar</label>
                                <input type="date" name="payment_date" id="payment_date" value="{{ $spp->payment_date ? $spp->payment_date->format('Y-m-d') : '' }}" />
                                @error('payment_date')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- end card -->

                        <!-- Status -->
                        <div class="card-style mb-30">
                            <div class="select-style-1">
                                <label for="status">Status</label>
                                <div class="select-position">
                                    <select name="status" id="status" required>
                                        <option value="belum_lunas" {{ $spp->status == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                        <option value="sebagian" {{ $spp->status == 'sebagian' ? 'selected' : '' }}>Sebagian</option>
                                        <option value="lunas" {{ $spp->status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                    </select>
                                </div>
                                @error('status')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- end card -->

                        <!-- Payment Method -->
                        <div class="card-style mb-30">
                            <div class="input-style-1">
                                <label for="payment_method">Metode Pembayaran</label>
                                <input type="text" name="payment_method" id="payment_method" value="{{ $spp->payment_method }}" />
                                @error('payment_method')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- end card -->

                        <!-- Remarks -->
                        <div class="card-style mb-30">
                            <label for="remarks">Catatan</label>
                            <textarea name="remarks" id="remarks" class="form-control" rows="4">{{ $spp->remarks }}</textarea>
                            @error('remarks')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- end card -->

                        <!-- Buttons -->
                        <div class="card-style mb-30">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <span class="icon"><i class="lni lni-save"></i></span> Update
                                </button>
                                <a href="{{ route('spp.index') }}" class="btn btn-secondary">
                                    <span class="icon"><i class="lni lni-arrow-left"></i></span> Kembali
                                </a>
                            </div>
                        </div>
                        <!-- end card -->
                    </form>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- ========== form-elements-wrapper end ========== -->
    </div>
    <!-- end container-fluid -->
</section>
<!-- ========== tab components end ========== -->

<script>
document.getElementById('student_id').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    document.getElementById('student_name').value = selected.getAttribute('data-name') || '';
    document.getElementById('class').value = selected.getAttribute('data-class') || '';
    document.getElementById('major').value = selected.getAttribute('data-major') || '';
});
</script>
@endsection
