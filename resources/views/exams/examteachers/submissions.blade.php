@extends('layouts.app')

@section('title', "Hasil Ujian: {$exam->title}")

@section('content')
<div class="submissions-page">
    {{-- Header Section --}}
    <div class="page-header">
        <div class="container">
            <div class="header-content">
                <div class="header-left">
                    <a href="{{ route('exams.index') }}" class="back-link">
                        <i class="lni lni-arrow-left"></i>
                    </a>
                    <div class="header-info">
                        <h1 class="page-title">Hasil Ujian</h1>
                        <p class="exam-title">{{ $exam->title }}</p>
                    </div>
                </div>
                <div class="header-right">
                    <div class="exam-badges">
                        <span class="badge badge-class">{{ $exam->class }}</span>
                        <span class="badge badge-subject">{{ $exam->subject }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-4">
        {{-- Stats Cards --}}
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon bg-primary-soft">
                    <i class="lni lni-list"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-value">{{ $exam->questions->count() }}</span>
                    <span class="stat-label">Total Soal</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-success-soft">
                    <i class="lni lni-users"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-value">{{ $exam->submissions->count() }}</span>
                    <span class="stat-label">Pengumpulan</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-warning-soft">
                    <i class="lni lni-star"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-value">100</span>
                    <span class="stat-label">Skor Maksimal</span>
                </div>
            </div>
        </div>

        @if($exam->submissions->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="lni lni-files"></i>
                </div>
                <h3>Belum Ada Pengumpulan</h3>
                <p>Siswa belum mengumpulkan jawaban untuk ujian ini.</p>
            </div>
        @else
            @php
                $totalQuestions = $exam->questions->count();
                $pointsPerQuestion = $totalQuestions > 0 ? 100 / $totalQuestions : 0;
            @endphp

            <div class="submissions-list">
                @foreach($exam->submissions as $submission)
                    @php
                        $essayScores = $submission->essay_scores ?? [];
                        $currentScore = $submission->total_score ?? 0;
                        $essayQuestionCount = $exam->questions->where('type', 'essay')->count();
                        $scoredEssayCount = count($essayScores);
                        $answers = $submission->answers;
                    @endphp

                    <div class="submission-card" id="submission-{{ $submission->id }}">
                        {{-- Submission Header --}}
                        <div class="submission-header">
                            <div class="student-info">
                                <div class="student-avatar">
                                    {{ strtoupper(substr($submission->student_name, 0, 1)) }}
                                </div>
                                <div class="student-details">
                                    <h3 class="student-name">{{ $submission->student_name }}</h3>
                                    <span class="submit-time">
                                        <i class="lni lni-calendar"></i>
                                        {{ $submission->submitted_at->format('d M Y, H:i') }}
                                    </span>
                                </div>
                            </div>
                            <div class="score-section">
                                @if($essayQuestionCount > 0)
                                    <div class="grading-status">
                                        @if($submission->is_scored)
                                            <span class="status-badge status-complete">
                                                <i class="lni lni-checkmark-circle"></i>
                                                Selesai Dinilai
                                            </span>
                                        @else
                                            <span class="status-badge status-pending">
                                                <i class="lni lni-timer"></i>
                                                {{ $scoredEssayCount }}/{{ $essayQuestionCount }} Essay
                                            </span>
                                        @endif
                                    </div>
                                @endif
                                <div class="score-circle {{ $currentScore >= 70 ? 'score-high' : ($currentScore >= 50 ? 'score-medium' : 'score-low') }}">
                                    <span class="score-value" id="total-score-{{ $submission->id }}">{{ number_format($currentScore, 0) }}</span>
                                    <span class="score-label">/ 100</span>
                                </div>
                            </div>
                        </div>

                        {{-- Questions List --}}
                        <div class="questions-container">
                            @foreach($exam->questions as $question)
                                @php
                                    $studentAnswer = $answers[$question->id] ?? null;
                                    $correctAnswerRaw = $question->correct_answer;
                                    $isCorrect = null;
                                    $currentEssayScore = $essayScores[$question->id] ?? null;

                                    if ($question->type === 'essay') {
                                        $isCorrect = null;
                                    } elseif ($question->type === 'checkbox') {
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
                                        $studentIndex = null;
                                        $correctIndex = null;
                                        if (is_string($studentAnswer) && is_array($question->options)) {
                                            $studentIndex = array_search($studentAnswer, $question->options);
                                        } elseif (is_numeric($studentAnswer)) {
                                            $studentIndex = (int) $studentAnswer;
                                        }
                                        if (is_array($correctAnswerRaw) && count($correctAnswerRaw) > 0) {
                                            $correctIndex = (int) $correctAnswerRaw[0];
                                        }
                                        $isCorrect = ($studentIndex !== null && $correctIndex !== null) && ($studentIndex === $correctIndex);
                                    }
                                @endphp

                                <div class="question-item {{ $isCorrect === true ? 'correct' : ($isCorrect === false ? 'incorrect' : 'pending') }}">
                                    <div class="question-header">
                                        <div class="question-number">{{ $loop->iteration }}</div>
                                        <div class="question-meta">
                                            <span class="question-type type-{{ $question->type }}">
                                                @if($question->type === 'essay')
                                                    <i class="lni lni-text-format"></i> Essay
                                                @elseif($question->type === 'multiple_choice')
                                                    <i class="lni lni-circle-plus"></i> Pilihan Ganda
                                                @elseif($question->type === 'checkbox')
                                                    <i class="lni lni-checkbox"></i> Checkbox
                                                @else
                                                    <i class="lni lni-chevron-down-circle"></i> Dropdown
                                                @endif
                                            </span>
                                            <span class="question-points">{{ number_format($pointsPerQuestion, 1) }} poin</span>
                                        </div>
                                        @if($isCorrect !== null)
                                            <div class="question-result">
                                                @if($isCorrect)
                                                    <span class="result-badge result-correct">
                                                        <i class="lni lni-checkmark"></i> +{{ number_format($pointsPerQuestion, 1) }}
                                                    </span>
                                                @else
                                                    <span class="result-badge result-incorrect">
                                                        <i class="lni lni-close"></i> 0
                                                    </span>
                                                @endif
                                            </div>
                                        @elseif($question->type === 'essay' && $currentEssayScore !== null)
                                            <div class="question-result">
                                                <span class="result-badge result-scored">
                                                    <i class="lni lni-star-fill"></i> {{ $currentEssayScore }}%
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <p class="question-text">{{ $question->question_text }}</p>

                                    @if($question->image)
                                        <div class="question-image">
                                            <img src="{{ Storage::url($question->image) }}" alt="Gambar soal">
                                        </div>
                                    @endif

                                    <div class="answer-section">
                                        <label class="answer-label">Jawaban Siswa</label>
                                        @if($question->type === 'essay')
                                            <div class="essay-answer">
                                                {{ $studentAnswer ?? 'Tidak dijawab' }}
                                            </div>
                                            
                                            {{-- Essay Scoring --}}
                                            <div class="essay-grading">
                                                <div class="grading-input-group">
                                                    <label>Nilai Essay</label>
                                                    <div class="grading-controls">
                                                        <input type="number" 
                                                               class="grading-input essay-score-input" 
                                                               id="essay-input-{{ $submission->id }}-{{ $question->id }}"
                                                               value="{{ $currentEssayScore ?? '' }}"
                                                               min="0" max="100" step="1"
                                                               placeholder="0-100"
                                                               data-submission-id="{{ $submission->id }}"
                                                               data-question-id="{{ $question->id }}">
                                                        <span class="input-suffix">%</span>
                                                        <button type="button" 
                                                                class="btn-save save-essay-score"
                                                                data-submission-id="{{ $submission->id }}"
                                                                data-question-id="{{ $question->id }}">
                                                            <i class="lni lni-checkmark"></i>
                                                            <span>Simpan</span>
                                                        </button>
                                                    </div>
                                                    @if($currentEssayScore !== null)
                                                        <span class="saved-indicator active" id="saved-badge-{{ $submission->id }}-{{ $question->id }}">
                                                            <i class="lni lni-checkmark-circle"></i> Tersimpan
                                                        </span>
                                                    @else
                                                        <span class="saved-indicator" id="saved-badge-{{ $submission->id }}-{{ $question->id }}">
                                                            <i class="lni lni-checkmark-circle"></i> Tersimpan
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                        @elseif(in_array($question->type, ['multiple_choice', 'dropdown']))
                                            <div class="choice-answer">
                                                @if(is_numeric($studentAnswer) && isset($question->options[$studentAnswer]))
                                                    {{ $question->options[$studentAnswer] }}
                                                @else
                                                    {{ $studentAnswer ?? 'Tidak dijawab' }}
                                                @endif
                                            </div>
                                        @elseif($question->type === 'checkbox')
                                            <div class="checkbox-answers">
                                                @foreach($question->options as $idx => $option)
                                                    <div class="checkbox-item {{ (is_array($studentAnswer) && in_array($idx, $studentAnswer)) || (is_scalar($studentAnswer) && $studentAnswer == $idx) ? 'checked' : '' }}">
                                                        <i class="lni {{ (is_array($studentAnswer) && in_array($idx, $studentAnswer)) || (is_scalar($studentAnswer) && $studentAnswer == $idx) ? 'lni-checkmark' : 'lni-close' }}"></i>
                                                        {{ $option }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<style>
/* Base Styles */
.submissions-page {
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e9f2 100%);
    min-height: 100vh;
}

/* Header */
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 1.5rem 0;
    color: white;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.back-link {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.2);
    border-radius: 10px;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
}

.back-link:hover {
    background: rgba(255,255,255,0.3);
    transform: translateX(-3px);
}

.page-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
}

