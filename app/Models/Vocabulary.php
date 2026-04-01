<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    use HasFactory;

    protected $fillable = [
        'set_id', 'word', 'pronunciation', 'meaning',
        'description_en', 'example', 'collocation', 'related_words', 'note',
    ];

    public function set()
    {
        return $this->belongsTo(VocabularySet::class, 'set_id');
    }

    public function srsProgress()
    {
        return $this->hasMany(SrsProgress::class);
    }

    public function userProgress(int $userId)
    {
        return $this->srsProgress()->where('user_id', $userId)->first();
    }
}
