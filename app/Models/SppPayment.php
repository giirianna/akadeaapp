<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SppPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'student_name',
        'class',
        'major',
        'month',
        'amount',
        'amount_paid',
        'payment_date',
        'status',
        'payment_method',
        'remarks',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount_paid' => 'decimal:2',
    ];

    // ✅ Set default value untuk 'amount' agar tidak error saat insert
    protected $attributes = [
        'amount' => 0,
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // ✅ Hitung jumlah tagihan real-time: dari enrollment_date → bulan ini
    public function getJumlahTagihanAttribute()
    {
        if ($this->student && $this->student->enrollment_date) {
            $enroll = Carbon::parse($this->student->enrollment_date)->startOfMonth();
            $now = Carbon::now()->startOfMonth();
            $months = $enroll->diffInMonths($now) + 1;
            return $months * 300000;
        }
        return 0;
    }

    // ✅ Sisa tagihan berdasarkan perhitungan real-time
    public function getSisaTagihanAttribute()
    {
        return $this->jumlah_tagihan - $this->amount_paid;
    }
}