@extends('layouts.app')

@section('title', 'Terima Kasih')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="mb-4">
                <i class="lni lni-checkmark-circle text-success" style="font-size: 4.5rem;"></i>
            </div>
            <h2 class="fw-bold text-primary mb-3">Ujian Berhasil Dikirim!</h2>
            <p class="lead mb-4">
                Terima kasih, <strong>{{ session('student_name') ?? 'Siswa' }}</strong>.
            </p>
            <div>
                <a href="{{ route('student.exams.index') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-medium">
                    <i class="lni lni-arrow-left me-1"></i> Lihat Ujian Lain
                </a>
            </div>
        </div>
    </div>
</div>
@endsection