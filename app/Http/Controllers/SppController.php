<?php

namespace App\Http\Controllers;

use App\Models\SppPayment;
use App\Models\Student;
use Illuminate\Http\Request;

class SppController extends Controller
{
    public function index()
    {
    $spps = SppPayment::with('student')->orderBy('created_at', 'desc')->paginate(10);
    $students = Student::orderBy('name')->get(); // ✅ Ambil semua siswa

    return view('spp.index', compact('spps', 'students')); // ✅ Kirim ke view
    }

    public function create()
    {
        $students = Student::orderBy('name')->get();
        return view('spp.create', compact('students'));
    }


    public function show(SppPayment $spp)
    {
        $spp->load('student');
        return view('spp.show', compact('spp'));
    }

    public function edit(SppPayment $spp)
    {
        $students = Student::orderBy('name')->get();
        return view('spp.edit', compact('spp', 'students'));
    }

    public function store(Request $request)
{
    // ... validasi

    $spp = SppPayment::create($request->all());
    return response()->json(['success' => true, 'spp' => $spp]);
}

public function update(Request $request, SppPayment $spp)
{
    // ... validasi

    $spp->update($request->all());
    return response()->json(['success' => true, 'spp' => $spp]);
}

public function destroy(SppPayment $spp)
{
    $spp->delete();
    return response()->json(['success' => true]);
}
}