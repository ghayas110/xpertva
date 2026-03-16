<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EmployeeActivity;
use Illuminate\Support\Facades\Auth;

class EmployeeActivityController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|string',
            'active_time' => 'required|integer',
            'idle_time' => 'required|integer',
            'mouse_move_count' => 'required|integer',
            'click_count' => 'required|integer',
            'keystroke_count' => 'required|integer',
        ]);

        if (Auth::check()) {
            EmployeeActivity::create([
                'user_id' => Auth::id(),
                'url' => $request->url,
                'active_time' => $request->active_time,
                'idle_time' => $request->idle_time,
                'mouse_move_count' => $request->mouse_move_count,
                'click_count' => $request->click_count,
                'keystroke_count' => $request->keystroke_count,
            ]);

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
    }
}
