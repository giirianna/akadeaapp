<form id="createSubjectForm" action="{{ route('subjects.store') }}" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="create_subject_code" class="form-label">{{ __('app.subject_code') }} <span class="text-danger">{{ __('app.required_indicator') }}</span></label>
            <input type="text" name="subject_code" id="create_subject_code" class="form-control" placeholder="{{ __('app.example') }}: MP-001" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="create_status" class="form-label">{{ __('app.status') }} <span class="text-danger">{{ __('app.required_indicator') }}</span></label>
            <select name="status" id="create_status" class="form-select" required>
                <option value="active">{{ __('app.active') }}</option>
                <option value="inactive">{{ __('app.inactive') }}</option>
            </select>
        </div>

        <div class="col-md-12 mb-3">
            <label for="create_subject_name" class="form-label">{{ __('app.subject_name') }} <span class="text-danger">{{ __('app.required_indicator') }}</span></label>
            <input type="text" name="subject_name" id="create_subject_name" class="form-control" placeholder="{{ __('app.mathematics') }}, {{ __('app.indonesian_language') }}, dll" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('app.class_level') }} <span class="text-danger">{{ __('app.required_indicator') }}</span></label>
            <div class="multiselect-dropdown">
                <button type="button" class="form-select text-start multiselect-btn" id="classLevelDropdownBtn" data-bs-toggle="dropdown" aria-expanded="false">
                    -- {{ __('app.select_class') }} --
                </button>
                <ul class="dropdown-menu p-2 w-100" id="classLevelDropdown">
                    @foreach($classLevels as $level)
                    <li>
                        <label class="dropdown-item d-flex align-items-center gap-2 rounded">
                            <input type="checkbox" name="class_level[]" value="{{ $level }}" class="form-check-input m-0 class-level-checkbox">
                            <span>Kelas {{ $level }}</span>
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>
            <small class="text-muted">Pilih satu atau lebih kelas</small>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('app.major') }} <span class="text-danger">{{ __('app.required_indicator') }}</span></label>
            <div class="multiselect-dropdown">
                <button type="button" class="form-select text-start multiselect-btn" id="majorDropdownBtn" data-bs-toggle="dropdown" aria-expanded="false">
                    -- {{ __('app.select_major') }} --
                </button>
                <ul class="dropdown-menu p-2 w-100" id="majorDropdown">
                    @foreach($majors as $major)
                    <li>
                        <label class="dropdown-item d-flex align-items-center gap-2 rounded">
                            <input type="checkbox" name="major[]" value="{{ $major }}" class="form-check-input m-0 major-checkbox">
                            <span>{{ $major }}</span>
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>
            <small class="text-muted">Pilih satu atau lebih jurusan</small>
        </div>

        <div class="col-md-12 mb-3">
            <label for="create_description" class="form-label">{{ __('app.description') }}</label>
            <textarea name="description" id="create_description" class="form-control" rows="3" placeholder="{{ __('app.optional') }}"></textarea>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-3">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('app.cancel') }}</button>
        <button type="submit" class="btn btn-primary">{{ __('app.save') }}</button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update button text when checkboxes change
    function updateMultiselectButton(checkboxSelector, buttonId, defaultText) {
        const checkboxes = document.querySelectorAll(checkboxSelector);
        const button = document.getElementById(buttonId);
        
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
