<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VocabularySet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description', 'tags', 'is_public'];

    protected $casts = [
        'tags'      => 'array',
        'is_public' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vocabularies()
    {
        return $this->hasMany(Vocabulary::class, 'set_id');
    }

    public function getWordCountAttribute(): int
    {
        return $this->vocabularies()->count();
    }
}
