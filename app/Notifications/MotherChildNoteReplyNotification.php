<?php

namespace App\Notifications;

use App\Models\MotherChildNote;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MotherChildNoteReplyNotification extends Notification
{
    use Queueable;

    public function __construct(private MotherChildNote $childNote) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'mother_child_note_reply',
            'child_note_id' => $this->childNote->id,
            'child_id' => $this->childNote->child_id,
            'child_name' => $this->childNote->child->name,
            'teacher_name' => $this->childNote->teacher->name,
            'message' => "ردّت المعلمة {$this->childNote->teacher->name} على ملاحظتك بخصوص الطفل {$this->childNote->child->name}.",
        ];
    }
}
