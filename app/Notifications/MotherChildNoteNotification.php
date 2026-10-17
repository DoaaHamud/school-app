<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\chaldrin;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MotherChildNoteNotification extends Notification
{
    use Queueable;

    public function __construct(
        private chaldrin $child,
        private User $mother,
        private string $note
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'mother_child_note',
            'child_id' => $this->child->id,
            'child_name' => $this->child->name,
            'mother_name' => $this->mother->name,
            'note' => $this->note,
            'message' => "وصلتك ملاحظة من {$this->mother->name} بخصوص الطفل {$this->child->name}.",
        ];
    }
}
