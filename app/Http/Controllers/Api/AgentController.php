<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use App\Models\EmployeeActivity;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    /**
     * The agent calls this on startup and periodically to learn:
     *  - who it is authenticated as (sanity check for provisioning),
     *  - the shift window it is allowed to monitor within,
     *  - the poll/report cadence and whether monitoring is currently active.
     */
    public function config(Request $request)
    {
        $user     = $request->attributes->get('agent_user');
        $settings = CompanySetting::current();

        $tz       = config('app.timezone', 'UTC');
        $now      = now($tz);
        $start    = $now->copy()->setTimeFromTimeString($settings->shift_start);
        $end      = $now->copy()->setTimeFromTimeString($settings->shift_end);

        // Overnight shifts (end <= start) roll the end into the next day.
        if ($end->lessThanOrEqualTo($start)) {
            $end->addDay();
        }

        $withinShift = $now->betweenIncluded($start, $end);

        return response()->json([
            'status'        => 'ok',
            'employee'      => ['id' => $user->id, 'name' => $user->name],
            'monitoring'    => true,
            'within_shift'  => $withinShift,
            'shift_start'   => substr($settings->shift_start, 0, 5),
            'shift_end'     => substr($settings->shift_end, 0, 5),
            'server_time'   => $now->toIso8601String(),
            'timezone'      => $tz,
            'report_interval_seconds' => 15,   // how often to POST a sample
            'consent_required'        => is_null($user->monitoring_consent_at),
        ]);
    }

    /**
     * Records the employee's on-screen acknowledgement of the monitoring notice.
     */
    public function consent(Request $request)
    {
        $user = $request->attributes->get('agent_user');
        if (is_null($user->monitoring_consent_at)) {
            $user->monitoring_consent_at = now();
            $user->save();
        }
        return response()->json(['status' => 'ok', 'consented_at' => $user->monitoring_consent_at]);
    }

    /**
     * Receives one activity sample (the foreground browser tab/URL) from the agent.
     * Only stores rows whose sample was taken inside the configured shift window.
     */
    public function activity(Request $request)
    {
        $user = $request->attributes->get('agent_user');

        $data = $request->validate([
            'url'              => 'nullable|string|max:2048',
            'app_name'         => 'nullable|string|max:120',
            'window_title'     => 'nullable|string|max:512',
            'active_time'      => 'nullable|integer|min:0',
            'idle_time'        => 'nullable|integer|min:0',
            'mouse_move_count' => 'nullable|integer|min:0',
            'click_count'      => 'nullable|integer|min:0',
            'keystroke_count'  => 'nullable|integer|min:0',
            'captured_at'      => 'nullable|date',
        ]);

        $settings = CompanySetting::current();
        $tz       = config('app.timezone', 'UTC');
        $captured = !empty($data['captured_at']) ? \Carbon\Carbon::parse($data['captured_at'])->tz($tz) : now($tz);

        $start = $captured->copy()->setTimeFromTimeString($settings->shift_start);
        $end   = $captured->copy()->setTimeFromTimeString($settings->shift_end);
        if ($end->lessThanOrEqualTo($start)) {
            $end->addDay();
        }

        if (!$captured->betweenIncluded($start, $end)) {
            // Silently ignore off-shift samples so nothing outside working hours is stored.
            return response()->json(['status' => 'skipped', 'reason' => 'outside_shift']);
        }

        EmployeeActivity::create([
            'user_id'          => $user->id,
            'source'           => 'agent',
            'url'              => $data['url'] ?? null,
            'app_name'         => $data['app_name'] ?? null,
            'window_title'     => $data['window_title'] ?? null,
            'captured_at'      => $captured,
            'active_time'      => $data['active_time'] ?? 0,
            'idle_time'        => $data['idle_time'] ?? 0,
            'mouse_move_count' => $data['mouse_move_count'] ?? 0,
            'click_count'      => $data['click_count'] ?? 0,
            'keystroke_count'  => $data['keystroke_count'] ?? 0,
        ]);

        return response()->json(['status' => 'success']);
    }
}
