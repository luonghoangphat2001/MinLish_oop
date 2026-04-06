<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\DailyStudyReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class SendDailyReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * T23 - Ghi chú Lead: Job gửi email nhắc NHÁC HỌC HÀNG NGÀY lúc **8h sáng**.
     *
     * **Luồng:**
     * 1. Tìm users: last_study_date NULL HOẶC < hôm nay
     * 2. Với mỗi user: Đếm từ SRS quá hạn (next_review_at <= bây giờ)
     * 3. Gửi batch notification (cursor, tiết kiệm RAM)
     * 4. Log thành công/lỗi (Laravel log)
     *
     * **Retry:** 3 lần tự động
     * **Hiệu suất:** Cursor + lazy count
     * **Lên lịch:** Kernel dailyAt('08:00')
     */
    public function handle(): void
    {
        $yesterday = \Carbon\Carbon::now()->subDay()->startOfDay();

        $users = User::where(function ($query) use ($yesterday) {
                $query->whereNull('last_study_date')
                      ->orWhereDate('last_study_date', '<', $yesterday);
            })
            ->cursor();

        $sentCount = 0;

        foreach ($users as $user) {
            try {
                $reviewCount = $user->srsProgress()
                    ->where('next_review_at', '<=', \Carbon\Carbon::now())
                    ->count();

                $user->notify(new DailyStudyReminder($reviewCount));
                $sentCount++;

                \Illuminate\Support\Facades\Log::info('Daily reminder sent', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'review_count' => $reviewCount
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Daily reminder failed', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        \Illuminate\Support\Facades\Log::info('Daily reminder batch complete', ['sent' => $sentCount]);
    }
}

