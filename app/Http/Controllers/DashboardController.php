<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Task;
use App\Models\CompanySetting;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'super_admin') {
            return view('dashboard.admin');
        }

        return $this->employeeDashboard($user);
    }

    private function employeeDashboard($user)
    {
        $now           = Carbon::now();
        $monthStart    = $now->copy()->startOfMonth();
        $monthEnd      = $now->copy()->endOfMonth();
        $today         = $now->copy()->startOfDay();

        // ── Attendance for current month ────────────────────────────────────
        $attendances = Attendance::where('user_id', $user->id)
            ->whereBetween('clock_in_time', [$monthStart, $monthEnd])
            ->orderBy('clock_in_time')
            ->get();

        // Aggregate total hours per calendar day in this month
        $dailyHours    = [];
        $dailyLabels   = [];
        $dailyDates    = [];
        for ($d = 1; $d <= $monthEnd->day; $d++) {
            $dt = $monthStart->copy()->day($d);
            $key = $dt->format('Y-m-d');
            $dailyHours[$key]  = 0.0;
            $dailyLabels[]     = $dt->format('M j');
            $dailyDates[]      = $key;
        }

        foreach ($attendances as $att) {
            $key = Carbon::parse($att->clock_in_time)->format('Y-m-d');
            if (!isset($dailyHours[$key])) continue;

            if ($att->total_hours) {
                $dailyHours[$key] += (float) $att->total_hours;
            } elseif ($att->clock_in_time && !$att->clock_out_time) {
                // Ongoing session — count hours up to "now"
                $dailyHours[$key] += Carbon::parse($att->clock_in_time)->diffInMinutes($now) / 60;
            }
        }
        $dailyHoursValues = array_map(fn($v) => round($v, 2), array_values($dailyHours));

        // Attendance rate: workdays present / workdays elapsed (Mon–Fri)
        $workdaysElapsed = 0;
        $workdaysPresent = 0;
        $presentDates    = collect($attendances)
            ->map(fn($a) => Carbon::parse($a->clock_in_time)->format('Y-m-d'))
            ->unique()
            ->values()
            ->all();

        for ($d = 1; $d <= $now->day; $d++) {
            $dt = $monthStart->copy()->day($d);
            if ($dt->isWeekend()) continue;
            $workdaysElapsed++;
            if (in_array($dt->format('Y-m-d'), $presentDates)) {
                $workdaysPresent++;
            }
        }
        $attendanceRate = $workdaysElapsed > 0
            ? round(($workdaysPresent / $workdaysElapsed) * 100)
            : 0;

        // ── Task stats (assigned to this user) ──────────────────────────────
        $myTasks = Task::where(function ($q) use ($user) {
            $q->whereHas('assignees', fn($qq) => $qq->where('users.id', $user->id))
              ->orWhere('assignee_id', $user->id);
        });

        $tasksCompletedMonth = (clone $myTasks)
            ->where('status', 'Completed')
            ->whereBetween('completed_at', [$monthStart, $monthEnd])
            ->count();

        $pendingTasks = (clone $myTasks)
            ->where('status', '!=', 'Completed')
            ->count();

        // Breakdown by status
        $statusCounts = (clone $myTasks)
            ->selectRaw('status, COUNT(*) as c')
            ->groupBy('status')
            ->pluck('c', 'status')
            ->toArray();

        // Breakdown by priority (for active tasks)
        $priorityCounts = (clone $myTasks)
            ->where('status', '!=', 'Completed')
            ->selectRaw('priority, COUNT(*) as c')
            ->groupBy('priority')
            ->pluck('c', 'priority')
            ->toArray();

        // Determine overdue (active tasks past due_date)
        $overdueCount = (clone $myTasks)
            ->where('status', '!=', 'Completed')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', $today)
            ->count();
        // Subtract overdue from In-Progress/To-Do for chart accuracy is optional; we expose separately
        $statusCounts['Overdue'] = $overdueCount;

        $shift = CompanySetting::current();

        return view('dashboard.employee', [
            'user'                => $user,
            'attendanceRate'      => $attendanceRate,
            'tasksCompletedMonth' => $tasksCompletedMonth,
            'pendingTasks'        => $pendingTasks,
            'dailyLabels'         => $dailyLabels,
            'dailyHoursValues'    => $dailyHoursValues,
            'statusCounts'        => $statusCounts,
            'priorityCounts'      => $priorityCounts,
            'shiftStart'          => $shift->shift_start,
            'shiftEnd'            => $shift->shift_end,
            'monthLabel'          => $now->format('F Y'),
            'dailyTarget'         => 8,
        ]);
    }
}
