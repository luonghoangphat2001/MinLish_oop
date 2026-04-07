<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use App\Models\User;

class DailyStudyReminder extends Notification
{
    use Queueable;

    /**
     * T23 - Daily reminder template
     */

    public function via(User $notifiable)
    {
        return ['mail'];
    }

    public function toMail(User $notifiable)
    {
        $reviewsToday = $notifiable->srsProgress()->where('next_review_at', '<=', now())->count();

        return (new MailMessage)
            ->subject('🔔 Nhắc học MinLish hôm nay!')
            ->greeting('Chào ' . $notifiable->name . '!')
            ->line("Bạn chưa học từ vựng hôm nay. Có {$reviewsToday} từ cần ôn.")
            ->line('Chỉ 15 phút thôi! Mở app và bắt đầu ngay.')
            ->action('Học ngay', url('/learning/today'))
            ->line('Cố lên nhé! 💪')
            ->line('MinLish Team');
    }
}

