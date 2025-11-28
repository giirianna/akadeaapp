<section>
    <div class="section-header mb-30">
        <h3 class="mb-10">{{ __('Update Password') }}</h3>
        <p class="text-sm">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
    </div>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <!-- Current Password Field -->
        <div class="input-style-1 mb-20">
            <label for="update_password_current_password">{{ __('Current Password') }}</label>
            <input type="password" id="update_password_current_password" name="current_password"
                autocomplete="current-password" />
            @error('currentPassword', 'updatePassword')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>
        <!-- end input -->

        <!-- New Password Field -->
        <div class="input-style-1 mb-20">
            <label for="update_password_password">{{ __('New Password') }}</label>
            <input type="password" id="update_password_password" name="password" autocomplete="new-password" />
            @error('password', 'updatePassword')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>
        <!-- end input -->

        <!-- Confirm Password Field -->
        <div class="input-style-1 mb-20">
            <label for="update_password_password_confirmation">{{ __('Confirm Password') }}</label>
            <input type="password" id="update_password_password_confirmation" name="password_confirmation"
                autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>
        <!-- end input -->

        <div class="d-flex gap-2 align-items-center mt-30">
            <button type="submit" class="btn btn-primary">
                <span class="icon"><i class="lni lni-save"></i></span> {{ __('Save') }}
            </button>
            @if (session('status') === 'password-updated')
                <p class="text-sm text-success mb-0" id="password-status">
                    {{ __('Saved.') }}
                </p>
                <script>
                    setTimeout(() => {
                        const el = document.getElementById('password-status');
                        if (el) el.style.display = 'none';
                    }, 2000);
                </script>
            @endif
        </div>
    </form>
</section>