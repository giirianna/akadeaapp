@extends('layouts.app')

@section('title', 'Hasil Ujian')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            {{-- Success Header --}}
            <div class="text-center mb-4">
                <div class="mb-3">
                    <i class="lni lni-checkmark-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <h2 class="fw-bold text-primary mb-2">Ujian Berhasil Dikirim!</h2>
                <p class="lead mb-0">
                    Terima kasih, <strong>{{ session('student_name') ?? 'Siswa' }}</strong>.
                </p>
            </div>

            {{-- Score Card --}}
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-body p-4">
                    {{-- Score Display --}}
                    <div class="text-center mb-4">
                        <h5 class="text-muted mb-3">Nilai Anda</h5>
                        <div class="score-circle mx-auto mb-3">
                            <span class="score-value">{{ number_format($scoreData['total_score'], 1) }}</span>
                            <span class="score-max">/100</span>
                        </div>
                        
                        {{-- Progress Bar --}}
                        <div class="progress mb-3" style="height: 10px;">
                            <div class="progress-bar bg-success" 
                                 role="progressbar" 
                                 style="width: {{ $scoreData['total_score'] }}%"
                                 aria-valuenow="{{ $scoreData['total_score'] }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                    </div>

                    {{-- Score Breakdown --}}
                    <div class="border-top pt-3">
                        <h6 class="text-muted mb-3">
                            <i class="lni lni-list me-1"></i> Rincian Nilai
                        </h6>
                        
                        <div class="row g-3">
                            {{-- Auto-scored Questions --}}
                            @if($scoreData['auto_scored_total'] > 0)
                                <div class="col-6">
                                    <div class="p-3 bg-light rounded text-center">
                                        <div class="text-success fw-bold fs-4">
                                            {{ $scoreData['auto_scored_correct'] }}/{{ $scoreData['auto_scored_total'] }}
                                        </div>
                                        <small class="text-muted">Jawaban Benar</small>
                                    </div>
                                </div>
                            @endif

                            {{-- Essay Questions Pending --}}
                            @if($scoreData['essay_count'] > 0)
                                <div class="col-6">
                                    <div class="p-3 bg-warning bg-opacity-10 rounded text-center">
                                        <div class="text-warning fw-bold fs-4">
                                            {{ $scoreData['essay_count'] }}
                                        </div>
                                        <small class="text-muted">Essay (Menunggu Dinilai)</small>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Essay Pending Notice --}}
                        @if($scoreData['essay_count'] > 0)
                            <div class="alert alert-info mt-3 mb-0">
                                <i class="lni lni-information-triangle me-2"></i>
                                <strong>Catatan:</strong> Nilai di atas belum termasuk {{ $scoreData['essay_count'] }} soal essay. 
                                Nilai akhir akan diperbarui setelah guru menilai jawaban essay Anda.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Exam Info --}}
            <div class="card border-0 bg-light mb-4">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <small class="text-muted d-block">Ujian</small>
                            <strong>{{ $exam->title }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Total Soal</small>
                            <strong>{{ $exam->questions->count() }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Back Button --}}
            <div class="text-center">
                <a href="{{ route('student.exams.index') }}" class="btn btn-primary px-5 py-2 rounded-pill fw-medium">
                    <i class="lni lni-arrow-left me-1"></i> Kembali ke Daftar Ujian
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.score-circle {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
}

.score-value {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1;
}

.score-max {
    font-size: 1rem;
    opacity: 0.8;
}

.card {
    border-radius: 16px;
}

.progress {
    border-radius: 10px;
    background-color: #e9ecef;
}

.progress-bar {
    border-radius: 10px;
}
</style>
@endsection