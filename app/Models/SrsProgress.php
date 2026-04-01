<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SrsProgress extends Model
{
    use HasFactory;

    protected $table = 'srs_progress';

    protected $fillable = [
        'user_id', 'vocabulary_id', 'ease_factor', 'interval_days',
        'repetitions', 'next_review_at', 'last_reviewed_at', 'status',
    ];

    protected $casts = [
        'next_review_at'    => 'datetime',
        'last_reviewed_at'  => 'datetime',
        'ease_factor'       => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vocabulary()
    {
        return $this->belongsTo(Vocabulary::class);
    }

    public function isDueForReview(): bool
    {
        return $this->next_review_at === null || $this->next_review_at->isPast();
    }
}
