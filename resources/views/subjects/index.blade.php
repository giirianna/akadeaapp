@extends('layouts.app')

@section('title', 'Mata Pelajaran')

@section('content')
<section class="table-components">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Mata Pelajaran</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Mata Pelajaran
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ========== title-wrapper end ========== -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="d-flex justify-content-between align-items-center mb-20">
                        <h6 class="mb-0">Daftar Mata Pelajaran</h6>
                        <button type="button" class="main-btn primary-btn btn-hover" id="btnAddSubject">
                            <i class="lni lni-plus"></i> Tambah Mata Pelajaran
                        </button>
                    </div>

                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select id="filter-class" class="form-select">
                                <option value="">Semua Kelas</option>
                                <option value="X">Kelas X</option>
                                <option value="XI">Kelas XI</option>
                                <option value="XII">Kelas XII</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="filter-major" class="form-select">
                                <option value="">Semua Jurusan</option>
                                <option value="Semua Jurusan">Semua Jurusan</option>
                                <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                                <option value="Teknik Komputer dan Jaringan">Teknik Komputer dan Jaringan</option>
                                <option value="Akuntansi">Akuntansi</option>
                                <option value="Otomatisasi Tata Kelola Perkantoran">Otomatisasi Tata Kelola Perkantoran</option>
                                <option value="Desain Komunikasi Visual">Desain Komunikasi Visual</option>
                                <option value="Tata Boga">Tata Boga</option>
                                <option value="Multimedia">Multimedia</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="filter-status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="active">Aktif</option>
                                <option value="inactive">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button id="reset-filters" class="btn btn-secondary w-100">Reset Filter</button>
                        </div>
                    </div>

                    <div class="table-wrapper table-responsive">
                        <table id="subjects-table" class="table">
                            <thead>
                                <tr>
                                    <th><h6>Kode</h6></th>
                                    <th><h6>Nama Mata Pelajaran</h6></th>
                                    <th><h6>Guru Pengajar</h6></th>
                                    <th><h6>Kelas</h6></th>
                                    <th><h6>Jurusan</h6></th>
                                    <th><h6>Status</h6></th>
                                    <th><h6>Aksi</h6></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Show Subject Modal -->
<div class="modal fade" id="showSubjectModal" tabindex="-1" aria-labelledby="showSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showSubjectModalLabel">Detail Mata Pelajaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="showSubjectContent">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Subject Modal -->
<div class="modal fade" id="editSubjectModal" tabindex="-1" aria-labelledby="editSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubjectModalLabel">Edit Mata Pelajaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="editSubjectContent">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Subject Modal -->
<div class="modal fade" id="deleteSubjectModal" tabindex="-1" aria-labelledby="deleteSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteSubjectModalLabel">
                    <i class="lni lni-warning"></i> Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Apakah Anda yakin ingin menghapus mata pelajaran <strong id="deleteSubjectName"></strong>?</p>
                <p class="text-muted small mb-0 mt-2">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="lni lni-trash-can"></i> Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Create Subject Modal -->
<div class="modal fade" id="createSubjectModal" tabindex="-1" aria-labelledby="createSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSubjectModalLabel">
                    <i class="lni lni-plus"></i> Tambah Mata Pelajaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="createSubjectContent">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Popup Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-body text-center py-5">
                <div class="success-checkmark mb-4">
                    <div class="check-icon">
                        <span class="icon-line line-tip"></span>
                        <span class="icon-line line-long"></span>
                        <div class="icon-circle"></div>
                        <div class="icon-fix"></div>
                    </div>
                </div>
                <h4 class="text-success mb-3" id="successModalTitle">Berhasil!</h4>
                <p class="text-muted mb-4" id="successModalMessage">Data berhasil disimpan.</p>
                <button type="button" class="btn btn-success px-4" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
