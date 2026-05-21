<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'The provided email is not registered.',
            ])->onlyInput('email');
        }

        if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Incorrect password entered.',
            ])->onlyInput('email');
        }

        Auth::login($user);
        $request->session()->regenerate();

        // Auto clock-in: set user online and create attendance record if not already online
        if ($user->status !== 'online') {
            $user->update(['status' => 'online']);
            Attendance::create([
                'user_id'       => $user->id,
                'clock_in_time' => Carbon::now(),
            ]);
        }

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        // Auto clock-out on logout
        if ($user && $user->status === 'online') {
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
                    'total_hours'    => number_format($totalHours, 2),
                ]);
            }
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
