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
        return view('spp.index', compact('spps'));
    }

    public function create()
    {
        $students = Student::orderBy('name')->get();
        return view('spp.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'student_name' => 'required|string|max:255',
            'class' => 'required|string|max:255',
            'major' => 'nullable|string|max:255',
            'month' => 'required|string|max:255',
            'due_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'amount_paid' => 'nullable|numeric|min:0',
            'payment_date' => 'nullable|date',
            'status' => 'required|in:belum_lunas,lunas,sebagian',
            'payment_method' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        SppPayment::create($request->all());

        return redirect()->route('spp.index')->with('success', 'Pembayaran SPP berhasil ditambahkan.');
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

    public function update(Request $request, SppPayment $spp)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'student_name' => 'required|string|max:255',
            'class' => 'required|string|max:255',
            'major' => 'nullable|string|max:255',
            'month' => 'required|string|max:255',
            'due_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'amount_paid' => 'nullable|numeric|min:0',
            'payment_date' => 'nullable|date',
            'status' => 'required|in:belum_lunas,lunas,sebagian',
            'payment_method' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        $spp->update($request->all());

        return redirect()->route('spp.index')->with('success', 'Pembayaran SPP berhasil diperbarui.');
    }

    public function destroy(SppPayment $spp)
    {
        $spp->delete();

        return redirect()->route('spp.index')->with('success', 'Pembayaran SPP berhasil dihapus.');
    }
}