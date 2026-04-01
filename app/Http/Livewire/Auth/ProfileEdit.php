<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProfileEdit extends Component
{
    public string $name    = '';
    public string $level   = 'A1';
    public string $goal    = '';
    public int $new_words  = 10;
    public int $review_words = 20;

    protected array $rules = [
        'name'          => 'required|string|max:255',
        'level'         => 'required|in:A1,A2,B1,B2,C1,C2',
        'goal'          => 'nullable|string|max:100',
        'new_words'     => 'required|integer|min:1|max:100',
        'review_words'  => 'required|integer|min:1|max:200',
    ];

    public function mount(): void
    {
        $user = Auth::user();
        $this->name  = $user->name;
        $this->level = $user->level ?? 'A1';
        $this->goal  = $user->goal ?? '';

        $goal = $user->dailyGoal;
        if ($goal) {
            $this->new_words    = $goal->new_words_per_day;
            $this->review_words = $goal->review_words_per_day;
        }
    }

    public function save(): void
    {
        $this->validate();

        $user = Auth::user();
        $user->update([
            'name'  => $this->name,
            'level' => $this->level,
            'goal'  => $this->goal,
        ]);

        $user->dailyGoal()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'new_words_per_day'    => $this->new_words,
                'review_words_per_day' => $this->review_words,
            ]
        );

        session()->flash('message', 'Đã lưu hồ sơ thành công!');
    }

    public function render()
    {
        return view('livewire.auth.profile-edit');
    }
}
