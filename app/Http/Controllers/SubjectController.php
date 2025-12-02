<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::with('teacher')->paginate(10);
        return view('subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = Teacher::select('id', 'full_name')->orderBy('full_name')->get();

        $majors = [
            'Semua Jurusan',
            'Rekayasa Perangkat Lunak',
            'Teknik Komputer dan Jaringan',
            'Akuntansi',
            'Otomatisasi Tata Kelola Perkantoran',
            'Desain Komunikasi Visual',
            'Tata Boga',
            'Multimedia',
        ];

        return view('subjects.create', compact('teachers', 'majors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id'    => 'required|exists:teachers,id',
            'subject_code'  => 'required|string|max:20|unique:subjects',
            'subject_name'  => 'required|string|max:100',
            'class_level'   => 'required|in:X,XI,XII',
            'major'         => 'required|string',
            'description'   => 'nullable|string',
            'status'        => 'required|in:active,inactive',
        ]);

        // Ambil nama guru dari teacher_id
        $teacher = Teacher::find($request->teacher_id);
        $validated['teacher_name'] = $teacher ? $teacher->full_name : null;

        Subject::create($validated);

        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        return view('subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        $teachers = Teacher::select('id', 'full_name')->orderBy('full_name')->get();

        $majors = [
            'Semua Jurusan',
            'Rekayasa Perangkat Lunak',
            'Teknik Komputer dan Jaringan',
            'Akuntansi',
            'Otomatisasi Tata Kelola Perkantoran',
            'Desain Komunikasi Visual',
            'Tata Boga',
            'Multimedia',
        ];

        return view('subjects.edit', compact('subject', 'teachers', 'majors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'teacher_id'    => 'required|exists:teachers,id',
            'subject_code'  => 'required|string|max:20|unique:subjects,subject_code,' . $subject->id,
            'subject_name'  => 'required|string|max:100',
            'class_level'   => 'required|in:X,XI,XII',
            'major'         => 'required|string',
            'description'   => 'nullable|string',
            'status'        => 'required|in:active,inactive',
        ]);

        // Update teacher_name berdasarkan guru terpilih
        $teacher = Teacher::find($request->teacher_id);
        $validated['teacher_name'] = $teacher ? $teacher->full_name : null;

        $subject->update($validated);

        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}