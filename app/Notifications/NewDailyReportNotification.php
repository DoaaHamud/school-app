<?php

namespace App\Notifications;

use App\Models\Daily_variables;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewDailyReportNotification extends Notification
{
    use Queueable;

    public function __construct(private Daily_variables $report) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $child = $this->report->child;

        return [
            'child_id' => $child->id,
            'child_name' => $child->name,
            'topic' => $this->report->topic,
            'message' => "تمت إضافة تقرير جديد عن {$child->name}: {$this->report->topic}",
        ];
    }
}
