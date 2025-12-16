@extends('layouts.app')

@section('title', 'Detail Ujian')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">Detail Ujian</h2>
        <a href="{{ route('exams.index') }}" class="btn btn-secondary px-4 py-2 rounded-pill">
            <i class="lni lni-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <!-- Info Ujian -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body">
            <h5 class="card-title fw-bold fs-4 mb-2">{{ $exam->title }}</h5>
            <p class="text-muted mb-3">
                {{ $exam->description ?? 'Tidak ada deskripsi.' }}
            </p>
            <div class="row g-3">
                <div class="col-md-4">
                    <small class="text-muted d-block">Durasi</small>
                    <strong>{{ $exam->duration_minutes }} menit</strong>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block">Waktu Mulai</small>
                    <strong>{{ $exam->start_time->format('d M Y H:i') }}</strong>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block">Waktu Berakhir</small>
                    <strong>{{ $exam->end_time->format('d M Y H:i') }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Soal -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light py-3">
            <h6 class="mb-0 fw-medium">Daftar Soal ({{ $exam->questions->count() }})</h6>
        </div>
        <div class="card-body">
            @if($exam->questions->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="lni lni-files" style="font-size: 2rem; opacity: 0.5;"></i>
                    <p class="mt-2 mb-0">Belum ada soal dalam ujian ini.</p>
                </div>
            @else
                @foreach ($exam->questions as $index => $q)
                    <div class="mb-4 pb-4 border-bottom border-light">
                        <div class="d-flex">
                            <div class="me-3 mt-1">
                                <span class="badge bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.85rem;">
                                    {{ $index + 1 }}
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <!-- Teks Soal -->
                                <div class="mb-2">{!! nl2br(e($q->question_text)) !!}</div>

                                <!-- Gambar Soal (jika ada) -->
                                @if($q->image)
                                    <div class="my-2">
                                        <img src="{{ asset('storage/' . $q->image) }}" 
                                             alt="Gambar soal {{ $index + 1 }}"
                                             class="img-fluid rounded border" 
                                             style="max-height: 200px; object-fit: contain;"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';">
                                        <small class="text-warning" style="display: none;">Gambar tidak dapat dimuat</small>
                                    </div>
                                @endif

                                <!-- Tipe Soal -->
                                <small class="text-muted d-block mb-2">
                                    Tipe: {{ ucfirst(str_replace('_', ' ', $q->type)) }}
                                </small>

                                <!-- Opsi (jika ada) -->
                                @if($q->options && in_array($q->type, ['multiple_choice', 'checkbox', 'dropdown']))
                                    <div class="mt-1">
                                        @foreach($q->options as $opt)
                                            <div class="d-flex align-items-start mb-1">
                                                <span class="me-2">•</span>
                                                <span>{{ $opt }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Jawaban Benar (opsional untuk admin) -->
                                @if(!empty($q->correct_answer))
                                    <div class="mt-2">
                                        <small class="text-success">
                                            <strong>Jawaban benar:</strong>
                                            @if(is_array($q->correct_answer))
                                                {{ implode(', ', array_map(fn($i) => $q->options[$i] ?? "Opsi $i", $q->correct_answer)) }}
                                            @else
                                                {{ $q->options[$q->correct_answer] ?? "Opsi $q->correct_answer" }}
                                            @endif
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection