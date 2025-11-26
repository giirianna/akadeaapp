<section>
    <div class="section-header mb-30">
        <h3 class="mb-10">{{ __('Profile Information') }}</h3>
        <p class="text-sm">{{ __('Update your account profile information and email address.') }}</p>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}" style="display: none;">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <!-- Name Field -->
        <div class="input-style-1 mb-20">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus
                autocomplete="name" />
            @error('name')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>
        <!-- end input -->

        <!-- Email Field -->
        <div class="input-style-1 mb-20">
            <label for="email">{{ __('Email') }}</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                autocomplete="username" />
            @error('email')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>
        <!-- end input -->

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div class="alert alert-info mb-20" role="alert">
                <div class="d-flex align-items-center">
                    <i class="lni lni-info-circle me-2"></i>
                    <div>
                        <p class="mb-0">{{ __('Your email address is unverified.') }}</p>
                        <button form="send-verification" class="btn btn-link p-0 text-decoration-underline mt-2">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </div>
                </div>
            </div>
            @if (session('status') === 'verification-link-sent')
                <div class="alert alert-success mb-20" role="alert">
                    {{ __('A new verification link has been sent to your email address.') }}
                </div>
            @endif
        @endif

        <div class="d-flex gap-2 align-items-center mt-30">
            <button type="submit" class="btn btn-primary">
                <span class="icon"><i class="lni lni-save"></i></span> {{ __('Save') }}
            </button>
            @if (session('status') === 'profile-updated')
                <p class="text-sm text-success mb-0" id="save-status">
                    {{ __('Saved.') }}
                </p>
                <script>
                    setTimeout(() => {
                        const el = document.getElementById('save-status');
                        if (el) el.style.display = 'none';
                    }, 2000);
                </script>
            @endif
        </div>
    </form>
</section>