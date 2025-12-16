@extends('layouts.app')
@section('title', 'Kerjakan Ujian')
@section('content')
<style>
    body { margin: 0; overflow: hidden; }
    #exam-container { padding: 20px; background: white; min-height: 100vh; }
</style>

<div class="container" id="exam-container">
    <div class="text-center mb-4">
        <h2>{{ $exam->title }}</h2>
        <p><strong>Sisa Waktu:</strong> <span id="timer">00:00</span></p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <form id="exam-form" method="POST" action="{{ route('student.exams.submit', $exam) }}">
        @csrf
        <div class="mb-3">
            <label for="student_name" class="form-label">Nama Lengkap</label>
            <input type="text" name="student_name" id="student_name" class="form-control" value="{{ old('student_name') }}" required>
        </div>

        @foreach($exam->questions as $q)
            <div class="card mb-4">
                <div class="card-body">
                    <h5>{{ $loop->iteration }}. {!! nl2br(e($q->question_text)) !!}</h5>
                    
                    {{-- Display question image if exists --}}
                    @if($q->image)
                        <div class="question-image mb-3">
                            <img src="{{ asset('storage/' . $q->image) }}" 
                                 alt="Question Image" 
                                 class="img-fluid rounded border"
                                 style="max-width: 100%; max-height: 400px; object-fit: contain;"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                            <div class="alert alert-warning" style="display: none;">
                                <small>Gambar tidak dapat dimuat</small>
                            </div>
                        </div>
                    @endif
                    
                    @if($q->type === 'multiple_choice')
                        @foreach($q->options as $i => $opt)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $q->id }}]" value="{{ $opt }}" id="q{{ $q->id }}_{{ $i }}" required>
                            <label class="form-check-label" for="q{{ $q->id }}_{{ $i }}">{{ $opt }}</label>
                        </div>
                        @endforeach
                    @elseif($q->type === 'checkbox')
                        @foreach($q->options as $i => $opt)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="answers[{{ $q->id }}][]" value="{{ $opt }}" id="q{{ $q->id }}_{{ $i }}">
                            <label class="form-check-label" for="q{{ $q->id }}_{{ $i }}">{{ $opt }}</label>
                        </div>
                        @endforeach
                    @elseif($q->type === 'dropdown')
                        <select class="form-control" name="answers[{{ $q->id }}]" required>
                            <option value="">-- Pilih Jawaban --</option>
                            @foreach($q->options as $opt)
                            <option value="{{ $opt }}">{{ $opt }}</option>
                            @endforeach
                        </select>
                    @elseif($q->type === 'essay')
                        <textarea class="form-control" name="answers[{{ $q->id }}]" rows="5" required placeholder="Tuliskan jawaban Anda...">{{ old("answers.$q->id") }}</textarea>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="text-center">
            <button type="submit" class="btn btn-success btn-lg" id="submit-btn">Kirim Ujian</button>
        </div>
    </form>
</div>

<script>
    let submitted = false;
    let timeLeft = {{ $exam->duration_minutes * 60 }};
    const timerElement = document.getElementById('timer');
    const examForm = document.getElementById('exam-form');
    const submitBtn = document.getElementById('submit-btn');

    function updateTimer() {
        if (submitted) return;
        const mins = String(Math.floor(timeLeft / 60)).padStart(2, '0');
        const secs = String(timeLeft % 60).padStart(2, '0');
        timerElement.textContent = `${mins}:${secs}`;
        if (timeLeft <= 0) {
            alert('Waktu habis! Ujian otomatis dikirim.');
            examForm.submit();
        }
        timeLeft--;
    }

    const timerInterval = setInterval(updateTimer, 1000);

    window.addEventListener('beforeunload', (e) => {
        if (!submitted) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    window.addEventListener('blur', () => {
        if (!submitted) {
            alert('Jangan tinggalkan halaman ujian!');
        }
    });

    if (examForm) {
        examForm.addEventListener('submit', () => {
            submitted = true;
            clearInterval(timerInterval);
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Mengirim...';
            }
        });
    }
</script>
@endsection