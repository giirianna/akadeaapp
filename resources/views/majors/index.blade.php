@extends('layouts.app')

@section('content')
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title">
                    <h2>
                        <i class="lni lni-book"></i> {{ __('app.major') ?? 'Major' }}
                    </h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end align-items-center gap-2">
                    <!-- Action Dropdown Menu -->
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="lni lni-menu"></i> {{ __('app.action') ?? 'Action' }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addMajorModal">
                                    <i class="lni lni-plus me-2"></i> {{ __('app.add_major') ?? 'Add Major' }}
                                </button>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('majors.index') }}">
                                    <i class="lni lni-reload me-2"></i> {{ __('app.refresh') ?? 'Refresh' }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== Toast Notifications ========== -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong><i class="lni lni-checkmark-circle"></i> {{ __('app.success') ?? 'Success!' }}</strong>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <strong><i class="lni lni-close-circle"></i> {{ __('app.error') ?? 'Error!' }}</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="card-style mb-30">
                <div class="card-head d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">
                            <i class="lni lni-list"></i> {{ __('app.major_list') ?? 'Major List' }}
                        </h6>
                        <small class="text-muted d-block mt-1">
                            {{ $majors->total() }} {{ __('app.total') ?? 'Total' }} {{ __('app.major') ?? 'Major' }}
                        </small>
                    </div>
                    <span class="badge bg-info">{{ $majors->count() }}/{{ $majors->total() }}</span>
                </div>

                <div class="table-wrapper table-responsive">
                    @if ($majors->count() > 0)
                        <table class="table table-hover table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%;">
                                        <h6>{{ __('app.no') ?? 'No' }}</h6>
                                    </th>
                                    <th style="width: 20%;">
                                        <h6><i class="lni lni-bookmark"></i> {{ __('app.name') ?? 'Name' }}</h6>
                                    </th>
                                    <th style="width: 10%;">
                                        <h6><i class="lni lni-tag"></i> {{ __('app.code') ?? 'Code' }}</h6>
                                    </th>
                                    <th style="width: 45%;">
                                        <h6><i class="lni lni-pencil-alt"></i> {{ __('app.description') ?? 'Description' }}</h6>
                                    </th>
                                    <th style="width: 20%;" class="text-center">
                                        <h6><i class="lni lni-settings"></i> {{ __('app.action') ?? 'Action' }}</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($majors as $index => $major)
                                    <tr class="align-middle">
                                        <td>
                                            <span class="badge bg-secondary">{{ $majors->firstItem() + $index }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $major->name }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $major->code ?? '—' }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ Str::limit($major->description, 50) ?? '—' }}</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="action d-flex justify-content-center gap-1">
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#viewMajorModal" onclick="viewMajor({{ $major }})" title="View">
                                                    <i class="lni lni-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editMajorModal" onclick="editMajor({{ $major }})" title="Edit">
                                                    <i class="lni lni-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#deleteMajorModal" onclick="setDeleteMajor({{ $major }})">
                                                    <i class="lni lni-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-end mt-4">
                            {{ $majors->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="lni lni-inbox" style="font-size: 48px; color: #ccc;"></i>
                            <p class="text-muted mt-3">
                                <strong>{{ __('app.no_data') ?? 'No data found' }}</strong>
                            </p>
                            <p class="text-muted small">
                                {{ __('app.no_major_message') ?? 'Click the Action menu to add a new major' }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- ========== ADD MAJOR MODAL ========== -->
    <div class="modal fade" id="addMajorModal" tabindex="-1" aria-labelledby="addMajorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMajorModalLabel">{{ __('app.add_major') ?? 'Add Major' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('majors.store') }}" id="addMajorForm">
                    @csrf
                    <div class="modal-body">
                        <div id="majorsContainer">
                            <!-- First major entry -->
                            <div class="major-entry mb-4 pb-3 border-bottom">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name_1" class="form-label">{{ __('app.name') ?? 'Name' }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control major-name" id="name_1" name="names[]"
                                            required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="code_1" class="form-label">{{ __('app.code') ?? 'Code' }}</label>
                                        <input type="text" class="form-control major-code" id="code_1" name="codes[]">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="description_1"
                                            class="form-label">{{ __('app.description') ?? 'Description' }}</label>
                                        <textarea class="form-control major-description" id="description_1"
                                            name="descriptions[]" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add More Button -->
                        <button type="button" class="btn btn-outline-primary btn-sm w-100" id="addMoreBtn"
                            onclick="addMajorField()">
                            <i class="lni lni-plus"></i> {{ __('app.add_more') ?? 'Add More' }}
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('app.cancel') ?? 'Cancel' }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('app.add') ?? 'Add' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ========== EDIT MAJOR MODAL ========== -->
    <div class="modal fade" id="editMajorModal" tabindex="-1" aria-labelledby="editMajorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMajorModalLabel">{{ __('app.edit_major') ?? 'Edit Major' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_name" class="form-label">{{ __('app.name') ?? 'Name' }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_code" class="form-label">{{ __('app.code') ?? 'Code' }}</label>
                                <input type="text" class="form-control" id="edit_code" name="code">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="edit_description"
                                    class="form-label">{{ __('app.description') ?? 'Description' }}</label>
                                <textarea class="form-control" id="edit_description" name="description" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('app.cancel') ?? 'Cancel' }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('app.update') ?? 'Update' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ========== VIEW MAJOR MODAL ========== -->
    <div class="modal fade" id="viewMajorModal" tabindex="-1" aria-labelledby="viewMajorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="viewMajorModalLabel">
                        <i class="lni lni-eye"></i> {{ __('app.view_major') ?? 'View Major' }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ __('app.name') ?? 'Name' }}</label>
                            <p class="border-bottom pb-2" id="view_name">-</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ __('app.code') ?? 'Code' }}</label>
                            <p class="border-bottom pb-2" id="view_code">-</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">{{ __('app.description') ?? 'Description' }}</label>
                            <p class="border-bottom pb-2" id="view_description" style="white-space: pre-wrap;">-</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ __('app.created_at') ?? 'Created At' }}</label>
                            <p id="view_created_at">-</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ __('app.updated_at') ?? 'Updated At' }}</label>
                            <p id="view_updated_at">-</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('app.close') ?? 'Close' }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== DELETE MAJOR MODAL ========== -->
    <div class="modal fade" id="deleteMajorModal" tabindex="-1" aria-labelledby="deleteMajorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteMajorModalLabel">
                        <i class="lni lni-trash"></i> {{ __('app.delete_major') ?? 'Delete Major' }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning" role="alert">
                        <i class="lni lni-warning"></i>
                        {{ __('app.delete_warning') ?? 'Warning: This action cannot be undone!' }}
                    </div>
                    <p>{{ __('app.delete_confirmation') ?? 'Are you sure you want to delete this major?' }}</p>
                    <p class="fw-bold">
                        {{ __('app.major') ?? 'Major' }}: <span id="delete_name" class="text-danger">-</span>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('app.cancel') ?? 'Cancel' }}</button>
                    <form method="POST" id="deleteForm" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="lni lni-trash"></i> {{ __('app.delete') ?? 'Delete' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let majorCount = 1;

        function addMajorField() {
            majorCount++;
            const container = document.getElementById('majorsContainer');
            const newField = `
                            <div class="major-entry mb-4 pb-3 border-bottom" id="entry_${majorCount}">
                                <div class="row">
                                    <div class="col-md-5 mb-3">
                                        <label for="name_${majorCount}" class="form-label">{{ __('app.name') ?? 'Name' }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control major-name" id="name_${majorCount}" name="names[]" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="code_${majorCount}" class="form-label">{{ __('app.code') ?? 'Code' }}</label>
                                        <input type="text" class="form-control major-code" id="code_${majorCount}" name="codes[]">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeMajorField(${majorCount})">
                                            <i class="lni lni-trash"></i> {{ __('app.delete') ?? 'Delete' }}
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="description_${majorCount}" class="form-label">{{ __('app.description') ?? 'Description' }}</label>
                                        <textarea class="form-control major-description" id="description_${majorCount}" name="descriptions[]" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        `;
            container.insertAdjacentHTML('beforeend', newField);
        }

        function removeMajorField(id) {
            const entry = document.getElementById(`entry_${id}`);
            if (entry) {
                entry.remove();
            }
        }

        function editMajor(major) {
            document.getElementById('edit_name').value = major.name;
            document.getElementById('edit_code').value = major.code || '';
            document.getElementById('edit_description').value = major.description || '';
            document.getElementById('editForm').action = `/majors/${major.id}`;
        }

        function viewMajor(major) {
            document.getElementById('view_name').textContent = major.name || '-';
            document.getElementById('view_code').textContent = major.code || '-';
            document.getElementById('view_description').textContent = major.description || '-';

            const createdAt = new Date(major.created_at).toLocaleString();
            const updatedAt = new Date(major.updated_at).toLocaleString();

            document.getElementById('view_created_at').textContent = createdAt;
            document.getElementById('view_updated_at').textContent = updatedAt;
        }

        function setDeleteMajor(major) {
            document.getElementById('delete_name').textContent = major.name;
            document.getElementById('deleteForm').action = `/majors/${major.id}`;
        }

        // Reset form when modal is closed
        document.getElementById('addMajorModal').addEventListener('hidden.bs.modal', function () {
            const container = document.getElementById('majorsContainer');
            majorCount = 1;
            container.innerHTML = `
                            <div class="major-entry mb-4 pb-3 border-bottom">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name_1" class="form-label">{{ __('app.name') ?? 'Name' }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control major-name" id="name_1" name="names[]" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="code_1" class="form-label">{{ __('app.code') ?? 'Code' }}</label>
                                        <input type="text" class="form-control major-code" id="code_1" name="codes[]">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="description_1" class="form-label">{{ __('app.description') ?? 'Description' }}</label>
                                        <textarea class="form-control major-description" id="description_1" name="descriptions[]" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        `;
            document.getElementById('addMajorForm').reset();
        });

        // Auto-hide success alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function () {
            const successAlerts = document.querySelectorAll('.alert-success');
            successAlerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
@endsection
