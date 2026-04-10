<?php

namespace Tests\Feature\Learning;

use App\Livewire\Learning\DailyQuiz;
use App\Models\DailyGoal;
use App\Models\User;
use App\Models\Vocabulary;
use App\Models\VocabularySet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DailyQuizTest extends TestCase
{
    use RefreshDatabase;

    public function test_daily_quiz_page_can_be_rendered(): void
    {
        $user = User::factory()->create();
        DailyGoal::create([
            'user_id' => $user->id,
            'new_words_per_day' => 10,
            'review_words_per_day' => 20,
            'daily_quiz_words_per_day' => 25,
        ]);

        $response = $this->actingAs($user)->get(route('learning.daily-quiz'));

        $response->assertOk()->assertSee('Daily Quiz');
    }

    public function test_daily_quiz_submission_creates_log_and_updates_streak(): void
    {
        $user = User::factory()->create([
            'streak_days' => 0,
            'last_study_date' => null,
        ]);

        $set = VocabularySet::factory()->create(['user_id' => $user->id]);
        $word = Vocabulary::factory()->create([
            'set_id' => $set->id,
            'meaning' => 'nước',
        ]);

        $this->actingAs($user);

        Livewire::test(DailyQuiz::class)
            ->set('wordIds', [$word->id])
            ->set('total', 1)
            ->set('currentIndex', 0)
            ->set('answer', 'nước')
            ->call('submitAnswer')
            ->assertSet('completed', true)
            ->assertSet('correctCount', 1);

        $this->assertDatabaseHas('study_logs', [
            'user_id' => $user->id,
            'vocabulary_id' => $word->id,
            'rating' => 'good',
        ]);

        $user->refresh();
        $this->assertSame(1, (int) $user->streak_days);
        $this->assertNotNull($user->last_study_date);
    }
}
