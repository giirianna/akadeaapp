<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExamController extends Controller
{

    
    public function index()
    {
        $exams = Exam::withCount('questions', 'submissions')
            ->latest()
            ->get();

        return view('exams.examteachers.index', compact('exams'));
    }

    public function create()
    {
        return view('exams.examteachers.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateExamData($request);

        $exam = Exam::create($data);
        $this->saveQuestions($exam, $request->questions ?? []);

        return redirect()->route('exams.index')
            ->with('success', 'Ujian berhasil dibuat!');
    }

    public function show(Exam $exam)
    {
        $exam->load('questions');
        return view('exams.examteachers.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        $exam->load('questions');
        return view('exams.examteachers.edit', compact('exam'));
    }

    public function update(Request $request, Exam $exam)
    {
        $data = $this->validateExamData($request);
        $exam->update($data);
        $this->updateQuestions($exam, $request->questions ?? []);

        return redirect()->route('exams.index')
            ->with('success', 'Ujian berhasil diperbarui!');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('exams.index')
            ->with('success', 'Ujian berhasil dihapus!');
    }

    public function submissions(Exam $exam)
    {
        $exam->load(['questions', 'submissions']);
        return view('exams.examteachers.submissions', compact('exam'));
    }

    /**
     * Validasi data ujian umum.
     */
    protected function validateExamData(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'class' => 'required|string|in:X,XI,XII',
            'subject' => 'required|string|max:100',
            'duration_minutes' => 'required|integer|min:1',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);
    }

    /**
     * Perbarui soal: hapus lama (termasuk gambar), simpan baru.
     */
    protected function updateQuestions(Exam $exam, array $questions): void
    {
        // Hapus file gambar lama
        $exam->questions->each(function ($question) {
            if ($question->image) {
                Storage::disk('public')->delete($question->image);
            }
        });

        // Hapus semua soal lama
        $exam->questions()->delete();

        // Simpan soal baru
        $this->saveQuestions($exam, $questions);
    }

    /**
     * Simpan daftar soal ke dalam ujian.
     */
    protected function saveQuestions(Exam $exam, array $questions): void
    {
        $request = request();

        foreach ($questions as $index => $q) {
            if (empty(trim(Arr::get($q, 'question_text')))) {
                continue;
            }

            $type = Arr::get($q, 'type', 'multiple_choice');
            $options = null;
            $correctAnswer = Arr::get($q, 'correct_answer', []);

            if (in_array($type, ['multiple_choice', 'checkbox', 'dropdown'])) {
                $rawOptions = Arr::get($q, 'options', []);
                $options = array_values(array_filter(
                    is_array($rawOptions) ? $rawOptions : [],
                    fn ($opt) => !empty(trim($opt))
                ));
                if (empty($options)) continue;
            }

            //Ambil file dari $request->file(), bukan dari $q['image']
            $imagePath = null;
            $fileKey = "questions.{$index}.image";

            if ($request->hasFile($fileKey)) {
                $image = $request->file($fileKey);
                if ($image->isValid()) {
                    $imagePath = $image->store('exam-questions', 'public');
                }
            }

            Question::create([
                'exam_id' => $exam->id,
                'question_text' => trim($q['question_text']),
                'type' => $type,
                'options' => $options ?: null,
                'correct_answer' => $correctAnswer,
                'image' => $imagePath,
            ]);
        }
    }
}