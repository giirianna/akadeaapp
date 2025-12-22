@extends('layouts.app')

@section('title', 'Edit Custom Role')

@section('content')
<section class="form-elements">
    <div class="container-fluid">
        <!-- Title -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Edit Role: {{ ucfirst(str_replace('_', ' ', $role->name)) }}</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Role Management</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('roles.custom.index') }}">Custom Roles</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="form-elements-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-style mb-30">
                        @if(in_array($role->name, ['admin', 'teacher', 'student']))
                            <div class="alert alert-info">
                                <i class="lni lni-information"></i> 
                                <strong>Base Role:</strong> You can view and modify permissions for this base role, but cannot change its name.
                            </div>
                        @endif

                        <h6 class="mb-25">Role Information</h6>
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('roles.custom.update', $role) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label for="name">Role Name <span class="text-danger">*</span></label>
                                        <input 
                                            type="text" 
                                            id="name" 
                                            name="name" 
                                            placeholder="e.g., librarian" 
                                            value="{{ old('name', $role->name) }}" 
                                            {{ in_array($role->name, ['admin', 'teacher', 'student']) ? 'readonly' : 'required' }}
                                        >
                                        @if(!in_array($role->name, ['admin', 'teacher', 'student']))
                                            <small class="text-muted">Use lowercase letters and underscores only</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label for="description">Description</label>
                                        <input type="text" id="description" name="description" placeholder="Brief description of this role" value="{{ old('description') }}">
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h6 class="mb-20">Module Permissions</h6>
                            <p class="text-sm text-muted mb-25">Select which modules and actions this role can access</p>

                            <div class="row">
                                @foreach($permissions as $module => $data)
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card border">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0">
                                                    <i class="lni lni-{{ $module === 'students' ? 'graduation' : ($module === 'teachers' ? 'users' : ($module === 'subjects' ? 'book' : ($module === 'spp' ? 'money-protection' : ($module === 'exams' ? 'clipboard' : 'cog')))) }}"></i>
                                                    {{ $data['name'] }}
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                @foreach($data['permissions'] as $permission)
                                                    <div class="form-check checkbox-style mb-2">
                                                        <input 
                                                            class="form-check-input" 
                                                            type="checkbox" 
                                                            name="permissions[]" 
                                                            value="{{ $permission['name'] }}" 
                                                            id="perm_{{ str_replace('.', '_', $permission['name']) }}"
                                                            {{ in_array($permission['name'], old('permissions', $rolePermissions)) ? 'checked' : '' }}
                                                        >
                                                        <label class="form-check-label" for="perm_{{ str_replace('.', '_', $permission['name']) }}">
                                                            {{ $permission['label'] }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="main-btn primary-btn btn-hover">
                                    <i class="lni lni-save"></i> Update Role
                                </button>
                                <a href="{{ route('roles.custom.index') }}" class="main-btn danger-btn-outline btn-hover">
                                    <i class="lni lni-close"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
