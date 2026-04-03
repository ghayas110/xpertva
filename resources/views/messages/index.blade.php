@extends('layouts.dashboard')

@section('title', 'Internal Inbox')

@section('content')
<div class="mb-8 flex justify-between items-end">
    <div>
        <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Internal Inbox</h2>
        <p class="text-slate-500 dark:text-slate-400 mt-2 text-base">Communicate and collaborate seamlessly across the platform.</p>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-12 gap-8 pb-10">

    <!-- Compose Message Panel -->
    <div class="xl:col-span-4 flex flex-col space-y-6">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6 relative overflow-hidden">
            <!-- Decorative Accent -->
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
            
            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-500"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                Compose Message
            </h3>
            
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-md mb-6 shadow-sm flex items-start">
                    <svg class="w-5 h-5 text-emerald-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('messages.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Recipient</label>
                    <select name="receiver_id" class="w-full border border-slate-300 dark:border-slate-600 rounded-xl dark:bg-slate-700 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow outline-none shadow-sm" required>
                        <option value="" disabled selected>-- Select a team member --</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ ucfirst(str_replace('_', ' ', $u->role)) }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Subject</label>
                    <input type="text" name="subject" placeholder="What is this about?" class="w-full border border-slate-300 dark:border-slate-600 rounded-xl dark:bg-slate-700 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow outline-none shadow-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Message</label>
                    <textarea name="body" rows="6" placeholder="Type your message here..." class="w-full border border-slate-300 dark:border-slate-600 rounded-xl dark:bg-slate-700 dark:text-white px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow outline-none shadow-sm resize-none" required></textarea>
                </div>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 flex items-center justify-center gap-2 w-full rounded-xl transition-colors shadow-md shadow-indigo-200 dark:shadow-none mt-2">
                    <span>Send Message</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Inbox List -->
    <div class="xl:col-span-8 flex flex-col space-y-6">
        
        <!-- Received Messages -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col h-[550px]">
            <div class="p-6 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 rounded-t-2xl flex items-center justify-between">
                <h3 class="text-xl font-bold flex items-center gap-2 text-slate-800 dark:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-500"><path d="M4 7V4h16v3"/><path d="M9 20h6"/><path d="M12 14v6"/><path d="M4 20h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2Z"/></svg>
                    Primary Inbox
                </h3>
            </div>
            
            <div class="flex-1 overflow-y-auto p-6 space-y-4">
                @forelse($receivedMessages as $msg)
                    <div class="group relative rounded-xl p-5 border transition-all duration-200 hover:shadow-md @if(!$msg->is_read) bg-indigo-50/50 dark:bg-indigo-900/10 border-indigo-200 dark:border-indigo-800 shadow-sm @else bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 @endif hover:border-indigo-300 dark:hover:border-indigo-600">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold flex-shrink-0 @if(!$msg->is_read) bg-indigo-200 dark:bg-indigo-800 text-indigo-800 dark:text-indigo-200 @else bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 @endif">
                                    {{ strtoupper(substr($msg->sender->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-base md:text-lg @if(!$msg->is_read) text-indigo-900 dark:text-indigo-100 @else text-slate-800 dark:text-slate-200 @endif leading-tight">{{ $msg->subject }}</h4>
                                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400">{{ $msg->sender->name }} &middot; {{ \Carbon\Carbon::parse($msg->sent_at)->diffForHumans() }}</span>
                                </div>
                            </div>
                            @if(!$msg->is_read)
                                <form action="{{ route('messages.read', $msg) }}" method="POST" class="opacity-0 group-hover:opacity-100 transition-opacity z-10 hidden sm:block">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="flex items-center gap-1.5 text-xs font-semibold bg-white dark:bg-slate-800 border border-indigo-200 dark:border-indigo-800 hover:bg-indigo-50 dark:hover:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 px-3 py-1.5 rounded-lg shadow-sm transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                        Mark Read
                                    </button>
                                </form>
                                <div class="w-3 h-3 rounded-full bg-indigo-500 absolute top-6 right-6 group-hover:hidden sm:block hidden"></div>
                                
                                <!-- Mobile Quick Mark button directly under avatar -->
                                <form action="{{ route('messages.read', $msg) }}" method="POST" class="sm:hidden block absolute top-4 right-4">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-indigo-500 bg-indigo-50 dark:bg-indigo-900/50 p-2 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div class="sm:pl-[52px] text-sm leading-relaxed @if(!$msg->is_read) text-slate-800 dark:text-slate-200 font-medium @else text-slate-600 dark:text-slate-400 @endif whitespace-pre-wrap mt-2 sm:mt-0">{{ $msg->body }}</div>
                    </div>
                @empty
                    <div class="h-full flex flex-col items-center justify-center text-center p-8 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-dashed border-slate-300 dark:border-slate-700">
                        <div class="w-20 h-20 bg-slate-200/50 dark:bg-slate-700/50 rounded-full flex items-center justify-center mb-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/><path d="m16 19 2 2 4-4"/></svg>
                        </div>
                        <h4 class="font-bold text-slate-700 dark:text-slate-300 mb-2 text-lg">You're all caught up!</h4>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">No new messages in your inbox.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Sent Messages -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col max-h-[500px]">
            <div class="p-6 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 rounded-t-2xl">
                <h3 class="text-xl font-bold flex items-center gap-2 text-slate-800 dark:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-500"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                    Sent Messages
                </h3>
            </div>
            
            <div class="flex-1 overflow-y-auto p-6 space-y-4">
                @forelse($sentMessages as $msg)
                    <div class="rounded-xl p-5 border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/30 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-colors">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h4 class="font-semibold text-slate-800 dark:text-slate-200 text-base md:text-lg leading-tight">{{ $msg->subject }}</h4>
                                <span class="text-xs font-medium text-slate-500 dark:text-slate-400">To: {{ $msg->receiver->name ?? 'Unknown' }} &middot; {{ \Carbon\Carbon::parse($msg->sent_at)->diffForHumans() }}</span>
                            </div>
                        </div>
                        <p class="text-sm text-slate-600 dark:text-slate-400 whitespace-pre-wrap mt-3 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 p-4 rounded-lg line-clamp-3 hover:line-clamp-none transition-all shadow-sm">{{ $msg->body }}</p>
                    </div>
                @empty
                    <div class="py-10 flex flex-col items-center justify-center">
                        <p class="text-slate-500 dark:text-slate-400 italic text-sm">No sent messages yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
