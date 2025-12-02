<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
<<<<<<< HEAD

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('subjects')->paginate(10);
        return view('teachers.index', compact('teachers'));
    }

=======
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
>>>>>>> 003c79269805b833399a5fc59703b21e24fe9c41
    public function create()
    {
        return view('teachers.create');
    }

<<<<<<< HEAD
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
=======
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
>>>>>>> 003c79269805b833399a5fc59703b21e24fe9c41
        }

        Teacher::create($validated);

<<<<<<< HEAD
        return redirect()->route('teachers.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function show(Teacher $teacher)
    {
        // Load relasi subjects agar bisa tampilkan mata pelajaran yang diajar
        $teacher->load('subjects');
        return view('teachers.show', compact('teacher'));
    }

=======
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
>>>>>>> 003c79269805b833399a5fc59703b21e24fe9c41
    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

<<<<<<< HEAD
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
=======
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
>>>>>>> 003c79269805b833399a5fc59703b21e24fe9c41
        }

        $teacher->update($validated);

<<<<<<< HEAD
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
=======
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
>>>>>>> 003c79269805b833399a5fc59703b21e24fe9c41
