<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class StudentExamController extends Controller
{
    public function index()
    {
        $exams = Exam::whereHas('questions')
                     ->with('questions')
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('exams.examstudents.exams', compact('exams'));
    }

    public function take(Exam $exam)
    {
        if ($exam->questions->isEmpty()) {
            return redirect()->route('examstudents.exams.index')
                ->with('error', 'Ujian ini belum memiliki soal.');
        }

        if (session()->has("exam_{$exam->id}_submitted")) {
            return redirect()->route('examstudents.exams.index')
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

        \App\Models\ExamSubmission::create([
            'exam_id' => $exam->id,
            'student_name' => $request->student_name,
            'answers' => $answers, 
            'submitted_at' => now(),
        ]);

        session(["exam_{$exam->id}_submitted" => true]);
        session(['student_name' => $request->student_name]);

        return view('exams.examstudents.thankyou', compact('exam'));
    }
}