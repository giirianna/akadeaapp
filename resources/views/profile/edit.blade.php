@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
    <!-- ========== profile-wrapper start ========== -->
    <section class="profile-wrapper">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Profil Pengguna</h2>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Profil</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== title-wrapper end ========== -->

            <!-- ========== profile-content start ========== -->
            <div class="profile-content">
                <div class="row">
                    <!-- Update Profile Information -->
                    <div class="col-lg-8">
                        <div class="card-style mb-30">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                        <!-- end card -->

                        <!-- Update Password -->
                        <div class="card-style mb-30">
                            @include('profile.partials.update-password-form')
                        </div>
                        <!-- end card -->

                        <!-- Delete Account -->
                        <div class="card-style">
                            @include('profile.partials.delete-user-form')
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== profile-content end ========== -->
        </div>
        <!-- end container-fluid -->
    </section>
    <!-- ========== profile-wrapper end ========== -->
@endsection