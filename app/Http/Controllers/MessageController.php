<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch received and sent messages
        $receivedMessages = Message::with('sender')
            ->where('receiver_id', $user->id)
            ->latest('sent_at')
            ->get();
            
        $sentMessages = Message::with('receiver')
            ->where('sender_id', $user->id)
            ->latest('sent_at')
            ->get();

        // Fetch users for the "To" dropdown (excluding self)
        $users = User::where('id', '!=', $user->id)->get();

        return view('messages.index', compact('receivedMessages', 'sentMessages', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'subject' => $request->subject,
            'body' => $request->body,
            'sent_at' => now(),
            'is_read' => false,
        ]);

        return back()->with('success', 'Message sent successfully.');
    }

    public function markAsRead(Request $request, Message $message)
    {
        // Ensure user is the receiver
        if ($message->receiver_id !== Auth::id()) {
            abort(403);
        }

        $message->update(['is_read' => true]);

        return back()->with('success', 'Message marked as read.');
    }
}
