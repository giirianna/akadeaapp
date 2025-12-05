<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />
    <title>Sign Up | {{ config('app.name', 'Laravel') }}</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/lineicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/materialdesignicons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/fullcalendar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
    <style>
        .main-wrapper {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .signin-section {
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: stretch;
            justify-content: center;
        }
        .signin-section .container-fluid {
            padding-left: 0 !important;
            padding-right: 0 !important;
            max-width: 100%;
            width: 100%;
            display: flex;
            align-items: stretch;
        }
        .auth-row {
            display: flex;
            align-items: stretch;
            width: 100%;
            height: 100%;
        }
        .auth-cover-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .signin-wrapper {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
    </style>
</head>
<body>
    <!-- ======== Preloader =========== -->
    <div id="preloader">
        <div class="spinner"></div>
    </div>
    <!-- ======== Preloader =========== -->

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
        <!-- ========== signin-section start ========== -->
        <section class="signin-section">
            <div class="container-fluid" style="display: flex; flex-direction: column; min-height: 100vh; padding-left: 20px; padding-right: 20px;">
                <div style="flex: 1; display: flex; align-items: center; justify-content: center; width: 100%; padding: 0;">
                    <div class="row g-0 auth-row" style="width: 100%; height: 100%; margin: 0;">
                        <div class="col-lg-5" style="min-width: 0;">
                            <div class="auth-cover-wrapper bg-primary-100">
                                <div class="auth-cover">
                                    <div class="title text-center">
                                        <h1 class="text-primary mb-10">Get Started</h1>
                                        <p class="text-medium">
                                            Create an account to get started
                                            <br class="d-sm-block" />
                                            and join our community.
                                        </p>
                                    </div>
                                    <div class="cover-image">
                                        <img src="{{ asset('assets/images/auth/signin-image.svg') }}" alt="" />
                                    </div>
                                    <div class="shape-image">
                                        <img src="{{ asset('assets/images/auth/shape.svg') }}" alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-lg-5" style="min-width: 0;">
                        <div class="signup-wrapper">
                            <div class="form-wrapper">
                                <h6 class="mb-15">Sign Up Form</h6>
                                <p class="text-sm mb-25">
                                    Fill in your information to create a new account
                                </p>

                                <!-- Display validation errors if any -->
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Error!</strong>
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <form action="{{ route('register') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-style-1">
                                                <label for="name">Name</label>
                                                <input
                                                    id="name"
                                                    type="text"
                                                    name="name"
                                                    placeholder="Enter your full name"
                                                    value="{{ old('name') }}"
                                                    required
                                                    autofocus
                                                />
                                                @error('name')
                                                    <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- end col -->
                                        <div class="col-12">
                                            <div class="input-style-1">
                                                <label for="email">Email</label>
                                                <input
                                                    id="email"
                                                    type="email"
                                                    name="email"
                                                    placeholder="Enter your email"
                                                    value="{{ old('email') }}"
                                                    required
                                                />
                                                @error('email')
                                                    <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- end col -->
                                        <div class="col-12">
                                            <div class="input-style-1">
                                                <label for="password">Password</label>
                                                <input
                                                    id="password"
                                                    type="password"
                                                    name="password"
                                                    placeholder="Enter your password"
                                                    required
                                                />
                                                @error('password')
                                                    <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- end col -->
                                        <div class="col-12">
                                            <div class="input-style-1">
                                                <label for="password_confirmation">Confirm Password</label>
                                                <input
                                                    id="password_confirmation"
                                                    type="password"
                                                    name="password_confirmation"
                                                    placeholder="Confirm your password"
                                                    required
                                                />
                                                @error('password_confirmation')
                                                    <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- end col -->
                                        <div class="col-12">
                                            <div class="form-check checkbox-style mb-30">
                                                <input class="form-check-input" type="checkbox" id="terms" name="terms" required />
                                                <label class="form-check-label" for="terms">
                                                    I agree to the <a href="#">Terms & Conditions</a>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                        <div class="col-12">
                                            <div class="button-group d-flex justify-content-center flex-wrap">
                                                <button type="submit" class="main-btn primary-btn btn-hover w-100 text-center">
                                                    Sign Up
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                </form>

                                <div class="singup-option pt-40">
                                    <p class="text-sm text-medium text-center text-gray">
                                        Already have an account?
                                    </p>
                                    <div class="pt-20 pb-20 d-flex justify-content-center">
                                        @if (Route::has('login'))
                                            <a href="{{ route('login') }}" class="hover-underline text-primary">
                                                Sign In here
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
                </div>
            </div>
        </section>
        <!-- ========== signin-section end ========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->

    <!-- ========= All Javascript files linkup ======== -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
