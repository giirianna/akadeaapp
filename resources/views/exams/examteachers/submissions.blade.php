@extends('layouts.app')

@section('title', "Hasil Ujian: {$exam->title}")

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-primary fw-bold">Hasil Ujian</h2>
            <h5 class="mb-0 text-muted">{{ $exam->title }}</h5>
        </div>
        <a href="{{ route('exams.index') }}" class="btn btn-secondary px-4 py-2 rounded-pill">
            <i class="lni lni-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <p class="mb-0"><strong>Total Pengumpulan:</strong> {{ $exam->submissions->count() }}</p>
    </div>

    @if($exam->submissions->isEmpty())
        <div class="text-center py-5">
            <i class="lni lni-files" style="font-size: 2.5rem; opacity: 0.5; color: #adb5bd;"></i>
            <p class="mt-3 mb-0 text-muted">Belum ada siswa yang mengumpulkan ujian.</p>
        </div>
    @else
        @foreach($exam->submissions as $submission)
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center bg-light py-2 px-3">
                    <strong class="fs-6">{{ $submission->student_name }}</strong>
                    <small class="text-muted">
                        {{ $submission->submitted_at->format('d M Y H:i') }}
                    </small>
                </div>
                <div class="card-body">
                    @php
                        $answers = $submission->answers; // Sudah array karena casting
                    @endphp

                    @foreach($exam->questions as $question)
                        <div class="mb-4 pb-3 border-bottom border-light">
                            <div class="d-flex">
                                <span class="badge bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center"
                                      style="width: 24px; height: 24px; font-size: 0.8rem;">
                                    {{ $loop->iteration }}
                                </span>
                                <div class="flex-grow-1">
                                    <p class="mb-2 fw-medium">{{ $question->question_text }}</p>

                                    @if($question->image)
                                        <div class="my-2">
                                            <img src="{{ Storage::url($question->image) }}" alt="Gambar soal"
                                                 class="img-fluid rounded border" style="max-height: 180px; object-fit: contain;">
                                        </div>
                                    @endif

                                    @php
                                        $studentAnswer = $answers[$question->id] ?? null;
                                        $correctAnswerRaw = $question->correct_answer; // Selalu array karena casting
                                        $isCorrect = null;

                                        if ($question->type === 'essay') {
                                            $isCorrect = null;
                                        } elseif ($question->type === 'checkbox') {
                                            // Checkbox: bandingkan array indeks
                                            $normalizeArray = function ($arr) {
                                                if (!is_array($arr)) return [];
                                                return array_map('intval', array_values(array_unique($arr)));
                                            };
                                            $studentNorm = $normalizeArray(is_array($studentAnswer) ? $studentAnswer : [$studentAnswer]);
                                            $correctNorm = $normalizeArray($correctAnswerRaw);
                                            sort($studentNorm);
                                            sort($correctNorm);
                                            $isCorrect = ($studentNorm === $correctNorm);
                                        } else {
                                            // multiple_choice & dropdown: konversi teks ke indeks
                                            $studentIndex = null;
                                            $correctIndex = null;

                                            // Cari indeks dari teks jawaban siswa
                                            if (is_string($studentAnswer) && is_array($question->options)) {
                                                $studentIndex = array_search($studentAnswer, $question->options);
                                            } elseif (is_numeric($studentAnswer)) {
                                                $studentIndex = (int) $studentAnswer;
                                            }

                                            // Ambil indeks dari correct_answer
                                            if (is_array($correctAnswerRaw) && count($correctAnswerRaw) > 0) {
                                                $correctIndex = (int) $correctAnswerRaw[0];
                                            }

                                            $isCorrect = ($studentIndex !== null && $correctIndex !== null) && ($studentIndex === $correctIndex);
                                        }
                                    @endphp

                                    <!-- Jawaban Siswa -->
                                    <div class="mt-2">
                                        <small class="text-muted d-block">Jawaban Siswa:</small>
                                        @if($question->type === 'essay')
                                            <div class="p-2 bg-light rounded">
                                                <span class="text-break">{{ $studentAnswer ?? '-' }}</span>
                                            </div>
                                        @elseif(in_array($question->type, ['multiple_choice', 'dropdown']))
                                            <div class="p-2 bg-light rounded">
                                                @if(is_numeric($studentAnswer) && isset($question->options[$studentAnswer]))
                                                    {{ $question->options[$studentAnswer] }}
                                                @else
                                                    {{ $studentAnswer ?? '-' }}
                                                @endif
                                            </div>
                                        @elseif($question->type === 'checkbox')
                                            <ul class="list-unstyled mb-0">
                                                @foreach($question->options as $idx => $option)
                                                    <li class="d-flex align-items-start mb-1">
                                                        <input type="checkbox" disabled
                                                            {{ is_array($studentAnswer) && in_array($idx, $studentAnswer) ? 'checked' : (is_scalar($studentAnswer) && $studentAnswer == $idx ? 'checked' : '') }}
                                                            class="me-2 mt-1">
                                                        <span>{{ $option }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>

                                    <!-- Penanda Benar/Salah -->
                                    @if($isCorrect !== null)
                                        <div class="mt-2">
                                            @if($isCorrect)
                                                <span class="badge bg-success">
                                                    <i class="lni lni-checkmark-circle me-1"></i> Benar
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="lni lni-cross-circle me-1"></i> Salah
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection