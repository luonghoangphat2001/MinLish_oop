<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InactivityGuiltTripNotification extends Notification
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
        return (new MailMessage)
            ->subject('😢 Min nhớ bạn...')
            ->greeting('Chào ' . $notifiable->name . '!')
            ->line('Hôm qua bạn không đến, hôm nay cũng vậy...')
            ->line('Phải chăng bạn đã quên Min rồi? Đừng bỏ rơi Min nhé, con đường chinh phục tiếng Anh vẫn đang chờ bạn.')
            ->line('Dành chỉ 5 phút hôm nay thôi để không bị quên kiến thức nhé!')
            ->action('Quay lại học cùng Min', url('/dashboard'))
            ->line('Min vẫn luôn ở đây chờ bạn!')
            ->line('Cảm ơn bạn đã đồng hành cùng MinLish.');
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'Min nhớ bạn! Hãy quay lại học nhé.',
            'type' => 'guilt_trip',
        ];
    }
}
