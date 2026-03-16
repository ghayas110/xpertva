<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AttendanceController extends Controller
{
    public function toggle()
    {
        $user = Auth::user();

        if ($user->status === 'online') {
            // Clock out
            $user->update(['status' => 'offline']);
            
            $attendance = Attendance::where('user_id', $user->id)
                ->whereNull('clock_out_time')
                ->latest()
                ->first();
                
            if ($attendance) {
                $clockOutTime = Carbon::now();
                $totalHours = $attendance->clock_in_time->diffInMinutes($clockOutTime) / 60;
                
                $attendance->update([
                    'clock_out_time' => $clockOutTime,
                    'total_hours' => number_format($totalHours, 2),
                ]);
            }

            return back()->with('status', 'You are now offline.');
        } else {
            // Clock in
            $user->update(['status' => 'online']);
            
            Attendance::create([
                'user_id' => $user->id,
                'clock_in_time' => Carbon::now(),
            ]);

            return back()->with('status', 'You are now online.');
        }
    }

    /**
     * Show "My Attendance" for the logged-in user.
     */
    public function myAttendance()
    {
        $user = auth()->user();
        $calendarData = $this->buildCalendarData($user->id);

        return view('attendance.my', compact('calendarData', 'user'));
    }

    /**
     * Show Attendance Management for HR / Super Admin
     */
    public function manage(Request $request)
    {
        $users = User::orderBy('name')->get();
        
        $selectedUserId = $request->query('user_id');
        $selectedUser = null;
        $calendarData = [];

        if ($selectedUserId) {
            $selectedUser = User::findOrFail($selectedUserId);
            $calendarData = $this->buildCalendarData($selectedUser->id);
        }

        return view('attendance.manage', compact('users', 'selectedUser', 'calendarData'));
    }

    /**
     * Build the calendar data for a specific user.
     * Groups data by Year and Month.
     */
    private function buildCalendarData($userId)
    {
        // Get all attendance for the user
        $attendances = Attendance::where('user_id', $userId)
            ->orderBy('clock_in_time', 'asc')
            ->get();

        // Get approved leaves
        $leaves = LeaveRequest::where('user_id', $userId)
            ->where('status', 'approved')
            ->get();

        $data = [];

        // If no attendance, return empty structure up to current month based on hire date or fallback
        if ($attendances->isEmpty() && $leaves->isEmpty()) {
             $user = User::find($userId);
             $minDate = $user->created_at ?? Carbon::now();
             $maxDate = Carbon::now();
        } else {
            // Find min and max dates from attendance and leaves to determine the range
            $minDate = Carbon::now();
            $maxDate = Carbon::now();

            if ($attendances->isNotEmpty()) {
                $minDate = Carbon::parse($attendances->min('clock_in_time'));
                $maxDate = Carbon::parse($attendances->max('clock_in_time'));
            }

            if ($leaves->isNotEmpty()) {
                $leaveMin = $leaves->min('start_date');
                $leaveMax = $leaves->max('end_date');
                if ($leaveMin < $minDate) $minDate = $leaveMin;
                if ($leaveMax > $maxDate) $maxDate = $leaveMax;
            }
        }

        // Force to start of month and end of month for period creation
        $minDate->startOfMonth();
        $maxDate->endOfMonth();

        // Ensure we always show up to the current month to prevent UX confusion
        if ($maxDate < Carbon::now()->endOfMonth()) {
            $maxDate = Carbon::now()->endOfMonth();
        }

        $overallTotals = ['present' => 0, 'absent' => 0, 'leaves' => 0];

        // Initialize structure for all months in range
        $period = CarbonPeriod::create($minDate, '1 month', $maxDate);
        foreach ($period as $dt) {
            $year = $dt->year;
            $month = $dt->month;
            
            if (!isset($data[$year])) {
                $data[$year] = [];
            }
            $data[$year][$month] = [
                'month_name' => $dt->format('F'),
                'days' => [],
                'totals' => ['present' => 0, 'absent' => 0, 'leaves' => 0],
                'start_day_of_week' => $dt->copy()->startOfMonth()->dayOfWeek, // 0 = Sunday
                'days_in_month' => $dt->daysInMonth
            ];

            // Initialize every day of the month as 'Absent' by default
            for ($day = 1; $day <= $dt->daysInMonth; $day++) {
                $currentDay = clone $dt->copy()->addDays($day - 1);
                // We only count weekdays as potentially absent/present automatically
                $isWeekend = $currentDay->isWeekend();
                
                $data[$year][$month]['days'][$day] = [
                    'date' => $currentDay->format('Y-m-d'),
                    'status' => $isWeekend ? 'weekend' : 'absent',
                    'record' => null
                ];
                
                if (!$isWeekend && $currentDay <= Carbon::now()) {
                   $data[$year][$month]['totals']['absent']++; // Tentatively absent
                   $overallTotals['absent']++;
                }
            }
        }

        // Populate Leaves (Overrides default)
        foreach ($leaves as $leave) {
            $leaveStart = Carbon::parse($leave->start_date)->startOfDay();
            $leaveEnd = Carbon::parse($leave->end_date)->endOfDay();
            
            $leavePeriod = CarbonPeriod::create($leaveStart, '1 day', $leaveEnd);
            foreach ($leavePeriod as $ld) {
                // Only mark weekdays as leaves if policy dictates, but standard is counting them
                if ($ld > Carbon::now()) continue; // Don't process future leaves for historical counts
                if ($ld->isWeekend()) continue;

                $yr = $ld->year;
                $mo = $ld->month;
                $dy = $ld->day;

                if (isset($data[$yr][$mo]['days'][$dy])) {
                    if ($data[$yr][$mo]['days'][$dy]['status'] === 'absent') {
                        $data[$yr][$mo]['totals']['absent']--; // Deduct the tentative absent
                        $overallTotals['absent']--;
                    }
                    if ($data[$yr][$mo]['days'][$dy]['status'] !== 'leave') {
                        $data[$yr][$mo]['totals']['leaves']++; // Increment leave count
                        $overallTotals['leaves']++;
                    }
                    $data[$yr][$mo]['days'][$dy]['status'] = 'leave';
                }
            }
        }

        // Populate Attendances (Overrides default and leaves theoretically)
        foreach ($attendances as $att) {
            $date = Carbon::parse($att->clock_in_time);
            $yr = $date->year;
            $mo = $date->month;
            $dy = $date->day;

            if (isset($data[$yr][$mo]['days'][$dy])) {
                $prevStatus = $data[$yr][$mo]['days'][$dy]['status'];
                
                // If they were tentatively absent (weekdays), deduct it
                if ($prevStatus === 'absent' && $date <= Carbon::now()) {
                    $data[$yr][$mo]['totals']['absent']--;
                    $overallTotals['absent']--;
                } elseif ($prevStatus === 'leave') {
                    $data[$yr][$mo]['totals']['leaves']--; // They came to work despite leave
                    $overallTotals['leaves']--;
                }

                $data[$yr][$mo]['days'][$dy]['status'] = 'present';
                $data[$yr][$mo]['days'][$dy]['record'] = $att;
                
                // Add Late Flag: Cutoff is 16:55 (4:55 PM)
                $cutoff = $date->copy()->setTime(16, 55, 0);
                $data[$yr][$mo]['days'][$dy]['is_late'] = $date->greaterThan($cutoff);

                if ($prevStatus !== 'present') {
                   $data[$yr][$mo]['totals']['present']++;
                   $overallTotals['present']++;
                }
            }
        }

        // Sort years descending so latest is on top
        krsort($data);
        foreach ($data as $yr => &$months) {
            krsort($months); // Latest month on top
        }

        return [
            'years' => $data,
            'overall_totals' => $overallTotals
        ];
    }
}
