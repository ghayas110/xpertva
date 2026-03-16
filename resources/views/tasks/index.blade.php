@extends('layouts.dashboard')

@section('title', 'Tasks Management')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Task Board</h2>
    <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Manage and track project tasks.</p>
</div>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Your Tasks</h2>
        @if(in_array(auth()->user()->role, ['super_admin', 'hr', 'onboarding', 'va']))
        <button onclick="document.getElementById('createTaskModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Create New Task
        </button>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- To-Do Column -->
        <div class="bg-gray-50 dark:bg-slate-700 rounded-lg shadow-inner p-4 min-h-[400px]" data-status="To-Do" ondrop="drop(event)" ondragover="allowDrop(event)">
            <div class="flex items-center justify-between mb-4 border-b pb-2">
                <h3 class="font-bold text-lg text-gray-700 dark:text-slate-300">To-Do</h3>
                <span class="bg-gray-200 dark:bg-slate-600 text-gray-600 dark:text-slate-300 text-xs font-bold px-2 py-1 rounded-full">{{ $tasks->where('status', 'To-Do')->count() }}</span>
            </div>
            <div class="task-list space-y-3 min-h-[300px]">
                @foreach($tasks->where('status', 'To-Do') as $task)
                    @include('tasks._card', ['task' => $task])
                @endforeach
            </div>
        </div>

        <!-- In Progress Column -->
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg shadow-inner p-4 min-h-[400px]" data-status="In-Progress" ondrop="drop(event)" ondragover="allowDrop(event)">
            <div class="flex items-center justify-between mb-4 border-b border-blue-200 dark:border-blue-800 pb-2">
                <h3 class="font-bold text-lg text-blue-800 dark:text-blue-300">In Progress</h3>
                <span class="bg-blue-200 dark:bg-blue-800 text-blue-800 dark:text-blue-200 text-xs font-bold px-2 py-1 rounded-full">{{ $tasks->where('status', 'In-Progress')->count() }}</span>
            </div>
            <div class="task-list space-y-3 min-h-[300px]">
                @foreach($tasks->where('status', 'In-Progress') as $task)
                    @include('tasks._card', ['task' => $task])
                @endforeach
            </div>
        </div>

        <!-- Completed Column -->
        <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-lg shadow-inner p-4 min-h-[400px]" data-status="Completed" ondrop="drop(event)" ondragover="allowDrop(event)">
            <div class="flex items-center justify-between mb-4 border-b border-emerald-200 dark:border-emerald-800 pb-2">
                <h3 class="font-bold text-lg text-emerald-800 dark:text-emerald-300">Completed</h3>
                <span class="bg-emerald-200 dark:bg-emerald-800 text-emerald-800 dark:text-emerald-200 text-xs font-bold px-2 py-1 rounded-full">{{ $tasks->where('status', 'Completed')->count() }}</span>
            </div>
            <div class="task-list space-y-3 min-h-[300px]">
                @foreach($tasks->where('status', 'Completed') as $task)
                    @include('tasks._card', ['task' => $task])
                @endforeach
            </div>
        </div>
    </div>

    <!-- Create Task Form Modal -->
    @if(in_array(auth()->user()->role, ['super_admin', 'hr', 'onboarding', 'va']))
    <div id="createTaskModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-opacity">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl w-full max-w-2xl mx-4 overflow-hidden">
            <div class="flex justify-between items-center p-6 border-b">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Create New Task</h3>
                <button onclick="document.getElementById('createTaskModal').classList.add('hidden')" class="text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:text-slate-400 transition-colors">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required placeholder="What needs to be done?">
                    </div>
                    <div class="mb-5">
                        <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Description</label>
                        <textarea name="description" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all min-h-[100px]" placeholder="Add details..."></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                        <div>
                            <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Priority</label>
                            <select name="priority" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                            <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Assignees</label>
                            <select name="assignees[]" id="createTaskAssignees" multiple size="4" onchange="toggleClientDropdown(this, 'clientSelectionDiv')" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}" data-role="{{ $u->role }}">{{ $u->name }} ({{ ucfirst(str_replace('_', ' ', $u->role)) }})</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Hold Ctrl/Cmd to select multiple</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6 hidden" id="clientSelectionDiv">
                        <div>
                            <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Assign Client</label>
                            <select name="client_id" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                                <option value="">No Client (Internal Task)</option>
                                @if(isset($clients))
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->company_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <button type="button" onclick="document.getElementById('createTaskModal').classList.add('hidden')" class="px-5 py-2.5 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 text-gray-800 dark:text-white font-medium rounded-lg transition-colors">Cancel</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg transition-colors shadow-sm">
                            Create Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Edit Task Modal -->
    <div id="editTaskModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-opacity p-4">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl w-full max-w-4xl mx-auto overflow-hidden max-h-[90vh] flex flex-col">
            <div class="flex flex-col md:flex-row h-full">
                <!-- Main Task Info (Left side) -->
                <div class="w-full md:w-2/3 p-6 border-r border-gray-100 dark:border-slate-700 overflow-y-auto">
                    <div class="flex justify-between items-start mb-6">
                        <h3 id="editTaskTitle" class="text-2xl font-bold text-gray-800 dark:text-white">Task Title</h3>
                        <button onclick="closeEditModal()" class="text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:text-slate-400 transition-colors md:hidden">
                            <i class="fa-solid fa-times text-xl"></i>
                        </button>
                    </div>
                    
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 dark:text-slate-300 mb-2 flex items-center gap-2"><i class="fa-solid fa-align-left text-gray-400 dark:text-slate-500"></i> Description</h4>
                        <div id="editTaskDescription" class="text-gray-600 dark:text-slate-400 bg-gray-50 dark:bg-slate-700 rounded-lg p-4 min-h-[100px] text-sm"></div>
                    </div>

                    <!-- Comments Section -->
                    <div class="mt-8">
                        <h4 class="font-semibold text-gray-700 dark:text-slate-300 mb-4 flex items-center gap-2"><i class="fa-regular fa-comments text-gray-400 dark:text-slate-500"></i> Activity & Updates</h4>
                        
                        <!-- Add Comment Box -->
                        <div class="bg-white dark:bg-slate-800 border rounded-lg p-0 mb-6 focus-within:ring-2 focus-within:ring-blue-500 overflow-hidden">
                            <textarea id="taskCommentInput" class="w-full p-4 outline-none resize-y min-h-[80px] text-sm dark:bg-slate-700 dark:text-white" placeholder="Write an update, note a blocker, or share progress..."></textarea>
                            <div class="bg-gray-50 dark:bg-slate-700 px-4 py-3 border-t flex justify-between items-center">
                                <select id="taskMentionsUpdateInput" multiple class="bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded text-sm px-2 py-1 outline-none max-w-[120px]" title="Mention user(s)">
                                    <option value="" disabled>@ Mention</option>
                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endforeach
                                </select>
                                <select id="taskStatusUpdateInput" class="bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded text-sm px-2 py-1 outline-none">
                                    <option value="">Standard Note</option>
                                    <option value="Progress">On Track</option>
                                    <option value="Blocked">Blocked</option>
                                </select>
                                <button onclick="submitComment()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded text-sm font-semibold transition-colors">Save Update</button>
                            </div>
                        </div>

                        <!-- Comments List -->
                        <div id="taskCommentsList" class="space-y-4">
                            <!-- Injected via JS -->
                        </div>
                    </div>
                </div>

                <!-- Task Details (Right side) -->
                <div class="w-full md:w-1/3 bg-gray-50 dark:bg-slate-700 p-6 overflow-y-auto hidden md:block relative">
                    <button onclick="closeEditModal()" class="absolute top-6 right-6 text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:text-slate-400 transition-colors">
                        <i class="fa-solid fa-times text-xl"></i>
                    </button>
                    
                    <h4 class="font-semibold text-gray-700 dark:text-slate-300 mb-4 mt-2">Task Details</h4>
                    
                    <!-- Assignee Setup -->
                    <div class="mb-5">
                        <label class="block text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-2">Assignees</label>
                        <select id="editTaskAssignees" multiple size="4" onchange="updateAssignees()" class="w-full bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 outline-none">
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" data-role="{{ $u->role }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-gray-500 mt-1">Cmd/Ctrl click to multi-select</p>
                    </div>

                    <!-- Client Setup -->
                    <div class="mb-5 hidden" id="editClientSelectionDiv">
                        <label class="block text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-2">Client</label>
                        <select id="editTaskClient" onchange="updateAssignees()" class="w-full bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 outline-none">
                            <option value="">No Client</option>
                            @if(isset($clients))
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->company_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Readonly Meta Data -->
                    <div class="mb-5">
                        <label class="block text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1">Status</label>
                        <span id="editTaskStatusBadge" class="bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-slate-200 text-xs font-bold px-2 py-1 rounded inline-block"></span>
                    </div>

                    <div class="mb-5">
                        <label class="block text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1">Priority</label>
                        <span id="editTaskPriority" class="text-sm text-gray-700 dark:text-slate-300 capitalize"></span>
                    </div>

                    <div class="mb-5">
                        <label class="block text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1">Reporter</label>
                        <span id="editTaskCreator" class="text-sm text-gray-700 dark:text-slate-300"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Kanban Drag and Drop Logic
    function allowDrop(ev) {
        ev.preventDefault();
        const container = ev.target.closest('[data-status]');
        if (container) {
            container.classList.add('ring-2', 'ring-blue-400', 'bg-opacity-80');
        }
    }

    // Remove styles on drag leave
    document.addEventListener('dragleave', function(ev) {
        const container = ev.target.closest('[data-status]');
        if (container) {
            container.classList.remove('ring-2', 'ring-blue-400', 'bg-opacity-80');
        }
    });

    function drag(ev) {
        ev.dataTransfer.setData("taskId", ev.target.id.replace('task-', ''));
        ev.target.classList.add('opacity-50');
    }

    document.addEventListener('dragend', function(ev) {
        ev.target.classList.remove('opacity-50');
        document.querySelectorAll('[data-status]').forEach(el => {
            el.classList.remove('ring-2', 'ring-blue-400', 'bg-opacity-80');
        });
    });

    function drop(ev) {
        ev.preventDefault();
        const container = ev.target.closest('[data-status]');
        if (!container) return;
        
        container.classList.remove('ring-2', 'ring-blue-400', 'bg-opacity-80');
        
        const newStatus = container.getAttribute('data-status');
        const taskId = ev.dataTransfer.getData("taskId");
        
        if (!taskId) return;

        const taskElement = document.getElementById('task-' + taskId);
        
        // Only append if parent is different
        if (taskElement.parentElement.closest('[data-status]') !== container) {
            container.querySelector('.task-list').appendChild(taskElement);
            
            // Update backend via fetch API
            updateTaskStatus(taskId, newStatus);
        }
    }

    function updateTaskStatus(taskId, newStatus) {
        fetch(`/tasks/${taskId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Could flash a small toast if desired
                window.location.reload(); // Reload to update counters and styling perfectly
            }
        })
        .catch(error => console.error('Error updating task:', error));
    }

    function deleteTask(taskId) {
        if(confirm('Are you sure you want to delete this task?')) {
            fetch(`/tasks/${taskId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    document.getElementById(`task-${taskId}`).remove();
                }
            })
            .catch(err => console.error(err));
        }
    }

    // Modal Edit Logic
    let currentEditTaskId = null;

    function openEditModal(taskId) {
        currentEditTaskId = taskId;
        
        // Fetch task details via JSON
        fetch(`/tasks/${taskId}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            const task = data.task;
            
            // Populate Modal Fields
            document.getElementById('editTaskTitle').textContent = task.title;
            document.getElementById('editTaskDescription').textContent = task.description || 'No description provided.';
            
            // Assignee
            const assigneeSelect = document.getElementById('editTaskAssignees');
            Array.from(assigneeSelect.options).forEach(opt => opt.selected = false);
            if (task.assignees && task.assignees.length > 0) {
                const assigneeIds = task.assignees.map(a => a.id.toString());
                Array.from(assigneeSelect.options).forEach(opt => {
                    if (assigneeIds.includes(opt.value)) opt.selected = true;
                });
            }
            
            // Meta data
            document.getElementById('editTaskStatusBadge').textContent = task.status;
            document.getElementById('editTaskPriority').textContent = task.priority;
            document.getElementById('editTaskCreator').textContent = task.creator ? task.creator.name : 'System';
            
            // Client
            document.getElementById('editTaskClient').value = task.client_id || '';
            toggleClientDropdown(document.getElementById('editTaskAssignees'), 'editClientSelectionDiv');

            // Populate Comments
            renderComments(task.comments);

            // Show modal
            document.getElementById('editTaskModal').classList.remove('hidden');
        })
        .catch(err => console.error('Failed to fetch task details:', err));
    }

    function closeEditModal() {
        document.getElementById('editTaskModal').classList.add('hidden');
        currentEditTaskId = null;
    }

    function updateAssignees() {
        if (!currentEditTaskId) return;

        const selectElement = document.getElementById('editTaskAssignees');
        const selectedAssignees = Array.from(selectElement.selectedOptions).map(opt => opt.value);

        const newClientId = document.getElementById('editTaskClient').value;
        toggleClientDropdown(selectElement, 'editClientSelectionDiv');

        fetch(`/tasks/${currentEditTaskId}/assignee`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ 
                assignees: selectedAssignees,
                client_id: newClientId || null 
            })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                // If you want to dynamically re-render the card on index background, you'd usually emit event.
                // For now, reload to get fresh data on index or just let it be.
            }
        });
    }

    function submitComment() {
        if (!currentEditTaskId) return;

        const commentText = document.getElementById('taskCommentInput').value;
        const statusUpdate = document.getElementById('taskStatusUpdateInput').value;
        const mappedMentions = Array.from(document.getElementById('taskMentionsUpdateInput').selectedOptions).map(opt => opt.value);
        
        if (!commentText.trim()) return;

        fetch(`/tasks/${currentEditTaskId}/comments`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                comment: commentText,
                status_update: statusUpdate,
                mentions: mappedMentions
            })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                // Clear input
                document.getElementById('taskCommentInput').value = '';
                document.getElementById('taskStatusUpdateInput').value = '';
                Array.from(document.getElementById('taskMentionsUpdateInput').options).forEach(opt => opt.selected = false);
                
                // Prepend to list directly (optimistic update mapping)
                const list = document.getElementById('taskCommentsList');
                list.innerHTML = createCommentHtml(data.comment) + list.innerHTML;
            }
        });
    }

    function renderComments(comments) {
        const list = document.getElementById('taskCommentsList');
        if (!comments || comments.length === 0) {
            list.innerHTML = '<p class="text-sm text-gray-400 dark:text-slate-500 italic">No activity yet.</p>';
            return;
        }

        list.innerHTML = comments.map(c => createCommentHtml(c)).join('');
    }

    function createCommentHtml(comment) {
        const date = new Date(comment.created_at).toLocaleDateString(undefined, { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
        const userName = comment.user ? comment.user.name : 'User';
        
        let tagHtml = '';
        if (comment.status_update) {
            const colorClass = comment.status_update === 'Blocked' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700';
            tagHtml = `<span class="ml-2 text-xs font-bold px-2 py-0.5 rounded ${colorClass}">${comment.status_update}</span>`;
        }

        return `
            <div class="flex gap-3 mb-4 last:mb-0 pb-4 border-b last:border-b-0 border-gray-100 dark:border-slate-700">
                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 font-bold text-sm">
                    ${userName.charAt(0)}
                </div>
                <div class="flex-grow">
                    <div class="flex justify-between items-start mb-1">
                        <div>
                            <span class="font-bold text-sm text-gray-800 dark:text-white">${userName}</span>
                            ${tagHtml}
                        </div>
                        <span class="text-xs text-gray-400 dark:text-slate-500">${date}</span>
                    </div>
                    <p class="text-gray-600 dark:text-slate-400 text-sm whitespace-pre-wrap">${comment.comment}</p>
                </div>
            </div>
        `;
    }

    function toggleClientDropdown(selectElement, divId) {
        let hasVaRole = false;
        
        // Check if ANY of the selected options is a VA
        Array.from(selectElement.selectedOptions).forEach(opt => {
            if (opt.getAttribute('data-role') === 'va') {
                hasVaRole = true;
            }
        });

        const clientDiv = document.getElementById(divId);
        
        if (hasVaRole) {
            clientDiv.classList.remove('hidden');
        } else {
            clientDiv.classList.add('hidden');
        }
    }

    // Check for open_task query parameter on load
    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const taskId = urlParams.get('open_task');
        if (taskId) {
            openEditModal(taskId);
        }
    });
</script>
@endpush
