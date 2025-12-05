<form id="editRoleForm" action="{{ route('roles.update', $user) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="mb-3">
        <label class="form-label"><strong>User:</strong></label>
        <p class="mb-0">{{ $user->name }}</p>
        <p class="text-muted small">{{ $user->email }}</p>
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Assign Role <span class="text-danger">*</span></label>
        <select name="role" id="role" class="form-select" required>
            <option value="">-- Select Role --</option>
            @foreach($roles as $role)
                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                </option>
            @endforeach
        </select>
        @error('role')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex justify-content-end gap-2 mt-3">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </div>
</form>
