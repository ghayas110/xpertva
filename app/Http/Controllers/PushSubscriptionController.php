<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
use App\Services\WebPush;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

/**
 * Registers and removes the browser subscriptions that background
 * notifications are delivered to.
 */
class PushSubscriptionController extends Controller
{
    public function __construct(private WebPush $push)
    {
    }

    /**
     * Store (or re-point) one browser's subscription.
     *
     * Keyed on the endpoint, not on the user: if two people share a device the
     * browser hands out the same endpoint, and it must end up belonging to
     * whoever is signed in now, otherwise one operator receives the other's
     * notifications.
     */
    public function store(Request $request): JsonResponse
    {
        if (!$this->push->isConfigured() || !Schema::hasTable('push_subscriptions')) {
            return response()->json(['ok' => false, 'reason' => 'not_configured'], 503);
        }

        $data = $request->validate([
            'endpoint' => ['required', 'string', 'max:2000', 'starts_with:https://'],
            'p256dh'   => ['required', 'string', 'max:255'],
            'auth'     => ['required', 'string', 'max:255'],
        ]);

        // Reject keys the encryption step would only choke on later.
        if (strlen(WebPush::b64urlDecode($data['p256dh'])) !== 65) {
            return response()->json(['ok' => false, 'reason' => 'bad_key'], 422);
        }
        if (strlen(WebPush::b64urlDecode($data['auth'])) !== 16) {
            return response()->json(['ok' => false, 'reason' => 'bad_auth'], 422);
        }

        PushSubscription::updateOrCreate(
            ['endpoint_hash' => PushSubscription::hashFor($data['endpoint'])],
            [
                'user_id'      => $request->user()->getKey(),
                'endpoint'     => $data['endpoint'],
                'p256dh'       => $data['p256dh'],
                'auth'         => $data['auth'],
                'user_agent'   => substr((string) $request->userAgent(), 0, 255),
                'failures'     => 0,
                'last_used_at' => now(),
            ]
        );

        return response()->json(['ok' => true]);
    }

    /** Forget a subscription the browser has just discarded. */
    public function destroy(Request $request): JsonResponse
    {
        $endpoint = (string) $request->input('endpoint');

        if ($endpoint !== '' && Schema::hasTable('push_subscriptions')) {
            PushSubscription::where('endpoint_hash', PushSubscription::hashFor($endpoint))
                ->where('user_id', $request->user()->getKey())
                ->delete();
        }

        return response()->json(['ok' => true]);
    }

    /**
     * Send the signed-in user a push right now.
     *
     * This is the only way to honestly confirm background delivery works:
     * close the portal, then have it fire. It reports the push service's own
     * status codes so a misconfiguration is visible rather than silent.
     */
    public function test(Request $request): JsonResponse
    {
        if (!$this->push->isConfigured()) {
            return response()->json(['ok' => false, 'reason' => 'not_configured'], 503);
        }

        if (!Schema::hasTable('push_subscriptions')) {
            return response()->json(['ok' => false, 'reason' => 'no_table'], 503);
        }

        $subscriptions = PushSubscription::where('user_id', $request->user()->getKey())->get();

        if ($subscriptions->isEmpty()) {
            return response()->json(['ok' => false, 'reason' => 'no_subscriptions'], 404);
        }

        $results = $this->push->send($subscriptions, [
            'tag'   => 'xpertva-test',
            'title' => 'Background notifications are working',
            'body'  => 'You will now be alerted about new website chats even with the portal closed.',
            'url'   => '/dashboard',
        ]);

        $delivered = count(array_filter($results, fn ($status) => $status >= 200 && $status < 300));

        return response()->json([
            'ok'        => $delivered > 0,
            'devices'   => count($results),
            'delivered' => $delivered,
            'statuses'  => array_values($results),
        ]);
    }
}
