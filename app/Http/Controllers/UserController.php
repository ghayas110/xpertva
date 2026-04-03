<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\FireEmployeeMail;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Only Super Admin can manage users
        if ($user->role !== 'super_admin') {
            abort(403, 'Unauthorized access to Employee Management.');
        }

        $users = User::orderBy('id', 'desc')->get();

        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        // Only Super Admin can manage users
        if (Auth::user()->role !== 'super_admin') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:sales,onboarding,va,accounts,hr,super_admin',
            'region' => 'nullable|in:USA,Pakistan',
            'salary' => 'nullable|numeric|min:0',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'offline',
            'region' => $request->region,
            'salary' => $request->salary,
        ]);

        return back()->with('success', 'Employee registered successfully.');
    }

    public function show(User $user)
    {
        // Only Super Admin can view specific employee details
        if (Auth::user()->role !== 'super_admin') {
            abort(403);
        }

        // Calculate performance
        $completedTasks = $user->assignedTasks()->where('status', 'Completed')->count();
        $thisMonthAttendances = $user->attendances()->whereMonth('created_at', Carbon::now()->month)->sum('total_hours');
        
        $efficiency = 0;
        if ($thisMonthAttendances > 0) {
            $efficiency = round($completedTasks / $thisMonthAttendances, 2);
        }

        // Calculate total unique days worked this month
        $totalDaysWorked = $user->attendances()
            ->whereMonth('created_at', Carbon::now()->month)
            ->distinct('created_at')
            ->count('created_at');

        // Dynamic expected days calculation
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $employeeStartDate = $user->created_at;

        // Start calculation from tomorrow if they were hired today so they aren't marked absent on their first day
        $calculationStartDate = $employeeStartDate->copy()->startOfDay();
        if ($calculationStartDate->lessThan($startOfMonth)) {
            $calculationStartDate = $startOfMonth->copy();
        }
        
        // Calculate weekdays between calculation start and yesterday (since today isn't over yet)
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
        
        $daysAbsent = max(0, $expectedWorkingDays - $totalDaysWorked);

        return response()->json([
            'user' => $user,
            'metrics' => [
                'employed_since' => $user->created_at->format('M d, Y'),
                'tasks_completed' => $completedTasks,
                'efficiency' => $efficiency,
                'days_absent' => $daysAbsent,
                'leaves_total' => $user->total_leaves,
                'leaves_used' => $user->used_leaves,
                'leaves_remaining' => max(0, $user->total_leaves - $user->used_leaves)
            ]
        ]);
    }

    public function update(Request $request, User $user)
    {
        // Only Super Admin can manage users
        if (Auth::user()->role !== 'super_admin') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:sales,onboarding,va,accounts,hr,super_admin',
            'region' => 'nullable|in:USA,Pakistan',
            'salary' => 'nullable|numeric|min:0',
            'total_leaves' => 'required|integer|min:0',
            'used_leaves' => 'required|integer|min:0',
            'status' => 'required|in:online,offline,fired,delete',
        ]);

        if ($request->status === 'delete') {
            $user->delete();
            return back()->with('success', 'Employee record permanently deleted.');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'region' => $request->region,
            'salary' => $request->salary,
            'total_leaves' => $request->total_leaves,
            'used_leaves' => $request->used_leaves,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Employee updated successfully.');
    }

    public function fire(Request $request, User $user)
    {
        // Only Super Admin can fire users
        if (Auth::user()->role !== 'super_admin') {
            abort(403);
        }

        $request->validate([
            'reason' => 'required|string'
        ]);

        // Change status to fired to lock them out
        $user->update([
            'status' => 'fired'
        ]);

        // Send email
        try {
            Mail::to($user->email)->send(new FireEmployeeMail($user, $request->reason));
            $message = "Employee has been fired and notified via email.";
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send fire email to {$user->email}: " . $e->getMessage());
            $message = "Employee has been fired, but the email notification could not be sent due to a mail server error.";
        }

        return back()->with('success', $message);
    }
}
