@extends('layouts.app')

@section('title', __('app.role_management'))

@section('content')
<!-- ========== table components start ========== -->
<section class="table-components">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>{{ __('app.role_management') }}</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('app.role_management') }}
                                </li>
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
                        <div class="d-flex justify-content-between align-items-center mb-20">
                            <div>
                                <h6>{{ __('app.user_roles') ?? 'User Roles' }}</h6>
                                <p class="text-sm">{{ __('app.manage_user_roles') ?? 'Manage user roles and permissions' }}</p>
                            </div>
                            <div>
                                <a href="{{ route('roles.custom.index') }}" class="main-btn primary-btn btn-hover">
                                    <i class="lni lni-cog"></i> Manage Custom Roles
                                </a>
                            </div>
                        </div>

                        <!-- Filters -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <select id="filter-role" class="form-select">
                                    <option value="">All Roles</option>
                                    <option value="admin">Admin</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="student">Student</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button id="reset-filters" class="btn btn-secondary w-100">Reset Filter</button>
                            </div>
                        </div>

                        <div class="table-wrapper table-responsive">
                            <table id="roles-table" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 50px;"><h6>#</h6></th>
                                        <th class="text-start"><h6>{{ __('app.name') }}</h6></th>
                                        <th class="text-start"><h6>{{ __('app.email') }}</h6></th>
                                        <th class="text-center"><h6>{{ __('app.current_role') ?? 'Current Role' }}</h6></th>
                                        <th class="text-center"><h6>{{ __('app.actions') }}</h6></th>
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
        <!-- ========== tables-wrapper end ========== -->
    </div>
</section>
<!-- ========== table components end ========== -->

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleModalLabel">Edit User Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="editRoleContent">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
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
    var table = $('#roles-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('roles.index') }}',
            data: function(d) {
                d.role = $('#filter-role').val();
            }
        },
        columns: [
            { data: 'number', name: 'number', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'role', name: 'role', orderable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"B>>rtip',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="lni lni-download"></i> Excel',
                className: 'btn btn-success btn-sm',
                exportOptions: {
                    columns: [1, 2, 3]
                }
            },
            {
                extend: 'pdf',
                text: '<i class="lni lni-download"></i> PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [1, 2, 3]
                }
            },
            {
                extend: 'copy',
                text: '<i class="lni lni-clipboard"></i> Copy',
                className: 'btn btn-info btn-sm',
                exportOptions: {
                    columns: [1, 2, 3]
                }
            },
            {
                extend: 'print',
                text: '<i class="lni lni-printer"></i> Print',
                className: 'btn btn-secondary btn-sm',
                exportOptions: {
                    columns: [1, 2, 3]
                }
            }
        ],
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries per page",
            zeroRecords: "No data found",
            info: "Showing page _PAGE_ of _PAGES_",
            infoEmpty: "No data available",
            infoFiltered: "(filtered from _MAX_ total entries)",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        }
    });

    // Apply filters on change
    $('#filter-role').change(function() {
        table.ajax.reload();
    });

    // Reset filters
    $('#reset-filters').click(function() {
        $('#filter-role').val('');
        table.ajax.reload();
    });

    // Edit Role Modal
    $(document).on('click', '.edit-role', function(e) {
        e.preventDefault();
        var userId = $(this).data('id');
        
        $('#editRoleModal').modal('show');
        $('#editRoleContent').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        
        $.ajax({
            url: '/roles/' + userId + '/edit',
            type: 'GET',
            success: function(response) {
                $('#editRoleContent').html(response);
            },
            error: function() {
                $('#editRoleContent').html('<div class="alert alert-danger">Failed to load data.</div>');
            }
        });
    });

    // Handle Edit Form Submission
    $(document).on('submit', '#editRoleForm', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var url = form.attr('action');
        var formData = form.serialize();
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#editRoleModal').modal('hide');
                table.ajax.reload();
                
                // Show success message
                var successAlert = '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                  '<strong>Success!</strong> Role updated successfully.' +
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
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var errorHtml = '<div class="alert alert-danger"><ul class="mb-0">';
                $.each(errors, function(key, value) {
                    errorHtml += '<li>' + value[0] + '</li>';
                });
                errorHtml += '</ul></div>';
                $('#editRoleContent').prepend(errorHtml);
            }
        });
    });
});
</script>
@endpush
@endsection
