<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\User;

class ClientController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Admin and HR can see all
        if (in_array($user->role, ['super_admin', 'hr'])) {
            $clients = Client::with(['assignedSales', 'assignedVA'])->get();
        } 
        // Sales sees leads and clients assigned to them
        elseif ($user->role === 'sales') {
            $clients = Client::with(['assignedSales', 'assignedVA'])
                ->where('assigned_sales_id', $user->id)
                ->get();
        }
        // Onboarding sees clients that have passed the Lead stage
        elseif ($user->role === 'onboarding') {
            $clients = Client::with(['assignedSales', 'assignedVA'])
                ->whereIn('status', ['Onboarding', 'Active', 'Churned'])
                ->get();
        }
        // VAs see clients assigned to them
        elseif ($user->role === 'va') {
            $clients = Client::with(['assignedSales', 'assignedVA'])
                ->where('assigned_va_id', $user->id)
                ->get();
        }
        // Accounts see Active clients
        elseif ($user->role === 'accounts') {
            $clients = Client::with(['assignedSales', 'assignedVA'])
                ->where('status', 'Active')
                ->get();
        } 
        else {
            $clients = collect();
        }
        $vas = User::where('role', 'va')->get();

        return view('clients.index', compact('clients', 'vas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_logo' => 'nullable|image|max:2048',
            'email' => 'nullable|array',
            'email.*' => 'nullable|email|max:255',
            'phone' => 'nullable|array',
            'phone.*' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'source' => 'nullable|string|max:255',
            'background_info' => 'nullable|string',
            'attached_file' => 'nullable|file|max:10240', // 10MB max
        ]);

        $logoPath = null;
        if ($request->hasFile('company_logo')) {
            $logoPath = $request->file('company_logo')->store('clients/logos', 'public');
        }

        $filePath = null;
        if ($request->hasFile('attached_file')) {
            $filePath = $request->file('attached_file')->store('clients/attachments', 'public');
        }

        // Clean arrays to remove empty entries
        $emails = array_filter($request->email ?? []) ?: null;
        $phones = array_filter($request->phone ?? []) ?: null;

        Client::create([
            'company_name' => $request->company_name,
            'company_logo' => $logoPath,
            'email' => $emails,
            'phone' => $phones,
            'website' => $request->website,
            'source' => $request->source,
            'background_info' => $request->background_info,
            'attached_file' => $filePath,
            'status' => 'Lead',
            'assigned_sales_id' => Auth::id(), // Assigned to the sales rep who created it
        ]);

        return back()->with('success', 'Lead created successfully.');
    }

    public function convertToClient(Request $request, Client $client)
    {
        // Only Sales or Admin should convert a lead
        if (!in_array(Auth::user()->role, ['sales', 'super_admin'])) {
            abort(403);
        }

        $client->update([
            'status' => 'Onboarding'
        ]);

        // Handover Logic: (Mocked notification to Onboarding team)
        // In a real app we'd dispatch an event or write to the Messages/Tasks table
        $task = \App\Models\Task::create([
            'title' => 'Task for: ' . $client->company_name,
            'description' => 'Sales has closed this client. Please begin the onboarding process and document folder creation.',
            'priority' => 'high',
            'creator_id' => Auth::id(),
            'client_id' => $client->id,
            'due_date' => now()->addDays(2),
            'status' => 'To-Do'
        ]);

        // Assign the task to all users with the 'onboarding' role
        $onboardingUsers = \App\Models\User::where('role', 'onboarding')->get();
        if ($onboardingUsers->isNotEmpty()) {
            $task->assignees()->sync($onboardingUsers->pluck('id')->toArray());
            
            // Send notifications if applicable
            foreach ($onboardingUsers as $assignee) {
                if (class_exists(\App\Notifications\TaskAssignedNotification::class)) {
                    $assignee->notify(new \App\Notifications\TaskAssignedNotification($task, Auth::user()));
                }
            }
        }

        return back()->with('success', 'Lead converted to Client. Onboarding team notified.');
    }

    public function destroy(Client $client)
    {
        // Only Sales or Admin should delete a lead/client
        if (!in_array(Auth::user()->role, ['sales', 'super_admin'])) {
            abort(403);
        }

        $client->delete();

        return back()->with('success', 'Lead/Client deleted successfully.');
    }

    public function update(Request $request, Client $client)
    {
        if (!in_array(Auth::user()->role, ['sales', 'super_admin', 'onboarding'])) {
            abort(403);
        }

        $request->validate([
            'company_name' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'source' => 'nullable|string|max:255',
            'background_info' => 'nullable|string',
            'email' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'assigned_va_id' => 'nullable|exists:users,id',
            'attached_file' => 'nullable|file|max:10240',
        ]);

        $updateData = [
            'company_name' => $request->company_name,
            'website' => $request->website,
            'source' => $request->source,
            'background_info' => $request->background_info,
        ];

        // Handle VA assignment via Onboarding
        if (in_array(Auth::user()->role, ['super_admin', 'onboarding'])) {
            if ($request->has('assigned_va_id')) {
                $updateData['assigned_va_id'] = $request->assigned_va_id;
            }
        }

        // Handle File Upload
        if ($request->hasFile('attached_file')) {
            $updateData['attached_file'] = $request->file('attached_file')->store('clients/attachments', 'public');
        }

        // Convert simple string inputs back to arrays for JSON column
        if ($request->filled('email')) {
            $updateData['email'] = [$request->email];
        } else {
            $updateData['email'] = null;
        }

        if ($request->filled('phone')) {
            $updateData['phone'] = [$request->phone];
        } else {
            $updateData['phone'] = null;
        }

        $client->update($updateData);

        // Auto-assign the "Task for: [Client]" to the new VA, current user (Onboarding), and Super Admin
        if (isset($updateData['assigned_va_id'])) {
            $onboardingTask = \App\Models\Task::where('client_id', $client->id)
                ->where('title', 'LIKE', 'Task for: %')
                ->first();

            if ($onboardingTask) {
                $superAdminIds = \App\Models\User::where('role', 'super_admin')->pluck('id')->toArray();
                $assigneeIds = array_unique(array_merge(
                    $superAdminIds,
                    [Auth::id(), $updateData['assigned_va_id']]
                ));
                
                $onboardingTask->assignees()->sync($assigneeIds);
            }
        }

        return back()->with('success', 'Lead/Client updated successfully.');
    }
}
