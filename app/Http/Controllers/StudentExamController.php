<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamSubmission;
use Illuminate\Http\Request;

class StudentExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with(['questions', 'submissions'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get the current student's name from session
        $studentName = session('student_name');

        return view('exams.examstudents.exams', compact('exams', 'studentName'));
    }

    public function take(Exam $exam)
    {
        if ($exam->questions->isEmpty()) {
            return redirect()->route('student.exams.index')
                ->with('error', 'Ujian ini belum memiliki soal.');
        }

        if (session()->has("exam_{$exam->id}_submitted")) {
            return redirect()->route('student.exams.index')
                ->with('error', 'Anda sudah menyelesaikan ujian ini.');
        }

        return view('exams.examstudents.take', compact('exam'));
    }

    public function submit(Request $request, Exam $exam)
    {
        $request->validate([
            'student_name' => 'required|string|max:100',
        ]);

        $answers = $request->input('answers', []);

        // Create the submission
        $submission = ExamSubmission::create([
            'exam_id' => $exam->id,
            'student_name' => $request->student_name,
            'answers' => $answers,
            'submitted_at' => now(),
        ]);

        // Calculate score for objective questions
        $exam->load('questions');
        $scoreData = $this->calculateSubmissionScore($submission, $exam);
        
        // Update submission with calculated score
        $submission->update([
            'total_score' => $scoreData['total_score'],
            'is_scored' => $scoreData['is_fully_scored'],
        ]);

        session(["exam_{$exam->id}_submitted" => true]);
        session(['student_name' => $request->student_name]);

        return view('exams.examstudents.thankyou', [
            'exam' => $exam,
            'submission' => $submission,
            'scoreData' => $scoreData,
        ]);
    }

    /**
     * Calculate the score for a submission.
     * Returns score data including breakdown for display.
     */
    protected function calculateSubmissionScore(ExamSubmission $submission, Exam $exam): array
    {
        $questions = $exam->questions;
        $totalQuestions = $questions->count();

        if ($totalQuestions === 0) {
            return [
                'total_score' => 0,
                'max_score' => 100,
                'points_per_question' => 0,
                'auto_scored_correct' => 0,
                'auto_scored_total' => 0,
                'essay_count' => 0,
                'is_fully_scored' => true,
                'question_results' => [],
            ];
        }

        $pointsPerQuestion = 100 / $totalQuestions;
        $totalScore = 0;
        $answers = $submission->answers ?? [];
        
        $autoScoredCorrect = 0;
        $autoScoredTotal = 0;
        $essayCount = 0;
        $questionResults = [];

        foreach ($questions as $question) {
            $studentAnswer = $answers[$question->id] ?? null;
            $result = [
                'question_id' => $question->id,
                'type' => $question->type,
                'points' => $pointsPerQuestion,
            ];

            if ($question->type === 'essay') {
                $essayCount++;
                $result['status'] = 'pending';
                $result['earned'] = 0;
            } else {
                $autoScoredTotal++;
                $isCorrect = $this->isAnswerCorrect($question, $studentAnswer);
                
                if ($isCorrect) {
                    $autoScoredCorrect++;
                    $totalScore += $pointsPerQuestion;
                    $result['status'] = 'correct';
                    $result['earned'] = $pointsPerQuestion;
                } else {
                    $result['status'] = 'incorrect';
                    $result['earned'] = 0;
                }
            }

            $questionResults[$question->id] = $result;
        }

        return [
            'total_score' => round($totalScore, 2),
            'max_score' => 100,
            'points_per_question' => round($pointsPerQuestion, 2),
            'auto_scored_correct' => $autoScoredCorrect,
            'auto_scored_total' => $autoScoredTotal,
            'essay_count' => $essayCount,
            'is_fully_scored' => $essayCount === 0,
            'question_results' => $questionResults,
        ];
    }

    /**
     * Check if an answer is correct for non-essay questions.
     */
    protected function isAnswerCorrect($question, $studentAnswer): bool
    {
        if ($studentAnswer === null) {
            return false;
        }

        $correctAnswerRaw = $question->correct_answer;

        if ($question->type === 'checkbox') {
            $normalizeArray = function ($arr) {
                if (!is_array($arr)) return [];
                return array_map('intval', array_values(array_unique($arr)));
            };
            $studentNorm = $normalizeArray(is_array($studentAnswer) ? $studentAnswer : [$studentAnswer]);
            $correctNorm = $normalizeArray($correctAnswerRaw);
            sort($studentNorm);
            sort($correctNorm);
            return $studentNorm === $correctNorm;
        } else {
            // multiple_choice & dropdown
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

            return ($studentIndex !== null && $correctIndex !== null) && ($studentIndex === $correctIndex);
        }
    }
}
