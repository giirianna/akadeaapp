@extends('layouts.app')

@section('title', __('app.add_student'))

@section('content')
    <!-- ========== tab components start ========== -->
    <section class="tab-components">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ __('app.add_student') }}</h2>
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
                                    <li class="breadcrumb-item"><a href="{{ route('students.index') }}">{{ __('app.students') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __('app.add_student') }}</li>
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
                        <form action="{{ route('students.store') }}" method="POST">
                            @csrf

                            <!-- Student Name -->
                            <div class="card-style mb-30">
                                <div class="input-style-1">
                                    <label for="name">{{ __('app.student_name') }}</label>
                                    <input type="text" name="name" id="name" placeholder="{{ __('app.enter_student_name') }}"
                                        value="{{ old('name') }}" required />
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
                                        value="{{ old('nis') }}" required />
                                    @error('nis')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Class -->
                            <div class="card-style mb-30">
                                <div class="input-style-1">
                                    <label for="class">{{ __('app.class') }} <span class="text-danger">*</span></label>
                                    <select name="class" id="class" class="form-control" required>
                                        <option value="">{{ __('app.select_class') }}</option>
                                        @foreach($classLevels as $level)
                                            <option value="{{ $level }}" {{ old('class') == $level ? 'selected' : '' }}>Kelas {{ $level }}</option>
                                        @endforeach
                                    </select>
                                    @error('class')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Major -->
                            <div class="card-style mb-30">
                                <div class="input-style-1">
                                    <label for="major_id">{{ __('app.major') }}</label>
                                    <select name="major_id" id="major_id" class="form-control">
                                        <option value="">{{ __('app.select_major') }}</option>
                                        @foreach($majors as $major)
                                            <option value="{{ $major->id }}" {{ old('major_id') == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('major_id')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Enrollment Date -->
                            <div class="card-style mb-30">
                                <div class="input-style-1">
                                    <label for="enrollment_date">{{ __('app.enrollment_date') }} <span class="text-danger">*</span></label>
                                    <input type="date" name="enrollment_date" id="enrollment_date" value="{{ old('enrollment_date') }}" required />
                                    @error('enrollment_date')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end card -->

                            <!-- Birth Date -->
                            <div class="card-style mb-30">
                                <div class="input-style-1">
                                    <label for="birth_date">{{ __('app.birth_date') }}</label>
                                    <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" />
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
                                    placeholder="{{ __('app.enter_address') }}">{{ old('address') }}</textarea>
                                @error('address')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- end card -->

                            <!-- Buttons -->
                            <div class="card-style mb-30">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="icon"><i class="lni lni-save"></i></span> {{ __('app.save') }}
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
