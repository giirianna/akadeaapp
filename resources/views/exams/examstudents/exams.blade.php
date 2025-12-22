@extends('layouts.app')

@section('title', 'Ujian Tersedia')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary fw-bold">Ujian Tersedia</h2>
            @if($studentName)
                <span class="badge bg-info fs-6">
                    <i class="lni lni-user me-1"></i> {{ $studentName }}
                </span>
            @endif
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
                        $hasQuestions = $exam->questions->count() > 0;
                        
                        // Get the student's submission for this exam (if exists)
                        $submission = null;
                        if ($studentName) {
                            $submission = $exam->submissions->where('student_name', $studentName)->first();
                        }
                        
                        $hasSubmitted = $submission !== null;
                        
                        // Get score data if submitted
                        $totalScore = $submission ? $submission->total_score : null;
                        $isScored = $submission ? $submission->is_scored : false;
                        $essayScores = $submission ? ($submission->essay_scores ?? []) : [];
                        
                        // Count essay questions
                        $essayCount = $exam->questions->where('type', 'essay')->count();
                        $essayGraded = count($essayScores);
                    @endphp

                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 rounded-3 {{ $hasSubmitted ? 'border-success' : '' }}">
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
                                        <i class="lni lni-list"></i>
                                        {{ $exam->questions->count() }} soal
                                    </div>
                                </div>

                                {{-- Score Display for Submitted Exams --}}
                                @if($hasSubmitted)
                                    <div class="score-card mb-3 p-3 bg-light rounded-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted small">Nilai Anda:</span>
                                            @if($isScored || $essayCount === 0)
                                                <span class="badge bg-success">
                                                    <i class="lni lni-checkmark-circle me-1"></i> Final
                                                </span>
                                            @else
                                                <span class="badge bg-warning text-dark">
                                                    <i class="lni lni-timer me-1"></i> {{ $essayGraded }}/{{ $essayCount }} Essay Dinilai
                                                </span>
                                            @endif
                                        </div>
                                        
                                        {{-- Score Display --}}
                                        <div class="d-flex align-items-baseline">
                                            <span class="fs-2 fw-bold text-primary">{{ number_format($totalScore ?? 0, 1) }}</span>
                                            <span class="text-muted ms-1">/100</span>
                                        </div>
                                        
                                        {{-- Progress Bar --}}
                                        <div class="progress mt-2" style="height: 6px;">
                                            <div class="progress-bar {{ ($totalScore ?? 0) >= 70 ? 'bg-success' : (($totalScore ?? 0) >= 50 ? 'bg-warning' : 'bg-danger') }}" 
                                                 role="progressbar" 
                                                 style="width: {{ $totalScore ?? 0 }}%">
                                            </div>
                                        </div>

                                        {{-- Pending Essay Notice --}}
                                        @if($essayCount > 0 && !$isScored)
                                            <small class="text-muted d-block mt-2">
                                                <i class="lni lni-information-triangle me-1"></i>
                                                Menunggu penilaian guru untuk {{ $essayCount - $essayGraded }} essay
                                            </small>
                                        @endif
                                    </div>
                                @endif

                                {{-- Status Badge --}}
                                @if(!$hasQuestions)
                                    <span class="badge bg-warning text-dark mb-3">Belum Siap (Soal Belum Ditambah)</span>
                                @elseif($hasSubmitted)
                                    <span class="badge bg-success mb-3">
                                        <i class="lni lni-checkmark-circle me-1"></i> Sudah Dikerjakan
                                    </span>
                                @else
                                    <span class="badge bg-primary mb-3">Belum Dikerjakan</span>
                                @endif

                                {{-- Action Button --}}
                                <div class="mt-auto">
                                    @if(!$hasQuestions)
                                        <button class="btn btn-secondary w-100 py-2" disabled>
                                            <i class="lni lni-info-circle me-1"></i> Soal Belum Tersedia
                                        </button>
                                    @elseif($hasSubmitted)
                                        <button class="btn btn-outline-success w-100 py-2" disabled>
                                            <i class="lni lni-checkmark-circle me-1"></i> Selesai
                                        </button>
                                    @else
                                        <a href="{{ route('student.exams.take', $exam) }}" class="btn btn-primary w-100 py-2">
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

    <style>
    .score-card {
        border-left: 4px solid #0d6efd;
    }
    .progress {
        border-radius: 10px;
        background-color: #e9ecef;
    }
    .progress-bar {
        border-radius: 10px;
    }
    .card.border-success {
        border-left: 4px solid #198754 !important;
    }
    </style>
@endsection