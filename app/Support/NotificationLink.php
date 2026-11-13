<?php

namespace App\Support;

/**
 * Single source of truth for where a notification leads.
 *
 * Three different places need this answer — the bell dropdown, the /notifications/poll
 * endpoint, and the background push payload. They had drifted apart before,
 * which is how chat notifications ended up pointing at "#".
 */
class NotificationLink
{
    /**
     * @param  array<string,mixed>  $data  the notification's stored data
     */
    public static function for(array $data): ?string
    {
        if (isset($data['task_id'])) {
            return route('tasks.index') . '?open_task=' . $data['task_id'];
        }

        if (isset($data['conversation_id'])) {
            return route('chat.index') . '?c=' . $data['conversation_id'];
        }

        return null;
    }

    /** Same as for(), but never null — for href attributes that must go somewhere. */
    public static function orDashboard(array $data): string
    {
        return self::for($data) ?? route('dashboard');
    }
}
