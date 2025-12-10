<form id="createSubjectForm" action="{{ route('subjects.store') }}" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="create_teacher_id" class="form-label">{{ __('app.teaching_teacher') }} <span class="text-danger">{{ __('app.required_indicator') }}</span></label>
            <select name="teacher_id" id="create_teacher_id" class="form-select" required>
                <option value="">-- {{ __('app.select_teacher') }} --</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label for="create_subject_code" class="form-label">{{ __('app.subject_code') }} <span class="text-danger">{{ __('app.required_indicator') }}</span></label>
            <input type="text" name="subject_code" id="create_subject_code" class="form-control" placeholder="{{ __('app.example') }}: MP-001" required>
        </div>

        <div class="col-md-12 mb-3">
            <label for="create_subject_name" class="form-label">{{ __('app.subject_name') }} <span class="text-danger">{{ __('app.required_indicator') }}</span></label>
            <input type="text" name="subject_name" id="create_subject_name" class="form-control" placeholder="{{ __('app.mathematics') }}, {{ __('app.indonesian_language') }}, dll" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="create_class_level" class="form-label">{{ __('app.class_level') }} <span class="text-danger">{{ __('app.required_indicator') }}</span></label>
            <select name="class_level" id="create_class_level" class="form-select" required>
                <option value="">-- {{ __('app.select_class') }} --</option>
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label for="create_major" class="form-label">{{ __('app.major') }} <span class="text-danger">{{ __('app.required_indicator') }}</span></label>
            <select name="major" id="create_major" class="form-select" required>
                <option value="">-- {{ __('app.select_major') }} --</option>
                @foreach($majors as $major)
                    <option value="{{ $major }}">{{ $major }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mb-3">
            <label for="create_description" class="form-label">{{ __('app.description') }}</label>
            <textarea name="description" id="create_description" class="form-control" rows="3" placeholder="{{ __('app.optional') }}"></textarea>
        </div>

        <div class="col-md-6 mb-3">
            <label for="create_status" class="form-label">{{ __('app.status') }} <span class="text-danger">{{ __('app.required_indicator') }}</span></label>
            <select name="status" id="create_status" class="form-select" required>
                <option value="active">{{ __('app.active') }}</option>
                <option value="inactive">{{ __('app.inactive') }}</option>
            </select>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-3">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('app.cancel') }}</button>
        <button type="submit" class="btn btn-primary">{{ __('app.save') }}</button>
    </div>
</form>
