<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('name')->paginate(10);
        return view('students.index', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|unique:students',
            'class' => 'required|string|max:255',
            'major' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'enrollment_date' => 'required|date',
            'address' => 'nullable|string',
        ]);

        $student = Student::create($request->only([
            'name', 'nis', 'class', 'major', 'birth_date', 'enrollment_date', 'address'
        ]));

        return response()->json(['success' => true, 'student' => $student]);
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|unique:students,nis,' . $student->id,
            'class' => 'required|string|max:255',
            'major' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'enrollment_date' => 'required|date',
            'address' => 'nullable|string',
        ]);

        $student->update($request->only([
            'name', 'nis', 'class', 'major', 'birth_date', 'enrollment_date', 'address'
        ]));

        return response()->json(['success' => true, 'student' => $student]);
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(['success' => true]);
    }
}