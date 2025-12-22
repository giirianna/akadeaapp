<form id="editSubjectForm" action="{{ route('subjects.update', $subject) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="subject_code" class="form-label">{{ __('app.subject_code') }} <span
                    class="text-danger">{{ __('app.required_indicator') }}</span></label>
            <input type="text" name="subject_code" id="subject_code" class="form-control"
                value="{{ old('subject_code', $subject->subject_code) }}" required>
            @error('subject_code')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="status" class="form-label">{{ __('app.status') }} <span
                    class="text-danger">{{ __('app.required_indicator') }}</span></label>
            <select name="status" id="status" class="form-select" required>
                <option value="active" {{ old('status', $subject->status) == 'active' ? 'selected' : '' }}>
                    {{ __('app.active') }}</option>
                <option value="inactive" {{ old('status', $subject->status) == 'inactive' ? 'selected' : '' }}>
                    {{ __('app.inactive') }}</option>
            </select>
            @error('status')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-12 mb-3">
            <label for="subject_name" class="form-label">{{ __('app.subject_name') }} <span
                    class="text-danger">{{ __('app.required_indicator') }}</span></label>
            <input type="text" name="subject_name" id="subject_name" class="form-control"
                value="{{ old('subject_name', $subject->subject_name) }}" required>
            @error('subject_name')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="class_level" class="form-label">{{ __('app.class_level') }} <span
                    class="text-danger">{{ __('app.required_indicator') }}</span></label>
            <select name="class_level" id="class_level" class="form-select" required>
                <option value="">-- {{ __('app.select_class') }} --</option>
                @foreach($classLevels as $level)
                    <option value="{{ $level }}" {{ old('class_level', $subject->class_level) == $level ? 'selected' : '' }}>
                        Kelas {{ $level }}</option>
                @endforeach
            </select>
            @error('class_level')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="major_id" class="form-label">{{ __('app.major') }} <span
                    class="text-danger">{{ __('app.required_indicator') }}</span></label>
            <select name="major_id" id="major_id" class="form-select" required>
                <option value="">-- {{ __('app.select_major') }} --</option>
                @foreach($majors as $major)
                    <option value="{{ $major->id }}" {{ old('major_id', $subject->major_id) == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                @endforeach
            </select>
            @error('major_id')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-12 mb-3">
            <label for="description" class="form-label">{{ __('app.description') }}</label>
            <textarea name="description" id="description" class="form-control"
                rows="3">{{ old('description', $subject->description) }}</textarea>
            @error('description')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-3">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('app.cancel') }}</button>
        <button type="submit" class="btn btn-primary">{{ __('app.update') }}</button>
    </div>
</form>