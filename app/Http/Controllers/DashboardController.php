<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            'super_admin' => view('dashboard.admin'),
            'sales' => view('dashboard.sales'),
            'onboarding' => view('dashboard.onboarding'),
            'va' => view('dashboard.va'),
            'accounts' => view('dashboard.accounts'),
            'hr' => view('dashboard.hr'),
            default => abort(403, 'Unknown role assigned to user.'),
        };
    }
}
