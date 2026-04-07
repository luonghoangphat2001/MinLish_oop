<?php

namespace Tests\Feature\Vocabulary;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Jobs\SendReviewReminderJob;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use App\Models\SrsProgress;
use Illuminate\Support\Facades\Artisan;

class T24ReviewReminderTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed --class=DatabaseSeeder');
        $this->user = User::factory()->create(['last_study_date' => now()->subDays(2)]);
    }

    /** @test */
    public function job_selects_users_with_overdue_review_words()
    {
        SrsProgress::factory()->create([
            'user_id' => $this->user->id,
            'next_review_at' => now()->subDay()
        ]);

        Queue::fake();
        $job = new SendReviewReminderJob();

        $this->assertTrue($job->shouldSendToUser($this->user)); // Expected method
    }

    /** @test */
    public function sends_review_reminder_for_users_with_overdue_words()
    {
        Notification::fake();

        $job = new SendReviewReminderJob();
        $job->handle();

        Notification::assertSentTimes(1);
    }

    /** @test */
    public function does_not_send_if_no_overdue_reviews()
    {
        SrsProgress::factory()->create([
            'user_id' => $this->user->id,
            'next_review_at' => now()->addDay()
        ]);

        Notification::fake();
        $job = new SendReviewReminderJob();
        $job->handle();

        Notification::assertNotSent();
    }

    /** @test */
    public function scheduled_at_18h_daily()
    {
        Queue::fake();
        Artisan::call('schedule:run');

        Queue::assertPushed(SendReviewReminderJob::class, 1);
    }
}

