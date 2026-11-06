@extends('layouts.dashboard')

@section('title', 'Website Chat')

@section('content')
<div class="mb-6 flex flex-wrap justify-between items-end gap-4">
    <div>
        <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Website Chat</h2>
        <p class="text-slate-500 dark:text-slate-400 mt-2 text-base">Live conversations from visitors on xpertva.com.</p>
    </div>
    <div class="flex items-center gap-2 text-sm">
        <span id="chat-live" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-900/20 dark:text-emerald-300 dark:border-emerald-800">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Live
        </span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pb-10"
     data-threads-url="{{ route('chat.threads') }}"
     id="chat-console">

    {{-- Conversation list --}}
    <aside class="lg:col-span-4 xl:col-span-3 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden flex flex-col max-h-[70vh]">
        <div class="px-4 py-3 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
            <h3 class="font-semibold text-sm text-slate-800 dark:text-white">Conversations</h3>
            <span id="chat-unread-total" class="text-xs font-bold text-white bg-red-500 rounded-full px-2 py-0.5 {{ $conversations->sum('unread_for_agent') ? '' : 'hidden' }}">{{ $conversations->sum('unread_for_agent') }}</span>
        </div>
        <div class="overflow-y-auto flex-1" id="chat-threads">
            @forelse($conversations as $c)
                <a href="{{ route('chat.index', ['c' => $c->id]) }}"
                   class="block px-4 py-3 border-b border-slate-100 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors {{ $active && $active->id === $c->id ? 'bg-indigo-50 dark:bg-indigo-900/20' : '' }}">
                    <div class="flex items-center justify-between gap-2">
                        <p class="font-medium text-sm text-slate-800 dark:text-slate-100 truncate">{{ $c->displayName() }}</p>
                        @if($c->unread_for_agent)
                            <span class="shrink-0 text-[10px] font-bold text-white bg-red-500 rounded-full px-1.5 py-0.5">{{ $c->unread_for_agent }}</span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 truncate mt-0.5">{{ \Illuminate\Support\Str::limit(optional($c->messages()->latest('id')->first())->body, 48) }}</p>
                    <p class="text-[10px] text-slate-400 mt-1">
                        {{ optional($c->last_message_at)->diffForHumans() }}
                        @if($c->status === 'closed') &middot; resolved @endif
                    </p>
                </a>
            @empty
                <p class="px-4 py-8 text-sm text-slate-500 dark:text-slate-400 text-center">No conversations yet. They will appear here the moment a visitor writes in.</p>
            @endforelse
        </div>
    </aside>

    {{-- Active thread --}}
    <section class="lg:col-span-8 xl:col-span-9 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 flex flex-col max-h-[70vh]"
             @if($active) data-conversation="{{ $active->id }}"
                          data-messages-url="{{ route('chat.messages', $active) }}"
                          data-reply-url="{{ route('chat.reply', $active) }}"
                          data-close-url="{{ route('chat.close', $active) }}" @endif
             id="chat-thread">
        @if($active)
            <header class="px-5 py-3 border-b border-slate-200 dark:border-slate-700 flex flex-wrap items-center gap-3">
                <div class="min-w-0">
                    <p class="font-semibold text-slate-800 dark:text-white truncate">{{ $active->displayName() }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 truncate">
                        @if($active->email)<a href="mailto:{{ $active->email }}" class="hover:underline">{{ $active->email }}</a> &middot; @endif
                        @if($active->phone){{ $active->phone }} &middot; @endif
                        from {{ $active->page_url ?: '/' }}
                    </p>
                </div>
                <div class="ml-auto flex items-center gap-2">
                    @if($active->email)
                        <a href="mailto:{{ $active->email }}" class="text-xs px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">Email</a>
                    @endif
                    <button type="button" id="chat-resolve" class="text-xs px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">
                        {{ $active->status === 'closed' ? 'Resolved' : 'Mark resolved' }}
                    </button>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-5 space-y-3" id="chat-log">
                @foreach($messages as $m)
                    <div data-mid="{{ $m->id }}" class="flex {{ $m->sender === 'agent' ? 'justify-end' : ($m->sender === 'system' ? 'justify-center' : 'justify-start') }}">
                        @if($m->sender === 'system')
                            <p class="text-xs text-slate-400 text-center max-w-md">{{ $m->body }}</p>
                        @else
                            <div class="max-w-[75%] rounded-2xl px-4 py-2.5 {{ $m->sender === 'agent' ? 'bg-indigo-600 text-white rounded-br-sm' : 'bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-100 rounded-bl-sm' }}">
                                <p class="text-sm whitespace-pre-wrap break-words">{{ $m->body }}</p>
                                <p class="text-[10px] mt-1 {{ $m->sender === 'agent' ? 'text-indigo-200' : 'text-slate-400' }}">
                                    {{ $m->sender === 'agent' ? ($m->user->name ?? 'You') . ' · ' : '' }}{{ $m->created_at->format('M j, g:i A') }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <form class="p-4 border-t border-slate-200 dark:border-slate-700 flex items-end gap-3" id="chat-reply-form">
                @csrf
                <textarea id="chat-reply" rows="1" maxlength="4000" required placeholder="Reply to {{ $active->displayName() }}"
                          class="flex-1 resize-none max-h-32 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-700 dark:text-slate-200 placeholder-slate-400"></textarea>
                <button type="submit" id="chat-reply-send" class="shrink-0 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-4 py-2 text-sm font-medium transition-colors disabled:opacity-50">
                    Send
                </button>
            </form>
        @else
            <div class="flex-1 grid place-items-center p-12 text-center">
                <div>
                    <i class="fa-regular fa-comments text-4xl text-slate-300 dark:text-slate-600"></i>
                    <p class="mt-4 text-slate-500 dark:text-slate-400">Pick a conversation on the left, or wait for the next visitor.</p>
                </div>
            </div>
        @endif
    </section>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/portal-chat.js') }}?v=1" defer></script>
@endpush
