<section>
    <div class="section-header mb-30">
        <h3 class="mb-10 text-danger">{{ __('Delete Account') }}</h3>
        <p class="text-sm">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </div>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletion">
        <span class="icon"><i class="lni lni-trash-can"></i></span> {{ __('Delete Account') }}
    </button>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="confirmUserDeletion" tabindex="-1" aria-labelledby="confirmUserDeletionLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmUserDeletionLabel">{{ __('Delete Account') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <div class="alert alert-danger" role="alert">
                            <h6 class="alert-heading mb-10">{{ __('Are you sure you want to delete your account?') }}
                            </h6>
                            <p class="mb-0">
                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                            </p>
                        </div>

                        <div class="input-style-1 mt-20">
                            <label for="password">{{ __('Password') }}</label>
                            <input type="password" id="password" name="password"
                                placeholder="{{ __('Enter your password') }}" />
                            @error('password', 'userDeletion')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-danger">
                            <span class="icon"><i class="lni lni-trash-can"></i></span> {{ __('Delete Account') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>