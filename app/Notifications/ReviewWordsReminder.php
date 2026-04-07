<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;
use App\Models\VocabularySet;
use App\Models\User;

class ReviewWordsReminder extends Notification
{
    use Queueable;

    public $overdueSets;

    public function __construct(Collection $overdueSets)
    {
        $this->overdueSets = $overdueSets;
    }

    /**
     * T24 - Review overdue words reminder
     */

    public function via(User $notifiable)
    {
        return ['mail'];
    }

    public function toMail(User $notifiable)
    {
        $setsList = $this->overdueSets->pluck('name')->implode(', ');
        $totalOverdue = $this->overdueSets->sum(fn($set) => $set->vocabularies->count());

        return (new MailMessage)
            ->subject('Ôn từ quá hạn - MinLish')
            ->greeting('Chào ' . $notifiable->name . '!')
            ->line("Bạn có {$totalOverdue} từ quá hạn cần ôn từ các bộ: {$setsList}")
            ->line('Ôn ngay để không quên nhé!')
            ->action('Ôn tập ngay', url('/learning/today'))
            ->line('Dashboard tiến độ: ' . url('/dashboard'))
            ->line('Cố lên!')
            ->line('MinLish Team');
    }
}

