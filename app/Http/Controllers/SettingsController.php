<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = CompanySetting::current();
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'shift_start' => ['required', 'date_format:H:i'],
            'shift_end'   => ['required', 'date_format:H:i', 'after:shift_start'],
            'late_cutoff' => ['required', 'date_format:H:i'],
        ]);

        CompanySetting::current()->update($data);

        return back()->with('success', 'Company shift settings updated.');
    }
}
