@extends('layouts.app')

@section('title', 'Ujian Tersedia')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">Ujian Tersedia</h2>
    </div>

    @if($exams->isEmpty())
        <div class="text-center py-5">
            <i class="lni lni-files" style="font-size: 2.5rem; opacity: 0.5; color: #adb5bd;"></i>
            <p class="mt-3 mb-0 text-muted">Belum ada ujian yang tersedia untuk Anda.</p>
        </div>
    @else
        <div class="row g-4">
            @foreach($exams as $exam)
                @php
                    $hasSubmitted = session()->has("exam_{$exam->id}_submitted");
                @endphp

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 rounded-3">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold mb-2">
                                <span class="badge bg-primary me-1">{{ $exam->class }}</span>
                                <span class="badge bg-info me-1">{{ $exam->subject }}</span>
                                {{ $exam->title }}
                            </h5>

                            <div class="text-muted small mb-3">
                                <div class="d-flex align-items-center gap-1 mb-1">
                                    <i class="lni lni-timer"></i>
                                    {{ $exam->duration_minutes }} menit
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <i class="lni lni-calendar"></i>
                                    {{ $exam->created_at->format('d M Y H:i') }}
                                </div>
                            </div>

                            <!-- Status Badge -->
                            @if($hasSubmitted)
                                <span class="badge bg-success mb-3">Sudah Dikerjakan</span>
                            @else
                                <span class="badge bg-primary mb-3">Belum Dikerjakan</span>
                            @endif

                            <!-- Action Button -->
                            <div class="mt-auto">
                                @if($hasSubmitted)
                                    <button class="btn btn-success w-100 py-2" disabled>
                                        <i class="lni lni-checkmark-circle me-1"></i> Sudah Dikerjakan
                                    </button>
                                @else
                                    <a href="{{ route('student.exams.take', $exam) }}" 
                                       class="btn btn-primary w-100 py-2">
                                        <i class="lni lni-play me-1"></i> Kerjakan Sekarang
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection