<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'teacher_number',
        'teacher_role',
        'full_name',
        'religion',
        'gender',
        'blood_type',
        'birth_date',
        'address',
        'phone_number',
        'employment_status',
        'highest_education',
        'years_of_experience',
        'photo',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'years_of_experience' => 'integer',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Subject (jika perlu)
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'teacher_id');
    }
}