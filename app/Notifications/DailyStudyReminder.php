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
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $reviewCount = DB::table('srs_progress')
            ->where('user_id', $notifiable->id)
            ->where('next_review_at', '<=', Carbon::today())
            ->where('status', '!=', 'mastered')
            ->count();

        return (new MailMessage)
            ->subject('🔔 Nhắc nhở học từ vựng hàng ngày - MinLish')
            ->greeting('Chào ' . $notifiable->name . '!')
            ->line('Bạn chưa học từ vựng hôm nay. Hãy dành 15 phút để ôn tập nhé!')
            ->line("Có **{$reviewCount}** từ cần ôn tập đang chờ bạn.")
            ->action('Học ngay', url('/dashboard'))
            ->line('Cảm ơn bạn đã sử dụng MinLish!')
            ->line('Team MinLish');
    }
}
