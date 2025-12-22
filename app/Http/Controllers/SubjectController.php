<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $query = Subject::with('teachers', 'major');

        // Apply filters
        if (request()->has('class_level') && request('class_level') != '') {
            $query->where('class_level', request('class_level'));
        }

        if (request()->has('major_id') && request('major_id') != '') {
            $query->where('major_id', request('major_id'));
        }

        if (request()->has('status') && request('status') != '') {
            $query->where('status', request('status'));
        }

        // Apply search
        if (request()->has('search') && request('search.value') != '') {
            $search = request('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('subject_code', 'like', "%{$search}%")
                    ->orWhere('subject_name', 'like', "%{$search}%")
                    ->orWhere('class_level', 'like', "%{$search}%")
                    ->orWhere('major', 'like', "%{$search}%")
                    ->orWhereHas('teachers', function ($tq) use ($search) {
                        $tq->where('full_name', 'like', "%{$search}%");
                    });
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
            // Get teacher names from pivot relation
            $teacherNames = $subject->teachers->pluck('full_name')->join(', ');

            // Get major name from relationship
            $majorName = $subject->major ? $subject->major->name : '—';

            $data[] = [
                'subject_code' => $subject->subject_code,
                'subject_name' => $subject->subject_name,
                'teacher_name' => $teacherNames ?: '—',
                'class_level' => $subject->class_level,
                'major' => $majorName,
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
        // Get majors from the Major model
        $majors = Major::orderBy('name')->get();
        $classLevels = ['X', 'XI', 'XII'];

        // If AJAX request, return partial view for modal
        if (request()->ajax()) {
            return view('subjects.partials.create', compact('majors', 'classLevels'));
        }

        return view('subjects.create', compact('majors', 'classLevels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_code' => 'required|string|max:20',
            'subject_name' => 'required|string|max:100',
            'class_level' => 'required|array|min:1',
            'class_level.*' => 'in:X,XI,XII',
            'major_id' => 'required|array|min:1',
            'major_id.*' => 'exists:majors,id',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $createdCount = 0;
        $baseCode = $validated['subject_code'];

        foreach ($validated['class_level'] as $classLevel) {
            foreach ($validated['major_id'] as $majorId) {
                // Get the major name for code generation
                $major = Major::find($majorId);
                if (!$major) {
                    continue;
                }

                // Generate unique code with suffix
                $majorAbbrev = Str::upper(Str::substr(preg_replace('/[^A-Za-z]/', '', $major->name), 0, 3));
                $uniqueCode = $baseCode . '-' . $classLevel . '-' . $majorAbbrev;

                // Check if this combination already exists, if so add a number suffix
                $existingCount = Subject::where('subject_code', 'like', $uniqueCode . '%')->count();
                if ($existingCount > 0) {
                    $uniqueCode = $uniqueCode . '-' . ($existingCount + 1);
                }

                Subject::create([
                    'subject_code' => $uniqueCode,
                    'subject_name' => $validated['subject_name'],
                    'class_level' => $classLevel,
                    'major_id' => $majorId,
                    'description' => $validated['description'] ?? null,
                    'status' => $validated['status'],
                    'teacher_id' => null,
                    'teacher_name' => null,
                ]);
                $createdCount++;
            }
        }

        $message = "Berhasil menambahkan {$createdCount} mata pelajaran.";

        // If AJAX request, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'count' => $createdCount
            ]);
        }

        return redirect()->route('subjects.index')->with('success', $message);
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
        // Get majors from the Major model
        $majors = Major::orderBy('name')->get();

        $classLevels = ['X', 'XI', 'XII'];

        // If AJAX request, return partial view for modal
        if (request()->ajax()) {
            return view('subjects.partials.edit', compact('subject', 'majors', 'classLevels'));
        }

        return view('subjects.edit', compact('subject', 'majors', 'classLevels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'subject_code' => 'required|string|max:20|unique:subjects,subject_code,' . $subject->id,
            'subject_name' => 'required|string|max:100',
            'class_level' => 'required|in:X,XI,XII',
            'major_id' => 'required|exists:majors,id',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $subject->update($validated);

        // If AJAX request, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Mata pelajaran berhasil diperbarui.'
            ]);
        }

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
