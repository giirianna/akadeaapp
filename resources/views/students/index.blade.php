@extends('layouts.app')
@section('title', 'Daftar Siswa')

@section('content')
<!-- ========== table components start ========== -->
<section class="table-components">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Daftar Siswa</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Siswa</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ========== title-wrapper end ========== -->

        <!-- ========== tables-wrapper start ========== -->
        <div class="tables-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-style mb-30">
                        <div class="d-flex justify-content-between align-items-center mb-30">
                            <div>
                                <h6>Data Siswa</h6>
                                <p class="text-sm">Daftar lengkap siswa yang terdaftar dalam sistem</p>
                            </div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#studentModal">
                                <span class="icon"><i class="lni lni-plus"></i></span> Tambah Siswa
                            </button>
                        </div>

                        @if($students->isEmpty())
                            <div class="alert alert-info" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="lni lni-info-circle me-2"></i>
                                    <span>Belum ada data siswa.</span>
                                </div>
                            </div>
                        @else
                            <div class="table-wrapper table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 50px;"><h6>#</h6></th>
                                            <th class="text-start"><h6>Nama</h6></th>
                                            <th class="text-center"><h6>NIS</h6></th>
                                            <th class="text-center"><h6>Kelas</h6></th>
                                            <th class="text-center"><h6>Jurusan</h6></th>
                                            <th class="text-center"><h6>Aksi</h6></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $student)
                                        <tr data-id="{{ $student->id }}">
                                            <td class="text-center">
                                                <p>{{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}</p>
                                            </td>
                                            <td class="text-start min-width">
                                                <p>{{ $student->name }}</p>
                                            </td>
                                            <td class="text-center min-width">
                                                <p><strong>{{ $student->nis }}</strong></p>
                                            </td>
                                            <td class="text-center min-width">
                                                <p>{{ $student->class }}</p>
                                            </td>
                                            <td class="text-center min-width">
                                                <p>{{ $student->major ?? '-' }}</p>
                                            </td>
                                            <td class="text-center">
                                                <div class="action d-flex gap-2 justify-content-center">
                                                    <button type="button" class="text-info"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#detailModal"
                                                        onclick="showDetail(
                                                            '{{ addslashes($student->name) }}',
                                                            '{{ $student->nis }}',
                                                            '{{ $student->class }}',
                                                            '{{ addslashes($student->major ?? '-') }}',
                                                            '{{ $student->birth_date ? \Carbon\Carbon::parse($student->birth_date)->format('d-m-Y') : '-' }}',
                                                            '{{ addslashes($student->address ?? '-') }}'
                                                        )"
                                                        title="Detail">
                                                        <i class="lni lni-eye"></i>
                                                    </button>
                                                    <button type="button" class="text-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#studentModal"
                                                        onclick="fillEditForm(
                                                            {{ $student->id }},
                                                            '{{ addslashes($student->name) }}',
                                                            '{{ $student->nis }}',
                                                            '{{ $student->class }}',
                                                            '{{ addslashes($student->major ?? '') }}',
                                                            '{{ $student->birth_date ?? '' }}',
                                                            '{{ addslashes($student->address ?? '') }}'
                                                        )"
                                                        title="Edit">
                                                        <i class="lni lni-pencil"></i>
                                                    </button>
                                                    <button type="button" class="text-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal"
                                                        onclick="setDeleteId({{ $student->id }}, '{{ addslashes($student->name) }}')"
                                                        title="Hapus">
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
                                <p class="text-sm">Total: {{ $students->total() }} data</p>
                                <div class="pagination-wrapper">
                                    {{ $students->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== MODAL: Tambah/Edit Siswa ========== -->
<div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentModalLabel">Tambah Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="studentForm" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="id" id="studentId">
                <div class="modal-body">
                    <div class="input-style-1 mb-3">
                        <label for="name">Nama Siswa</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="input-style-1 mb-3">
                        <label for="nis">NIS</label>
                        <input type="text" name="nis" id="nis" class="form-control" required>
                    </div>
                    <div class="input-style-1 mb-3">
                        <label for="class">Kelas</label>
                        <input type="text" name="class" id="class" class="form-control" required>
                    </div>
                    <div class="input-style-1 mb-3">
                        <label for="major">Jurusan</label>
                        <input type="text" name="major" id="major" class="form-control">
                    </div>
                    <div class="input-style-1 mb-3">
                        <label for="birth_date">Tanggal Lahir</label>
                        <input type="date" name="birth_date" id="birth_date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="address">Alamat</label>
                        <textarea name="address" id="address" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="lni lni-arrow-left"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="lni lni-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========== MODAL: Detail Siswa ========== -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Nama:</strong></div>
                    <div class="col-md-8" id="detail-name"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>NIS:</strong></div>
                    <div class="col-md-8" id="detail-nis"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Kelas:</strong></div>
                    <div class="col-md-8" id="detail-class"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Jurusan:</strong></div>
                    <div class="col-md-8" id="detail-major"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Tanggal Lahir:</strong></div>
                    <div class="col-md-8" id="detail-birth_date"></div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Alamat:</strong></div>
                    <div class="col-md-8" id="detail-address"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- ========== MODAL: Konfirmasi Hapus ========== -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus data siswa:</p>
                <p class="text-danger fw-bold" id="delete-student-name"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="lni lni-arrow-left"></i> Batal
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="lni lni-trash-can"></i> Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let deleteStudentId = null;

    function setDeleteId(id, name) {
        deleteStudentId = id;
        document.getElementById('delete-student-name').textContent = name;
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (!deleteStudentId) return;

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/students/${deleteStudentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            // Tutup modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            modal.hide();

            // Hanya hapus baris jika sukses
            if (data.success) {
                const row = document.querySelector(`tr[data-id="${deleteStudentId}"]`);
                if (row) row.remove();
            }

            // Reset ID
            deleteStudentId = null;
        })
        .catch(error => {
            console.error('Error:', error);
            // ⚠️ TIDAK ADA ALERT — hanya tutup modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            modal.hide();
            deleteStudentId = null;
        });
    });

    function fillEditForm(id, name, nis, class_, major, birth_date, address) {
        const form = document.getElementById('studentForm');
        form.action = `/students/${id}`;
        form.querySelector('[name="_method"]').value = 'PUT';

        document.getElementById('studentModalLabel').textContent = 'Edit Siswa';
        document.getElementById('studentId').value = id;
        document.getElementById('name').value = name;
        document.getElementById('nis').value = nis;
        document.getElementById('class').value = class_;
        document.getElementById('major').value = major;
        document.getElementById('birth_date').value = birth_date;
        document.getElementById('address').value = address;
    }

    function showDetail(name, nis, class_, major, birth_date, address) {
        document.getElementById('detail-name').textContent = name;
        document.getElementById('detail-nis').textContent = nis;
        document.getElementById('detail-class').textContent = class_;
        document.getElementById('detail-major').textContent = major;
        document.getElementById('detail-birth_date').textContent = birth_date;
        document.getElementById('detail-address').textContent = address;
    }

    // Reset modal ke mode "Tambah" saat ditutup
    document.getElementById('studentModal').addEventListener('hidden.bs.modal', function () {
        const form = document.getElementById('studentForm');
        form.action = "{{ route('students.store') }}";
        form.querySelector('[name="_method"]').value = 'POST';
        form.reset();
        document.getElementById('studentModalLabel').textContent = 'Tambah Siswa';
        document.getElementById('studentId').value = '';
    });
</script>
@endsection