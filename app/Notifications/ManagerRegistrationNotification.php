<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ManagerRegistrationNotification extends Notification
{
    use Queueable;

    public function __construct(private User $manager) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'manager_id' => $this->manager->id,
            'manager_name' => $this->manager->name,
            'message' => "طلب تسجيل مدير جديد: {$this->manager->name}",
        ];
    }
}
