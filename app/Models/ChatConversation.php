<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ChatConversation extends Model
{
    protected $fillable = [
        'token', 'name', 'email', 'phone', 'page_url',
        'status', 'assigned_to', 'unread_for_agent', 'unread_for_visitor', 'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public static function startFresh(array $attributes = []): self
    {
        return static::create($attributes + [
            'token'           => Str::random(48),
            'status'          => 'open',
            'last_message_at' => now(),
        ]);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'conversation_id');
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function displayName(): string
    {
        return $this->name ?: 'Visitor ' . substr($this->token, 0, 6);
    }
}
