<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'google_id',
        'level', 'goal', 'streak_days', 'last_study_date',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_study_date'   => 'date',
        'password'          => 'hashed',
    ];

    public function vocabularySets()
    {
        return $this->hasMany(VocabularySet::class);
    }

    public function srsProgresses()
    {
        return $this->hasMany(SrsProgress::class);
    }

    public function studyLogs()
    {
        return $this->hasMany(StudyLog::class);
    }

    public function dailyGoal()
    {
        return $this->hasOne(DailyGoal::class);
    }

    public function getTotalLearnedWordsAttribute(): int
    {
        return $this->srsProgresses()
            ->whereIn('status', ['review', 'mastered'])
            ->count();
    }
}
