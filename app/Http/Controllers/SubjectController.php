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
        // If request is coming from DataTables AJAX, use getData instead
        if (request()->ajax()) {
            return $this->getData();
        }
        
        return view('subjects.index');
    }

    /**
     * Get data for DataTables AJAX
     */
    public function getData()
    {
        $query = Subject::with('teacher');

        // Apply filters
        if (request()->has('class_level') && request('class_level') != '') {
            $query->where('class_level', request('class_level'));
        }

        if (request()->has('major') && request('major') != '') {
            $query->where('major', request('major'));
        }

        if (request()->has('status') && request('status') != '') {
            $query->where('status', request('status'));
        }

        // Apply search
        if (request()->has('search') && request('search.value') != '') {
            $search = request('search.value');
            $query->where(function($q) use ($search) {
                $q->where('subject_code', 'like', "%{$search}%")
                  ->orWhere('subject_name', 'like', "%{$search}%")
                  ->orWhere('teacher_name', 'like', "%{$search}%")
                  ->orWhere('class_level', 'like', "%{$search}%")
                  ->orWhere('major', 'like', "%{$search}%");
            });
        }

        // Get total records before pagination
        $totalData = $query->count();

        // Apply ordering
        $columns = ['subject_code', 'subject_name', 'teacher_name', 'class_level', 'major', 'status'];
        if (request()->has('order')) {
            $orderColumnIndex = request('order.0.column');
            $orderDir = request('order.0.dir');
            if (isset($columns[$orderColumnIndex])) {
                $query->orderBy($columns[$orderColumnIndex], $orderDir);
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        // Apply pagination
        $start = request('start', 0);
        $length = request('length', 10);
        $subjects = $query->skip($start)->take($length)->get();

        // Format data for DataTables
        $data = [];
        foreach ($subjects as $subject) {
            $data[] = [
                'subject_code' => $subject->subject_code,
                'subject_name' => $subject->subject_name,
                'teacher_name' => $subject->teacher_name ?? '—',
                'class_level' => $subject->class_level,
                'major' => $subject->major,
                'status' => $subject->status === 'active' 
                    ? '<span class="status-btn active-btn">Aktif</span>' 
                    : '<span class="status-btn close-btn">Tidak Aktif</span>',
                'actions' => '
                    <div class="action">
                        <a href="#" class="text-info me-2 show-subject" data-id="' . $subject->id . '" title="Lihat Detail">
                            <i class="lni lni-eye"></i>
                        </a>
                        <a href="#" class="text-primary me-2 edit-subject" data-id="' . $subject->id . '" title="Edit">
                            <i class="lni lni-pencil"></i>
                        </a>
                        <a href="#" class="text-danger delete-subject" data-id="' . $subject->id . '" data-name="' . htmlspecialchars($subject->subject_name) . '" data-url="' . route('subjects.destroy', $subject) . '" title="Hapus">
                            <i class="lni lni-trash-can"></i>
                        </a>
                    </div>',
            ];
        }

        return response()->json([
            'draw' => intval(request('draw')),
            'recordsTotal' => Subject::count(),
            'recordsFiltered' => $totalData,
            'data' => $data
        ]);
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
        // If AJAX request, return partial view for modal
        if (request()->ajax()) {
            return view('subjects.partials.show', compact('subject'));
        }
        
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

        // If AJAX request, return partial view for modal
        if (request()->ajax()) {
            return view('subjects.partials.edit', compact('subject', 'teachers', 'majors'));
        }

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