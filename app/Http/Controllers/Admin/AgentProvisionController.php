<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Lets a super admin see the per-employee token used to provision the
 * desktop monitoring agent, and rotate it if a machine is decommissioned.
 */
class AgentProvisionController extends Controller
{
    private function authorizeSuperAdmin(): void
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Unauthorized action.');
        }
    }

    public function index()
    {
        $this->authorizeSuperAdmin();

        $users = User::orderBy('name')->get();
        $apiBase = rtrim(config('app.url'), '/') . '/api/agent';

        return view('admin.agents.index', compact('users', 'apiBase'));
    }

    public function regenerate(Request $request, User $user)
    {
        $this->authorizeSuperAdmin();

        $user->agent_token = Str::random(48);
        $user->save();

        return back()->with('status', "New agent token generated for {$user->name}. Update that machine's agent config.");
    }
}
