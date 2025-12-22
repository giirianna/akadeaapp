<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $fillable = ['name', 'description', 'code'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all subjects for this major.
     */
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'major_id');
    }
}
