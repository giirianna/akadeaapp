<?php

namespace App\Http\Controllers;

use App\Models\SppPayment;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SppController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('siswa')) {
            return redirect()->route('dashboard');
        }

        $spps = SppPayment::with('student')->orderBy('created_at', 'desc')->paginate(10);
        $students = Student::orderBy('name')->get();

        return view('spp.index', compact('spps', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'month' => 'required|string',
            'amount_paid' => 'nullable|numeric|min:0',
            'payment_date' => 'nullable|date',
            'status' => 'required|in:belum_lunas,sebagian,lunas',
            'payment_method' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $student = Student::findOrFail($request->student_id);

        // Cek duplikat bulan
        if (SppPayment::where('student_id', $student->id)->where('month', $request->month)->exists()) {
            return response()->json(['success' => false, 'message' => 'Bulan ini sudah terdaftar.']);
        }

        // Hitung status berdasarkan amount_paid vs jumlah_tagihan real-time
        $jumlahTagihan = $student->enrollment_date
            ? (Carbon::parse($student->enrollment_date)->diffInMonths(Carbon::now()) ?: 0) + 1
            : 0;
        $jumlahTagihan *= 300000;
        $amountPaid = (int) ($request->amount_paid ?? 0);
        $status = $this->getStatus($amountPaid, $jumlahTagihan);

        SppPayment::create([
            'student_id' => $student->id,
            'student_name' => $student->name,
            'class' => $student->class,
            'major' => $student->major,
            'month' => $request->month,
            'amount_paid' => $amountPaid,
            'payment_date' => $request->payment_date,
            'status' => $status,
            'payment_method' => $request->payment_method,
            'remarks' => $request->remarks,
            // Kolom 'amount' TIDAK diisi — diabaikan, hanya untuk backward compatibility
        ]);

        return response()->json(['success' => true]);
    }

    public function update(Request $request, SppPayment $spp)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'month' => 'required|string',
            'amount_paid' => 'nullable|numeric|min:0',
            'payment_date' => 'nullable|date',
            'status' => 'required|in:belum_lunas,sebagian,lunas',
            'payment_method' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $student = Student::findOrFail($request->student_id);

        // Hitung ulang jumlah tagihan real-time
        $jumlahTagihan = $student->enrollment_date
            ? (Carbon::parse($student->enrollment_date)->diffInMonths(Carbon::now()) ?: 0) + 1
            : 0;
        $jumlahTagihan *= 300000;
        $amountPaid = (int) ($request->amount_paid ?? 0);
        $status = $this->getStatus($amountPaid, $jumlahTagihan);

        $spp->update([
            'student_id' => $student->id,
            'student_name' => $student->name,
            'class' => $student->class,
            'major' => $student->major,
            'month' => $request->month,
            'amount_paid' => $amountPaid,
            'payment_date' => $request->payment_date,
            'status' => $status,
            'payment_method' => $request->payment_method,
            'remarks' => $request->remarks,
            // Kolom 'amount' TIDAK diupdate
        ]);

        return response()->json(['success' => true]);
    }

    private function getStatus($paid, $total)
    {
        if ($paid >= $total) return 'lunas';
        if ($paid > 0) return 'sebagian';
        return 'belum_lunas';
    }

    public function destroy(SppPayment $spp)
    {
        $spp->delete();
        return response()->json(['success' => true]);
    }
}