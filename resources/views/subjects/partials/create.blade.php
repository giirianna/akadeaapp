<form id="createSubjectForm" action="{{ route('subjects.store') }}" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="create_teacher_id" class="form-label">Guru Pengajar <span class="text-danger">*</span></label>
            <select name="teacher_id" id="create_teacher_id" class="form-select" required>
                <option value="">-- Pilih Guru --</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label for="create_subject_code" class="form-label">Kode Mata Pelajaran <span class="text-danger">*</span></label>
            <input type="text" name="subject_code" id="create_subject_code" class="form-control" placeholder="Contoh: MP-001" required>
        </div>

        <div class="col-md-12 mb-3">
            <label for="create_subject_name" class="form-label">Nama Mata Pelajaran <span class="text-danger">*</span></label>
            <input type="text" name="subject_name" id="create_subject_name" class="form-control" placeholder="Matematika, Bahasa Indonesia, dll" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="create_class_level" class="form-label">Tingkat Kelas <span class="text-danger">*</span></label>
            <select name="class_level" id="create_class_level" class="form-select" required>
                <option value="">-- Pilih Kelas --</option>
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label for="create_major" class="form-label">Jurusan <span class="text-danger">*</span></label>
            <select name="major" id="create_major" class="form-select" required>
                <option value="">-- Pilih Jurusan --</option>
                @foreach($majors as $major)
                    <option value="{{ $major }}">{{ $major }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mb-3">
            <label for="create_description" class="form-label">Deskripsi</label>
            <textarea name="description" id="create_description" class="form-control" rows="3" placeholder="Opsional"></textarea>
        </div>

        <div class="col-md-6 mb-3">
            <label for="create_status" class="form-label">Status <span class="text-danger">*</span></label>
            <select name="status" id="create_status" class="form-select" required>
                <option value="active">Aktif</option>
                <option value="inactive">Tidak Aktif</option>
            </select>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-3">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
