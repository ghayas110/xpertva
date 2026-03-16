@extends('layouts.dashboard')

@section('title', 'Employee Activity Monitor')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row items-start font-inter sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Activity Monitor</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Track employee mouse and keyboard activity</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-4 mb-6 transition-colors duration-300">
    <form method="GET" action="{{ route('admin.activities') }}" class="flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <label for="user_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Employee</label>
            <select name="user_id" id="user_id" onchange="this.form.submit()" class="w-full bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg px-3 py-2 text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                <option value="">All Employees</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $selectedUserId == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-1">
            <label for="date" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Date</label>
            <input type="date" name="date" id="date" value="{{ $date }}" onchange="this.form.submit()" class="w-full bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg px-3 py-2 text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
        </div>
        <div class="flex items-end">
            <a href="{{ route('admin.activities') }}" class="px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-lg text-sm font-medium transition-colors border border-slate-200 dark:border-slate-600">Reset</a>
        </div>
    </form>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-4 relative overflow-hidden group">
        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform duration-300">
            <i class="fa-regular fa-clock text-6xl text-emerald-500"></i>
        </div>
        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Total Active Time</p>
        <h3 class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 tracking-tight">{{ gmdate('H:i:s', $totalActiveTime) }}</h3>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-4 relative overflow-hidden group">
        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform duration-300">
            <i class="fa-solid fa-mug-hot text-6xl text-amber-500"></i>
        </div>
        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Total Idle Time</p>
        <h3 class="text-2xl font-bold text-amber-600 dark:text-amber-400 tracking-tight">{{ gmdate('H:i:s', $totalIdleTime) }}</h3>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-4 relative overflow-hidden group">
        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform duration-300">
            <i class="fa-solid fa-keyboard text-6xl text-indigo-500"></i>
        </div>
        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Total Keystrokes</p>
        <h3 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">{{ number_format($totalKeystrokes) }}</h3>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-4 relative overflow-hidden group">
        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform duration-300">
            <i class="fa-solid fa-computer-mouse text-6xl text-blue-500"></i>
        </div>
        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Mouse Actions</p>
        <h3 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">{{ number_format($totalClicks + $totalMouseMoves) }}</h3>
    </div>

    <!-- Social Media Time -->
    @php
        $totalSocialMediaTime = $activities->filter(fn($a) => $a->isSocialMedia())->sum('active_time');
    @endphp
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-4 relative overflow-hidden group bg-red-50/50 dark:bg-rose-900/10">
        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform duration-300">
            <i class="fa-solid fa-share-nodes text-6xl text-rose-500"></i>
        </div>
        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Social Media Time</p>
        <h3 class="text-2xl font-bold text-rose-600 dark:text-rose-400 tracking-tight">{{ gmdate('H:i:s', $totalSocialMediaTime) }}</h3>
    </div>
</div>

<!-- Log Table -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors duration-300">
    <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/50">
        <h2 class="font-semibold text-slate-800 dark:text-white flex items-center gap-2">
            <i class="fa-solid fa-list-ul text-slate-400"></i> Detailed Logs
        </h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-slate-50 dark:bg-slate-700/50 text-slate-600 dark:text-slate-300 font-medium border-b border-slate-200 dark:border-slate-700">
                <tr>
                    <th class="px-6 py-3">Time</th>
                    @if(!$selectedUserId)
                    <th class="px-6 py-3">Employee</th>
                    @endif
                    <th class="px-6 py-3">URL</th>
                    <th class="px-6 py-3 text-right">Active</th>
                    <th class="px-6 py-3 text-right">Idle</th>
                    <th class="px-6 py-3 text-right">Keystrokes</th>
                    <th class="px-6 py-3 text-right">Clicks</th>
                    <th class="px-6 py-3 text-right">Mouse Moves</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-700 text-slate-700 dark:text-slate-300">
                @forelse($activities as $activity)
                    @php $isSocial = $activity->isSocialMedia(); @endphp
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors {{ $isSocial ? 'bg-rose-50/30 dark:bg-rose-900/10' : '' }}">
                        <td class="px-6 py-3">{{ $activity->created_at->format('h:i:s A') }}</td>
                        @if(!$selectedUserId)
                        <td class="px-6 py-3 font-medium text-slate-900 dark:text-white">
                            {{ $activity->user->name }}
                        </td>
                        @endif
                        <td class="px-6 py-3 min-w-[200px] max-w-[300px] truncate" title="{{ $activity->url }}">
                            @if($isSocial)
                                @php $platform = $activity->getSocialPlatform(); @endphp
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-xs font-medium bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400 mr-2">
                                    <i class="fa-brands fa-{{ strtolower($platform) }} text-[10px]"></i> {{ $platform }}
                                </span>
                            @endif
                            {{ str_replace(url('/'), '', $activity->url) ?: '/' }}
                        </td>
                        <td class="px-6 py-3 text-right text-emerald-600 dark:text-emerald-400">{{ $activity->active_time }}s</td>
                        <td class="px-6 py-3 text-right {{ $activity->idle_time > 0 ? 'text-amber-600 dark:text-amber-400 font-medium' : 'text-slate-400 dark:text-slate-500' }}">{{ $activity->idle_time }}s</td>
                        <td class="px-6 py-3 text-right">{{ $activity->keystroke_count }}</td>
                        <td class="px-6 py-3 text-right">{{ $activity->click_count }}</td>
                        <td class="px-6 py-3 text-right">{{ $activity->mouse_move_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $selectedUserId ? 7 : 8 }}" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            <i class="fa-regular fa-folder-open text-4xl mb-3 text-slate-300 dark:text-slate-600"></i>
                            <p>No activity logged for this period.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
