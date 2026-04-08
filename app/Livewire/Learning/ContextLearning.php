<?php

namespace App\Livewire\Learning;

use App\Models\SrsProgress;
use App\Models\StudyLog;
use App\Models\VocabularySet;
use App\Services\SpacedRepetitionService;
use Livewire\Component;

class ContextLearning extends Component
{
    public VocabularySet $set;
    public array $queueIds = [];
    public int $currentIndex = 0;
    public int $total = 0;
    public bool $showAnswer = false;
    public bool $completed = false;
    public string $userInput = '';
    public bool $isCorrect = false;
    public bool $hasChecked = false;
    public int $retryCount = 0;
    public string $hint = '';

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

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $this->srsService->initializeProgress($user, $this->set);
        $this->prepareQueue();
    }

    public function checkSpelling(): void
    {
        if ($this->hasChecked || $this->completed) {
            return;
        }

        $current = $this->getCurrentProgress();
        if (!$current) {
            return;
        }

        $word = $current->vocabulary->word;
        $correctWord = trim(strtolower($word));
        $inputWord = trim(strtolower($this->userInput));

        if ($inputWord === $correctWord) {
            $this->isCorrect = true;
            $this->showAnswer = true;
            $this->hasChecked = true;
        } else {
            $this->isCorrect = false;
            $this->retryCount++;
            
            if ($this->retryCount >= 3) {
                $this->showAnswer = true;
                $this->hasChecked = true;
            } else {
                $this->generateHint($word);
            }
            
            $this->dispatch('spelling-wrong');
        }
    }

    private function generateHint(string $word): void
    {
        $len = strlen($word);
        if ($this->retryCount === 1) {
            $this->hint = "Gợi ý 1: Từ bắt đầu bằng chữ '" . substr($word, 0, 1) . "'";
        } elseif ($this->retryCount === 2) {
            $this->hint = "Gợi ý 2: Từ có " . $len . " chữ cái, kết thúc bằng '" . substr($word, -1) . "'";
        }
    }

    public function revealAnswer(): void
    {
        $this->showAnswer = true;
        $this->hasChecked = true;
    }

    public function submitRating(string $rating): void
    {
        if (!in_array($rating, ['again', 'hard', 'good', 'easy'], true)) {
            return;
        }

        if ($this->completed || !isset($this->queueIds[$this->currentIndex])) {
            return;
        }

        $userId = auth()->id();
        $progress = SrsProgress::with('vocabulary')
            ->where('user_id', $userId)
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
            'user_id' => $userId,
            'vocabulary_id' => $progress->vocabulary_id,
            'rating' => $rating,
            'studied_at' => now(),
        ]);

        $this->ratingSummary[$rating]++;
        $this->nextWord();
    }

    private function nextWord(): void
    {
        $this->showAnswer = false;
        $this->isCorrect = false;
        $this->hasChecked = false;
        $this->retryCount = 0;
        $this->hint = '';
        $this->userInput = '';
        $this->currentIndex++;

        if ($this->currentIndex >= $this->total) {
            $this->completed = true;
            return;
        }
    }

    public function restartSession(): void
    {
        $this->completed = false;
        $this->showAnswer = false;
        $this->currentIndex = 0;
        $this->userInput = '';
        $this->isCorrect = false;
        $this->hasChecked = false;
        $this->retryCount = 0;
        $this->hint = '';
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
        $currentProgress = $this->getCurrentProgress();
        $maskedExample = '';
        
        if ($currentProgress && $currentProgress->vocabulary->example) {
            $word = $currentProgress->vocabulary->word;
            // Mask the word in the example sentence
            $maskedExample = preg_replace("/\b" . preg_quote($word, '/') . "\b/i", "________", $currentProgress->vocabulary->example);
        }

        return view('livewire.learning.context-learning', [
            'currentProgress' => $currentProgress,
            'maskedExample' => $maskedExample,
        ]);
    }

    private function prepareQueue(): void
    {
        $userId = auth()->id();
        $progresses = SrsProgress::query()
            ->where('user_id', $userId)
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

        $userId = auth()->id();
        return SrsProgress::with('vocabulary')
            ->where('user_id', $userId)
            ->find($this->queueIds[$this->currentIndex]);
    }
}
