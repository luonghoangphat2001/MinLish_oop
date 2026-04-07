<?php

namespace Tests\Feature\Vocabulary;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Jobs\SendDailyReminderJob;
use App\Notifications\DailyStudyReminder;
use App\Models\StudyLog;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Artisan;

class T23DailyReminderTest extends TestCase
{
    use RefreshDatabase;

    private User $user1;
    private User $user2;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed --class=DatabaseSeeder');
        $this->user1 = User::factory()->create(['last_study_date' => null]);
        $this->user2 = User::factory()->create(['last_study_date' => now()->subDay()]);
    }

    /** @test */
    public function job_selects_users_who_havent_studied_today()
    {
        // user1: no study today, should receive
        // user2: studied yesterday, should receive
        // Create user who studied today (should not receive)
        $studiedToday = User::factory()->create(['last_study_date' => now()]);

        Queue::fake();
        $job = new SendDailyReminderJob();

        $this->assertCount(2, $job->usersNeedingReminder()); // Custom method or query in job
    }

    /** @test */
    public function sends_daily_study_reminder_notification_to_eligible_users()
    {
        Notification::fake();

        $job = new SendDailyReminderJob();
        $job->handle();

        Notification::assertSentTo(
            $this->user1,
            DailyStudyReminder::class
        );
        Notification::assertSentTo(
            $this->user2,
            DailyStudyReminder::class
        );
    }

    /** @test */
    public function job_is_queued_on_schedule()
    {
        Queue::fake();

        Artisan::call('schedule:run');

        Queue::assertPushed(SendDailyReminderJob::class);
    }

    /** @test */
    public function notification_contains_correct_reminder_content()
    {
        Notification::fake();

        $notification = new DailyStudyReminder($this->user1);
        $mail = $notification->toMail($this->user1);

        $this->assertStringContainsString('học HÀNG NGÀY', $mail->render());
        $this->assertStringContainsString('dashboard', $mail->render());
    }

    /** @test */
    public function does_not_send_to_users_who_studied_today()
    {
        $studiedToday = User::factory()->create(['last_study_date' => now()]);

        Notification::fake();
        $job = new SendDailyReminderJob();
        $job->handle();

        Notification::assertNotSentTo($studiedToday, DailyStudyReminder::class);
    }
}

