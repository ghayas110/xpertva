<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\User;
use App\Models\Client;
use App\Notifications\TaskAssignedNotification;
use App\Notifications\UserMentionedNotification;

class TaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Admins and HR can see all tasks
        if (in_array($user->role, ['super_admin', 'hr'])) {
            $tasks = Task::with(['creator', 'assignees', 'client', 'parent'])->get();
        } else {
            // Normal users only see tasks assigned to them or created by them
            $tasks = Task::with(['creator', 'assignees', 'client', 'parent'])
                ->whereHas('assignees', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->orWhere('creator_id', $user->id)
                ->get();
        }

        $users = User::all();
        $clients = Client::all();

        return view('tasks.index', compact('tasks', 'users', 'clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'assignees' => 'nullable|array',
            'assignees.*' => 'exists:users,id',
            'client_id' => 'nullable|exists:clients,id',
            'parent_id' => 'nullable|exists:tasks,id',
            'due_date' => 'nullable|date',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'creator_id' => Auth::id(),
            'client_id' => $request->client_id,
            'parent_id' => $request->parent_id,
            'due_date' => $request->due_date,
            'status' => 'To-Do',
        ]);

        if ($request->has('assignees') && is_array($request->assignees)) {
            $task->assignees()->sync($request->assignees);
            
            // Send notification to the assigned users
            foreach ($request->assignees as $assigneeId) {
                $assignee = User::find($assigneeId);
                if ($assignee) {
                    $assignee->notify(new TaskAssignedNotification($task, Auth::user()));
                }
            }
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'task' => $task->load(['creator', 'assignees', 'client', 'parent'])]);
        }

        return back()->with('success', 'Task created successfully.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:To-Do,In-Progress,Waiting-Approval,Completed',
        ]);

        $updateData = ['status' => $request->status];

        if ($request->status === 'Completed') {
            $updateData['completed_at'] = now();
        } else {
            $updateData['completed_at'] = null; // Reopen task
        }

        $task->update($updateData);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'task' => $task]);
        }

        return back()->with('success', 'Task status updated.');
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'due_date' => 'nullable|date',
        ]);

        $task->update($request->only(['due_date']));

        return response()->json(['success' => true, 'task' => $task]);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Task deleted successfully.');
    }

    public function show(Task $task)
    {
        // Load relationship data
        $task->load(['creator', 'assignees', 'client', 'comments.user', 'subtasks', 'parent']);
        
        return response()->json([
            'task' => $task
        ]);
    }

    public function updateAssignee(Request $request, Task $task)
    {
        $request->validate([
            'assignees' => 'nullable|array',
            'assignees.*' => 'exists:users,id',
            'client_id' => 'nullable|exists:clients,id'
        ]);

        $task->update([
            'client_id' => $request->has('client_id') ? $request->client_id : $task->client_id
        ]);

        $task->assignees()->sync($request->assignees ?? []);

        return response()->json(['success' => true, 'task' => $task->load('assignees')]);
    }

    public function addComment(Request $request, Task $task)
    {
        $request->validate([
            'comment' => 'required|string',
            'status_update' => 'nullable|string', // e.g. "Blocked", "Progress"
            'mentions' => 'nullable|array',
            'mentions.*' => 'exists:users,id'
        ]);

        $comment = $task->comments()->create([
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'status_update' => $request->status_update
        ]);

        if ($request->has('mentions') && is_array($request->mentions)) {
            foreach ($request->mentions as $userId) {
                if ($userId != Auth::id()) {
                    $user = User::find($userId);
                    if ($user) {
                        $user->notify(new UserMentionedNotification($task, Auth::user()));
                    }
                }
            }
        }

        return response()->json(['success' => true, 'comment' => $comment->load('user')]);
    }

    public function getCard(Task $task)
    {
        $task->load(['creator', 'assignees', 'client', 'parent']);
        return view('tasks._card', compact('task'))->render();
    }
}
