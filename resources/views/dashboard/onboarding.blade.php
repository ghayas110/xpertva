@extends('layouts.dashboard')

@section('title', 'Onboarding Dashboard')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Onboarding Portal</h2>
    <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Welcome back, {{ explode(' ', trim(auth()->user()->name))[0] }}. View handed-over clients.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <a href="{{ route('tasks.index') }}" class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 flex items-start gap-4 hover:border-indigo-300 hover:shadow-md transition-all group">
        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-list-check text-xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-lg text-slate-800 dark:text-white">My Tasks</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Process new client handovers.</p>
        </div>
    </a>

    <a href="{{ route('clients.index') }}" class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 flex items-start gap-4 hover:border-emerald-300 hover:shadow-md transition-all group">
        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-folder-open text-xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-lg text-slate-800 dark:text-white">Client Data</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">View clients sent from sales.</p>
        </div>
    </a>

    <a href="{{ route('messages.index') }}" class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 flex items-start gap-4 hover:border-orange-300 hover:shadow-md transition-all group">
        <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-envelope text-xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-lg text-slate-800 dark:text-white">Internal Inbox</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Check your messages.</p>
        </div>
    </a>
</div>
@endsection
