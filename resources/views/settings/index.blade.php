@extends('layouts.dashboard')

@section('title', 'Settings')

@php
    // Convert 24h time (H:i:s or H:i) into a 12h display label like "9:00 AM".
    $fmt = function ($t) {
        if (!$t) return '';
        try { return \Carbon\Carbon::createFromFormat('H:i:s', strlen($t) === 5 ? $t.':00' : $t)->format('g:i A'); }
        catch (\Throwable $e) { return $t; }
    };
    $isAdmin = auth()->user()->role === 'super_admin';
@endphp

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Settings</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $isAdmin ? 'Manage the company-wide shift schedule.' : 'Manage your personal preferences.' }}</p>
    </div>

    @if($isAdmin)
    {{-- Company Shift Timings (Admin) --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700">
            <h2 class="font-semibold text-slate-800 dark:text-white"><i class="fa-regular fa-clock mr-2 text-indigo-500"></i>Company Shift Timings</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                Set the daily working schedule (AM/PM) and the late-arrival cutoff. The cutoff drives the late-attendance flag and the automated warning/deduction emails.
            </p>
        </div>
        <form action="{{ route('settings.shift') }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Shift Start <span class="text-xs text-slate-400">(AM)</span></label>
                    <input type="time" name="shift_start" value="{{ old('shift_start', \Illuminate\Support\Str::substr($settings->shift_start, 0, 5)) }}" required class="w-full bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-700 dark:text-slate-200">
                    <p class="text-xs text-slate-500 mt-1">Current: <span class="font-semibold">{{ $fmt($settings->shift_start) }}</span></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Shift End <span class="text-xs text-slate-400">(PM)</span></label>
                    <input type="time" name="shift_end" value="{{ old('shift_end', \Illuminate\Support\Str::substr($settings->shift_end, 0, 5)) }}" required class="w-full bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-700 dark:text-slate-200">
                    <p class="text-xs text-slate-500 mt-1">Current: <span class="font-semibold">{{ $fmt($settings->shift_end) }}</span></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Late Cutoff</label>
                    <input type="time" name="late_cutoff" value="{{ old('late_cutoff', \Illuminate\Support\Str::substr($settings->late_cutoff, 0, 5)) }}" required class="w-full bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-700 dark:text-slate-200">
                    <p class="text-xs text-slate-500 mt-1">Current: <span class="font-semibold">{{ $fmt($settings->late_cutoff) }}</span></p>
                </div>
            </div>

            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4 text-sm text-amber-800 dark:text-amber-200">
                <p class="font-medium mb-1"><i class="fa-solid fa-circle-info mr-1"></i> How the late cutoff works</p>
                <p class="text-xs leading-relaxed">
                    Any clock-in after the cutoff is marked <span class="font-semibold">Late</span> on the attendance calendar.
                    The nightly <code class="px-1 bg-amber-100 dark:bg-amber-800 rounded">attendance:process-penalties</code> job uses the same cutoff to:
                    send a <span class="font-semibold">warning email</span> on a user's 2nd late of the month,
                    a <span class="font-semibold">salary deduction email</span> on the 3rd,
                    and flag <span class="font-semibold">habitual late</span> if both this and last month exceed 3 lates.
                </p>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Save Shift Settings</button>
            </div>
        </form>
    </div>
    @endif

    {{-- Quick links --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
        <h2 class="font-semibold text-slate-800 dark:text-white mb-3"><i class="fa-solid fa-link mr-2 text-indigo-500"></i>Quick Links</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-3 border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                <i class="fa-regular fa-user text-indigo-500"></i>
                <div>
                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">Edit Profile</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Name, email, picture, phone, password</p>
                </div>
            </a>
            <a href="{{ route('attendance.my') }}" class="flex items-center gap-3 p-3 border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                <i class="fa-solid fa-calendar-days text-indigo-500"></i>
                <div>
                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">My Attendance</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Review your clock-ins and late days</p>
                </div>
            </a>
        </div>
    </div>

</div>
@endsection