.exam-title {
    margin: 0;
    opacity: 0.9;
    font-size: 0.95rem;
}

.exam-badges {
    display: flex;
    gap: 0.5rem;
}

.badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.badge-class {
    background: rgba(255,255,255,0.25);
}

.badge-subject {
    background: rgba(255,255,255,0.15);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.bg-primary-soft {
    background: rgba(102, 126, 234, 0.15);
    color: #667eea;
}

.bg-success-soft {
    background: rgba(16, 185, 129, 0.15);
    color: #10b981;
}

.bg-warning-soft {
    background: rgba(245, 158, 11, 0.15);
    color: #f59e0b;
}

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
}

.stat-label {
    font-size: 0.8rem;
    color: #64748b;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
}

.empty-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: #f1f5f9;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #94a3b8;
}

.empty-state h3 {
    color: #334155;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #64748b;
    margin: 0;
}

/* Submission Card */
.submission-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
}

.submission-header {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e2e8f0;
}

.student-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.student-avatar {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    font-weight: 700;
}

.student-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0 0 0.25rem 0;
}

.submit-time {
    font-size: 0.85rem;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 0.35rem;
}

.score-section {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.status-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.35rem;
}

.status-complete {
    background: #dcfce7;
    color: #16a34a;
}

.status-pending {
    background: #fef3c7;
    color: #d97706;
}

