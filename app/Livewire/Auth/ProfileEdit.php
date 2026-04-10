<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProfileEdit extends Component
{
    public string $name = '';
    public string $level = 'A1';
    public string $goal = '';
    public int $new_words = 10;
    public int $review_words = 20;
    public int $daily_quiz_words = 25;

    protected array $rules = [
        'name' => 'required|string|max:255',
        'level' => 'required|in:A1,A2,B1,B2,C1,C2',
        'goal' => 'nullable|string|max:100',
        'new_words' => 'required|integer|min:1|max:100',
        'review_words' => 'required|integer|min:1|max:200',
        'daily_quiz_words' => 'required|integer|min:5|max:100',
    ];

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->level = $user->level ?? 'A1';
        $this->goal = $user->goal ?? '';

        $goal = $user->dailyGoal;
        if ($goal) {
            $this->new_words = (int) $goal->new_words_per_day;
            $this->review_words = (int) $goal->review_words_per_day;
            $this->daily_quiz_words = (int) ($goal->daily_quiz_words_per_day ?? 25);
        }
    }

    public function save(): void
    {
        $this->validate();

        $user = Auth::user();
        $user->update([
            'name' => $this->name,
            'level' => $this->level,
            'goal' => $this->goal,
        ]);

        $user->dailyGoal()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'new_words_per_day' => $this->new_words,
                'review_words_per_day' => $this->review_words,
                'daily_quiz_words_per_day' => $this->daily_quiz_words,
            ]
        );

        session()->flash('message', 'Đã lưu hồ sơ thành công!');
    }

    public function render()
    {
        return view('livewire.auth.profile-edit');
    }
}