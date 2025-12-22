<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use App\Models\Subject;
use App\Services\QuestionImportService;
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

        $subjects = Subject::select('subject_name')
            ->distinct()
            ->orderBy('subject_name')
            ->get();

        return view('exams.examteachers.index', compact('exams', 'subjects'));
    }

    public function create()
    {
        $subjects = Subject::select('subject_name')
            ->distinct()
            ->orderBy('subject_name')
            ->get();
        return view('exams.examteachers.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $data = $this->validateExamData($request);

        $exam = Exam::create($data);

        // Handle questions_file if uploaded
        if ($request->hasFile('questions_file')) {
            $service = new QuestionImportService();
            $result = $service->parseFile($request->file('questions_file'));

            if ($result['success']) {
                foreach ($result['questions'] as $q) {
                    Question::create([
                        'exam_id' => $exam->id,
                        'question_text' => $q['question_text'],
                        'type' => $q['type'],
                        'options' => $q['options'],
                        'correct_answer' => $q['correct_answer'],
                        'image' => null,
                    ]);
                }
            }
        } else {
            $this->saveQuestions($exam, $request->questions ?? []);
        }

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
        $subjects = Subject::select('subject_name')
            ->distinct()
            ->orderBy('subject_name')
            ->get();
        return view('exams.examteachers.edit', compact('exam', 'subjects'));
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
            'questions_file' => 'nullable|file|mimes:xlsx,xls,docx,doc|max:10240',
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
                    fn($opt) => !empty(trim($opt))
                ));
                if (empty($options))
                    continue;
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

    /**
     * Import questions from Excel/Word file
     */
    public function importQuestions(Request $request, Exam $exam)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,docx,doc|max:10240' // 10MB max
        ]);

        $service = new QuestionImportService();
        $result = $service->parseFile($request->file('file'));

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 400);
        }

        // Delete existing questions for this exam
        $exam->questions()->delete();

        // Import new questions
        foreach ($result['questions'] as $q) {
            Question::create([
                'exam_id' => $exam->id,
                'question_text' => $q['question_text'],
                'type' => $q['type'],
                'options' => $q['options'],
                'correct_answer' => $q['correct_answer'],
                'image' => null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "Berhasil mengimport {$result['count']} soal.",
            'count' => $result['count'],
            'errors' => $result['errors']
        ]);
    }

    /**
     * Download Excel template for question import
     */
    public function downloadTemplate()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = ['Tipe', 'Pertanyaan', 'OpsiA', 'OpsiB', 'OpsiC', 'OpsiD', 'OpsiE', 'Jawaban'];
        $sheet->fromArray([$headers], null, 'A1');

        // Style header
        $headerStyle = [
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center']
        ];
        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

        // Add sample data
        $samples = [
            ['multiple_choice', 'Apa ibukota Indonesia?', 'Jakarta', 'Surabaya', 'Bandung', 'Medan', '', 'A'],
            ['multiple_choice', '2 + 2 = ?', '2', '3', '4', '5', '', 'C'],
            ['essay', 'Jelaskan pengertian fotosintesis', '', '', '', '', '', ''],
        ];

        foreach ($samples as $i => $sample) {
            $sheet->fromArray([$sample], null, 'A' . ($i + 2));
        }

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(35);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(12);

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Template_Soal.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
