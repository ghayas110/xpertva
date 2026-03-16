<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TaskAssignedNotification extends Notification
{
    use Queueable;

    protected $task;
    protected $assignedBy;

    public function __construct($task, $assignedBy)
    {
        $this->task = $task;
        $this->assignedBy = $assignedBy;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Task Assigned',
            'message' => 'You have been assigned a new task: "' . $this->task->title . '"',
            'task_id' => $this->task->id,
            'assigned_by' => $this->assignedBy->name,
            'icon' => 'fa-solid fa-list-check',
            'color' => 'blue',
        ];
    }
}
