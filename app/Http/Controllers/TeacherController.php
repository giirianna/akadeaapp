<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::with('user')->paginate(10);

        return view('teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_number' => ['required', 'string', 'max:255', 'unique:teachers,teacher_number'],
            'teacher_role'   => ['required', 'array', 'min:1'],
            'teacher_role.*' => ['string', 'max:255'],
            'full_name'      => ['required', 'string', 'max:255'],
            'religion'       => ['nullable', 'string', 'max:255'],
            'gender'         => ['required', 'string', 'max:50'],
            'blood_type'     => ['nullable', 'string', 'max:10'],
            'birth_date'     => ['nullable', 'date'],
            'address'        => ['nullable', 'string'],
            'phone_number'   => ['nullable', 'string', 'max:50'],
            'employment_status' => ['nullable', 'string', 'max:50'],
            'highest_education' => ['nullable', 'string', 'max:50'],
            'years_of_experience' => ['nullable', 'integer', 'min:0'],
            'teacher_photo'  => ['nullable', 'image', 'max:2048'],
        ]);

        $validated['user_id'] = Auth::id();

        // Convert selected subjects array to comma-separated string
        if (isset($validated['teacher_role']) && is_array($validated['teacher_role'])) {
            $validated['teacher_role'] = implode(',', $validated['teacher_role']);
        }

        if ($request->hasFile('teacher_photo')) {
            $path = $request->file('teacher_photo')->store('teacher_photos', 'public');
            $validated['teacher_photo'] = $path;
        }

        Teacher::create($validated);

        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        return view('teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'teacher_number' => ['required', 'string', 'max:255', 'unique:teachers,teacher_number,' . $teacher->id],
            'teacher_role'   => ['required', 'array', 'min:1'],
            'teacher_role.*' => ['string', 'max:255'],
            'full_name'      => ['required', 'string', 'max:255'],
            'religion'       => ['nullable', 'string', 'max:255'],
            'gender'         => ['required', 'string', 'max:50'],
            'blood_type'     => ['nullable', 'string', 'max:10'],
            'birth_date'     => ['nullable', 'date'],
            'address'        => ['nullable', 'string'],
            'phone_number'   => ['nullable', 'string', 'max:50'],
            'employment_status' => ['nullable', 'string', 'max:50'],
            'highest_education' => ['nullable', 'string', 'max:50'],
            'years_of_experience' => ['nullable', 'integer', 'min:0'],
            'teacher_photo'  => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('teacher_photo')) {
            $path = $request->file('teacher_photo')->store('teacher_photos', 'public');
            $validated['teacher_photo'] = $path;
        }

        $teacher->update($validated);

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}
