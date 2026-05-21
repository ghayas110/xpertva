<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AttendanceClockInNotification extends Notification
{
    use Queueable;

    protected string $state;
    protected string $detail;

    public function __construct(string $state, string $detail)
    {
        $this->state  = $state;
        $this->detail = $detail;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $titles = [
            'on_time' => 'Clocked in — On Time',
            'late'    => 'Clocked in — Late',
            'early'   => 'Clocked in — Early',
        ];
        $icons = [
            'on_time' => 'fa-solid fa-circle-check',
            'late'    => 'fa-solid fa-triangle-exclamation',
            'early'   => 'fa-solid fa-clock',
        ];

        return [
            'title'   => $titles[$this->state] ?? 'Clocked in',
            'message' => $this->detail,
            'icon'    => $icons[$this->state] ?? 'fa-solid fa-clock',
            'color'   => $this->state === 'late' ? 'red' : 'green',
            'kind'    => 'attendance',
        ];
    }
}
