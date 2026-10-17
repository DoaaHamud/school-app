<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TeacherRegistrationNotification extends Notification
{
    use Queueable;

    public function __construct(private User $teacher) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'teacher_id' => $this->teacher->id,
            'teacher_name' => $this->teacher->name,
            'message' => "طلب انضمام معلم جديد: {$this->teacher->name}",
        ];
    }
}
