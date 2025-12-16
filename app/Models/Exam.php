<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'title',
        'description',
        'class',              // ← DITAMBAHKAN
        'subject',            // ← DITAMBAHKAN
        'duration_minutes',
        'start_time',
        'end_time'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('id');
    }

    public function submissions()
    {
        return $this->hasMany(ExamSubmission::class);
    }
}