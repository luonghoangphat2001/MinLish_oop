<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
    public function getListeners()
    {
        return [
            "echo-notification:App.Models.User." . Auth::id() . ",notification" => '$refresh',
        ];
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
    }

    public function deleteNotification($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->delete();
        }
    }

    public function render()
    {
        $notifications = Auth::user()->notifications()->latest()->take(10)->get();
        $unreadCount = Auth::user()->unreadNotifications()->count();

        return view('livewire.dashboard.notification-bell', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }
}
