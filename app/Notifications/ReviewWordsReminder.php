<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReviewWordsReminder extends Notification
{
    use Queueable;

    public int $overdueCount;
    public array $setsWithOverdue;

    /**
     * T24 - Ghi chú Lead: Email nhắc ÔN từ QUÁ HẠN.
     *
     * **Params:**
     * - overdueCount: Số từ cần ôn
     * - setsWithOverdue: Array sets cần ôn (name list)
     *
     * **Content:** List sets + motivation + dashboard CTA
     * **Via:** Mail queue (T23/T24 infra)
     */
    public function __construct(int $overdueCount, array $setsWithOverdue)
    {
        $this->overdueCount = $overdueCount;
        $this->setsWithOverdue = $setsWithOverdue;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $setsList = collect($this->setsWithOverdue)->pluck('name')->join(', ');

        return (new MailMessage)
            ->subject('👋 ' . $notifiable->name . '! ' . $this->overdueCount . ' từ vựng đang chờ ôn tập 📚')
            ->greeting('Xin chào ' . $notifiable->name . '!')
            ->line('Hy vọng bạn có một ngày học tập hiệu quả! ☀️')
            ->line('---')
            ->line('🔔 **Nhắc nhở ôn tập**')
            ->line('Bạn hiện có **' . $this->overdueCount . ' từ** cần ôn vì đã quá hạn theo lịch SRS.')
            ->line('**Các bộ từ:** ' . $setsList)
            ->line('---')
            ->line('💡 **Tại sao cần ôn ngay?**')
            ->line('- Duy trì streak học tập liên tục')
            ->line('- Củng cố trí nhớ theo đường cong quên lãng')
            ->line('- Đạt mục tiêu từ vựng hàng tháng')
            ->line('---')
            ->line('⏰ **Chỉ mất 5-10 phút**')
            ->action('Ôn ngay bây giờ', url('/dashboard'))
            ->line('---')
            ->line('MinLish - Người bạn đồng hành học tiếng Anh 💙')
            ->line('P.S. Streak hôm nay đang chờ bạn đấy!');
    }
}

