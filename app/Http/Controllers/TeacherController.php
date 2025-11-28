<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('subjects')->paginate(10);
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    { 
        $validated = $request->validate([
            'teacher_number' => 'required|string|unique:teachers',
            'teacher_role' => 'nullable|string',
            'full_name' => 'required|string',
            'religion' => 'nullable|string',
            'gender' => 'nullable|in:male,female',
            'blood_type' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'employment_status' => 'nullable|string',
            'highest_education' => 'nullable|string',
            'years_of_experience' => 'nullable|integer',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('teachers', 'public');
        }

        Teacher::create($validated);

        return redirect()->route('teachers.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function show(Teacher $teacher)
    {
        // Load relasi subjects agar bisa tampilkan mata pelajaran yang diajar
        $teacher->load('subjects');
        return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'teacher_number' => 'required|string|unique:teachers,teacher_number,' . $teacher->id,
            'teacher_role' => 'nullable|string',
            'full_name' => 'required|string',
            'religion' => 'nullable|string',
            'gender' => 'nullable|in:male,female',
            'blood_type' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'employment_status' => 'nullable|string',
            'highest_education' => 'nullable|string',
            'years_of_experience' => 'nullable|integer',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($teacher->photo) {
                \Storage::disk('public')->delete($teacher->photo);
            }
            $validated['photo'] = $request->file('photo')->store('teachers', 'public');
        }

        $teacher->update($validated);

        return redirect()->route('teachers.index')->with('success', 'Guru berhasil diperbarui.');
    }

    public function destroy(Teacher $teacher)
    {
        if ($teacher->photo) {
            \Storage::disk('public')->delete($teacher->photo);
        }
        $teacher->delete();

        return redirect()->route('teachers.index')->with('success', 'Guru berhasil dihapus.');
    }
}