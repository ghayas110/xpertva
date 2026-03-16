@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Welcome back, {{ explode(' ', trim(auth()->user()->name))[0] }}!</h2>
        <p class="text-slate-500 text-sm mt-1">Here's what's happening internally today.</p>
    </div>
    <div class="hidden sm:flex items-center gap-3">
        <button class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-900 px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm inline-flex items-center gap-2">
            <i class="fa-solid fa-download"></i> Export
        </button>
        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm inline-flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Add Widget
        </button>
    </div>
</div>

<!-- Key Metrics Row -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Card 1 -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 flex border-l-4 border-l-indigo-500">
        <div class="flex-1">
            <h3 class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-1">Total Employees</h3>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-bold text-slate-800 dark:text-white">{{ \App\Models\User::count() }}</span>
            </div>
        </div>
        <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
            <i class="fa-solid fa-users text-xl"></i>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 flex border-l-4 border-l-emerald-500">
        <div class="flex-1">
            <h3 class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-1">Total Clients</h3>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-bold text-slate-800 dark:text-white">{{ \App\Models\Client::count() }}</span>
            </div>
        </div>
        <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
            <i class="fa-solid fa-cube text-xl"></i>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 flex border-l-4 border-l-blue-500">
        <div class="flex-1">
            <h3 class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-1">Active Tasks</h3>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-bold text-slate-800 dark:text-white">{{ \App\Models\Task::where('status', '!=', 'Completed')->count() }}</span>
            </div>
        </div>
        <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
            <i class="fa-solid fa-list-check text-xl"></i>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 flex border-l-4 border-l-orange-500">
        <div class="flex-1">
            <h3 class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-1">Gross Revenue</h3>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-bold text-slate-800 dark:text-white">${{ number_format(\App\Models\Financial::where('category', 'Invoicing')->sum('amount')) }}</span>
            </div>
        </div>
        <div class="w-12 h-12 rounded-xl bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 flex items-center justify-center shrink-0">
            <i class="fa-solid fa-money-bill-wave text-xl"></i>
        </div>
    </div>
</div>

<!-- Tasks Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Tasks Completion Rate -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 flex flex-col justify-between">
        <div class="flex justify-between items-start mb-2">
            <div>
                <h3 class="font-bold text-lg text-slate-800 dark:text-white">Task Completion</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">Progress of all assigned tasks</p>
            </div>
        </div>
        
        @php
            $totalTasks = \App\Models\Task::count();
            $completedTasks = \App\Models\Task::where('status', 'Completed')->count();
            $remainingTasks = $totalTasks - $completedTasks;
            $completedPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0;
        @endphp

        <div class="relative flex items-center justify-center h-48 w-full mt-4">
            <canvas id="taskCompletionChart"></canvas>
            <div class="absolute inset-0 flex flex-col items-center justify-center pt-8 pointer-events-none">
                <span class="text-4xl font-bold text-slate-800 dark:text-white tracking-tight">{{ $completedPercentage }}%</span>
                <span class="text-xs font-semibold text-emerald-500 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-0.5 rounded-full mt-1">Completed</span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2 border-t border-slate-100 dark:border-slate-700 pt-4 bg-slate-50/50 dark:bg-slate-700/30 -mx-6 -mb-6 px-6 pb-6 rounded-b-2xl mt-6">
            <div class="text-center border-r border-slate-200 dark:border-slate-600">
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider mb-1">Total Tasks</p>
                <div class="flex items-center justify-center gap-1">
                    <span class="text-lg font-bold text-slate-800 dark:text-white">{{ $totalTasks }}</span>
                </div>
            </div>
            <div class="text-center">
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider mb-1">Completed</p>
                <div class="flex items-center justify-center gap-1">
                    <span class="text-lg font-bold text-slate-800 dark:text-white">{{ $completedTasks }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks by Status -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 flex flex-col">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="font-bold text-lg text-slate-800 dark:text-white">Tasks By Status</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">Breakdown of task statuses</p>
            </div>
        </div>
        <div class="relative flex-1 min-h-[250px] w-full mt-2">
            <canvas id="tasksStatusChart"></canvas>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Shared Chart Settings
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#94a3b8'; // slate-400
        Chart.defaults.scale.grid.color = '#f1f5f9'; // slate-100

        // 1. Task Completion Doughnut Chart
        const ctxCompletion = document.getElementById('taskCompletionChart').getContext('2d');
        const totalTasks = {{ $totalTasks ?? 0 }};
        const completedTasks = {{ $completedTasks ?? 0 }};
        const remainingTasks = {{ $remainingTasks ?? 0 }};
        
        new Chart(ctxCompletion, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Remaining'],
                datasets: [{
                    data: totalTasks > 0 ? [completedTasks, remainingTasks] : [0, 1],
                    backgroundColor: totalTasks > 0 ? [
                        '#10b981', // emerald-500
                        '#e2e8f0'  // slate-200
                    ] : ['#e2e8f0', '#e2e8f0'],
                    borderWidth: 0,
                    borderRadius: [10, 0]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '85%',
                rotation: -90,
                circumference: 180,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: totalTasks > 0 }
                }
            }
        });

        // 2. Tasks By Status Bar Chart
        @php
            // Fetch task breakdown
            $statuses = \App\Models\Task::selectRaw("status, count(*) as count")
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();
            
            $statusLabels = array_keys($statuses);
            $statusCounts = array_values($statuses);
        @endphp

        const ctxStatus = document.getElementById('tasksStatusChart').getContext('2d');
        const statusLabels = {!! json_encode($statusLabels) !!};
        const statusCounts = {!! json_encode($statusCounts) !!};

        new Chart(ctxStatus, {
            type: 'bar',
            data: {
                labels: statusLabels.length ? statusLabels : ['No Tasks'],
                datasets: [{
                    label: 'Tasks',
                    data: statusCounts.length ? statusCounts : [0],
                    backgroundColor: '#4f46e5', // indigo-600
                    borderRadius: 4,
                    barPercentage: 0.4,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0 },
                        border: { display: false }
                    },
                    x: {
                        grid: { display: false },
                        border: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush
