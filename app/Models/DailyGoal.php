<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyGoal extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'new_words_per_day', 'review_words_per_day'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
