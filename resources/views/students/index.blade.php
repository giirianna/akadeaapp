@extends('layouts.app')
@section('title', __('app.student_list'))

{{-- 🔒 Hanya guru yang boleh akses --}}
@if(auth()->user()->hasRole('siswa') || (auth()->user()->student_id ?? false))
<script>
    window.location.href = "{{ route('dashboard') }}";
</script>
@stop
@endif

@section('content')
<!-- ========== table components start ========== -->
<section class="table-components">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>{{ __('app.student_list') }}</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('app.students') }}</li>
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
                                <h6>{{ __('app.student_list') }}</h6>
                                <p class="text-sm">{{ __('app.student_list_description') }}</p>
                            </div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#studentModal">
                                <span class="icon"><i class="lni lni-plus"></i></span> {{ __('app.add_student') }}
                            </button>
                        </div>

                        @if($students->isEmpty())
                            <div class="alert alert-info" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="lni lni-info-circle me-2"></i>
                                    <span>{{ __('app.no_student_data') }}</span>
                                </div>
                            </div>
                        @else
                            <div class="table-wrapper table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 50px;"><h6>#</h6></th>
                                            <th class="text-start"><h6>{{ __('app.name') }}</h6></th>
                                            <th class="text-center"><h6>{{ __('app.student_number') }}</h6></th>
                                            <th class="text-center"><h6>{{ __('app.class') }}</h6></th>
                                            <th class="text-center"><h6>{{ __('app.major') ?? 'Jurusan' }}</h6></th>
                                            <th class="text-center"><h6>Bulan Masuk</h6></th>
                                            <th class="text-center"><h6>{{ __('app.actions') }}</h6></th>
                                        </tr>
                                    </thead>
                                    <tbody id="studentsTableBody">
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
                                            <td class="text-center min-width">
                                                <p>
                                                    {{ \Carbon\Carbon::parse($student->enrollment_date)->format('d/m/Y') }}
                                                </p>
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
                                                            '{{ addslashes($student->address ?? '-') }}',
                                                            '{{ \Carbon\Carbon::parse($student->enrollment_date)->format('d/m/Y') }}'
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
                                                            '{{ addslashes($student->address ?? '') }}',
                                                            '{{ $student->enrollment_date ?? '' }}'
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
            <form id="studentForm">
                @csrf
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
                    <div class="input-style-1 mb-3">
                        <label for="enrollment_date">Bulan Masuk</label>
                        <input type="date" name="enrollment_date" id="enrollment_date" class="form-control" required>
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
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Siswa</h5>
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
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Bulan Masuk:</strong></div>
                    <div class="col-md-8" id="detail-enrollment_date"></div>
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

    // Hapus
    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (!deleteStudentId) return;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch(`/students/${deleteStudentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            modal.hide();
            if (data.success) {
                const row = document.querySelector(`tr[data-id="${deleteStudentId}"]`);
                if (row) row.remove();
            }
            deleteStudentId = null;
        })
        .catch(() => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            modal.hide();
            deleteStudentId = null;
        });
    });

    // Simpan & Edit (AJAX) — NO RELOAD
    document.getElementById('studentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const studentId = formData.get('id');
        const url = studentId ? `/students/${studentId}` : `/students`;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Untuk edit, Laravel butuh _method=PUT
        if (studentId) {
            formData.append('_method', 'PUT');
        }

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('studentModal'));
                modal.hide();

                // Show success message with credentials if provided
                if (data.message) {
                    alert(data.message);
                }

                const student = data.student;

                if (studentId) {
                    // Update baris yang ada
                    const row = document.querySelector(`tr[data-id="${studentId}"]`);
                    if (row) {
                        const enrollmentDisplay = new Date(student.enrollment_date).toLocaleDateString('id-ID');
                        row.querySelector('.text-start p').textContent = student.name;
                        row.querySelectorAll('.text-center p')[1].textContent = student.nis;
                        row.querySelectorAll('.text-center p')[2].textContent = student.class;
                        row.querySelectorAll('.text-center p')[3].textContent = student.major || '-';
                        row.querySelectorAll('.text-center p')[4].textContent = enrollmentDisplay;
                    }
                } else {
                    // Tambah baris baru
                    const tableBody = document.getElementById('studentsTableBody');
                    const newIndex = tableBody.children.length + 1;
                    const enrollmentDisplay = new Date(student.enrollment_date).toLocaleDateString('id-ID');

                    const newRow = document.createElement('tr');
                    newRow.setAttribute('data-id', student.id);
                    newRow.innerHTML = `
                        <td class="text-center"><p>${newIndex}</p></td>
                        <td class="text-start min-width"><p>${student.name}</p></td>
                        <td class="text-center min-width"><p><strong>${student.nis}</strong></p></td>
                        <td class="text-center min-width"><p>${student.class}</p></td>
                        <td class="text-center min-width"><p>${student.major || '-'}</p></td>
                        <td class="text-center min-width"><p>${enrollmentDisplay}</p></td>
                        <td class="text-center">
                            <div class="action d-flex gap-2 justify-content-center">
                                <button type="button" class="text-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                    onclick="showDetail('${addslashes(student.name)}', '${student.nis}', '${student.class}', 
                                    '${addslashes(student.major || '-')}', 
                                    '${student.birth_date ? new Date(student.birth_date).toLocaleDateString('id-ID') : '-'}',
                                    '${addslashes(student.address || '-')}', '${enrollmentDisplay}')"
                                    title="Detail">
                                    <i class="lni lni-eye"></i>
                                </button>
                                <button type="button" class="text-warning" data-bs-toggle="modal" data-bs-target="#studentModal"
                                    onclick="fillEditForm(${student.id}, '${addslashes(student.name)}', '${student.nis}', 
                                    '${student.class}', '${addslashes(student.major || '')}', 
                                    '${student.birth_date || ''}', '${addslashes(student.address || '')}', '${student.enrollment_date}')"
                                    title="Edit">
                                    <i class="lni lni-pencil"></i>
                                </button>
                                <button type="button" class="text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    onclick="setDeleteId(${student.id}, '${addslashes(student.name)}')"
                                    title="Hapus">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    `;
                    tableBody.appendChild(newRow);
                }

                // Reset form
                document.getElementById('studentForm').reset();
                document.getElementById('studentModalLabel').textContent = 'Tambah Siswa';
                document.getElementById('studentId').value = '';
            } else {
                alert(data.message || 'Gagal menyimpan data.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan data.');
        });
    });

    // Helper: escape string for JS
    function addslashes(str) {
        return (str + '').replace(/[\\"]/g, '\\$&').replace(/\u0000/g, '\\0');
    }

    function fillEditForm(id, name, nis, class_, major, birth_date, address, enrollment_date) {
        document.getElementById('studentModalLabel').textContent = 'Edit Siswa';
        document.getElementById('studentId').value = id;
        document.getElementById('name').value = name;
        document.getElementById('nis').value = nis;
        document.getElementById('class').value = class_;
        document.getElementById('major').value = major;
        document.getElementById('birth_date').value = birth_date; // format: YYYY-MM-DD
        document.getElementById('address').value = address;
        document.getElementById('enrollment_date').value = enrollment_date; // pastikan format YYYY-MM-DD
    }

    function showDetail(name, nis, class_, major, birth_date, address, enrollment_date) {
        document.getElementById('detail-name').textContent = name;
        document.getElementById('detail-nis').textContent = nis;
        document.getElementById('detail-class').textContent = class_;
        document.getElementById('detail-major').textContent = major;
        document.getElementById('detail-birth_date').textContent = birth_date;
        document.getElementById('detail-address').textContent = address;
        document.getElementById('detail-enrollment_date').textContent = enrollment_date;
    }

    function setDeleteId(id, name) {
        deleteStudentId = id;
        document.getElementById('delete-student-name').textContent = name;
    }

    document.getElementById('studentModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('studentForm').reset();
        document.getElementById('studentModalLabel').textContent = 'Tambah Siswa';
        document.getElementById('studentId').value = '';
    });
</script>
@endsection