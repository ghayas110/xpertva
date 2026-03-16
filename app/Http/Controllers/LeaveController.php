<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'hr' || $user->role === 'admin') {
            $leaves = LeaveRequest::with('user')->orderBy('created_at', 'desc')->get();
        } else {
            $leaves = LeaveRequest::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        }

        return view('leaves.index', compact('leaves'));
    }

    public function create()
    {
        return view('leaves.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:500',
            'type' => 'required|in:casual,sick,other',
        ]);

        $user = Auth::user();

        LeaveRequest::create([
            'user_id' => $user->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'type' => $request->type,
            'status' => 'pending',
            // is_paid will be determined upon approval
        ]);

        return redirect()->route('leaves.index')->with('success', 'Leave request submitted successfully.');
    }

    public function edit(LeaveRequest $leave)
    {
        // Only HR/Admin can approve/reject
        $user = Auth::user();
        if ($user->role !== 'hr' && $user->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('leaves.edit', compact('leave'));
    }

    public function update(Request $request, LeaveRequest $leave)
    {
        $user = Auth::user();
        if ($user->role !== 'hr' && $user->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_remarks' => 'nullable|string|max:500',
        ]);

        // Logic for casual 1 per month
        $isPaid = true;

        if ($request->status === 'approved' && $leave->type === 'casual') {
            // Check if user already took a casual leave this month
            $startMonth = Carbon::parse($leave->start_date)->month;
            $startYear = Carbon::parse($leave->start_date)->year;

            $existingLeavesThisMonth = LeaveRequest::where('user_id', $leave->user_id)
                ->where('status', 'approved')
                ->where('type', 'casual')
                ->whereMonth('start_date', $startMonth)
                ->whereYear('start_date', $startYear)
                ->count();

            // Policy states: 1 leave a month
            // If they take 2 leaves: 1 paid leave, other days deducted on total package
            if ($existingLeavesThisMonth >= 1) {
                // This leave will be deducted
                $isPaid = false;
            }
        }

        $leave->update([
            'status' => $request->status,
            'admin_remarks' => $request->admin_remarks,
            'is_paid' => $isPaid,
        ]);

        return redirect()->route('leaves.index')->with('success', 'Leave request updated successfully.');
    }
}
