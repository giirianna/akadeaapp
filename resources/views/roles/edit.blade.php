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
                    <!-- end col -->
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
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== title-wrapper end ========== -->

            <!-- ========== form-elements-wrapper start ========== -->
            <div class="form-elements-wrapper">
                <div class="row">
                    <div class="col-lg-8">
                        <form action="{{ route('roles.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- User Info Card -->
                            <div class="card-style mb-30">
                                <h6 class="mb-25">{{ __('app.user_information') }}</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="text-sm mb-2"><strong>{{ __('app.name') }}:</strong></p>
                                        <p class="mb-3">{{ $user->name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-sm mb-2"><strong>{{ __('app.email') }}:</strong></p>
                                        <p class="mb-3">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-sm mb-2"><strong>{{ __('app.current_role') }}:</strong></p>
                                        @php
                                            $currentRole = $user->roles->first()?->name ?? 'No Role';
                                            $badgeClass = match($currentRole) {
                                                'super_admin' => 'danger',
                                                'admin' => 'warning',
                                                'basic' => 'info',
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
                                    <p class="text-sm text-muted mb-2"><strong>{{ __('app.role_descriptions') }}:</strong></p>
                                    <ul class="text-sm text-muted">
                                        <li><strong>Basic:</strong> {{ __('app.basic_role') }}</li>
                                        <li><strong>Admin:</strong> {{ __('app.admin_role') }}</li>
                                        <li><strong>Super Admin:</strong> {{ __('app.super_admin_role') }}</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Buttons -->
                            <div class="card-style mb-30">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="icon"><i class="lni lni-save"></i></span> {{ __('app.update_role') }}
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
