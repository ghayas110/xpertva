<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Authenticates the desktop monitoring agent using a per-employee token
 * sent in the `X-Agent-Token` header (or `token` field). On success the
 * resolved user is attached to the request as `agent_user`.
 */
class AgentToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('X-Agent-Token') ?: $request->input('token');

        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'Missing agent token'], 401);
        }

        $user = User::where('agent_token', $token)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Invalid agent token'], 401);
        }

        // Firing/terminated employees stop reporting.
        if (isset($user->status) && $user->status === 'inactive') {
            return response()->json(['status' => 'error', 'message' => 'Account inactive'], 403);
        }

        $request->attributes->set('agent_user', $user);

        return $next($request);
    }
}
