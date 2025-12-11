@extends('layouts.app')

@section('title', 'Tambah Mata Pelajaran')

@push('styles')
<style>
    /* Multi-select Dropdown Styles */
    .multiselect-dropdown {
        position: relative;
    }
    .multiselect-dropdown .multiselect-btn {
        background-color: #fff;
        border: 1px solid #ced4da;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-align: left;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 100%;
        padding: 10px 15px;
        border-radius: 5px;
    }
    .multiselect-dropdown .multiselect-btn::after {
        margin-left: auto;
    }
    .multiselect-dropdown .dropdown-menu {
        max-height: 250px;
        overflow-y: auto;
        min-width: 100%;
        padding: 8px;
    }
    .multiselect-dropdown .dropdown-item {
        padding: 8px 12px;
        cursor: pointer;
        border-radius: 6px;
        transition: background-color 0.2s;
    }
    .multiselect-dropdown .dropdown-item:hover {
        background-color: #f8f9fa;
    }
    .multiselect-dropdown .dropdown-item label {
        cursor: pointer;
        margin: 0;
        width: 100%;
    }
    .multiselect-dropdown .form-check-input {
        cursor: pointer;
        width: 18px;
        height: 18px;
    }
    .multiselect-dropdown .form-check-input:checked {
        background-color: #4a6cf7;
        border-color: #4a6cf7;
    }
</style>
@endpush

@section('content')
<section class="form-components">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Tambah Mata Pelajaran</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Mata Pelajaran</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
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
                    <form action="{{ route('subjects.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label for="subject_code">Kode Mata Pelajaran <span class="text-danger">*</span></label>
                                    <input type="text" name="subject_code" id="subject_code" value="{{ old('subject_code') }}" placeholder="Contoh: MP-001" required>
                                    @error('subject_code')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label for="subject_name">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                                    <input type="text" name="subject_name" id="subject_name" value="{{ old('subject_name') }}" placeholder="Matematika, Bahasa Indonesia, dll" required>
                                    @error('subject_name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label>Kelas <span class="text-danger">*</span></label>
                                    <div class="multiselect-dropdown">
                                        <button type="button" class="multiselect-btn" id="classLevelDropdownBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                            -- Pilih Kelas --
                                        </button>
                                        <ul class="dropdown-menu p-2 w-100" id="classLevelDropdown">
                                            @foreach($classLevels as $level)
                                            <li>
                                                <label class="dropdown-item d-flex align-items-center gap-2 rounded">
                                                    <input type="checkbox" name="class_level[]" value="{{ $level }}" class="form-check-input m-0 class-level-checkbox" {{ is_array(old('class_level')) && in_array($level, old('class_level')) ? 'checked' : '' }}>
                                                    <span>Kelas {{ $level }}</span>
                                                </label>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <small class="text-muted">Pilih satu atau lebih kelas</small>
                                    @error('class_level')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label>Jurusan <span class="text-danger">*</span></label>
                                    <div class="multiselect-dropdown">
                                        <button type="button" class="multiselect-btn" id="majorDropdownBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                            -- Pilih Jurusan --
                                        </button>
                                        <ul class="dropdown-menu p-2 w-100" id="majorDropdown">
                                            @foreach($majors as $major)
                                            <li>
                                                <label class="dropdown-item d-flex align-items-center gap-2 rounded">
                                                    <input type="checkbox" name="major[]" value="{{ $major }}" class="form-check-input m-0 major-checkbox" {{ is_array(old('major')) && in_array($major, old('major')) ? 'checked' : '' }}>
                                                    <span>{{ $major }}</span>
                                                </label>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <small class="text-muted">Pilih satu atau lebih jurusan</small>
                                    @error('major')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="input-style-1">
                                    <label for="description">Deskripsi</label>
                                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Opsional">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('subjects.index') }}" class="btn btn-light me-2">Batal</a>
                            <button type="submit" class="main-btn primary-btn btn-hover">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update button text when checkboxes change
    function updateMultiselectButton(checkboxSelector, buttonId, defaultText) {
        const checkboxes = document.querySelectorAll(checkboxSelector);
        const button = document.getElementById(buttonId);
        
        // Initial update
        const initialChecked = document.querySelectorAll(checkboxSelector + ':checked');
        if (initialChecked.length > 0) {
            if (initialChecked.length === 1) {
                button.textContent = initialChecked[0].nextElementSibling.textContent.trim();
            } else {
                button.textContent = initialChecked.length + ' dipilih';
            }
        }
        
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checked = document.querySelectorAll(checkboxSelector + ':checked');
                if (checked.length === 0) {
                    button.textContent = defaultText;
                } else if (checked.length === 1) {
                    button.textContent = checked[0].nextElementSibling.textContent.trim();
                } else {
                    button.textContent = checked.length + ' dipilih';
                }
            });
        });
    }
    
    updateMultiselectButton('.class-level-checkbox', 'classLevelDropdownBtn', '-- Pilih Kelas --');
    updateMultiselectButton('.major-checkbox', 'majorDropdownBtn', '-- Pilih Jurusan --');
    
    // Prevent dropdown from closing when clicking on items
    document.querySelectorAll('.multiselect-dropdown .dropdown-menu').forEach(menu => {
        menu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
});
</script>
@endpush