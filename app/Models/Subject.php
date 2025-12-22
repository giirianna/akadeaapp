<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'teacher_name',
        'subject_code',
        'subject_name',
        'class_level',
        'major_id',
        'description',
        'status'
    ];

    /**
     * Get the major that this subject belongs to.
     */
    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    /**
     * Get teachers assigned to this subject via pivot table (many-to-many).
     */
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_subject')->withTimestamps();
    }

    /**
     * Get the single teacher that owns this subject (legacy relationship).
     * @deprecated Use teachers() relationship instead
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}
