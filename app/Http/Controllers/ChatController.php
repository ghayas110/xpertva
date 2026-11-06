<?php

namespace App\Http\Controllers;

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Models\User;
use App\Notifications\NewChatMessageNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

/**
 * Public website chat. The visitor is anonymous; their conversation token is
 * held in localStorage and is the only credential, so every lookup is strictly
 * by token and nothing else is ever exposed.
 */
class ChatController extends Controller
{
    /** Roles that should be alerted when a visitor writes in. */
    private const AGENT_ROLES = ['super_admin', 'admin', 'sales', 'hr'];

    /**
     * Hand the widget a fresh CSRF token. The page HTML can be minutes or hours
     * old by the time someone types, and a stale token is the usual cause of a
     * "CSRF token mismatch" on a long lived page. Safe to expose: the token is
     * bound to the caller's own session and the same origin policy stops any
     * other site from reading this response.
     */
    public function token(Request $request): JsonResponse
    {
        return response()->json(['token' => csrf_token()]);
    }

    public function start(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'    => 'nullable|string|max:120',
            'email'   => 'nullable|email|max:190',
            'phone'   => 'nullable|string|max:40',
            'message' => 'required|string|max:2000',
            'page'    => 'nullable|string|max:255',
        ]);

        $conversation = ChatConversation::startFresh([
            'name'     => $data['name'] ?? null,
            'email'    => $data['email'] ?? null,
            'phone'    => $data['phone'] ?? null,
            'page_url' => $data['page'] ?? null,
        ]);

        $this->appendVisitorMessage($conversation, $data['message']);

        $conversation->messages()->create([
            'sender' => 'system',
            'body'   => 'Thanks for reaching out. One of our operators will reply here shortly. '
                      . 'If you would rather talk on WhatsApp, use the button above.',
        ]);

        return response()->json([
            'token'    => $conversation->token,
            'messages' => $conversation->messages()->orderBy('id')->get()
                              ->map(fn (ChatMessage $m) => $m->toWire()),
        ]);
    }

    public function send(Request $request, string $token): JsonResponse
    {
        $conversation = $this->locate($token);

        $data = $request->validate(['message' => 'required|string|max:2000']);

        $message = $this->appendVisitorMessage($conversation, $data['message']);

        return response()->json(['message' => $message->toWire()]);
    }

    /** Long-ish poll used by the open widget to pick up operator replies. */
    public function poll(Request $request, string $token): JsonResponse
    {
        $conversation = $this->locate($token);

        $after = (int) $request->query('after', 0);

        $messages = $conversation->messages()
            ->where('id', '>', $after)
            ->orderBy('id')
            ->get();

        // Anything the visitor can now see counts as delivered.
        if ($messages->contains(fn (ChatMessage $m) => $m->sender !== 'visitor')) {
            $conversation->update(['unread_for_visitor' => 0]);
        }

        return response()->json([
            'status'   => $conversation->status,
            'messages' => $messages->map(fn (ChatMessage $m) => $m->toWire()),
        ]);
    }

    private function locate(string $token): ChatConversation
    {
        return ChatConversation::where('token', $token)->firstOrFail();
    }

    private function appendVisitorMessage(ChatConversation $conversation, string $body): ChatMessage
    {
        $message = $conversation->messages()->create([
            'sender' => 'visitor',
            'body'   => $body,
        ]);

        $conversation->increment('unread_for_agent');
        $conversation->update([
            'last_message_at' => now(),
            'status'          => 'open',
        ]);

        $this->alertAgents($conversation, $body);

        return $message;
    }

    private function alertAgents(ChatConversation $conversation, string $body): void
    {
        $agents = $conversation->assigned_to
            ? User::where('id', $conversation->assigned_to)->get()
            : User::whereIn('role', self::AGENT_ROLES)->get();

        if ($agents->isNotEmpty()) {
            Notification::send($agents, new NewChatMessageNotification($conversation, $body));
        }
    }
}
