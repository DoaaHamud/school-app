<?php

namespace App\Notifications;

use App\Models\SchoolMotherRequest;
use Illuminate\Notifications\Notification;

class SchoolMotherRequestNotification extends Notification
{
    public function __construct(
        private SchoolMotherRequest $request,
        private string $event
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $isNewRequest = $this->event === 'request_created';

        return [
            'type' => $this->event,
            'request_id' => $this->request->id,
            'school_name' => $this->request->school?->name,
            'message' => $isNewRequest
                ? 'وصل طلب انضمام ولي أمر جديد إلى المدرسة.'
                : 'تم قبول طلب انضمامك إلى المدرسة.',
        ];
    }
}
