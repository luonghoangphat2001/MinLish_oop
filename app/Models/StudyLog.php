<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'vocabulary_id', 'rating', 'studied_at'];

    protected $casts = [
        'studied_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vocabulary()
    {
        return $this->belongsTo(Vocabulary::class);
    }
}
