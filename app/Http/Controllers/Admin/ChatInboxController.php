<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/** Operator side of the website chat. */
class ChatInboxController extends Controller
{
    public function index(Request $request): View
    {
        $conversations = $this->listQuery();

        $active = $request->filled('c')
            ? ChatConversation::find($request->query('c'))
            : $conversations->first();

        if ($active) {
            $this->markAgentRead($active);
        }

        return view('chat.index', [
            'conversations' => $conversations,
            'active'        => $active,
            'messages'      => $active ? $active->messages()->orderBy('id')->get() : collect(),
        ]);
    }

    /** Sidebar refresh: conversation list plus unread counts. */
    public function threads(): JsonResponse
    {
        return response()->json([
            'total_unread'  => (int) ChatConversation::sum('unread_for_agent'),
            'conversations' => $this->listQuery()->map(fn (ChatConversation $c) => [
                'id'      => $c->id,
                'name'    => $c->displayName(),
                'email'   => $c->email,
                'status'  => $c->status,
                'unread'  => $c->unread_for_agent,
                'preview' => optional($c->messages()->latest('id')->first())->body,
                'at'      => optional($c->last_message_at)->diffForHumans(),
            ]),
        ]);
    }

    /** Thread refresh for the open conversation. */
    public function messages(Request $request, ChatConversation $conversation): JsonResponse
    {
        $after = (int) $request->query('after', 0);

        $messages = $conversation->messages()
            ->where('id', '>', $after)
            ->orderBy('id')
            ->get();

        $this->markAgentRead($conversation);

        return response()->json([
            'status'   => $conversation->status,
            'messages' => $messages->map(fn (ChatMessage $m) => $m->toWire()),
        ]);
    }

    public function reply(Request $request, ChatConversation $conversation): JsonResponse
    {
        $data = $request->validate(['message' => 'required|string|max:4000']);

        $message = $conversation->messages()->create([
            'sender'  => 'agent',
            'user_id' => $request->user()->id,
            'body'    => $data['message'],
        ]);

        $conversation->increment('unread_for_visitor');
        $conversation->update([
            'last_message_at' => now(),
            'status'          => 'open',
            // First operator to answer owns the thread from then on.
            'assigned_to'     => $conversation->assigned_to ?: $request->user()->id,
        ]);

        $this->markAgentRead($conversation);

        return response()->json(['message' => $message->toWire()]);
    }

    public function close(ChatConversation $conversation): JsonResponse
    {
        $conversation->update(['status' => 'closed', 'unread_for_agent' => 0]);

        $conversation->messages()->create([
            'sender' => 'system',
            'body'   => 'This conversation was marked resolved. Send a message to reopen it.',
        ]);

        return response()->json(['status' => 'closed']);
    }

    private function listQuery()
    {
        if (! \Illuminate\Support\Facades\Schema::hasTable('chat_conversations')) {
            return collect();
        }

        return ChatConversation::query()
            ->orderByRaw('CASE WHEN status = ? THEN 0 ELSE 1 END', ['open'])
            ->orderByDesc('last_message_at')
            ->limit(60)
            ->get();
    }

    private function markAgentRead(ChatConversation $conversation): void
    {
        if ($conversation->unread_for_agent > 0) {
            $conversation->update(['unread_for_agent' => 0]);
        }

        $conversation->messages()
            ->where('sender', 'visitor')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }
}
