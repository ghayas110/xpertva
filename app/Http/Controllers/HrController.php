<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class HrController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Only HR and Admin can see this
        if (!in_array($user->role, ['hr', 'super_admin'])) {
            abort(403, 'Unauthorized access to HR Dashboard.');
        }

        // Fetch all users with their attendances and tasks
        $employees = User::with(['attendances' => function($query) {
            // Get attendance for the current month
            $query->whereMonth('created_at', Carbon::now()->month);
        }, 'assignedTasks' => function($query) {
            // Get tasks assigned to them
        }])->get();

        // Map data to calculate metrics
        $progressData = $employees->map(function ($employee) {
            $totalHours = $employee->attendances->sum('total_hours');
            
            $hours = floor($totalHours);
            $minutes = round(($totalHours - $hours) * 60);
            
            $timeString = '';
            if ($hours > 0) {
                $timeString .= $hours . 'h ';
            }
            $timeString .= $minutes . 'm';

            $completedTasks = $employee->assignedTasks->where('status', 'Completed')->count();
            $pendingTasks = $employee->assignedTasks->whereIn('status', ['To-Do', 'In-Progress'])->count();
            $totalTasks = $completedTasks + $pendingTasks;
            
            // Calculate total unique days worked
            $totalDaysWorked = $employee->attendances()
                ->whereMonth('created_at', Carbon::now()->month)
                ->distinct('created_at')
                ->count('created_at');
            
            // Dynamic expected days calculation
            $now = Carbon::now();
            $startOfMonth = $now->copy()->startOfMonth();
            $employeeStartDate = $employee->created_at;

            // If employee started after the beginning of this month, their "expected" days start from their hire date
            // Start calculation from tomorrow if they were hired today so they aren't marked absent on their first day
            $calculationStartDate = $employeeStartDate->copy()->startOfDay();
            if ($calculationStartDate->lessThan($startOfMonth)) {
                $calculationStartDate = $startOfMonth->copy();
            }
            
            // Calculate weekdays between calculation start and yesterday (since today isn't over yet, we don't expect today's hours log yet)
            $expectedWorkingDays = 0;
            $currentDate = $calculationStartDate->copy();
            $yesterday = $now->copy()->subDay()->endOfDay();
            
            while ($currentDate->lte($yesterday)) {
                if ($currentDate->isWeekday()) {
                    $expectedWorkingDays++;
                }
                $currentDate->addDay();
            }

            // Ensure expected days doesn't go below 0
            $expectedWorkingDays = max(0, $expectedWorkingDays);
            
            // Calculate absences
            $daysAbsent = max(0, $expectedWorkingDays - $totalDaysWorked);
            
            // Calculate salary deductions based on attendance
            $baseSalary = $employee->salary ?? 0;
            $earnedSalary = $baseSalary;
            
            // If absent for more than 2 days, deduct 2% per day of absence beyond the 2 days
            if ($baseSalary > 0 && $daysAbsent > 2) {
                // Number of days to penalize is total absences minus the 2 permitted
                $penaltyDays = $daysAbsent - 2;
                $deductionPercentage = $penaltyDays * 0.02; // 2% per penalty day
                
                // Ensure we don't deduct more than 100%
                $deductionPercentage = min(1, $deductionPercentage);
                
                $earnedSalary = $baseSalary - ($baseSalary * $deductionPercentage);
            }
            
            return [
                'id' => $employee->id,
                'name' => $employee->name,
                'role' => $employee->role,
                'status' => $employee->status,
                'region' => $employee->region,
                'hours_this_month' => round($totalHours, 2),
                'formatted_time' => trim($timeString),
                'tasks_completed' => $completedTasks,
                'tasks_pending' => $pendingTasks,
                'tasks_total' => $totalTasks,
                'days_absent' => $daysAbsent,
                'base_salary' => $baseSalary,
                'earned_salary' => round($earnedSalary, 0),
            ];
        });

        return view('hr.index', compact('progressData'));
    }
}
