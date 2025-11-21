<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />
    <title>Sign In | {{ config('app.name', 'Laravel') }}</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/lineicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/materialdesignicons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/fullcalendar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
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
            <div class="container-fluid">
                <!-- ========== title-wrapper start ========== -->
                <div class="title-wrapper pt-30">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="title">
                                <h2>Sign In</h2>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-md-6">
                            <div class="breadcrumb-wrapper">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('login') }}">Home</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Sign In
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- ========== title-wrapper end ========== -->

                <div class="row g-0 auth-row">
                    <div class="col-lg-6">
                        <div class="auth-cover-wrapper bg-primary-100">
                            <div class="auth-cover">
                                <div class="title text-center">
                                    <h1 class="text-primary mb-10">Welcome Back</h1>
                                    <p class="text-medium">
                                        Sign in to your existing account to continue
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
                    <div class="col-lg-6">
                        <div class="signin-wrapper">
                            <div class="form-wrapper">
                                <h6 class="mb-15">Sign In Form</h6>
                                <p class="text-sm mb-25">
                                    Enter your credentials to access your account
                                </p>

                                <!-- Display session status if any -->
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

                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="row">
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
                                                    autofocus
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
                                        <div class="col-xxl-6 col-lg-12 col-md-6">
                                            <div class="form-check checkbox-style mb-30">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    id="remember"
                                                    name="remember"
                                                />
                                                <label class="form-check-label" for="remember">
                                                    Remember me next time
                                                </label>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                        <div class="col-xxl-6 col-lg-12 col-md-6">
                                            <div class="text-start text-md-end text-lg-start text-xxl-end mb-30">
                                                @if (Route::has('password.request'))
                                                    <a href="{{ route('password.request') }}" class="hover-underline">
                                                        Forgot Password?
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- end col -->
                                        <div class="col-12">
                                            <div class="button-group d-flex justify-content-center flex-wrap">
                                                <button type="submit" class="main-btn primary-btn btn-hover w-100 text-center">
                                                    Sign In
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                </form>

                                <div class="signin-option pt-40">
                                    <p class="text-sm text-medium text-center text-gray">
                                        Don't have an account yet?
                                    </p>
                                    <div class="pt-20 pb-20 d-flex justify-content-center">
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="hover-underline text-primary">
                                                Create an account
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
        </section>
        <!-- ========== signin-section end ========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->

    <!-- ========= All Javascript files linkup ======== -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
