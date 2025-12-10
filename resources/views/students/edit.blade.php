@extends('layouts.app')

@section('title', __('app.edit_student'))

@section('content')
    <!-- ========== tab components start ========== -->
    <section class="tab-components">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ __('app.edit_student') }}</h2>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('students.index') }}">{{ __('app.students') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __('app.edit_student') }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== title-wrapper end ========== -->

            <!-- ========== form-elements-wrapper start ========== -->
            <div class="form-elements-wrapper">
                <div class="row">
                    <div class="col-lg-8">
                        <form action="{{ route('students.update', $student) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Student Name -->
                            <div class="card-style mb-30">
                                <div class="input-style-1">
                                    <label for="name">{{ __('app.student_name') }}</label>
                                    <input type="text" name="name" id="name" placeholder="{{ __('app.enter_student_name') }}"
                                        value="{{ $student->name }}" required />
                                    @error('name')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- NIS -->
                            <div class="card-style mb-30">
                                <div class="input-style-1">
                                    <label for="nis">{{ __('app.nis') }}</label>
                                    <input type="text" name="nis" id="nis" placeholder="{{ __('app.enter_nis') }}"
                                        value="{{ $student->nis }}" required />
                                    @error('nis')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Class -->
                            <div class="card-style mb-30">
                                <div class="input-style-1">
                                    <label for="class">{{ __('app.class') }}</label>
                                    <input type="text" name="class" id="class" placeholder="{{ __('app.enter_class') }}"
                                        value="{{ $student->class }}" required />
                                    @error('class')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Major -->
                            <div class="card-style mb-30">
                                <div class="input-style-1">
                                    <label for="major">{{ __('app.major') }}</label>
                                    <input type="text" name="major" id="major" placeholder="{{ __('app.enter_major') }}"
                                        value="{{ $student->major }}" />
                                    @error('major')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Birth Date -->
                            <div class="card-style mb-30">
                                <div class="input-style-1">
                                    <label for="birth_date">{{ __('app.birth_date') }}</label>
                                    <input type="date" name="birth_date" id="birth_date"
                                        value="{{ $student->birth_date ? $student->birth_date->format('Y-m-d') : '' }}" />
                                    @error('birth_date')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Address -->
                            <div class="card-style mb-30">
                                <label for="address">{{ __('app.address') }}</label>
                                <textarea name="address" id="address" class="form-control" rows="4"
                                    placeholder="{{ __('app.enter_address') }}">{{ $student->address }}</textarea>
                                @error('address')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- end card -->

                            <!-- Buttons -->
                            <div class="card-style mb-30">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="icon"><i class="lni lni-save"></i></span> {{ __('app.update') }}
                                    </button>
                                    <a href="{{ route('students.index') }}" class="btn btn-secondary">
                                        <span class="icon"><i class="lni lni-arrow-left"></i></span> {{ __('app.back') }}
                                    </a>
                                </div>
                            </div>
                            <!-- end card -->
                        </form>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== form-elements-wrapper end ========== -->
        </div>
        <!-- end container-fluid -->
    </section>
    <!-- ========== tab components end ========== -->
@endsection