<style>
    /* Success Checkmark Animation */
    .success-checkmark {
        width: 80px;
        height: 80px;
        margin: 0 auto;
    }
    .success-checkmark .check-icon {
        width: 80px;
        height: 80px;
        position: relative;
        border-radius: 50%;
        box-sizing: content-box;
        border: 4px solid #4CAF50;
    }
    .success-checkmark .check-icon::before {
        top: 3px;
        left: -2px;
        width: 30px;
        transform-origin: 100% 50%;
        border-radius: 100px 0 0 100px;
    }
    .success-checkmark .check-icon::after {
        top: 0;
        left: 30px;
        width: 60px;
        transform-origin: 0 50%;
        border-radius: 0 100px 100px 0;
        animation: rotate-circle 4.25s ease-in;
    }
    .success-checkmark .check-icon::before, .success-checkmark .check-icon::after {
        content: '';
        height: 100px;
        position: absolute;
        background: #FFFFFF;
        transform: rotate(-45deg);
    }
    .success-checkmark .check-icon .icon-line {
        height: 5px;
        background-color: #4CAF50;
        display: block;
        border-radius: 2px;
        position: absolute;
        z-index: 10;
    }
    .success-checkmark .check-icon .icon-line.line-tip {
        top: 46px;
        left: 14px;
        width: 25px;
        transform: rotate(45deg);
        animation: icon-line-tip 0.75s;
    }
    .success-checkmark .check-icon .icon-line.line-long {
        top: 38px;
        right: 8px;
        width: 47px;
        transform: rotate(-45deg);
        animation: icon-line-long 0.75s;
    }
    .success-checkmark .check-icon .icon-circle {
        top: -4px;
        left: -4px;
        z-index: 10;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        position: absolute;
        box-sizing: content-box;
        border: 4px solid rgba(76, 175, 80, 0.5);
    }
    .success-checkmark .check-icon .icon-fix {
        top: 8px;
        width: 5px;
        left: 26px;
        z-index: 1;
        height: 85px;
        position: absolute;
        transform: rotate(-45deg);
        background-color: #FFFFFF;
    }
    @keyframes rotate-circle {
        0% { transform: rotate(-45deg); }
        5% { transform: rotate(-45deg); }
        12% { transform: rotate(-405deg); }
        100% { transform: rotate(-405deg); }
    }
    @keyframes icon-line-tip {
        0% { width: 0; left: 1px; top: 19px; }
        54% { width: 0; left: 1px; top: 19px; }
        70% { width: 50px; left: -8px; top: 37px; }
        84% { width: 17px; left: 21px; top: 48px; }
        100% { width: 25px; left: 14px; top: 46px; }
    }
    @keyframes icon-line-long {
        0% { width: 0; right: 46px; top: 54px; }
        65% { width: 0; right: 46px; top: 54px; }
        84% { width: 55px; right: 0px; top: 35px; }
        100% { width: 47px; right: 8px; top: 38px; }
    }
    #successModal .modal-content {
        border-radius: 15px;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#subjects-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('subjects.index') }}',
            data: function(d) {
                d.class_level = $('#filter-class').val();
                d.major = $('#filter-major').val();
                d.status = $('#filter-status').val();
            }
        },
        columns: [
            { data: 'subject_code', name: 'subject_code' },
            { data: 'subject_name', name: 'subject_name' },
            { data: 'teacher_name', name: 'teacher_name' },
            { data: 'class_level', name: 'class_level' },
            { data: 'major', name: 'major' },
            { data: 'status', name: 'status', orderable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"B>>rtip',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="lni lni-download"></i> Excel',
                className: 'btn btn-success btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'pdf',
                text: '<i class="lni lni-download"></i> PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'copy',
                text: '<i class="lni lni-clipboard"></i> Copy',
                className: 'btn btn-info btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'print',
                text: '<i class="lni lni-printer"></i> Print',
                className: 'btn btn-secondary btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            }
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Tidak ada data ditemukan",
            info: "Menampilkan halaman _PAGE_ dari _PAGES_",
            infoEmpty: "Tidak ada data tersedia",
            infoFiltered: "(difilter dari _MAX_ total data)",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        }
    });

    // Apply filters on change
    $('#filter-class, #filter-major, #filter-status').change(function() {
        table.ajax.reload();
    });

    // Reset filters
    $('#reset-filters').click(function() {
        $('#filter-class, #filter-major, #filter-status').val('');
        table.ajax.reload();
    });

    // Show success popup function
    function showSuccessPopup(title, message) {
        $('#successModalTitle').text(title || 'Berhasil!');
        $('#successModalMessage').text(message || 'Data berhasil disimpan.');
        $('#successModal').modal('show');
    }

    // Create Subject Modal - Open
    $('#btnAddSubject').on('click', function() {
        $('#createSubjectModal').modal('show');
        $('#createSubjectContent').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        
        $.ajax({
            url: '{{ route("subjects.create") }}',
            type: 'GET',
            success: function(response) {
                $('#createSubjectContent').html(response);
            },
            error: function() {
                $('#createSubjectContent').html('<div class="alert alert-danger">Gagal memuat form.</div>');
            }
        });
    });

    // Handle Create Form Submission
    $(document).on('submit', '#createSubjectForm', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var url = form.attr('action');
        var formData = new FormData(this);
        var submitBtn = form.find('button[type="submit"]');
        
        // Disable submit button to prevent double submission
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status"></span> Menyimpan...');
        
        // Remove any existing error alerts
        form.find('.alert-danger').remove();
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#createSubjectModal').modal('hide');
                table.ajax.reload();
                showSuccessPopup('Berhasil!', 'Mata pelajaran berhasil ditambahkan.');
                
                // Reset form
                form[0].reset();
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html('Simpan');
                
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    var errorHtml = '<div class="alert alert-danger"><ul class="mb-0">';
                    $.each(errors, function(key, value) {
                        errorHtml += '<li>' + value[0] + '</li>';
                    });
                    errorHtml += '</ul></div>';
                    form.prepend(errorHtml);
                } else {
                    form.prepend('<div class="alert alert-danger">Gagal menyimpan data. Silakan coba lagi.</div>');
                }
            }
        });
    });

    // Show Subject Modal
    $(document).on('click', '.show-subject', function(e) {
        e.preventDefault();
        var subjectId = $(this).data('id');
        
        $('#showSubjectModal').modal('show');
        $('#showSubjectContent').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        
        $.ajax({
            url: '/subjects/' + subjectId,
            type: 'GET',
            success: function(response) {
                $('#showSubjectContent').html(response);
            },
            error: function() {
                $('#showSubjectContent').html('<div class="alert alert-danger">Gagal memuat data.</div>');
            }
        });
    });

    // Edit Subject Modal
    $(document).on('click', '.edit-subject', function(e) {
        e.preventDefault();
        var subjectId = $(this).data('id');
        
        $('#editSubjectModal').modal('show');
        $('#editSubjectContent').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        
        $.ajax({
            url: '/subjects/' + subjectId + '/edit',
            type: 'GET',
            success: function(response) {
                $('#editSubjectContent').html(response);
            },
            error: function() {
                $('#editSubjectContent').html('<div class="alert alert-danger">Gagal memuat data.</div>');
            }
        });
    });

    // Handle Edit Form Submission
    $(document).on('submit', '#editSubjectForm', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var url = form.attr('action');
        var formData = new FormData(this);
        var submitBtn = form.find('button[type="submit"]');
        
        // Disable submit button to prevent double submission
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status"></span> Menyimpan...');
        
        // Remove any existing error alerts
        form.find('.alert-danger').remove();
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#editSubjectModal').modal('hide');
                table.ajax.reload();
                showSuccessPopup('Berhasil!', 'Mata pelajaran berhasil diperbarui.');
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html('Simpan Perubahan');
                
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    var errorHtml = '<div class="alert alert-danger"><ul class="mb-0">';
                    $.each(errors, function(key, value) {
                        errorHtml += '<li>' + value[0] + '</li>';
                    });
                    errorHtml += '</ul></div>';
                    form.prepend(errorHtml);
                } else {
                    form.prepend('<div class="alert alert-danger">Gagal menyimpan data. Silakan coba lagi.</div>');
                }
            }
        });
    });

    // Delete Subject Modal
    var deleteUrl = '';
    
    $(document).on('click', '.delete-subject', function(e) {
        e.preventDefault();
        var subjectName = $(this).data('name');
        deleteUrl = $(this).data('url');
        
        $('#deleteSubjectName').text(subjectName);
        $('#deleteSubjectModal').modal('show');
    });

    // Confirm Delete
    $('#confirmDeleteBtn').on('click', function() {
        if (deleteUrl) {
            var deleteBtn = $(this);
            deleteBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status"></span> Menghapus...');
            
            $.ajax({
                url: deleteUrl,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    deleteBtn.prop('disabled', false).html('<i class="lni lni-trash-can"></i> Hapus');
                    $('#deleteSubjectModal').modal('hide');
                    table.ajax.reload();
                    showSuccessPopup('Berhasil!', 'Mata pelajaran berhasil dihapus.');
                },
                error: function() {
                    deleteBtn.prop('disabled', false).html('<i class="lni lni-trash-can"></i> Hapus');
                    $('#deleteSubjectModal').modal('hide');
                    alert('Gagal menghapus mata pelajaran.');
                }
            });
        }
    });
});
</script>
@endpush
@endsection