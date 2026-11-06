<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    protected $fillable = ['conversation_id', 'sender', 'user_id', 'body', 'read_at'];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(ChatConversation::class, 'conversation_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Shape sent to both the widget and the portal inbox. */
    public function toWire(): array
    {
        return [
            'id'     => $this->id,
            'sender' => $this->sender,
            'author' => $this->sender === 'agent' ? ($this->user->name ?? 'XpertVA') : null,
            'body'   => $this->body,
            'at'     => $this->created_at->toIso8601String(),
            'time'   => $this->created_at->format('g:i A'),
        ];
    }
}
