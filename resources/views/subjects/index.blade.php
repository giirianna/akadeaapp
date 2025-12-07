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
                        <a href="{{ route('subjects.create') }}" class="main-btn primary-btn btn-hover">
                            Tambah Mata Pelajaran
                        </a>
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

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
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
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#editSubjectModal').modal('hide');
                table.ajax.reload();
                alert('Mata pelajaran berhasil diperbarui!');
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var errorHtml = '<div class="alert alert-danger"><ul class="mb-0">';
                $.each(errors, function(key, value) {
                    errorHtml += '<li>' + value[0] + '</li>';
                });
                errorHtml += '</ul></div>';
                $('#editSubjectContent').prepend(errorHtml);
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
            $.ajax({
                url: deleteUrl,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#deleteSubjectModal').modal('hide');
                    table.ajax.reload();
                    
                    // Show success message
                    var successAlert = '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                      '<strong>Berhasil!</strong> Mata pelajaran berhasil dihapus.' +
                                      '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                                      '</div>';
                    $('.container-fluid').prepend(successAlert);
                    
                    // Auto-hide alert after 3 seconds
                    setTimeout(function() {
                        $('.alert-success').fadeOut('slow', function() {
                            $(this).remove();
                        });
                    }, 3000);
                },
                error: function() {
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