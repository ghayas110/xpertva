<?php

namespace App\Notifications\Channels;

use App\Models\PushSubscription;
use App\Services\WebPush;
use App\Support\NotificationLink;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

/**
 * Delivers a notification to the recipient's registered browsers so it arrives
 * even when the portal is closed. Add it alongside 'database' in a
 * notification's via() and it will reuse that notification's toArray() data,
 * or a toWebPush() method if one is defined.
 *
 * Every failure mode here is swallowed. These notifications are raised inside
 * ordinary requests — a visitor sending a chat message, an admin assigning a
 * task — and a push service being slow or a missing table must never turn into
 * a 500 for that person.
 */
class WebPushChannel
{
    /** A subscription that keeps failing for non-fatal reasons is dropped at this point. */
    private const MAX_FAILURES = 5;

    public function __construct(private WebPush $push)
    {
    }

    public function send(object $notifiable, Notification $notification): void
    {
        try {
            $this->deliver($notifiable, $notification);
        } catch (\Throwable $e) {
            Log::warning('Background push notification failed', [
                'notification' => get_class($notification),
                'error'        => $e->getMessage(),
            ]);
        }
    }

    private function deliver(object $notifiable, Notification $notification): void
    {
        if (!$this->push->isConfigured()) {
            return; // No VAPID keys: the portal falls back to in-page alerts.
        }

        if (!Schema::hasTable('push_subscriptions')) {
            return; // Migration not run on this environment yet.
        }

        if (!method_exists($notifiable, 'getKey')) {
            return;
        }

        $subscriptions = PushSubscription::where('user_id', $notifiable->getKey())->get();
        if ($subscriptions->isEmpty()) {
            return;
        }

        $data = $this->dataFor($notifiable, $notification);
        if ($data === []) {
            return;
        }

        $payload = [
            // The same tag the in-page notifier uses, so that a notification
            // which arrives by both routes replaces itself rather than
            // appearing twice in the tray.
            'tag'   => 'xpertva-' . ($notification->id ?? uniqid()),
            'title' => $data['title']   ?? 'XpertVA',
            'body'  => $data['message'] ?? '',
            'url'   => $this->relative(NotificationLink::for($data)),
        ];

        $results = $this->push->send($subscriptions, $payload);

        $this->prune($subscriptions, $results);
    }

    /**
     * Reduce the destination to a path.
     *
     * The service worker resolves it against its own origin, which makes the
     * link immune to an APP_URL that does not match the live hostname — a push
     * is the one place a wrong absolute URL cannot be noticed and corrected,
     * because it opens a window on a device nobody is looking at.
     */
    private function relative(?string $url): ?string
    {
        if ($url === null) {
            return null;
        }

        $parts = parse_url($url);
        if ($parts === false || !isset($parts['path'])) {
            return $url;
        }

        return $parts['path']
            . (isset($parts['query']) ? '?' . $parts['query'] : '')
            . (isset($parts['fragment']) ? '#' . $parts['fragment'] : '');
    }

    /**
     * Prefer a notification's own toWebPush(), fall back to the data it already
     * stores in the database so existing notifications need no changes.
     *
     * @return array<string,mixed>
     */
    private function dataFor(object $notifiable, Notification $notification): array
    {
        if (method_exists($notification, 'toWebPush')) {
            return (array) $notification->toWebPush($notifiable);
        }

        if (method_exists($notification, 'toArray')) {
            return (array) $notification->toArray($notifiable);
        }

        return [];
    }

    /**
     * Keep the table honest. A push service answers 404 or 410 once the browser
     * has discarded a subscription — that one is gone for good and is deleted
     * at once. Anything else (a timeout, a 500 at the push service) is counted,
     * and only after it keeps happening is the row given up on.
     *
     * @param  \Illuminate\Support\Collection<int,PushSubscription>  $subscriptions
     * @param  array<string,int>  $results
     */
    private function prune($subscriptions, array $results): void
    {
        foreach ($subscriptions as $subscription) {
            $status = $results[$subscription->endpoint] ?? null;

            if ($status === null) {
                continue; // Never attempted (malformed row).
            }

            if ($status === 404 || $status === 410) {
                $subscription->delete();
                continue;
            }

            if ($status >= 200 && $status < 300) {
                $subscription->forceFill([
                    'failures'     => 0,
                    'last_used_at' => now(),
                ])->save();
                continue;
            }

            if ($subscription->failures + 1 >= self::MAX_FAILURES) {
                $subscription->delete();
                continue;
            }

            $subscription->increment('failures');
        }
    }
}
