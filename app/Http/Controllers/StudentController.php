<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user', 'major')->orderBy('name')->paginate(10);
        $majors = Major::orderBy('name')->get();
        return view('students.index', compact('students', 'majors'));
    }

    public function create()
    {
        $majors = Major::orderBy('name')->get();
        $classLevels = ['X', 'XI', 'XII'];
        return view('students.create', compact('majors', 'classLevels'));
    }

    public function edit(Student $student)
    {
        $majors = Major::orderBy('name')->get();
        $classLevels = ['X', 'XI', 'XII'];
        return view('students.edit', compact('student', 'majors', 'classLevels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|unique:students',
            'class' => 'required|in:X,XI,XII',
            'major_id' => 'nullable|exists:majors,id',
            'birth_date' => 'nullable|date',
            'enrollment_date' => 'required|date',
            'address' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Create user account for student
            $email = $request->nis . '@student.akadeaapp.com';
            $user = User::create([
                'name' => $request->name,
                'email' => $email,
                'password' => Hash::make($request->nis), // Default password is NIS
                'email_verified_at' => now(),
            ]);

            // Assign student role
            $user->assignRole('student');

            // Create student record
            $student = Student::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'nis' => $request->nis,
                'class' => $request->class,
                'major_id' => $request->major_id,
                'birth_date' => $request->birth_date,
                'enrollment_date' => $request->enrollment_date,
                'address' => $request->address,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'student' => $student->load('user'),
                'message' => 'Siswa berhasil ditambahkan. Akun login: ' . $email . ' | Password: ' . $request->nis
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan siswa: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|unique:students,nis,' . $student->id,
            'class' => 'required|in:X,XI,XII',
            'major_id' => 'nullable|exists:majors,id',
            'birth_date' => 'nullable|date',
            'enrollment_date' => 'required|date',
            'address' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Update student record
            $student->update([
                'name' => $request->name,
                'nis' => $request->nis,
                'class' => $request->class,
                'major_id' => $request->major_id,
                'birth_date' => $request->birth_date,
                'enrollment_date' => $request->enrollment_date,
                'address' => $request->address,
            ]);

            // Update associated user account if exists
            if ($student->user) {
                $student->user->update([
                    'name' => $request->name,
                    'email' => $request->nis . '@student.akadeaapp.com',
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'student' => $student->load('user')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui siswa: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Student $student)
    {
        DB::beginTransaction();
        try {
            // Delete associated user account (will cascade delete student due to foreign key)
            if ($student->user) {
                $student->user->delete();
            } else {
                // If no user, delete student directly
                $student->delete();
            }

            DB::commit();

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus siswa: ' . $e->getMessage()
            ], 500);
        }
    }
}
