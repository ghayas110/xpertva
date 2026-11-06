<?php

namespace App\Notifications;

use App\Models\ChatConversation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewChatMessageNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected ChatConversation $conversation,
        protected string $body,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title'           => 'Website chat: ' . $this->conversation->displayName(),
            'message'         => Str::limit($this->body, 90),
            'icon'            => 'fa-solid fa-comments',
            'color'           => 'indigo',
            'kind'            => 'chat',
            'conversation_id' => $this->conversation->id,
        ];
    }
}
