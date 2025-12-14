@extends('layouts.app')
@section('title', 'Daftar Pembayaran SPP')

{{-- 🔒 Hanya guru yang bisa akses --}}
@if(auth()->user()->hasRole('siswa'))
    <script>
        window.location.href = "{{ route('dashboard') }}";
    </script>
    @stop
@endif

@section('content')
<section class="table-components">
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title"><h2>Daftar Pembayaran SPP</h2></div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Pembayaran SPP</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="tables-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-style mb-30">
                        <div class="d-flex justify-content-between align-items-center mb-30">
                            <div>
                                <h6>Data Pembayaran SPP</h6>
                                <p class="text-sm">Daftar lengkap pembayaran SPP siswa</p>
                            </div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sppModal">
                                <span class="icon"><i class="lni lni-plus"></i></span> Tambah Pembayaran
                            </button>
                        </div>

                        @if($spps->isEmpty())
                            <div class="alert alert-info" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="lni lni-info-circle me-2"></i>
                                    <span>Belum ada data pembayaran SPP.</span>
                                </div>
                            </div>
                        @else
                            <div class="table-wrapper table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 50px;"><h6>#</h6></th>
                                            <th class="text-start"><h6>Nama Siswa</h6></th>
                                            <th class="text-center"><h6>Kelas</h6></th>
                                            <th class="text-center"><h6>Bulan Masuk</h6></th>
                                            <th class="text-right"><h6>Total SPP</h6></th>
                                            <th class="text-right"><h6>Jumlah Dibayar</h6></th>
                                            <th class="text-right"><h6>Sisa Tagihan</h6></th>
                                            <th class="text-center"><h6>Status</h6></th>
                                            <th class="text-center"><h6>Aksi</h6></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($spps as $spp)
                                        <tr data-id="{{ $spp->id }}">
                                            <td class="text-center"><p>{{ ($spps->currentPage() - 1) * $spps->perPage() + $loop->iteration }}</p></td>
                                            <td class="text-start min-width"><p>{{ $spp->student_name }}</p></td>
                                            <td class="text-center min-width"><p>{{ $spp->class }}</p></td>
                                            <td class="text-center min-width"><p>{{ $spp->month }}</p></td>
                                            <td class="text-right min-width"><p><strong>Rp {{ number_format($spp->jumlah_tagihan, 0, ',', '.') }}</strong></p></td>
                                            <td class="text-right min-width"><p>Rp {{ number_format($spp->amount_paid, 0, ',', '.') }}</p></td>
                                            <td class="text-right min-width"><p>Rp {{ number_format($spp->sisa_tagihan, 0, ',', '.') }}</p></td>
                                            <td class="text-center min-width">
                                                @php
                                                    $statusClass = match ($spp->status) {
                                                        'lunas' => 'success',
                                                        'sebagian' => 'warning',
                                                        default => 'danger'
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $statusClass }}">{{ ucfirst($spp->status) }}</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="action d-flex gap-2 justify-content-center">
                                                    <button type="button" class="text-info" data-bs-toggle="modal" data-bs-target="#detailSppModal"
                                                        onclick="showSppDetail('{{ addslashes($spp->student_name) }}', '{{ $spp->class }}', '{{ addslashes($spp->major ?? '-') }}', '{{ $spp->month }}', '-', '{{ number_format($spp->jumlah_tagihan, 0, ',', '.') }}', '{{ number_format($spp->amount_paid, 0, ',', '.') }}', '{{ $spp->payment_date ? $spp->payment_date->format('d-m-Y') : '-' }}', '{{ ucfirst($spp->status) }}', '{{ addslashes($spp->payment_method ?? '-') }}', '{{ addslashes($spp->remarks ?? '-') }}')">
                                                        <i class="lni lni-eye"></i>
                                                    </button>
                                                    <button type="button" class="text-warning" data-bs-toggle="modal" data-bs-target="#sppModal"
                                                        onclick="fillSppEditForm({{ $spp->id }}, {{ $spp->student_id }}, '{{ addslashes($spp->student_name) }}', '{{ $spp->class }}', '{{ addslashes($spp->major ?? '') }}', '{{ $spp->month }}', {{ $spp->jumlah_tagihan }}, {{ $spp->amount_paid }}, '{{ $spp->payment_date ? $spp->payment_date->format('Y-m-d') : '' }}', '{{ $spp->status }}', '{{ addslashes($spp->payment_method ?? '') }}', '{{ addslashes($spp->remarks ?? '') }}')">
                                                        <i class="lni lni-pencil"></i>
                                                    </button>
                                                    <button type="button" class="text-danger" data-bs-toggle="modal" data-bs-target="#deleteSppModal"
                                                        onclick="setDeleteSppId({{ $spp->id }}, '{{ addslashes($spp->student_name . ' - ' . $spp->month) }}')">
                                                        <i class="lni lni-trash-can"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-20">
                                <p class="text-sm">Total: {{ $spps->total() }} data</p>
                                <div class="pagination-wrapper">{{ $spps->links() }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MODAL: Tambah/Edit -->
<div class="modal fade" id="sppModal" tabindex="-1" aria-labelledby="sppModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sppModalLabel">Tambah Pembayaran SPP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="sppForm">@csrf
                <input type="hidden" name="id" id="sppId">
                <div class="modal-body">
                    <div class="select-style-1 mb-3">
                        <label for="student_id">Pilih Siswa</label>
                        <div class="select-position">
                            <select name="student_id" id="student_id" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" data-name="{{ $student->name }}" data-class="{{ $student->class }}" data-major="{{ $student->major }}" data-enrollment-date="{{ $student->enrollment_date }}">
                                        {{ $student->name }} ({{ $student->class }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="input-style-1 mb-3"><label>Nama Siswa</label><input type="text" name="student_name" id="student_name" readonly required></div>
                    <div class="input-style-1 mb-3"><label>Kelas</label><input type="text" name="class" id="class" readonly required></div>
                    <div class="input-style-1 mb-3"><label>Jurusan</label><input type="text" name="major" id="major" readonly></div>
                    <div class="input-style-1 mb-3"><label>Bulan Masuk</label><input type="text" name="month" id="month" readonly required></div>
                    <div class="input-style-1 mb-3">
                        <label>Jumlah Tagihan (Rp)</label>
                        <input type="text" id="amount_display" readonly class="form-control">
                    </div>
                    <div class="input-style-1 mb-3"><label>Jumlah Dibayar (Rp)</label><input type="number" name="amount_paid" id="amount_paid" min="0"></div>
                    <div class="input-style-1 mb-3"><label>Tanggal Bayar</label><input type="date" name="payment_date" id="payment_date"></div>
                    <div class="select-style-1 mb-3">
                        <label>Status</label>
                        <select name="status" id="status" required>
                            <option value="belum_lunas">Belum Lunas</option>
                            <option value="sebagian">Sebagian</option>
                            <option value="lunas">Lunas</option>
                        </select>
                    </div>
                    <div class="input-style-1 mb-3"><label>Metode Pembayaran</label><input type="text" name="payment_method" id="payment_method"></div>
                    <div class="mb-3"><label>Catatan</label><textarea name="remarks" id="remarks" class="form-control" rows="3"></textarea></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="lni lni-arrow-left"></i> Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="lni lni-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL: Detail -->
<div class="modal fade" id="detailSppModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Detail Pembayaran SPP</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="row mb-2"><div class="col-md-4"><strong>Nama Siswa:</strong></div><div class="col-md-8" id="detail-student-name"></div></div>
                <div class="row mb-2"><div class="col-md-4"><strong>Kelas:</strong></div><div class="col-md-8" id="detail-class"></div></div>
                <div class="row mb-2"><div class="col-md-4"><strong>Jurusan:</strong></div><div class="col-md-8" id="detail-major"></div></div>
                <div class="row mb-2"><div class="col-md-4"><strong>Bulan Masuk:</strong></div><div class="col-md-8" id="detail-month"></div></div>
                <div class="row mb-2"><div class="col-md-4"><strong>Total SPP:</strong></div><div class="col-md-8" id="detail-amount"></div></div>
                <div class="row mb-2"><div class="col-md-4"><strong>Jumlah Dibayar:</strong></div><div class="col-md-8" id="detail-amount-paid"></div></div>
                <div class="row mb-2"><div class="col-md-4"><strong>Sisa Tagihan:</strong></div><div class="col-md-8" id="detail-sisa-tagihan"></div></div>
                <div class="row mb-2"><div class="col-md-4"><strong>Tanggal Bayar:</strong></div><div class="col-md-8" id="detail-payment-date"></div></div>
                <div class="row mb-2"><div class="col-md-4"><strong>Status:</strong></div><div class="col-md-8" id="detail-status"></div></div>
                <div class="row mb-2"><div class="col-md-4"><strong>Metode Pembayaran:</strong></div><div class="col-md-8" id="detail-payment-method"></div></div>
                <div class="row"><div class="col-md-4"><strong>Catatan:</strong></div><div class="col-md-8" id="detail-remarks"></div></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button></div>
        </div>
    </div>
</div>

<!-- MODAL: Hapus -->
<div class="modal fade" id="deleteSppModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Konfirmasi Hapus</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <p>Yakin ingin menghapus pembayaran SPP:</p>
                <p class="text-danger fw-bold" id="delete-spp-desc"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="lni lni-arrow-left"></i> Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteSppBtn"><i class="lni lni-trash-can"></i> Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
    function getMonthsDifference(startDateStr, endDateStr) {
        const start = new Date(startDateStr);
        const end = new Date(endDateStr);
        start.setDate(1);
        end.setDate(1);
        let months = (end.getFullYear() - start.getFullYear()) * 12 + (end.getMonth() - start.getMonth());
        return Math.max(1, months);
    }

    document.getElementById('student_id').addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];
        const enrollmentDate = opt.getAttribute('data-enrollment-date');
        document.getElementById('student_name').value = opt.getAttribute('data-name') || '';
        document.getElementById('class').value = opt.getAttribute('data-class') || '';
        document.getElementById('major').value = opt.getAttribute('data-major') || '';

        if (enrollmentDate) {
            const enroll = new Date(enrollmentDate);
            const monthNames = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            document.getElementById('month').value = monthNames[enroll.getMonth()] + ' ' + enroll.getFullYear();

            const now = new Date();
            const monthsDiff = getMonthsDifference(enrollmentDate, now.toISOString().split('T')[0]);
            const amount = monthsDiff * 300000;
            document.getElementById('amount_display').value = 'Rp ' + amount.toLocaleString('id-ID');
        }
    });

    function fillSppEditForm(id, student_id, name, class_, major, month, amount, amount_paid, payment_date, status, method, remarks) {
        document.getElementById('sppModalLabel').textContent = 'Edit Pembayaran SPP';
        document.getElementById('sppId').value = id;
        document.getElementById('student_id').value = student_id;
        document.getElementById('student_name').value = name;
        document.getElementById('class').value = class_;
        document.getElementById('major').value = major;
        document.getElementById('month').value = month;
        document.getElementById('amount_display').value = 'Rp ' + amount.toLocaleString('id-ID');
        document.getElementById('amount_paid').value = amount_paid;
        document.getElementById('payment_date').value = payment_date;
        document.getElementById('status').value = status;
        document.getElementById('payment_method').value = method;
        document.getElementById('remarks').value = remarks;
    }

    function showSppDetail(name, class_, major, month, due, amountStr, paidStr, payment, status, method, remarks) {
        const amount = parseInt(amountStr.replace(/\D/g, '')) || 0;
        const paid = parseInt(paidStr.replace(/\D/g, '')) || 0;
        const sisa = amount - paid;

        document.getElementById('detail-student-name').textContent = name;
        document.getElementById('detail-class').textContent = class_;
        document.getElementById('detail-major').textContent = major;
        document.getElementById('detail-month').textContent = month;
        document.getElementById('detail-amount').textContent = 'Rp ' + amount.toLocaleString('id-ID');
        document.getElementById('detail-amount-paid').textContent = 'Rp ' + paid.toLocaleString('id-ID');
        document.getElementById('detail-sisa-tagihan').textContent = 'Rp ' + sisa.toLocaleString('id-ID');
        document.getElementById('detail-payment-date').textContent = payment;
        document.getElementById('detail-status').textContent = status;
        document.getElementById('detail-payment-method').textContent = method;
        document.getElementById('detail-remarks').textContent = remarks;
    }

    let deleteSppId = null;
    function setDeleteSppId(id, desc) {
        deleteSppId = id;
        document.getElementById('delete-spp-desc').textContent = desc;
    }

    document.getElementById('sppModal').addEventListener('hidden.bs.modal', () => {
        document.getElementById('sppForm').reset();
        document.getElementById('sppModalLabel').textContent = 'Tambah Pembayaran SPP';
        document.getElementById('sppId').value = '';
        document.getElementById('amount_display').value = '';
    });

    // ✅ PERBAIKAN: HANYA BAGIAN INI YANG DIUBAH — AGAR DATA BARU BISA DISIMPAN
    document.getElementById('sppForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const student_id = document.getElementById('student_id').value;
        if (!student_id) {
            alert('Pilih siswa terlebih dahulu.');
            return;
        }

        const formData = new FormData();
        formData.append('student_id', student_id);
        formData.append('month', document.getElementById('month').value);
        formData.append('amount_paid', document.getElementById('amount_paid').value || 0);
        formData.append('status', document.getElementById('status').value);
        const payment_date = document.getElementById('payment_date').value;
        if (payment_date) formData.append('payment_date', payment_date);
        const payment_method = document.getElementById('payment_method').value;
        if (payment_method) formData.append('payment_method', payment_method);
        const remarks = document.getElementById('remarks').value;
        if (remarks) formData.append('remarks', remarks);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        const id = document.getElementById('sppId').value;
        let url = "{{ route('spp.store') }}";
        if (id) {
            formData.append('_method', 'PUT');
            url = `/spp/${id}`;
        }

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            bootstrap.Modal.getInstance(document.getElementById('sppModal')).hide();
            if (data.success) location.reload();
            else alert(data.message || 'Gagal menyimpan data.');
        });
    });

    document.getElementById('confirmDeleteSppBtn').addEventListener('click', function() {
        if (!deleteSppId) return;
        fetch(`/spp/${deleteSppId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(r => r.json()).then(data => {
            bootstrap.Modal.getInstance(document.getElementById('deleteSppModal')).hide();
            if (data.success) document.querySelector(`tr[data-id="${deleteSppId}"]`)?.remove();
            deleteSppId = null;
        });
    });
</script>
@endsection