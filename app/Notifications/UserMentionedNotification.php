<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\Task;
use App\Models\User;

class UserMentionedNotification extends Notification
{
    use Queueable;

    public $task;
    public $mentioner;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task, User $mentioner)
    {
        $this->task = $task;
        $this->mentioner = $mentioner;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Store in DB so it shows in the bells dropdown
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'mention',
            'title' => 'You were mentioned',
            'message' => "{$this->mentioner->name} mentioned you in task: {$this->task->title}",
            'task_id' => $this->task->id,
            'icon' => 'fa-solid fa-at'
        ];
    }
}
