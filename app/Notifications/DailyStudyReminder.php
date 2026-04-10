<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DailyStudyReminder extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $reviewCount = DB::table('srs_progress')
            ->where('user_id', $notifiable->id)
            ->where('next_review_at', '<=', Carbon::today())
            ->where('status', '!=', 'mastered')
            ->count();

        $streak = $notifiable->streak_days ?? 0;
        $streakText = $streak > 0 ? "Chuỗi **{$streak} ngày** của bạn đang chờ được nối tiếp!" : "Bắt đầu hành trình chinh phục tiếng Anh ngay hôm nay!";

        return (new MailMessage)
            ->subject('🔥 Đừng để chuỗi ngày học của bạn bị đứt quãng!')
            ->greeting('Chào ' . $notifiable->name . '!')
            ->line('Vẫy tay chào ngày mới! ' . $streakText)
            ->line('Một chút nỗ lực mỗi ngày sẽ mang lại thành công lớn. Hãy dành 10-15 phút để ôn tập nhé!')
            ->line("Hiện có **{$reviewCount}** từ vựng đang chờ bạn ôn luyện.")
            ->action('Học ngay thôi nào!', url('/dashboard'))
            ->line('Hẹn gặp lại bạn trong bài học!')
            ->line('Team MinLish');
    }
}
