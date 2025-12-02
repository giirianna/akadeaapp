@extends('layouts.app')

@section('title', 'Role Management')

@section('content')
    <!-- ========== table components start ========== -->
    <section class="table-components">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Role Management</h2>
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
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Role Management
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== title-wrapper end ========== -->

            <!-- ========== tables-wrapper start ========== -->
            <div class="tables-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-style mb-30">
                            <div class="d-flex justify-content-between align-items-center mb-30">
                                <div>
                                    <h6>User Roles</h6>
                                    <p class="text-sm">Manage user roles and permissions</p>
                                </div>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <div class="d-flex align-items-center">
                                        <i class="lni lni-checkmark-circle me-2"></i>
                                        <span>{{ session('success') }}</span>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if($users->isEmpty())
                                <div class="alert alert-info" role="alert">
                                    <div class="d-flex align-items-center">
                                        <i class="lni lni-info-circle me-2"></i>
                                        <span>Belum ada pengguna terdaftar.</span>
                                    </div>
                                </div>
                            @else
                                <div class="table-wrapper table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 50px;">
                                                    <h6>#</h6>
                                                </th>
                                                <th class="text-start">
                                                    <h6>Name</h6>
                                                </th>
                                                <th class="text-start">
                                                    <h6>Email</h6>
                                                </th>
                                                <th class="text-center">
                                                    <h6>Current Role</h6>
                                                </th>
                                                <th class="text-center">
                                                    <h6>Actions</h6>
                                                </th>
                                            </tr>
                                            <!-- end table row-->
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)
                                                <tr>
                                                    <td class="text-center">
                                                        <p>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                                        </p>
                                                    </td>
                                                    <td class="text-start min-width">
                                                        <p>{{ $user->name }}</p>
                                                    </td>
                                                    <td class="text-start min-width">
                                                        <p>{{ $user->email }}</p>
                                                    </td>
                                                    <td class="text-center min-width">
                                                        @php
                                                            $roleName = $user->roles->first()?->name ?? 'No Role';
                                                            $badgeClass = match($roleName) {
                                                                'super_admin' => 'danger',
                                                                'admin' => 'warning',
                                                                'basic' => 'info',
                                                                default => 'secondary'
                                                            };
                                                        @endphp
                                                        <span class="badge bg-{{ $badgeClass }}">
                                                            {{ ucfirst(str_replace('_', ' ', $roleName)) }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="action d-flex gap-2 justify-content-center">
                                                            <a href="{{ route('roles.edit', $user) }}" class="text-warning"
                                                                title="Edit Role">
                                                                <i class="lni lni-pencil"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- end table row -->
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-wrapper -->

                                <!-- Pagination -->
                                <div class="d-flex justify-content-between align-items-center mt-20">
                                    <p class="text-sm">Total: {{ $users->total() }} users</p>
                                    <div class="pagination-wrapper">
                                        {{ $users->links() }}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== tables-wrapper end ========== -->
        </div>
        <!-- end container-fluid -->
    </section>
    <!-- ========== table components end ========== -->
@endsection
