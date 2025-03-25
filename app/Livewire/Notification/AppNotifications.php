<?php

namespace App\Livewire\Notification;

use App\Models\Employee;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AppNotifications extends Component
{
    public function getNotifications()
    {
        $user = Employee::find(Auth::guard('employee')->user()->employee_id);

        return $user->unreadNotifications;
    }

    public function readNotification($notifiable_id, $notification_id)
    {
        $user = Employee::find($notifiable_id);

        $notification = $user->notifications()->where('id', $notification_id)->first();

        if ($notification) {
            $notification->markAsRead();
        }
    }

 
    public function readAll($notifiable_id)
    {
        $user = Employee::find($notifiable_id);

        $user->unreadNotifications->markAsRead();
    }

    public function render()
    {
        return view('livewire.notification.app-notifications');
    }
}
