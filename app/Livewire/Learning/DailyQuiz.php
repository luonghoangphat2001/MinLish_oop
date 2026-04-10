<?php

namespace App\Livewire\Learning;

use App\Models\StudyLog;
use App\Models\Vocabulary;
use App\Models\VocabularySet;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Livewire\Component;

class DailyQuiz extends Component
{
    public array $wordIds = [];
    public int $currentIndex = 0;
    public int $total = 0;
    public bool $completed = false;
    public string $answer = '';
    public ?bool $lastCorrect = null;
    public int $correctCount = 0;
    public int $wrongCount = 0;
    public int $quizLimit = 25;

    public array $results = [];

    public function mount(): void
    {
        $user = request()->user();
        abort_if(!$user, 403);

        $this->quizLimit = (int) ($user->dailyGoal?->daily_quiz_words_per_day ?? 25);
        $this->prepareQuiz();
    }

    public function submitAnswer(): void
    {
        if ($this->completed || !isset($this->wordIds[$this->currentIndex])) {
            return;
        }

        $this->validate([
            'answer' => 'required|string|max:1000',
        ]);

        $user = request()->user();
        abort_if(!$user, 403);

        $word = Vocabulary::with('set')->find($this->wordIds[$this->currentIndex]);
        if (!$word) {
            $this->completed = true;
            return;
        }

        $isCorrect = $this->isAnswerCorrect($this->answer, $word->meaning);

        StudyLog::create([
            'user_id' => $user->id,
            'vocabulary_id' => $word->id,
            'rating' => $isCorrect ? 'good' : 'again',
            'studied_at' => now(),
        ]);

        $this->results[] = [
            'word' => $word->word,
            'meaning' => $word->meaning,
            'answer' => $this->answer,
            'set' => $word->set?->name ?? '',
            'is_correct' => $isCorrect,
        ];

        if ($isCorrect) {
            $this->correctCount++;
        } else {
            $this->wrongCount++;
        }

        $this->lastCorrect = $isCorrect;
        $this->currentIndex++;
        $this->answer = '';

        if ($this->currentIndex >= $this->total) {
            $this->completed = true;
        }
    }

    public function restart(): void
    {
        $this->wordIds = [];
        $this->currentIndex = 0;
        $this->total = 0;
        $this->completed = false;
        $this->answer = '';
        $this->lastCorrect = null;
        $this->correctCount = 0;
        $this->wrongCount = 0;
        $this->results = [];

        $this->prepareQuiz();
    }

    public function render()
    {
        return view('livewire.learning.daily-quiz', [
            'currentWord' => $this->getCurrentWord(),
            'availableSets' => $this->getAvailableSetNames(),
            'progressPercent' => $this->total > 0
                ? (int) round(($this->currentIndex / $this->total) * 100)
                : 0,
        ]);
    }

    private function prepareQuiz(): void
    {
        $user = request()->user();
        abort_if(!$user, 403);

        $ids = Vocabulary::query()
            ->whereHas('set', fn ($q) => $q->where('user_id', $user->id))
            ->inRandomOrder()
            ->limit($this->quizLimit)
            ->pluck('id')
            ->all();

        $this->wordIds = $ids;
        $this->total = count($ids);
    }

    private function getCurrentWord(): ?Vocabulary
    {
        if ($this->completed || !isset($this->wordIds[$this->currentIndex])) {
            return null;
        }

        return Vocabulary::with('set')->find($this->wordIds[$this->currentIndex]);
    }

    private function getAvailableSetNames(): Collection
    {
        $user = request()->user();
        abort_if(!$user, 403);

        return VocabularySet::query()
            ->where('user_id', $user->id)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    private function isAnswerCorrect(string $answer, string $meaning): bool
    {
        $normalizedAnswer = $this->normalize($answer);
        $normalizedMeaning = $this->normalize($meaning);

        if ($normalizedAnswer === '' || $normalizedMeaning === '') {
            return false;
        }

        if ($normalizedAnswer === $normalizedMeaning) {
            return true;
        }

        $acceptedChunks = preg_split('/[,;\/|]+/u', $normalizedMeaning) ?: [];
        foreach ($acceptedChunks as $chunk) {
            if ($chunk === '') {
                continue;
            }

            if (Str::contains($chunk, $normalizedAnswer) || Str::contains($normalizedAnswer, $chunk)) {
                return true;
            }
        }

        return false;
    }

    private function normalize(string $value): string
    {
        $value = Str::lower(trim($value));
        $value = preg_replace('/\s+/u', ' ', $value) ?? '';
        return trim($value);
    }
}
