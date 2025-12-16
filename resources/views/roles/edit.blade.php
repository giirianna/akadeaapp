@extends('layouts.app')

@section('title', __('app.edit_role'))

@section('content')
    <!-- ========== tab components start ========== -->
    <section class="tab-components">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ __('app.edit_role') }}</h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('roles.index') }}">{{ __('app.role_management') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __('app.edit_role') }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ========== title-wrapper end ========== -->

            <!-- ========== form-elements-wrapper start ========== -->
            <div class="form-elements-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="{{ route('roles.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- User Info Card -->
                            <div class="card-style mb-30">
                                <h6 class="mb-25">{{ __('app.user_information') }}</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p class="text-sm mb-2"><strong>{{ __('app.name') }}:</strong></p>
                                        <p class="mb-3">{{ $user->name }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="text-sm mb-2"><strong>{{ __('app.email') }}:</strong></p>
                                        <p class="mb-3">{{ $user->email }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="text-sm mb-2"><strong>{{ __('app.current_role') }}:</strong></p>
                                        @php
                                            $currentRole = $user->roles->first()?->name ?? 'No Role';
                                            $badgeClass = match($currentRole) {
                                                'admin' => 'danger',
                                                'teacher' => 'warning',
                                                'student' => 'info',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $currentRole)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Role Selection Card -->
                            <div class="card-style mb-30">
                                <h6 class="mb-25">{{ __('app.assign_role') }}</h6>
                                <div class="select-style-1">
                                    <label for="role">{{ __('app.select_role') }}</label>
                                    <div class="select-position">
                                        <select name="role" id="role" required>
                                            <option value="">{{ __('app.choose_role') }}</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->name }}" 
                                                    {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                    {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('role')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Role Descriptions -->
                                <div class="mt-20">
                                    <p class="text-sm text-muted mb-2"><strong>{{ __('app.role_descriptions') ?? 'Role Descriptions' }}:</strong></p>
                                    <ul class="text-sm text-muted">
                                        <li><strong>Admin:</strong> Full access to all modules including Settings</li>
                                        <li><strong>Teacher:</strong> Access to Home and Management menus</li>
                                        <li><strong>Student:</strong> Access to Home menu only (Dashboard, Exams)</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Custom Permissions Card -->
                            <div class="card-style mb-30">
                                <h6 class="mb-10">Custom Permissions</h6>
                                <p class="text-sm text-muted mb-25">Override default role permissions for this user. Leave unchecked to use role defaults.</p>
                                
                                <div class="alert alert-info">
                                    <strong>Permission Levels:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li><strong>View:</strong> Can only see data</li>
                                        <li><strong>View + Create:</strong> Can see and add new data</li>
                                        <li><strong>View + Edit:</strong> Can see and modify existing data</li>
                                        <li><strong>Full Access:</strong> Can view, create, edit, and delete</li>
                                    </ul>
                                </div>

                                <div class="table-responsive mt-20">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 200px;">Module</th>
                                                <th class="text-center">View</th>
                                                <th class="text-center">Create</th>
                                                <th class="text-center">Edit</th>
                                                <th class="text-center">Delete</th>
                                                <th class="text-center">Quick Select</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $modules = [
                                                    'dashboard' => 'Dashboard',
                                                    'students' => 'Students',
                                                    'teachers' => 'Teachers',
                                                    'spp' => 'SPP Payments',
                                                    'subjects' => 'Subjects',
                                                    'exams_students' => 'Exams (Students)',
                                                    'exams_teachers' => 'Exams (Teachers)',
                                                    'roles' => 'Role Management',
                                                ];
                                                $actions = ['view', 'create', 'edit', 'delete'];
                                            @endphp
                                            
                                            @foreach($modules as $module => $label)
                                                <tr>
                                                    <td><strong>{{ $label }}</strong></td>
                                                    @foreach($actions as $action)
                                                        <td class="text-center">
                                                            <input 
                                                                type="checkbox" 
                                                                name="permissions[]" 
                                                                value="{{ $module }}.{{ $action }}"
                                                                class="form-check-input permission-checkbox module-{{ $module }}"
                                                                {{ $user->hasPermissionTo("{$module}.{$action}") ? 'checked' : '' }}
                                                            >
                                                        </td>
                                                    @endforeach
                                                    <td class="text-center">
                                                        <button 
                                                            type="button" 
                                                            class="btn btn-sm btn-outline-primary quick-select"
                                                            data-module="{{ $module }}"
                                                            data-level="view"
                                                        >
                                                            View Only
                                                        </button>
                                                        <button 
                                                            type="button" 
                                                            class="btn btn-sm btn-outline-warning quick-select"
                                                            data-module="{{ $module }}"
                                                            data-level="edit"
                                                        >
                                                            View + Edit
                                                        </button>
                                                        <button 
                                                            type="button" 
                                                            class="btn btn-sm btn-outline-success quick-select"
                                                            data-module="{{ $module }}"
                                                            data-level="full"
                                                        >
                                                            Full
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Buttons -->
                            <div class="card-style mb-30">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="icon"><i class="lni lni-save"></i></span> {{ __('app.update_role') ?? 'Update Role & Permissions' }}
                                    </button>
                                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                                        <span class="icon"><i class="lni lni-arrow-left"></i></span> {{ __('app.back') }}
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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quick select buttons
    document.querySelectorAll('.quick-select').forEach(button => {
        button.addEventListener('click', function() {
            const module = this.dataset.module;
            const level = this.dataset.level;
            const checkboxes = document.querySelectorAll(`.module-${module}`);
            
            // Uncheck all first
            checkboxes.forEach(cb => cb.checked = false);
            
            // Check based on level
            if (level === 'view') {
                // Only view
                checkboxes[0].checked = true;
            } else if (level === 'edit') {
                // View + Edit
                checkboxes[0].checked = true; // view
                checkboxes[2].checked = true; // edit
            } else if (level === 'full') {
                // All permissions
                checkboxes.forEach(cb => cb.checked = true);
            }
        });
    });
});
</script>
@endpush
