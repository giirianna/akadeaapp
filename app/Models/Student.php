<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'class',
        'major',
        'nis',
        'birth_date',
        'enrollment_date',
        'address',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'enrollment_date' => 'date',
    ];

    /**
     * Get the user account associated with the student.
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}