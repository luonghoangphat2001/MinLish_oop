<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReviewWordsReminder extends Notification
{
    use Queueable;

    public function __construct(
        public int $overdueCount,
        public array $sets
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $setsList = collect($this->sets)->pluck('name')->implode(', ');

        return (new MailMessage)
            ->subject('⚠️ Nhắc nhở ôn từ vựng quá hạn - MinLish')
            ->greeting('Chào ' . $notifiable->name . '!')
            ->line('Bạn có **' . $this->overdueCount . '** từ vựng cần ôn tập quá hạn!')
            ->line('Các bộ từ: ' . $setsList)
            ->action('Ôn tập ngay', url('/dashboard'))
            ->line('Đừng để từ vựng "ngủ quên" nhé!')
            ->line('Team MinLish');
    }
}
