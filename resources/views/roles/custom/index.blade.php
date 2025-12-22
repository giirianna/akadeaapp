@extends('layouts.app')

@section('title', 'Manage Custom Roles')

@section('content')
<section class="table-components">
    <div class="container-fluid">
        <!-- Title -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Custom Roles Management</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('roles.index') }}">Role Management</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Custom Roles
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Roles Table -->
        <div class="tables-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-style mb-30">
                        <div class="d-flex justify-content-between align-items-center mb-20">
                            <div>
                                <h6>All Roles</h6>
                                <p class="text-sm">Manage custom roles and their permissions</p>
                            </div>
                            <div>
                                <a href="{{ route('roles.custom.create') }}" class="main-btn primary-btn btn-hover">
                                    <i class="lni lni-plus"></i> Add New Role
                                </a>
                            </div>
                        </div>

                        <div class="table-wrapper table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;"><h6>#</h6></th>
                                        <th><h6>Role Name</h6></th>
                                        <th class="text-center"><h6>Users</h6></th>
                                        <th class="text-center"><h6>Permissions</h6></th>
                                        <th class="text-center"><h6>Type</h6></th>
                                        <th class="text-center"><h6>Actions</h6></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($roles as $index => $role)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <strong>{{ ucfirst(str_replace('_', ' ', $role->name)) }}</strong>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info">{{ $role->users_count }} users</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary">{{ $role->permissions_count }} permissions</span>
                                            </td>
                                            <td class="text-center">
                                                @if(in_array($role->name, ['admin', 'teacher', 'student']))
                                                    <span class="badge bg-success">Base Role</span>
                                                @else
                                                    <span class="badge bg-warning">Custom</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="action d-flex gap-2 justify-content-center">
                                                    <a href="{{ route('roles.custom.edit', $role) }}" class="text-warning" title="Edit Role">
                                                        <i class="lni lni-pencil"></i>
                                                    </a>
                                                    
                                                    @if(!in_array($role->name, ['admin', 'teacher', 'student']))
                                                        <form action="{{ route('roles.custom.destroy', $role) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this role?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="border-0 bg-transparent text-danger" title="Delete Role">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-muted" title="Cannot delete base roles">
                                                            <i class="lni lni-lock"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No roles found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
