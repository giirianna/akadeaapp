<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Teacher extends Model
{
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

    /**
     * Get the user that owns the teacher.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
