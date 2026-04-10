<?php

namespace App\Livewire\Learning;

use Livewire\Component;
use App\Models\Vocabulary;
use Illuminate\Support\Facades\Auth;
use App\Models\StudyLog;
use Livewire\Attributes\Computed;

class LearningSession extends Component
{
    public array $queueIds = [];
    public int $currentIndex = 0;
    public bool $isFinished = false;
    public int $sessionStartTime;

    public array $ratingStats = [
        'again' => 0,
        'hard'  => 0,
        'good'  => 0,
        'easy'  => 0
    ];

    public function mount()
    {
        $this->sessionStartTime = time();
        $this->loadQueue();
    }

    public function loadQueue()
    {
        $newWordIds = Vocabulary::inRandomOrder()->limit(5)->pluck('id')->toArray();

        $reviewWordIds = Vocabulary::orderBy('id', 'desc')->limit(5)->pluck('id')->toArray();

        $this->queueIds = array_merge($newWordIds, $reviewWordIds);
    }
#[Computed]
    public function currentWord()
    {
        if (!isset($this->queueIds[$this->currentIndex])) {
            return null;
        }
        
        return Vocabulary::find($this->queueIds[$this->currentIndex]);
    }

    public function submitRating(string $rating)
    {
        $wordId = $this->queueIds[$this->currentIndex];

        StudyLog::create([
            'user_id'       => Auth::id(),
            'vocabulary_id' => $wordId,
            'rating'        => $rating,
            'studied_at'    => now(),
        ]);

        if (isset($this->ratingStats[$rating])) {
            $this->ratingStats[$rating]++;
        }

        $this->currentIndex++;

        if ($this->currentIndex >= count($this->queueIds)) {
            $this->isFinished = true;
        }
    }

    public function learnMore()
    {
        $this->reset(['currentIndex', 'isFinished', 'ratingStats', 'queueIds']);
        $this->sessionStartTime = time();
        $this->loadQueue();
    }

    public function render()
    {
        return view('livewire.learning.learning-session');
    }
}
