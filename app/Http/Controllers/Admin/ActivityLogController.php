<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\EmployeeActivity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        // Only allow super admins to view this
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Unauthorized action.');
        }

        // Get selected user or default to all
        $selectedUserId = $request->input('user_id');
        $date = $request->input('date', date('Y-m-d'));

        // Query activities for the selected date
        $query = EmployeeActivity::with('user')
            ->whereDate('created_at', $date);
            
        if ($selectedUserId) {
            $query->where('user_id', $selectedUserId);
        }

        // Calculate summary stats
        $activities = $query->latest()->get();
        
        $totalActiveTime = $activities->sum('active_time');
        $totalIdleTime = $activities->sum('idle_time');
        $totalKeystrokes = $activities->sum('keystroke_count');
        $totalClicks = $activities->sum('click_count');
        $totalMouseMoves = $activities->sum('mouse_move_count');
        
        // Group by hour for chart
        $hourlyData = [];
        for ($i = 0; $i < 24; $i++) {
            $hourlyData[$i] = [
                'active' => 0,
                'idle' => 0,
                'keystrokes' => 0
            ];
        }
        
        foreach ($activities as $activity) {
            $hour = intval($activity->created_at->format('G'));
            $hourlyData[$hour]['active'] += $activity->active_time;
            $hourlyData[$hour]['idle'] += $activity->idle_time;
            $hourlyData[$hour]['keystrokes'] += $activity->keystroke_count;
        }

        $users = User::orderBy('name')->get();

        return view('admin.activities.index', compact(
            'activities', 
            'users', 
            'selectedUserId', 
            'date',
            'totalActiveTime',
            'totalIdleTime',
            'totalKeystrokes',
            'totalClicks',
            'totalMouseMoves',
            'hourlyData'
        ));
    }
}
