<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One browser's standing permission to receive background notifications.
 *
 * A user has one row per device/browser, not one row overall: an operator who
 * uses the portal on a phone and a laptop should be alerted on both.
 */
class PushSubscription extends Model
{
    protected $fillable = [
        'user_id', 'endpoint', 'endpoint_hash', 'p256dh', 'auth', 'user_agent', 'failures', 'last_used_at',
    ];

    protected $casts = [
        'last_used_at' => 'datetime',
        'failures'     => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function hashFor(string $endpoint): string
    {
        return hash('sha256', $endpoint);
    }
}
