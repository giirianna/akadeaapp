<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

=======
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
>>>>>>> 003c79269805b833399a5fc59703b21e24fe9c41
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
<<<<<<< HEAD
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
=======
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
>>>>>>> 003c79269805b833399a5fc59703b21e24fe9c41
