<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Teacher extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
        'teacher_photo',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'years_of_experience' => 'integer',
    ];

    /**
     * Get the user that owns the teacher.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subjects taught by this teacher.
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subject')->withTimestamps();
    }
}