.score-circle {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.score-high {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.score-medium {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}

.score-low {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

.score-value {
    font-size: 1.4rem;
    font-weight: 700;
    line-height: 1;
}

.score-label {
    font-size: 0.65rem;
    opacity: 0.85;
}

/* Questions Container */
.questions-container {
    padding: 1.5rem;
}

.question-item {
    background: #fafbfc;
    border-radius: 14px;
    padding: 1.25rem;
    margin-bottom: 1rem;
    border-left: 4px solid #e2e8f0;
    transition: all 0.3s ease;
}

.question-item.correct {
    border-left-color: #10b981;
    background: rgba(16, 185, 129, 0.03);
}

.question-item.incorrect {
    border-left-color: #ef4444;
    background: rgba(239, 68, 68, 0.03);
}

.question-item.pending {
    border-left-color: #667eea;
}

.question-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.75rem;
}

.question-number {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
}

.question-meta {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex: 1;
}

.question-type {
    padding: 0.3rem 0.6rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.type-essay {
    background: #dbeafe;
    color: #2563eb;
}

.type-multiple_choice, .type-dropdown, .type-checkbox {
    background: #f1f5f9;
    color: #475569;
}

.question-points {
    font-size: 0.8rem;
    color: #94a3b8;
}

.question-result {
    margin-left: auto;
}

.result-badge {
    padding: 0.35rem 0.7rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.result-correct {
    background: #dcfce7;
    color: #16a34a;
}

.result-incorrect {
    background: #fee2e2;
    color: #dc2626;
}

.result-scored {
    background: #dbeafe;
    color: #2563eb;
}

.question-text {
    color: #334155;
    margin: 0 0 1rem 0;
    line-height: 1.6;
}

.question-image {
    margin-bottom: 1rem;
}

.question-image img {
    max-height: 200px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
}

/* Answer Section */
.answer-section {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px dashed #e2e8f0;
}

.answer-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: block;
    margin-bottom: 0.5rem;
}

.essay-answer, .choice-answer {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 1rem;
    color: #334155;
    line-height: 1.6;
}

.checkbox-answers {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.checkbox-item {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    color: #94a3b8;
}

.checkbox-item.checked {
    background: #f0fdf4;
    border-color: #86efac;
    color: #166534;
}

/* Essay Grading */
.essay-grading {
    margin-top: 1rem;
    background: linear-gradient(135deg, #667eea08 0%, #764ba208 100%);
    border: 1px solid #667eea20;
    border-radius: 12px;
    padding: 1rem;
}

.grading-input-group {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.grading-input-group label {
    font-weight: 600;
    color: #475569;
    font-size: 0.9rem;
}

.grading-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.grading-input {
    width: 80px;
    padding: 0.5rem 0.75rem;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    text-align: center;
    transition: all 0.3s ease;
}

.grading-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
}

.grading-input.is-valid {
    border-color: #10b981;
    background: #f0fdf4;
}

.input-suffix {
    font-weight: 600;
    color: #64748b;
}

.btn-save {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
}

.btn-save:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

.saved-indicator {
    font-size: 0.8rem;
    color: #10b981;
    font-weight: 600;
    display: none;
    align-items: center;
    gap: 0.3rem;
}

.saved-indicator.active {
    display: flex;
}

/* Responsive */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .submission-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .score-section {
        width: 100%;
        justify-content: space-between;
    }
    
    .grading-input-group {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.save-essay-score').forEach(function(button) {
        button.addEventListener('click', function() {
            const submissionId = this.dataset.submissionId;
            const questionId = this.dataset.questionId;
            const inputField = document.getElementById('essay-input-' + submissionId + '-' + questionId);
            const score = parseFloat(inputField.value);

            if (isNaN(score) || score < 0 || score > 100) {
                alert('Masukkan nilai antara 0-100');
                return;
            }

            button.disabled = true;
            button.innerHTML = '<i class="lni lni-spinner-solid lni-spin"></i> <span>Menyimpan...</span>';

            fetch('{{ url("examteachers/submissions") }}/' + submissionId + '/score-essay', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    question_id: questionId,
                    score: score
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const totalScoreElement = document.getElementById('total-score-' + submissionId);
                    if (totalScoreElement) {
                        totalScoreElement.textContent = Math.round(parseFloat(data.total_score));
                    }

                    const savedBadge = document.getElementById('saved-badge-' + submissionId + '-' + questionId);
                    if (savedBadge) {
                        savedBadge.classList.add('active');
                    }

                    inputField.classList.add('is-valid');
                    setTimeout(() => inputField.classList.remove('is-valid'), 2000);
                } else {
                    alert('Gagal menyimpan nilai. Silakan coba lagi.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            })
            .finally(() => {
                button.disabled = false;
                button.innerHTML = '<i class="lni lni-checkmark"></i> <span>Simpan</span>';
            });
        });
    });

    document.querySelectorAll('.essay-score-input').forEach(function(input) {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const submissionId = this.dataset.submissionId;
                const questionId = this.dataset.questionId;
                const button = document.querySelector('.save-essay-score[data-submission-id="' + submissionId + '"][data-question-id="' + questionId + '"]');
                if (button) {
                    button.click();
                }
            }
        });
    });
});
</script>
@endpush
@endsection