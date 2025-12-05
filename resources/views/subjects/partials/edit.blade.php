<form id="editSubjectForm" action="{{ route('subjects.update', $subject) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="teacher_id" class="form-label">Guru Pengajar <span class="text-danger">*</span></label>
            <select name="teacher_id" id="teacher_id" class="form-select" required>
                <option value="">-- Pilih Guru --</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('teacher_id', $subject->teacher_id) == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->full_name }}
                    </option>
                @endforeach
            </select>
            @error('teacher_id')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="subject_code" class="form-label">Kode Mata Pelajaran <span class="text-danger">*</span></label>
            <input type="text" name="subject_code" id="subject_code" class="form-control" value="{{ old('subject_code', $subject->subject_code) }}" required>
            @error('subject_code')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-12 mb-3">
            <label for="subject_name" class="form-label">Nama Mata Pelajaran <span class="text-danger">*</span></label>
            <input type="text" name="subject_name" id="subject_name" class="form-control" value="{{ old('subject_name', $subject->subject_name) }}" required>
            @error('subject_name')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="class_level" class="form-label">Tingkat Kelas <span class="text-danger">*</span></label>
            <select name="class_level" id="class_level" class="form-select" required>
                <option value="">-- Pilih Kelas --</option>
                <option value="X" {{ old('class_level', $subject->class_level) == 'X' ? 'selected' : '' }}>X</option>
                <option value="XI" {{ old('class_level', $subject->class_level) == 'XI' ? 'selected' : '' }}>XI</option>
                <option value="XII" {{ old('class_level', $subject->class_level) == 'XII' ? 'selected' : '' }}>XII</option>
            </select>
            @error('class_level')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="major" class="form-label">Jurusan <span class="text-danger">*</span></label>
            <select name="major" id="major" class="form-select" required>
                <option value="">-- Pilih Jurusan --</option>
                @foreach($majors as $major)
                    <option value="{{ $major }}" {{ old('major', $subject->major) == $major ? 'selected' : '' }}>{{ $major }}</option>
                @endforeach
            </select>
            @error('major')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-12 mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $subject->description) }}</textarea>
            @error('description')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
            <select name="status" id="status" class="form-select" required>
                <option value="active" {{ old('status', $subject->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ old('status', $subject->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('status')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-3">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>
