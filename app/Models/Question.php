<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'exam_id',
        'question_text',
        'description',
        'type',
        'options',
        'correct_answer',
        'required',
        'image',
        'scale_min',
        'scale_max',
        'rows',
    ];

    protected $casts = [
        'options' => 'array',
        'correct_answer' => 'array',
        'required' => 'boolean',
        'rows' => 'array',
        'scale_min' => 'integer',
        'scale_max' => 'integer',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}