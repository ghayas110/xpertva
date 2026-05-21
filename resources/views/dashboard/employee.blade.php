@extends('layouts.dashboard')

@section('title', ucfirst($user->role) . ' Dashboard')

@section('content')
@php
    $roleLabels = [
        'va' => 'VA Operations',
        'sales' => 'Sales Operations',
        'onboarding' => 'Onboarding Operations',
        'accounts' => 'Accounts Operations',
        'hr' => 'HR Operations',
    ];
    $headline = $roleLabels[$user->role] ?? 'My Dashboard';
@endphp

<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800 dark:text-white">{{ $headline }}</h2>
    <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">
        Welcome back, {{ explode(' ', trim($user->name))[0] }}! Here's what's happening in your dashboard.
    </p>
</div>

{{-- ── Top metrics row ─────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
            <i class="fa-solid fa-clock text-xl"></i>
        </div>
        <div class="min-w-0">
            <h3 class="text-slate-500 dark:text-slate-400 text-sm font-medium">Current Time</h3>
            <p id="liveClock" class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-tight">--:--</p>
            <p id="liveDate" class="text-xs text-slate-400 mt-0.5">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
            <i class="fa-solid fa-circle-check text-xl"></i>
        </div>
        <div>
            <h3 class="text-slate-500 dark:text-slate-400 text-sm font-medium">Attendance Rate</h3>
            <p class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-tight">{{ $attendanceRate }}%</p>
            <p class="text-xs text-slate-400 mt-0.5">This Month</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
            <i class="fa-solid fa-list-check text-xl"></i>
        </div>
        <div>
            <h3 class="text-slate-500 dark:text-slate-400 text-sm font-medium">Tasks Completed</h3>
            <p class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-tight">{{ $tasksCompletedMonth }}</p>
            <p class="text-xs text-slate-400 mt-0.5">This Month</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 flex items-center justify-center shrink-0">
            <i class="fa-solid fa-hourglass-half text-xl"></i>
        </div>
        <div>
            <h3 class="text-slate-500 dark:text-slate-400 text-sm font-medium">Pending Tasks</h3>
            <p class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-tight">{{ $pendingTasks }}</p>
            <p class="text-xs text-slate-400 mt-0.5">Total</p>
        </div>
    </div>
</div>

{{-- ── Analytics row ──────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
        <h3 class="font-bold text-lg text-slate-800 dark:text-white">Attendance Analytics</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">{{ $monthLabel }} Attendance</p>
        <div class="relative h-72 w-full">
            <canvas id="attendanceChart"></canvas>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
        <h3 class="font-bold text-lg text-slate-800 dark:text-white">Task Analytics</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Your task distribution</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-center font-semibold text-slate-500 dark:text-slate-400 mb-2">Task Breakdown by Status</p>
                <div class="relative h-56"><canvas id="taskStatusChart"></canvas></div>
            </div>
            <div>
                <p class="text-xs text-center font-semibold text-slate-500 dark:text-slate-400 mb-2">Tasks by Priority</p>
                <div class="relative h-56"><canvas id="taskPriorityChart"></canvas></div>
            </div>
        </div>
    </div>
</div>

{{-- ── Quick action row ──────────────────────────────────────────── --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <a href="{{ route('tasks.index') }}" class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-5 flex items-center gap-4 hover:border-indigo-300 hover:shadow-md transition-all group">
        <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-clipboard-list"></i>
        </div>
        <div class="flex-1">
            <h3 class="font-bold text-slate-800 dark:text-white">My Tasks</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">View tasks assigned to you.</p>
        </div>
        <i class="fa-solid fa-chevron-right text-indigo-400"></i>
    </a>

    <a href="{{ route('clients.index') }}" class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-5 flex items-center gap-4 hover:border-emerald-300 hover:shadow-md transition-all group">
        <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="flex-1">
            <h3 class="font-bold text-slate-800 dark:text-white">My Clients</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">View clients assigned to you.</p>
        </div>
        <i class="fa-solid fa-chevron-right text-emerald-400"></i>
    </a>

    <a href="{{ route('notes.index') }}" class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-5 flex items-center gap-4 hover:border-orange-300 hover:shadow-md transition-all group">
        <div class="w-11 h-11 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-note-sticky"></i>
        </div>
        <div class="flex-1">
            <h3 class="font-bold text-slate-800 dark:text-white">Internal Notes</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Quickly view your notes.</p>
        </div>
        <i class="fa-solid fa-chevron-right text-orange-400"></i>
    </a>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ── Live clock ───────────────────────────────────────────────
    const clockEl = document.getElementById('liveClock');
    const dateEl  = document.getElementById('liveDate');
    function tick() {
        const d = new Date();
        clockEl.textContent = d.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit', hour12: true });
        dateEl.textContent  = d.toLocaleDateString([], { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    }
    tick();
    setInterval(tick, 1000);

    // Chart defaults
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#94a3b8';

    // ── Attendance bar chart ─────────────────────────────────────
    const dailyLabels = {!! json_encode($dailyLabels) !!};
    const dailyValues = {!! json_encode($dailyHoursValues) !!};
    const target      = {{ $dailyTarget }};
    const todayIdx    = (new Date()).getDate() - 1;

    new Chart(document.getElementById('attendanceChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Hours',
                data: dailyValues,
                backgroundColor: dailyValues.map((v, i) => {
                    if (i > todayIdx) return '#e2e8f0';
                    if (v >= target) return '#3b82f6';
                    if (v > 0)       return '#f59e0b';
                    return '#fecaca';
                }),
                borderRadius: 4,
                barPercentage: 0.7,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ctx.parsed.y.toFixed(2) + ' hrs'
                    }
                },
                annotation: {}
            },
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: Math.max(10, target + 2),
                    ticks: { stepSize: 2 },
                    grid: { color: '#f1f5f9' }
                },
                x: { grid: { display: false }, ticks: { maxTicksLimit: 16 } }
            }
        },
        plugins: [{
            id: 'targetLine',
            afterDraw(chart) {
                const { ctx, chartArea: { left, right }, scales: { y } } = chart;
                const yPos = y.getPixelForValue(target);
                ctx.save();
                ctx.strokeStyle = '#475569';
                ctx.setLineDash([6, 4]);
                ctx.lineWidth = 1;
                ctx.beginPath();
                ctx.moveTo(left, yPos);
                ctx.lineTo(right, yPos);
                ctx.stroke();
                ctx.fillStyle = '#475569';
                ctx.font = '10px Inter';
                ctx.fillText('Daily Target', left + 6, yPos - 4);
                ctx.restore();
            }
        }]
    });

    // ── Task status doughnut ──────────────────────────────────────
    const statusData = {!! json_encode($statusCounts) !!};
    const statusOrder = ['Completed', 'In-Progress', 'To-Do', 'Waiting-Approval', 'Overdue'];
    const statusColors = {
        'Completed': '#10b981',
        'In-Progress': '#3b82f6',
        'To-Do': '#f59e0b',
        'Waiting-Approval': '#a855f7',
        'Overdue': '#ef4444'
    };
    const stLabels = [], stValues = [], stColors = [];
    statusOrder.forEach(k => {
        if (statusData[k]) { stLabels.push(k); stValues.push(statusData[k]); stColors.push(statusColors[k]); }
    });
    Object.keys(statusData).forEach(k => {
        if (!statusOrder.includes(k) && statusData[k]) {
            stLabels.push(k); stValues.push(statusData[k]); stColors.push('#94a3b8');
        }
    });

    new Chart(document.getElementById('taskStatusChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: stLabels.length ? stLabels : ['No tasks'],
            datasets: [{
                data: stValues.length ? stValues : [1],
                backgroundColor: stColors.length ? stColors : ['#e2e8f0'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } }
            }
        }
    });

    // ── Task priority bar chart ───────────────────────────────────
    const priorityData = {!! json_encode($priorityCounts) !!};
    const priorityOrder = ['High', 'Medium', 'Low'];
    const priorityColors = { 'High': '#3b82f6', 'Medium': '#f59e0b', 'Low': '#10b981' };
    const prLabels = priorityOrder.filter(k => priorityData[k] !== undefined);
    const prValues = prLabels.map(k => priorityData[k]);

    new Chart(document.getElementById('taskPriorityChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: prLabels.length ? prLabels : ['None'],
            datasets: [{
                data: prValues.length ? prValues : [0],
                backgroundColor: prLabels.map(k => priorityColors[k] || '#94a3b8'),
                borderRadius: 4,
                barPercentage: 0.6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 } },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endpush
