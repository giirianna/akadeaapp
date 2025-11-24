<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'class',
        'major',
        'nis',
        'birth_date',
        'address',
    ];

    // Tambahkan ini agar birth_date otomatis jadi objek Carbon
    protected $casts = [
        'birth_date' => 'date', // atau 'datetime' jika butuh jam
    ];
}