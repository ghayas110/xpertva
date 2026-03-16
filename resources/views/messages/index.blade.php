@extends('layouts.dashboard')

@section('title', 'Internal Inbox')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Internal Inbox</h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Send and receive messages across the platform.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8">

    <!-- Compose Message Panel -->
    <div class="md:col-span-1">
        <div class="bg-white dark:bg-slate-800 rounded shadow p-6">
            <h3 class="text-xl font-bold mb-4">Compose Message</h3>
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-3 py-2 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('messages.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">To</label>
                    <select name="receiver_id" class="w-full border dark:border-slate-600 rounded dark:bg-slate-700 dark:text-white px-3 py-2" required>
                        <option value="">-- Select Recipient --</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ ucfirst(str_replace('_', ' ', $u->role)) }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Subject</label>
                    <input type="text" name="subject" class="w-full border dark:border-slate-600 rounded dark:bg-slate-700 dark:text-white px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Message</label>
                    <textarea name="body" rows="4" class="w-full border dark:border-slate-600 rounded dark:bg-slate-700 dark:text-white px-3 py-2" required></textarea>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 w-full rounded">
                    Send Message
                </button>
            </form>
        </div>
    </div>

    <!-- Inbox List -->
    <div class="md:col-span-2 space-y-8">
        
        <!-- Received Messages -->
        <div class="bg-white dark:bg-slate-800 rounded shadow p-6">
            <h3 class="text-xl font-bold mb-4 border-b pb-2">Inbox</h3>
            <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                @forelse($receivedMessages as $msg)
                    <div class="border rounded p-4 @if(!$msg->is_read) bg-blue-50 border-blue-200 @else bg-gray-50 dark:bg-slate-700 border-gray-200 dark:border-slate-700 @endif">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h4 class="font-bold @if(!$msg->is_read) text-blue-800 @else text-gray-800 dark:text-white @endif">{{ $msg->subject }}</h4>
                                <span class="text-xs text-gray-500 dark:text-slate-400">From: {{ $msg->sender->name }} | {{ \Carbon\Carbon::parse($msg->sent_at)->diffForHumans() }}</span>
                            </div>
                            @if(!$msg->is_read)
                                <form action="{{ route('messages.read', $msg) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-xs bg-blue-200 hover:bg-blue-300 text-blue-800 px-2 py-1 rounded">Mark Read</button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400">Read</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-700 dark:text-slate-300 whitespace-pre-wrap">{{ $msg->body }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-slate-400 italic">No received messages.</p>
                @endforelse
            </div>
        </div>

        <!-- Sent Messages -->
        <div class="bg-white dark:bg-slate-800 rounded shadow p-6">
            <h3 class="text-xl font-bold mb-4 border-b pb-2">Sent Messages</h3>
            <div class="space-y-4 max-h-64 overflow-y-auto pr-2">
                @forelse($sentMessages as $msg)
                    <div class="border rounded p-4 bg-gray-50 dark:bg-slate-700 border-gray-200 dark:border-slate-700 cursor-default opacity-80">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h4 class="font-bold text-gray-700 dark:text-slate-300">{{ $msg->subject }}</h4>
                                <span class="text-xs text-gray-500 dark:text-slate-400">To: {{ $msg->receiver->name ?? 'Unknown' }} | {{ \Carbon\Carbon::parse($msg->sent_at)->diffForHumans() }}</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-slate-400 whitespace-pre-wrap">{{ $msg->body }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-slate-400 italic">No sent messages.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
