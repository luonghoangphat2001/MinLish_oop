<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class DailyStudyReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public int $reviewCount;

    /**
     * T23 - Ghi chú Lead: Template EMAIL nhắc học HÀNG NGÀY.
     *
     * **Nội dung động:**
     * - reviewCount: Số từ SRS quá hạn
     * - Chào tên user
     * - Link dashboard CTA
     *
     * **Kênh:** Mail queue (infra T23)
     * **Phong cách:** Thân thiện, động viên
     */
    public function __construct(int $reviewCount)
    {
        $this->reviewCount = $reviewCount;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $appUrl = config('app.url');
        $reviewText = $this->reviewCount > 0
            ? "Bạn có {$this->reviewCount} từ cần ôn tập hôm nay!"
            : "Hãy học một vài từ mới để duy trì streak nhé!";

        return (new MailMessage)
            ->subject('🧠 Nhắc học MinLish - ' . now()->format('d/m'))
            ->greeting('Chào ' . $notifiable->name . '!')
            ->line('Cảm ơn bạn đã sử dụng MinLish để học từ vựng.')
            ->line($reviewText)
            ->line('Học đều đặn 15-30 phút mỗi ngày sẽ giúp bạn nhớ lâu hơn!')
            ->action('Học ngay hôm nay', $appUrl . '/dashboard')
            ->line('Streak của bạn đang chờ bạn tiếp tục...')
            ->line('Trân trọng,')
            ->line('MinLish Team');
    }
}

