<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public int $new_words_per_day = 10;
    public int $review_words_per_day = 20;

    public function mount(): void
    {
        $goal = Auth::user()->dailyGoal;

        if ($goal) {
            $this->new_words_per_day    = $goal->new_words_per_day;
            $this->review_words_per_day = $goal->review_words_per_day;
        }
    }

    public function save(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'new_words_per_day'    => ['required', 'integer', 'min:1', 'max:100'],
            'review_words_per_day' => ['required', 'integer', 'min:0', 'max:200'],
        ]);

        $user->dailyGoal()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        session()->flash('status', 'goal-saved');
    }
};
?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Mục tiêu học tập') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Đặt số từ mới và ôn tập mỗi ngày để lập kế hoạch học tập phù hợp.') }}
        </p>
    </header>

    <form wire:submit="save" class="mt-6 space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <x-input-label for="new_words_per_day" :value="__('Từ mới mỗi ngày')" />
                <x-text-input
                    wire:model="new_words_per_day"
                    id="new_words_per_day"
                    name="new_words_per_day"
                    type="number"
                    min="1"
                    max="100"
                    class="mt-1 block w-full"
                    required
                />
                <x-input-error class="mt-2" :messages="$errors->get('new_words_per_day')" />
            </div>

            <div>
                <x-input-label for="review_words_per_day" :value="__('Từ ôn mỗi ngày')" />
                <x-text-input
                    wire:model="review_words_per_day"
                    id="review_words_per_day"
                    name="review_words_per_day"
                    type="number"
                    min="0"
                    max="200"
                    class="mt-1 block w-full"
                    required
                />
                <x-input-error class="mt-2" :messages="$errors->get('review_words_per_day')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Lưu mục tiêu') }}</x-primary-button>

            @if (session('status') === 'goal-saved')
                <p class="text-sm text-green-600">{{ __('Đã lưu mục tiêu.') }}</p>
            @endif
        </div>
    </form>
</section>
