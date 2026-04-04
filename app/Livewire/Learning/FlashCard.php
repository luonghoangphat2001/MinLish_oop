<?php

namespace App\Livewire\Learning;

use App\Models\SrsProgress;
use App\Models\StudyLog;
use App\Models\VocabularySet;
use App\Services\SpacedRepetitionService;
use Livewire\Component;

class FlashCard extends Component
{
    public VocabularySet $set;
    public array $queueIds = [];
    public int $currentIndex = 0;
    public int $total = 0;
    public bool $showBack = false;
    public bool $completed = false;
    public array $ratingSummary = [
        'again' => 0,
        'hard' => 0,
        'good' => 0,
        'easy' => 0,
    ];

    protected SpacedRepetitionService $srsService;

    public function boot(SpacedRepetitionService $srsService): void
    {
        $this->srsService = $srsService;
    }

    public function mount(VocabularySet $set): void
    {
        abort_unless($set->user_id === auth()->id(), 403);
        $this->set = $set;

        $this->srsService->initializeProgress(auth()->user(), $this->set);
        $this->prepareQueue();
    }

    public function flipCard(): void
    {
        if ($this->completed || $this->total === 0) {
            return;
        }

        $this->showBack = !$this->showBack;
    }

    public function submitRating(string $rating): void
    {
        if (!in_array($rating, ['again', 'hard', 'good', 'easy'], true)) {
            return;
        }

        if ($this->completed || !isset($this->queueIds[$this->currentIndex])) {
            return;
        }

        $progress = SrsProgress::with('vocabulary')
            ->where('user_id', auth()->id())
            ->findOrFail($this->queueIds[$this->currentIndex]);

        $calculated = $this->srsService->calculate(
            easeFactor: (float) $progress->ease_factor,
            intervalDays: (int) $progress->interval_days,
            repetitions: (int) $progress->repetitions,
            rating: $rating
        );

        $progress->update([
            ...$calculated,
            'last_reviewed_at' => now(),
        ]);

        StudyLog::create([
            'user_id' => auth()->id(),
            'vocabulary_id' => $progress->vocabulary_id,
            'rating' => $rating,
            'studied_at' => now(),
        ]);

        $this->ratingSummary[$rating]++;
        $this->showBack = false;
        $this->currentIndex++;

        if ($this->currentIndex >= $this->total) {
            $this->completed = true;
            return;
        }
    }

    public function restartSession(): void
    {
        $this->completed = false;
        $this->showBack = false;
        $this->currentIndex = 0;
        $this->ratingSummary = [
            'again' => 0,
            'hard' => 0,
            'good' => 0,
            'easy' => 0,
        ];
        $this->prepareQueue();
    }

    public function render()
    {
        return view('livewire.learning.flash-card', [
            'currentProgress' => $this->getCurrentProgress(),
        ]);
    }

    private function prepareQueue(): void
    {
        $progresses = SrsProgress::query()
            ->where('user_id', auth()->id())
            ->whereHas('vocabulary', fn ($q) => $q->where('set_id', $this->set->id))
            ->orderByRaw("CASE status WHEN 'new' THEN 0 WHEN 'learning' THEN 1 WHEN 'review' THEN 2 ELSE 3 END")
            ->orderBy('next_review_at')
            ->limit(50)
            ->get();

        $this->queueIds = $progresses->pluck('id')->all();
        $this->total = count($this->queueIds);
    }

    private function getCurrentProgress(): ?SrsProgress
    {
        if ($this->completed || !isset($this->queueIds[$this->currentIndex])) {
            return null;
        }

        return SrsProgress::with('vocabulary')
            ->where('user_id', auth()->id())
            ->find($this->queueIds[$this->currentIndex]);
    }
}

