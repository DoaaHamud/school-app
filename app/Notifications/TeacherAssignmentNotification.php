<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TeacherAssignmentNotification extends Notification
{
    use Queueable;

    public function __construct(
        private string $className,
        private int $studentCount
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $studentText = $this->studentCount === 1 ? 'طفل جديد' : 'أطفال جدد';

        return [
            'class' => $this->className,
            'student_count' => $this->studentCount,
            'message' => "تم إسناد {$this->studentCount} {$studentText} من صف {$this->className} إليكِ.",
        ];
    }
}
