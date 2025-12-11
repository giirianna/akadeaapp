<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::with(['user', 'subjects'])->paginate(10);
        return view('teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::where('status', 'active')
            ->orderBy('subject_name')
            ->get();
        return view('teachers.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // User account fields
            'email'             => ['required', 'email', 'unique:users,email'],
            'password'          => ['required', 'string', 'min:8', 'confirmed'],
            // Teacher fields
            'teacher_number'    => ['required', 'string', 'max:255', 'unique:teachers,teacher_number'],
            'teacher_role'      => ['nullable', 'array'],
            'teacher_role.*'    => ['string', 'max:255'],
            'full_name'         => ['required', 'string', 'max:255'],
            'religion'          => ['nullable', 'string', 'max:255'],
            'gender'            => ['required', 'string', 'max:50'],
            'blood_type'        => ['nullable', 'string', 'max:10'],
            'birth_date'        => ['nullable', 'date'],
            'address'           => ['nullable', 'string'],
            'phone_number'      => ['nullable', 'string', 'max:50'],
            'employment_status' => ['nullable', 'string', 'max:50'],
            'highest_education' => ['nullable', 'string', 'max:50'],
            'years_of_experience' => ['nullable', 'integer', 'min:0'],
            'teacher_photo'     => ['nullable', 'image', 'max:2048'],
            // Subjects (from Subject module)
            'subjects'          => ['required', 'array', 'min:1'],
            'subjects.*'        => ['exists:subjects,id'],
        ]);

        DB::beginTransaction();
        try {
            // Create User account for the teacher
            $user = User::create([
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'email_verified_at' => now(),
            ]);

            // Assign teacher role
            $user->assignRole('teacher');

            // Convert selected subjects array to comma-separated string for teacher_role
            $teacherRole = '';
            if (isset($validated['teacher_role']) && is_array($validated['teacher_role'])) {
                $teacherRole = implode(',', $validated['teacher_role']);
            }

            // Handle photo upload
            $photoPath = null;
            if ($request->hasFile('teacher_photo')) {
                $photoPath = $request->file('teacher_photo')->store('teacher_photos', 'public');
            }

            // Create Teacher record
            $teacher = Teacher::create([
                'user_id' => $user->id,
                'teacher_number' => $validated['teacher_number'],
                'teacher_role' => $teacherRole,
                'full_name' => $validated['full_name'],
                'religion' => $validated['religion'] ?? null,
                'gender' => $validated['gender'],
                'blood_type' => $validated['blood_type'] ?? null,
                'birth_date' => $validated['birth_date'] ?? null,
                'address' => $validated['address'] ?? null,
                'phone_number' => $validated['phone_number'] ?? null,
                'employment_status' => $validated['employment_status'] ?? null,
                'highest_education' => $validated['highest_education'] ?? null,
                'years_of_experience' => $validated['years_of_experience'] ?? 0,
                'teacher_photo' => $photoPath,
            ]);

            // Sync subjects from Subject module
            $teacher->subjects()->sync($validated['subjects']);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Guru berhasil ditambahkan. Akun login telah dibuat dengan email: ' . $user->email
                ]);
            }

            return redirect()->route('teachers.index')->with('success', 'Guru berhasil ditambahkan. Akun login telah dibuat dengan email: ' . $user->email);

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal menambahkan guru: ' . $e->getMessage()], 500);
            }
            
            return back()->withInput()->with('error', 'Gagal menambahkan guru: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        $teacher->load(['subjects', 'user']);
        return view('teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        $subjects = Subject::where('status', 'active')
            ->orderBy('subject_name')
            ->get();
        $assignedSubjectIds = $teacher->subjects->pluck('id')->toArray();
        return view('teachers.edit', compact('teacher', 'subjects', 'assignedSubjectIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            // Email can change but unique check excludes current user
            'email'             => ['nullable', 'email', 'unique:users,email,' . ($teacher->user_id ?? 'NULL')],
            'password'          => ['nullable', 'string', 'min:8', 'confirmed'],
            // Teacher fields
            'teacher_number'    => ['required', 'string', 'max:255', 'unique:teachers,teacher_number,' . $teacher->id],
            'teacher_role'      => ['nullable', 'array'],
            'teacher_role.*'    => ['string', 'max:255'],
            'full_name'         => ['required', 'string', 'max:255'],
            'religion'          => ['nullable', 'string', 'max:255'],
            'gender'            => ['required', 'string', 'max:50'],
            'blood_type'        => ['nullable', 'string', 'max:10'],
            'birth_date'        => ['nullable', 'date'],
            'address'           => ['nullable', 'string'],
            'phone_number'      => ['nullable', 'string', 'max:50'],
            'employment_status' => ['nullable', 'string', 'max:50'],
            'highest_education' => ['nullable', 'string', 'max:50'],
            'years_of_experience' => ['nullable', 'integer', 'min:0'],
            'teacher_photo'     => ['nullable', 'image', 'max:2048'],
            // Subjects
            'subjects'          => ['required', 'array', 'min:1'],
            'subjects.*'        => ['exists:subjects,id'],
        ]);

        DB::beginTransaction();
        try {
            // Update User account if exists
            if ($teacher->user) {
                $userData = ['name' => $validated['full_name']];
                
                if (!empty($validated['email'])) {
                    $userData['email'] = $validated['email'];
                }
                
                if (!empty($validated['password'])) {
                    $userData['password'] = $validated['password'];
                }
                
                $teacher->user->update($userData);
            }

            // Convert selected subjects array to comma-separated string
            $teacherRole = '';
            if (isset($validated['teacher_role']) && is_array($validated['teacher_role'])) {
                $teacherRole = implode(',', $validated['teacher_role']);
            }

            // Handle photo upload
            if ($request->hasFile('teacher_photo')) {
                if ($teacher->teacher_photo) {
                    Storage::disk('public')->delete($teacher->teacher_photo);
                }
                $validated['teacher_photo'] = $request->file('teacher_photo')->store('teacher_photos', 'public');
            }

            // Update Teacher record
            $teacher->update([
                'teacher_number' => $validated['teacher_number'],
                'teacher_role' => $teacherRole,
                'full_name' => $validated['full_name'],
                'religion' => $validated['religion'] ?? null,
                'gender' => $validated['gender'],
                'blood_type' => $validated['blood_type'] ?? null,
                'birth_date' => $validated['birth_date'] ?? null,
                'address' => $validated['address'] ?? null,
                'phone_number' => $validated['phone_number'] ?? null,
                'employment_status' => $validated['employment_status'] ?? null,
                'highest_education' => $validated['highest_education'] ?? null,
                'years_of_experience' => $validated['years_of_experience'] ?? 0,
                'teacher_photo' => $validated['teacher_photo'] ?? $teacher->teacher_photo,
            ]);

            // Sync subjects
            $teacher->subjects()->sync($validated['subjects']);

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Guru berhasil diperbarui.']);
            }

            return redirect()->route('teachers.index')->with('success', 'Guru berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal memperbarui guru: ' . $e->getMessage()], 500);
            }
            
            return back()->withInput()->with('error', 'Gagal memperbarui guru: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        DB::beginTransaction();
        try {
            // Delete photo if exists
            if ($teacher->teacher_photo) {
                Storage::disk('public')->delete($teacher->teacher_photo);
            }

            // Delete associated user account
            if ($teacher->user) {
                $teacher->user->delete();
            }

            // Delete teacher (subjects will be detached via cascade)
            $teacher->delete();

            DB::commit();

            return redirect()->route('teachers.index')->with('success', 'Guru dan akun pengguna berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus guru: ' . $e->getMessage());
        }
    }
}
