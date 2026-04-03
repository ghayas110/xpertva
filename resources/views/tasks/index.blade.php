@extends('layouts.dashboard')

@section('title', 'Tasks Management')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Task Board</h2>
    <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Manage and track project tasks.</p>
</div>


    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Your Tasks</h2>
        @if(in_array(auth()->user()->role, ['super_admin', 'hr', 'onboarding', 'va']))
        <button onclick="document.getElementById('createTaskModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Create New Task
        </button>
        @endif
    </div>

    <!-- Filters Block -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 bg-white dark:bg-slate-800 p-4 rounded-lg shadow-sm border border-gray-100 dark:border-slate-700">
        <div class="flex-1 w-full overflow-x-auto pb-2 md:pb-0 scrollbar-hide">
            <div class="flex gap-2">
                <button onclick="filterTasks('client', '')" id="filter-btn-all" class="client-pill whitespace-nowrap bg-blue-600 text-white border-blue-600 px-4 py-1.5 rounded-full text-sm font-bold shadow-sm transition-colors border">All Tasks</button>
                @foreach($clients as $client)
                    <button onclick="filterTasks('client', '{{ $client->id }}')" id="filter-btn-{{ $client->id }}" class="client-pill whitespace-nowrap bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-300 hover:bg-gray-200 dark:hover:bg-slate-600 px-4 py-1.5 rounded-full text-sm font-bold shadow-sm transition-colors border border-transparent flex items-center gap-2" data-client-id="{{ $client->id }}">
                        <i class="fa-solid fa-building text-gray-400 dark:text-slate-500"></i> {{ $client->company_name }}
                    </button>
                @endforeach
            </div>
        </div>

        @if(auth()->user()->role === 'super_admin')
        <div class="flex items-center gap-3 shrink-0">
            <label class="text-sm font-bold text-gray-600 dark:text-slate-400 whitespace-nowrap"><i class="fa-solid fa-filter text-indigo-500"></i> Employee SID:</label>
            <select id="employeeFilter" onchange="filterTasks('employee', this.value)" class="bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-sm rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-blue-500 outline-none text-gray-700 dark:text-white font-medium cursor-pointer max-w-[200px]">
                <option value="">All Employees</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ ucwords(str_replace('_', ' ', $user->role)) }})</option>
                @endforeach
            </select>
        </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
        <!-- To-Do Column -->
        <div id="todo-column" class="bg-gray-100 dark:bg-slate-800 rounded-lg shadow-inner p-4 min-h-[400px]" data-status="To-Do" ondrop="drop(event)" ondragover="allowDrop(event)">
            <div class="flex items-center justify-between mb-4 border-b border-gray-200 dark:border-slate-700 pb-2">
                <h3 class="font-bold text-lg text-gray-700 dark:text-slate-200 uppercase tracking-tighter">To-Do</h3>
                <span id="todo-count" class="bg-gray-200 dark:bg-slate-600 text-gray-600 dark:text-slate-300 text-xs font-bold px-2 py-1 rounded-full">{{ $tasks->where('status', 'To-Do')->count() }}</span>
            </div>
            <div id="todo-list" class="task-list space-y-3 min-h-[300px]">
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

        <!-- Waiting for Approval Column -->
        <div class="bg-amber-50 dark:bg-amber-900/20 rounded-lg shadow-inner p-4 min-h-[400px]" data-status="Waiting-Approval" ondrop="drop(event)" ondragover="allowDrop(event)">
            <div class="flex items-center justify-between mb-4 border-b border-amber-200 dark:border-amber-800 pb-2">
                <h3 class="font-bold text-lg text-amber-800 dark:text-amber-300">Waiting for Approval</h3>
                <span class="bg-amber-200 dark:bg-amber-800 text-amber-800 dark:text-amber-200 text-xs font-bold px-2 py-1 rounded-full">{{ $tasks->where('status', 'Waiting-Approval')->count() }}</span>
            </div>
            <div class="task-list space-y-3 min-h-[300px]">
                @foreach($tasks->where('status', 'Waiting-Approval') as $task)
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
                        </div>
                        <div class="relative">
                            <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Assignees</label>
                            
                            <!-- Hidden Select -->
                            <select name="assignees[]" id="createTaskAssignees" multiple class="hidden" onchange="toggleClientDropdown(this, 'clientSelectionDiv'); renderCreateAssignedMembersDisplay()">
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}" data-role="{{ $u->role }}" data-name="{{ $u->name }}">{{ $u->name }} ({{ ucfirst(str_replace('_', ' ', $u->role)) }})</option>
                                @endforeach
                            </select>

                            <!-- Assigned Members Display -->
                            <div id="createAssignedMembersDisplay" class="flex flex-wrap gap-2 mb-2 p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg border border-gray-200 dark:border-slate-600 min-h-[50px] items-center">
                                <span class="text-sm text-gray-400 dark:text-slate-500 italic">No members assigned</span>
                            </div>
                            
                            <button type="button" onclick="toggleCreateMembersPopover()" class="text-sm text-indigo-600 hover:text-indigo-700 font-bold flex items-center gap-1 transition-colors mt-2">
                                <i class="fa-solid fa-user-plus text-xs"></i> Select Members
                            </button>

                            <!-- Create Members Popover -->
                            <div id="createMembersPopover" class="hidden fixed z-[9999] w-72 bg-white dark:bg-slate-800 rounded-lg shadow-xl border border-gray-200 dark:border-slate-600 overflow-hidden">
                                <div class="flex justify-between items-center px-4 py-3 border-b border-gray-100 dark:border-slate-700">
                                    <h5 class="font-bold text-sm text-gray-800 dark:text-white">Members</h5>
                                    <button type="button" onclick="toggleCreateMembersPopover()" class="text-gray-400 hover:text-gray-600 dark:hover:text-slate-300">
                                        <i class="fa-solid fa-times text-sm"></i>
                                    </button>
                                </div>
                                <div class="px-4 py-2">
                                    <input type="text" id="createMemberSearchInput" oninput="filterCreateMembers()" placeholder="Search members" class="w-full text-sm border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md px-3 py-2 outline-none focus:border-indigo-400">
                                </div>
                                
                                <div id="createCardMembersSection" class="hidden">
                                    <p class="px-4 py-1 text-[11px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Selected members</p>
                                    <div id="createCardMembersList" class="max-h-[120px] overflow-y-auto"></div>
                                </div>
                                
                                <div id="createBoardMembersSection">
                                    <p class="px-4 py-1 text-[11px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Board members</p>
                                    <div id="createBoardMembersList" class="max-h-[180px] overflow-y-auto pb-2"></div>
                                </div>
                            </div>
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
                    <div class="flex justify-end gap-3 mt-4 -mx-6 -mb-6 px-6 py-4 bg-gray-50 dark:bg-slate-700/30 border-t border-gray-100 dark:border-slate-700 rounded-b-xl">
                        <button type="button" onclick="document.getElementById('createTaskModal').classList.add('hidden')" class="px-5 py-2.5 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600 border border-gray-200 dark:border-slate-600 text-gray-800 dark:text-white font-medium rounded-lg transition-colors">Cancel</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg transition-colors shadow-sm focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800">
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
                        <div id="editTaskDescription" class="text-gray-600 dark:text-slate-400 bg-gray-50 dark:bg-slate-700 rounded-lg p-4 min-h-[80px] text-sm"></div>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 dark:text-slate-300 mb-2 flex items-center justify-between gap-2">
                            <span class="flex items-center gap-2">
                                <i class="fa-solid fa-list-ul text-gray-400 dark:text-slate-500"></i> Subtasks
                                <!-- Subtask Loader -->
                                <div id="subtaskLoader" class="hidden ml-2 inline-block animate-spin rounded-full h-4 w-4 border-2 border-indigo-500 border-t-transparent"></div>
                            </span>
                            <button onclick="toggleSubtaskForm()" class="text-indigo-600 hover:text-indigo-700 text-xs font-bold transition-colors">
                                <i class="fa-solid fa-plus"></i> Add Subtask
                            </button>
                        </h4>
                        
                        <!-- Subtask Creation Form (Hidden by default) -->
                        <div id="subtaskForm" class="hidden mb-4 bg-gray-100 dark:bg-slate-900 rounded-lg p-4 border border-indigo-200 dark:border-indigo-900">
                            <div class="mb-3">
                                <label class="block text-xs font-bold text-gray-500 dark:text-slate-400 uppercase mb-1">Parent Task Description</label>
                                <div id="parentTaskDescriptionPreview" class="text-xs text-gray-600 dark:text-slate-400 italic mb-2 p-2 bg-white dark:bg-slate-800 rounded border border-gray-200 dark:border-slate-700"></div>
                            </div>
                            <div class="mb-3">
                                <input type="text" id="subtaskTitleInput" class="w-full text-sm border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded px-3 py-2 outline-none focus:border-indigo-500" placeholder="Subtask title...">
                            </div>
                            <div class="flex justify-end gap-2">
                                <button onclick="toggleSubtaskForm()" class="px-3 py-1.5 text-xs text-gray-500 hover:text-gray-700 font-bold transition-colors">Cancel</button>
                                <button onclick="submitSubtask()" id="submitSubtaskBtn" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-xs font-bold transition-colors shadow-sm flex items-center gap-2">
                                    <span id="subtaskBtnText">Create Subtask</span>
                                    <div id="subtaskBtnLoader" class="hidden animate-spin rounded-full h-3 w-3 border-2 border-white border-t-transparent"></div>
                                </button>
                            </div>
                        </div>

                        <div id="subtasksList" class="space-y-1">
                            <!-- Injected via JS -->
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="mt-8">
                        <h4 class="font-semibold text-gray-700 dark:text-slate-300 mb-4 flex items-center gap-2"><i class="fa-regular fa-comments text-gray-400 dark:text-slate-500"></i> Activity & Updates</h4>
                        
                        <!-- Add Comment Box -->
                        <div class="bg-white dark:bg-slate-800 border rounded-lg p-0 mb-6 focus-within:ring-2 focus-within:ring-blue-500 overflow-hidden relative">
                            <textarea id="taskCommentInput" oninput="handleMentionInput(event)" onkeydown="handleMentionKeydown(event)" class="w-full p-4 outline-none resize-y min-h-[80px] text-sm dark:bg-slate-700 dark:text-white" placeholder="Write an update... type @ to mention someone"></textarea>
                            
                            <!-- @Mention Suggestions Dropdown -->
                            <div id="mentionSuggestionsDropdown" class="hidden fixed z-[9999] bg-white dark:bg-slate-800 rounded-lg shadow-xl border border-gray-200 dark:border-slate-600 w-64 max-h-[200px] overflow-y-auto">
                                <!-- Populated via JS -->
                            </div>

                            <!-- Hidden field to track mentioned user IDs -->
                            <input type="hidden" id="taskMentionIds" value="[]">
                            
                            <div class="bg-gray-50 dark:bg-slate-700 px-4 py-3 border-t flex justify-between items-center">
                                <div class="flex items-center gap-2">
                                    <span id="mentionedUsersPreview" class="flex items-center gap-1 text-xs text-gray-400 dark:text-slate-500">
                                        <!-- Shows mentioned user badges -->
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <select id="taskStatusUpdateInput" class="bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded text-sm px-2 py-1 outline-none">
                                        <option value="">Standard Note</option>
                                        <option value="Progress">On Track</option>
                                        <option value="Blocked">Blocked</option>
                                    </select>
                                    <button onclick="submitComment()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded text-sm font-semibold transition-colors">Save Update</button>
                                </div>
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
                    
                    <!-- Assignee Setup (Trello-style) -->
                    <div class="mb-5">
                        <label class="block text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-2">Members</label>
                        
                        <!-- Assigned Members Display -->
                        <div id="assignedMembersDisplay" class="flex flex-wrap gap-2 mb-2">
                            <!-- Populated via JS -->
                        </div>
                        
                        <button type="button" onclick="toggleMembersPopover()" class="text-sm text-indigo-600 hover:text-indigo-700 font-bold flex items-center gap-1 transition-colors">
                            <i class="fa-solid fa-user-plus text-xs"></i> Manage Members
                        </button>
                        
                        <!-- Members Popover -->
                        <div id="membersPopover" class="hidden fixed z-[9999] w-72 bg-white dark:bg-slate-800 rounded-lg shadow-xl border border-gray-200 dark:border-slate-600 overflow-hidden">
                            <div class="flex justify-between items-center px-4 py-3 border-b border-gray-100 dark:border-slate-700">
                                <h5 class="font-bold text-sm text-gray-800 dark:text-white">Members</h5>
                                <button onclick="toggleMembersPopover()" class="text-gray-400 hover:text-gray-600 dark:hover:text-slate-300">
                                    <i class="fa-solid fa-times text-sm"></i>
                                </button>
                            </div>
                            <div class="px-4 py-2">
                                <input type="text" id="memberSearchInput" oninput="filterMembers()" placeholder="Search members" class="w-full text-sm border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md px-3 py-2 outline-none focus:border-indigo-400">
                            </div>
                            
                            <!-- Card Members (Assigned) -->
                            <div id="cardMembersSection" class="hidden">
                                <p class="px-4 py-1 text-[11px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Card members</p>
                                <div id="cardMembersList" class="max-h-[120px] overflow-y-auto">
                                    <!-- Populated via JS -->
                                </div>
                            </div>
                            
                            <!-- Board Members (Unassigned) -->
                            <div id="boardMembersSection">
                                <p class="px-4 py-1 text-[11px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Board members</p>
                                <div id="boardMembersList" class="max-h-[180px] overflow-y-auto pb-2">
                                    <!-- Populated via JS -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden select to hold actual values for updateAssignees -->
                    <select id="editTaskAssignees" multiple class="hidden" onchange="updateAssignees()">
                        @foreach($users as $u)
                            <option value="{{ $u->id }}" data-role="{{ $u->role }}" data-name="{{ $u->name }}">{{ $u->name }}</option>
                        @endforeach
                    </select>

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

                    <!-- Due Date (Trello-style) -->
                    <div class="mb-5">
                        <label class="block text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-2">Dates</label>
                        <div id="dueDateDisplay" class="flex items-center gap-2 mb-2">
                            <span id="dueDateText" class="text-sm text-gray-700 dark:text-slate-300 italic">No due date</span>
                        </div>
                        <button type="button" onclick="toggleDatePopover()" class="text-sm text-indigo-600 hover:text-indigo-700 font-bold flex items-center gap-1 transition-colors">
                            <i class="fa-regular fa-calendar text-xs"></i> Set Date
                        </button>
                        
                        <!-- Date Popover -->
                        <div id="datePopover" class="hidden fixed z-[9999] w-72 bg-white dark:bg-slate-800 rounded-lg shadow-xl border border-gray-200 dark:border-slate-600 overflow-hidden">
                            <div class="flex justify-between items-center px-4 py-3 border-b border-gray-100 dark:border-slate-700">
                                <h5 class="font-bold text-sm text-gray-800 dark:text-white">Dates</h5>
                                <button onclick="toggleDatePopover()" class="text-gray-400 hover:text-gray-600 dark:hover:text-slate-300">
                                    <i class="fa-solid fa-times text-sm"></i>
                                </button>
                            </div>
                            <div class="p-4">
                                <label class="block text-xs font-bold text-gray-500 dark:text-slate-400 uppercase mb-2">Due date</label>
                                <input type="date" id="dueDateInput" class="w-full text-sm border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md px-3 py-2 outline-none focus:border-indigo-400 mb-3">
                                <div class="flex gap-2">
                                    <button onclick="saveDueDate()" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 rounded-md transition-colors">Save</button>
                                    <button onclick="removeDueDate()" class="flex-1 bg-gray-100 dark:bg-slate-600 hover:bg-gray-200 dark:hover:bg-slate-500 text-gray-700 dark:text-slate-300 text-sm font-bold py-2 rounded-md transition-colors">Remove</button>
                                </div>
                            </div>
                        </div>
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

                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-slate-600">
                        <button id="completeBtn" onclick="changeStatus('Completed')" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-lg transition-colors shadow-sm mb-3">
                            <i class="fa-solid fa-circle-check"></i> Mark as Completed
                        </button>
                        <button id="reopenBtn" onclick="changeStatus('To-Do')" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2.5 rounded-lg transition-colors shadow-sm mb-3 hidden">
                            <i class="fa-solid fa-rotate-left"></i> Reopen Task
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Task Modal -->
    <div id="deleteTaskModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-opacity">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl w-full max-w-sm mx-4 overflow-hidden">
            <div class="p-6 text-center">
                <div class="w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Delete Task</h3>
                <p class="text-gray-600 dark:text-slate-400 mb-6">Do you want to delete the task or not?</p>
                <div class="flex justify-center gap-3">
                    <button onclick="closeDeleteModal()" class="px-5 py-2.5 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 text-gray-800 dark:text-white font-medium rounded-lg transition-colors">Cancel</button>
                    <button onclick="confirmDeleteTask()" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-lg transition-colors shadow-sm">
                        Delete
                    </button>
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

    let taskToDeleteId = null;

    let isSubtaskDeletion = false;
    function openDeleteModal(taskId, isSubtask = false) {
        if(event) {
            event.stopPropagation(); // prevent opening the edit modal
        }
        taskToDeleteId = taskId;
        isSubtaskDeletion = isSubtask;
        document.getElementById('deleteTaskModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteTaskModal').classList.add('hidden');
        taskToDeleteId = null;
    }

    function confirmDeleteTask() {
        if (!taskToDeleteId) return;

        fetch(`/tasks/${taskToDeleteId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                // Remove from Kanban board
                const card = document.getElementById(`task-${taskToDeleteId}`);
                if (card) {
                    // Update column count if removing from board
                    const column = card.closest('[data-status]');
                    if (column) {
                        const status = column.getAttribute('data-status');
                        const countSpan = document.getElementById(`${status.toLowerCase()}-count`);
                        if (countSpan) {
                            countSpan.textContent = Math.max(0, (parseInt(countSpan.textContent) || 0) - 1);
                        }
                    }
                    card.remove();
                }

                // If deleted from a subtask list, remove the row
                if (isSubtaskDeletion) {
                    const subtaskRow = document.getElementById(`subtask-row-${taskToDeleteId}`);
                    if (subtaskRow) subtaskRow.remove();
                    
                    const subtasksList = document.getElementById('subtasksList');
                    if (subtasksList && subtasksList.children.length === 0) {
                        subtasksList.innerHTML = '<p class="text-[10px] text-gray-400 dark:text-slate-500 italic">No subtasks yet.</p>';
                    }
                }

                closeDeleteModal();
            }
        })
        .catch(err => {
            console.error(err);
            closeDeleteModal();
        });
    }

    // Modal Edit Logic
    let currentEditTaskId = null;

    function openEditModal(taskId) {
        // Show skeleton immediately
        renderSubtaskSkeleton();
        
        // Fetch task details via JSON
        fetch(`/tasks/${taskId}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            renderTaskInModal(data.task);
        })
        .catch(err => console.error('Failed to fetch task details:', err));
    }

    function renderSubtaskSkeleton() {
        const list = document.getElementById('subtasksList');
        if (!list) return;
        
        list.innerHTML = `
            <div class="animate-pulse space-y-2">
                <div class="h-9 bg-gray-100 dark:bg-slate-700 rounded-md w-full opacity-60"></div>
                <div class="h-9 bg-gray-100 dark:bg-slate-700 rounded-md w-full opacity-40"></div>
            </div>
        `;
    }

    function renderTaskInModal(task) {
        currentEditTaskId = task.id;
        
        // Reset subtask form
        document.getElementById('subtaskForm').classList.add('hidden');
        document.getElementById('subtaskTitleInput').value = '';
        
        // Populate Modal Fields
        document.getElementById('editTaskTitle').textContent = task.title;
        document.getElementById('editTaskDescription').textContent = task.description || 'No description provided.';
        document.getElementById('parentTaskDescriptionPreview').textContent = task.description || 'No parent description.';
        
        // Assignee
        const assigneeSelect = document.getElementById('editTaskAssignees');
        Array.from(assigneeSelect.options).forEach(opt => opt.selected = false);
        if (task.assignees && task.assignees.length > 0) {
            const assigneeIds = task.assignees.map(a => a.id.toString());
            Array.from(assigneeSelect.options).forEach(opt => {
                if (assigneeIds.includes(opt.value)) opt.selected = true;
            });
        }
        
        // Render Trello-style member avatars
        renderAssignedMembersDisplay();
        // Close popover if open
        document.getElementById('membersPopover').classList.add('hidden');
        
        document.getElementById('editTaskStatusBadge').textContent = task.status;
        document.getElementById('editTaskPriority').textContent = task.priority;
        document.getElementById('editTaskCreator').textContent = task.creator ? task.creator.name : 'System';
        
        // Status Buttons visibility
        if (task.status === 'Completed') {
            document.getElementById('completeBtn').classList.add('hidden');
            document.getElementById('reopenBtn').classList.remove('hidden');
        } else {
            document.getElementById('completeBtn').classList.remove('hidden');
            document.getElementById('reopenBtn').classList.add('hidden');
        }

        // Client
        document.getElementById('editTaskClient').value = task.client_id || '';
        toggleClientDropdown(document.getElementById('editTaskAssignees'), 'editClientSelectionDiv');

        // Due Date
        renderDueDateDisplay(task.due_date ? task.due_date.split('T')[0] : null);
        document.getElementById('datePopover').classList.add('hidden');

        // Reset mentions
        document.getElementById('taskMentionIds').value = '[]';
        document.getElementById('mentionedUsersPreview').innerHTML = '';
        document.getElementById('taskCommentInput').value = '';

        // Populate Comments
        renderComments(task.comments);

        // Populate Subtasks
        renderSubtasks(task.subtasks);

        // Show modal
        document.getElementById('editTaskModal').classList.remove('hidden');
    }

    function changeStatus(newStatus) {
        if (!currentEditTaskId) return;
        updateTaskStatus(currentEditTaskId, newStatus);
    }

    function toggleSubtaskForm() {
        const form = document.getElementById('subtaskForm');
        form.classList.toggle('hidden');
    }

    function submitSubtask() {
        if (!currentEditTaskId) return;

        const parentTaskId = currentEditTaskId;
        const titleInput = document.getElementById('subtaskTitleInput');
        const title = titleInput.value;
        if (!title.trim()) return;

        // Show Loader & Disable Button
        const btn = document.getElementById('submitSubtaskBtn');
        const loader = document.getElementById('subtaskBtnLoader');
        const btnText = document.getElementById('subtaskBtnText');
        const headingLoader = document.getElementById('subtaskLoader');
        
        btn.disabled = true;
        loader.classList.remove('hidden');
        headingLoader.classList.remove('hidden');
        btnText.textContent = 'Creating...';

        // Show Skeleton in list immediately
        renderSubtaskSkeleton();

        // Fetch main task details to clone some properties if needed
        fetch(`/tasks/${parentTaskId}`, { headers: { 'Accept': 'application/json' } })
        .then(res => res.json())
        .then(data => {
            const parentTask = data.task;
            
            fetch('/tasks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    title: title,
                    description: '', 
                    priority: parentTask.priority || 'medium',
                    client_id: parentTask.client_id,
                    parent_id: parentTaskId,
                    assignees: parentTask.assignees ? parentTask.assignees.map(a => a.id) : []
                })
            })
            .then(res => res.json())
            .then(resData => {
                if (resData.success) {
                    const newTask = resData.task;

                    // 1. Re-fetch the PARENT task to get the updated subtask list
                    // Keep showing skeleton while we fetch
                    setTimeout(() => {
                        fetch(`/tasks/${parentTaskId}`, { headers: { 'Accept': 'application/json' } })
                        .then(r => r.json())
                        .then(parentData => {
                            // Only update subtasks list, don't replace the whole modal
                            renderSubtasks(parentData.task.subtasks);
                            
                            // Reset Creation Form
                            titleInput.value = '';
                            btn.disabled = false;
                            loader.classList.add('hidden');
                            headingLoader.classList.add('hidden');
                            btnText.textContent = 'Create Subtask';
                        });
                    }, 400);

                    // 2. Fetch the board card HTML in the background
                    fetch(`/tasks/${newTask.id}/card`, {
                        headers: { 'Accept': 'text/html' }
                    })
                    .then(cardRes => cardRes.text())
                    .then(cardHtml => {
                        // 3. Add the card to the "To-Do" list on the board
                        const todoList = document.getElementById('todo-list');
                        if (todoList) {
                            const wrapper = document.createElement('div');
                            wrapper.innerHTML = cardHtml.trim();
                            const newCard = wrapper.firstChild;
                            todoList.prepend(newCard);
                            
                            // 4. Increment the To-Do count
                            const todoCount = document.getElementById('todo-count');
                            if (todoCount) {
                                todoCount.textContent = (parseInt(todoCount.textContent) || 0) + 1;
                            }
                        }
                    });
                }
            })
            .catch(err => {
                btn.disabled = false;
                loader.classList.add('hidden');
                headingLoader.classList.add('hidden');
                btnText.textContent = 'Create Subtask';
                console.error(err);
            });
        });
    }

    function renderSubtasks(subtasks) {
        const list = document.getElementById('subtasksList');
        if (!subtasks || subtasks.length === 0) {
            list.innerHTML = '<p class="text-[10px] text-gray-400 dark:text-slate-500 italic">No subtasks yet.</p>';
            return;
        }

        list.innerHTML = subtasks.map(s => `
            <div id="subtask-row-${s.id}" class="flex items-center gap-2 p-2 bg-white dark:bg-slate-800 border dark:border-slate-700 rounded text-sm hover:border-indigo-300 group">
                <i class="fa-solid fa-circle-dot text-[10px] text-indigo-400"></i>
                <button onclick="openEditModal(${s.id})" class="flex-grow text-left hover:text-indigo-600 transition-colors ${s.status === 'Completed' ? 'line-through text-gray-400' : 'text-gray-700 dark:text-slate-300'}">
                    ${s.title}
                </button>
                <span class="text-[10px] px-1.5 py-0.5 rounded ${s.status === 'Completed' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'}">${s.status}</span>
                <button onclick="openDeleteModal(${s.id}, true)" class="text-gray-400 hover:text-red-500 transition-colors opacity-0 group-hover:opacity-100 p-1">
                    <i class="fa-solid fa-trash-can text-xs"></i>
                </button>
            </div>
        `).join('');
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
                // Dynamically refresh the task card on the Kanban board
                fetch(`/tasks/${currentEditTaskId}/card`, {
                    headers: { 'Accept': 'text/html' }
                })
                .then(cardRes => cardRes.text())
                .then(cardHtml => {
                    const existingCard = document.getElementById(`task-${currentEditTaskId}`);
                    if (existingCard) {
                        const wrapper = document.createElement('div');
                        wrapper.innerHTML = cardHtml.trim();
                        const newCard = wrapper.firstChild;
                        existingCard.replaceWith(newCard);
                    }
                });
            }
        });
    }

    function submitComment() {
        if (!currentEditTaskId) return;

        const commentText = document.getElementById('taskCommentInput').value;
        const statusUpdate = document.getElementById('taskStatusUpdateInput').value;
        const mentionIds = JSON.parse(document.getElementById('taskMentionIds').value || '[]');
        
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
                mentions: mentionIds
            })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                // Clear input
                document.getElementById('taskCommentInput').value = '';
                document.getElementById('taskStatusUpdateInput').value = '';
                document.getElementById('taskMentionIds').value = '[]';
                document.getElementById('mentionedUsersPreview').innerHTML = '';
                
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

    // ========== @Mention System ==========
    const allUsers = [
        @foreach($users as $u)
            { id: {{ $u->id }}, name: "{{ $u->name }}" },
        @endforeach
    ];
    
    let mentionActive = false;
    let mentionQuery = '';
    let mentionStartPos = 0;
    let mentionSelectedIndex = 0;

    function handleMentionInput(e) {
        const textarea = e.target;
        const value = textarea.value;
        const cursorPos = textarea.selectionStart;
        
        // Find the last @ before cursor
        const textBeforeCursor = value.substring(0, cursorPos);
        const lastAtIndex = textBeforeCursor.lastIndexOf('@');
        
        if (lastAtIndex !== -1) {
            const textAfterAt = textBeforeCursor.substring(lastAtIndex + 1);
            // Only activate if no space in the query (still typing a name)
            if (!textAfterAt.includes(' ') || textAfterAt.length === 0) {
                mentionActive = true;
                mentionStartPos = lastAtIndex;
                mentionQuery = textAfterAt.toLowerCase();
                mentionSelectedIndex = 0;
                renderMentionSuggestions();
                return;
            }
        }
        
        closeMentionDropdown();
    }

    function handleMentionKeydown(e) {
        if (!mentionActive) return;
        
        const dropdown = document.getElementById('mentionSuggestionsDropdown');
        const items = dropdown.querySelectorAll('[data-mention-user]');
        
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            mentionSelectedIndex = Math.min(mentionSelectedIndex + 1, items.length - 1);
            highlightMentionItem(items);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            mentionSelectedIndex = Math.max(mentionSelectedIndex - 1, 0);
            highlightMentionItem(items);
        } else if (e.key === 'Enter' && mentionActive && items.length > 0) {
            e.preventDefault();
            const selectedItem = items[mentionSelectedIndex];
            if (selectedItem) {
                insertMention(selectedItem.dataset.mentionUser, selectedItem.dataset.mentionName);
            }
        } else if (e.key === 'Escape') {
            closeMentionDropdown();
        }
    }

    function highlightMentionItem(items) {
        items.forEach((item, i) => {
            if (i === mentionSelectedIndex) {
                item.classList.add('bg-indigo-50', 'dark:bg-slate-700');
            } else {
                item.classList.remove('bg-indigo-50', 'dark:bg-slate-700');
            }
        });
    }

    function renderMentionSuggestions() {
        const dropdown = document.getElementById('mentionSuggestionsDropdown');
        const filtered = allUsers.filter(u => u.name.toLowerCase().includes(mentionQuery));
        
        if (filtered.length === 0) {
            closeMentionDropdown();
            return;
        }

        dropdown.innerHTML = filtered.map((u, i) => {
            const initials = getInitials(u.name);
            const color = getMemberColor(u.id);
            return `
                <button type="button" data-mention-user="${u.id}" data-mention-name="${u.name}" onclick="insertMention('${u.id}', '${u.name}')" 
                    class="flex items-center gap-3 w-full px-4 py-2 hover:bg-indigo-50 dark:hover:bg-slate-700 transition-colors text-left ${i === mentionSelectedIndex ? 'bg-indigo-50 dark:bg-slate-700' : ''}">
                    <div class="w-7 h-7 rounded-full ${color} text-white flex items-center justify-center text-[10px] font-bold shrink-0">${initials}</div>
                    <span class="text-sm text-gray-700 dark:text-slate-300">${u.name}</span>
                </button>
            `;
        }).join('');
        
        // Position near the textarea using fixed coords
        const textarea = document.getElementById('taskCommentInput');
        const rect = textarea.getBoundingClientRect();
        dropdown.style.left = (rect.left) + 'px';
        dropdown.style.top = (rect.bottom + 4) + 'px';
        dropdown.classList.remove('hidden');
    }

    function insertMention(userId, userName) {
        const textarea = document.getElementById('taskCommentInput');
        const value = textarea.value;
        const before = value.substring(0, mentionStartPos);
        const after = value.substring(textarea.selectionStart);
        
        textarea.value = before + '@' + userName + ' ' + after;
        textarea.focus();
        const newPos = mentionStartPos + userName.length + 2;
        textarea.setSelectionRange(newPos, newPos);
        
        // Track mention
        const mentionIdsInput = document.getElementById('taskMentionIds');
        const ids = JSON.parse(mentionIdsInput.value || '[]');
        if (!ids.includes(parseInt(userId))) {
            ids.push(parseInt(userId));
            mentionIdsInput.value = JSON.stringify(ids);
        }
        
        // Update preview
        updateMentionPreview();
        closeMentionDropdown();
    }

    function updateMentionPreview() {
        const ids = JSON.parse(document.getElementById('taskMentionIds').value || '[]');
        const preview = document.getElementById('mentionedUsersPreview');
        
        if (ids.length === 0) {
            preview.innerHTML = '';
            return;
        }
        
        const names = ids.map(id => {
            const user = allUsers.find(u => u.id === id);
            return user ? `<span class="bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 text-[10px] font-bold px-1.5 py-0.5 rounded">@${user.name}</span>` : '';
        }).join('');
        
        preview.innerHTML = '<i class="fa-solid fa-at text-[10px] text-indigo-400 mr-1"></i>' + names;
    }

    function closeMentionDropdown() {
        mentionActive = false;
        document.getElementById('mentionSuggestionsDropdown').classList.add('hidden');
    }

    // ========== Date Popover ==========
    function toggleDatePopover() {
        const popover = document.getElementById('datePopover');
        popover.classList.toggle('hidden');
        if (!popover.classList.contains('hidden')) {
            const trigger = document.querySelector('[onclick*="toggleDatePopover"]');
            if (trigger) {
                const rect = trigger.getBoundingClientRect();
                popover.style.top = (rect.bottom + 4) + 'px';
                popover.style.left = Math.max(8, rect.left - 100) + 'px';
            }
        }
    }

    function saveDueDate() {
        if (!currentEditTaskId) return;
        const dateVal = document.getElementById('dueDateInput').value;
        if (!dateVal) return;

        fetch(`/tasks/${currentEditTaskId}`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ due_date: dateVal })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                renderDueDateDisplay(dateVal);
                toggleDatePopover();
            }
        });
    }

    function removeDueDate() {
        if (!currentEditTaskId) return;

        fetch(`/tasks/${currentEditTaskId}`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ due_date: null })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                renderDueDateDisplay(null);
                toggleDatePopover();
            }
        });
    }

    function renderDueDateDisplay(dateStr) {
        const textEl = document.getElementById('dueDateText');
        const inputEl = document.getElementById('dueDateInput');
        
        if (!dateStr) {
            textEl.innerHTML = '<span class="italic text-gray-400">No due date</span>';
            inputEl.value = '';
            return;
        }
        
        const d = new Date(dateStr + 'T00:00:00');
        const formatted = d.toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' });
        const now = new Date();
        const isOverdue = d < now && d.toDateString() !== now.toDateString();
        
        textEl.innerHTML = `
            <i class="fa-regular fa-calendar text-xs ${isOverdue ? 'text-red-500' : 'text-indigo-500'}"></i>
            <span class="${isOverdue ? 'text-red-600 font-bold' : 'text-gray-700 dark:text-slate-300'}">${formatted}</span>
            ${isOverdue ? '<span class="text-[10px] bg-red-100 text-red-600 px-1.5 py-0.5 rounded font-bold ml-1">OVERDUE</span>' : ''}
        `;
        inputEl.value = dateStr;
    }

    // Close date popover on outside click
    document.addEventListener('click', function(e) {
        const popover = document.getElementById('datePopover');
        if (!popover) return;
        const isInside = e.target.closest('#datePopover') || e.target.closest('[onclick*="toggleDatePopover"]');
        if (!isInside && !popover.classList.contains('hidden')) {
            popover.classList.add('hidden');
        }
    });

    // ========== Trello-style Members Popover ==========
    const memberColors = ['bg-green-500', 'bg-purple-500', 'bg-blue-500', 'bg-rose-500', 'bg-amber-500', 'bg-teal-500', 'bg-cyan-500', 'bg-orange-500'];
    
    function getMemberColor(id) {
        return memberColors[id % memberColors.length];
    }
    
    function getInitials(name) {
        return name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2);
    }

    function toggleMembersPopover(e) {
        const popover = document.getElementById('membersPopover');
        popover.classList.toggle('hidden');
        if (!popover.classList.contains('hidden')) {
            // Position near the trigger button
            const trigger = document.querySelector('[onclick*="toggleMembersPopover"]');
            if (trigger) {
                const rect = trigger.getBoundingClientRect();
                popover.style.top = (rect.bottom + 4) + 'px';
                popover.style.left = Math.max(8, rect.left - 100) + 'px';
            }
            document.getElementById('memberSearchInput').value = '';
            renderMembersPopover();
            document.getElementById('memberSearchInput').focus();
        }
    }

    function renderAssignedMembersDisplay() {
        const select = document.getElementById('editTaskAssignees');
        const display = document.getElementById('assignedMembersDisplay');
        const assigned = Array.from(select.selectedOptions);
        
        if (assigned.length === 0) {
            display.innerHTML = '<span class="text-xs text-gray-400 dark:text-slate-500 italic">No members assigned</span>';
            return;
        }
        
        display.innerHTML = assigned.map(opt => {
            const name = opt.getAttribute('data-name') || opt.textContent;
            const initials = getInitials(name);
            const color = getMemberColor(parseInt(opt.value));
            return `
                <div class="flex items-center gap-0 group/avatar" title="${name}">
                    <div class="w-8 h-8 rounded-full ${color} text-white flex items-center justify-center text-xs font-bold shadow-sm cursor-default">
                        ${initials}
                    </div>
                </div>
            `;
        }).join('') + `
            <button type="button" onclick="toggleMembersPopover()" class="w-8 h-8 rounded-full bg-gray-200 dark:bg-slate-600 text-gray-500 dark:text-slate-400 flex items-center justify-center text-sm hover:bg-gray-300 dark:hover:bg-slate-500 transition-colors" title="Add member">
                <i class="fa-solid fa-plus text-xs"></i>
            </button>
        `;
    }

    function renderMembersPopover(filter = '') {
        const select = document.getElementById('editTaskAssignees');
        const assignedIds = Array.from(select.selectedOptions).map(o => o.value);
        const allOptions = Array.from(select.options);
        const query = filter.toLowerCase();

        // Card Members (assigned)
        const cardMembers = allOptions.filter(o => assignedIds.includes(o.value));
        const boardMembers = allOptions.filter(o => !assignedIds.includes(o.value));

        const filteredCard = query ? cardMembers.filter(o => (o.getAttribute('data-name') || o.textContent).toLowerCase().includes(query)) : cardMembers;
        const filteredBoard = query ? boardMembers.filter(o => (o.getAttribute('data-name') || o.textContent).toLowerCase().includes(query)) : boardMembers;

        // Card Members Section
        const cardSection = document.getElementById('cardMembersSection');
        const cardList = document.getElementById('cardMembersList');
        if (filteredCard.length > 0) {
            cardSection.classList.remove('hidden');
            cardList.innerHTML = filteredCard.map(opt => {
                const name = opt.getAttribute('data-name') || opt.textContent;
                const initials = getInitials(name);
                const color = getMemberColor(parseInt(opt.value));
                return `
                    <button onclick="toggleMember('${opt.value}')" class="flex items-center gap-3 w-full px-4 py-2 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors text-left">
                        <div class="w-8 h-8 rounded-full ${color} text-white flex items-center justify-center text-xs font-bold shrink-0">${initials}</div>
                        <span class="text-sm text-gray-700 dark:text-slate-300 flex-grow">${name}</span>
                        <i class="fa-solid fa-times text-gray-400 hover:text-red-500 text-xs"></i>
                    </button>
                `;
            }).join('');
        } else {
            cardSection.classList.add('hidden');
        }

        // Board Members Section
        const boardList = document.getElementById('boardMembersList');
        if (filteredBoard.length > 0) {
            document.getElementById('boardMembersSection').classList.remove('hidden');
            boardList.innerHTML = filteredBoard.map(opt => {
                const name = opt.getAttribute('data-name') || opt.textContent;
                const initials = getInitials(name);
                const color = getMemberColor(parseInt(opt.value));
                return `
                    <button onclick="toggleMember('${opt.value}')" class="flex items-center gap-3 w-full px-4 py-2 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors text-left">
                        <div class="w-8 h-8 rounded-full ${color} text-white flex items-center justify-center text-xs font-bold shrink-0">${initials}</div>
                        <span class="text-sm text-gray-700 dark:text-slate-300 flex-grow">${name}</span>
                    </button>
                `;
            }).join('');
        } else {
            document.getElementById('boardMembersSection').classList.add('hidden');
            boardList.innerHTML = '<p class="px-4 py-2 text-xs text-gray-400 italic">No more members</p>';
        }
    }

    function filterMembers() {
        const query = document.getElementById('memberSearchInput').value;
        renderMembersPopover(query);
    }

    function toggleMember(userId) {
        const select = document.getElementById('editTaskAssignees');
        const option = select.querySelector(`option[value="${userId}"]`);
        if (!option) return;
        
        // Toggle selection
        option.selected = !option.selected;
        
        // Trigger the change event to save
        select.dispatchEvent(new Event('change'));
        
        // Re-render both displays
        renderAssignedMembersDisplay();
        renderMembersPopover(document.getElementById('memberSearchInput').value);
    }

    // Close popover when clicking outside
    document.addEventListener('click', function(e) {
        const popover = document.getElementById('membersPopover');
        if (!popover) return;
        const isInside = e.target.closest('#membersPopover') || e.target.closest('[onclick*="toggleMembersPopover"]');
        if (!isInside && !popover.classList.contains('hidden')) {
            popover.classList.add('hidden');
        }
    });

    // ========== Create Task Trello-style Members Popover ==========
    function toggleCreateMembersPopover(e) {
        const popover = document.getElementById('createMembersPopover');
        popover.classList.toggle('hidden');
        if (!popover.classList.contains('hidden')) {
            // Position near the trigger button using viewport coordinates to escape overflow-hidden
            const trigger = document.querySelector('[onclick*="toggleCreateMembersPopover"]');
            if (trigger) {
                const rect = trigger.getBoundingClientRect();
                popover.style.top = (rect.bottom + 4) + 'px';
                popover.style.left = Math.max(8, rect.left) + 'px';
            }
            document.getElementById('createMemberSearchInput').value = '';
            renderCreateMembersPopover();
            document.getElementById('createMemberSearchInput').focus();
        }
    }

    function renderCreateAssignedMembersDisplay() {
        const select = document.getElementById('createTaskAssignees');
        const display = document.getElementById('createAssignedMembersDisplay');
        const assigned = Array.from(select.selectedOptions);
        
        if (assigned.length === 0) {
            display.innerHTML = '<span class="text-sm text-gray-400 dark:text-slate-500 italic">No members assigned</span>';
            return;
        }
        
        display.innerHTML = assigned.map(opt => {
            const name = opt.getAttribute('data-name') || opt.textContent;
            const initials = getInitials(name);
            const color = getMemberColor(parseInt(opt.value));
            return `
                <div class="flex items-center gap-0 group/avatar" title="${name}">
                    <div class="w-8 h-8 rounded-full ${color} text-white flex items-center justify-center text-xs font-bold shadow-sm cursor-default">
                        ${initials}
                    </div>
                </div>
            `;
        }).join('') + `
            <button type="button" onclick="toggleCreateMembersPopover()" class="w-8 h-8 rounded-full bg-gray-200 dark:bg-slate-600 text-gray-500 dark:text-slate-400 flex items-center justify-center text-sm hover:bg-gray-300 dark:hover:bg-slate-500 transition-colors" title="Select members">
                <i class="fa-solid fa-plus text-xs"></i>
            </button>
        `;
    }

    function renderCreateMembersPopover(filter = '') {
        const select = document.getElementById('createTaskAssignees');
        const assignedIds = Array.from(select.selectedOptions).map(o => o.value);
        const allOptions = Array.from(select.options);
        const query = filter.toLowerCase();

        const cardMembers = allOptions.filter(o => assignedIds.includes(o.value));
        const boardMembers = allOptions.filter(o => !assignedIds.includes(o.value));

        const filteredCard = query ? cardMembers.filter(o => (o.getAttribute('data-name') || o.textContent).toLowerCase().includes(query)) : cardMembers;
        const filteredBoard = query ? boardMembers.filter(o => (o.getAttribute('data-name') || o.textContent).toLowerCase().includes(query)) : boardMembers;

        const cardSection = document.getElementById('createCardMembersSection');
        const cardList = document.getElementById('createCardMembersList');
        if (filteredCard.length > 0) {
            cardSection.classList.remove('hidden');
            cardList.innerHTML = filteredCard.map(opt => {
                const name = opt.getAttribute('data-name') || opt.textContent;
                const initials = getInitials(name);
                const color = getMemberColor(parseInt(opt.value));
                return `
                    <button type="button" onclick="toggleCreateMember('${opt.value}')" class="flex items-center gap-3 w-full px-4 py-2 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors text-left">
                        <div class="w-8 h-8 rounded-full ${color} text-white flex items-center justify-center text-xs font-bold shrink-0">${initials}</div>
                        <span class="text-sm text-gray-700 dark:text-slate-300 flex-grow">${name}</span>
                        <i class="fa-solid fa-times text-gray-400 hover:text-red-500 text-xs"></i>
                    </button>
                `;
            }).join('');
        } else {
            cardSection.classList.add('hidden');
        }

        const boardList = document.getElementById('createBoardMembersList');
        if (filteredBoard.length > 0) {
            document.getElementById('createBoardMembersSection').classList.remove('hidden');
            boardList.innerHTML = filteredBoard.map(opt => {
                const name = opt.getAttribute('data-name') || opt.textContent;
                const initials = getInitials(name);
                const color = getMemberColor(parseInt(opt.value));
                return `
                    <button type="button" onclick="toggleCreateMember('${opt.value}')" class="flex items-center gap-3 w-full px-4 py-2 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors text-left">
                        <div class="w-8 h-8 rounded-full ${color} text-white flex items-center justify-center text-xs font-bold shrink-0">${initials}</div>
                        <span class="text-sm text-gray-700 dark:text-slate-300 flex-grow">${name}</span>
                    </button>
                `;
            }).join('');
        } else {
            document.getElementById('createBoardMembersSection').classList.add('hidden');
            boardList.innerHTML = '<p class="px-4 py-2 text-xs text-gray-400 italic">No more members</p>';
        }
    }

    function filterCreateMembers() {
        renderCreateMembersPopover(document.getElementById('createMemberSearchInput').value);
    }

    function toggleCreateMember(userId) {
        const select = document.getElementById('createTaskAssignees');
        const option = select.querySelector(`option[value="${userId}"]`);
        if (!option) return;
        
        option.selected = !option.selected;
        select.dispatchEvent(new Event('change'));
        
        renderCreateAssignedMembersDisplay();
        renderCreateMembersPopover(document.getElementById('createMemberSearchInput').value);
    }

    // Close form popover when clicking outside
    document.addEventListener('click', function(e) {
        const popover = document.getElementById('createMembersPopover');
        if (!popover) return;
        const isInside = e.target.closest('#createMembersPopover') || e.target.closest('[onclick*="toggleCreateMembersPopover"]');
        if (!isInside && !popover.classList.contains('hidden')) {
            popover.classList.add('hidden');
        }
    });

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
        
        // Ensure counts are accurate on initial load
        filterTasks('client', ''); 
    });

    // ========== Filtering Logic ==========
    let currentClientFilter = '';
    let currentEmployeeFilter = '';

    function filterTasks(type, value) {
        if (type === 'client') {
            if (currentClientFilter === value && value !== '') {
                // Deselect if already active
                value = '';
            }
            currentClientFilter = value;
            
            // Update UI for pills
            document.querySelectorAll('.client-pill').forEach(pill => {
                const pillClientId = pill.getAttribute('data-client-id') || '';
                
                if (pillClientId == value) {
                    pill.classList.add('bg-blue-600', 'text-white', 'border-blue-600');
                    pill.classList.remove('bg-gray-100', 'dark:bg-slate-700', 'text-gray-700', 'dark:text-slate-300', 'hover:bg-gray-200', 'dark:hover:bg-slate-600', 'border-transparent');
                    
                    // Update icon color if present inside the active pill
                    const icon = pill.querySelector('i');
                    if(icon) {
                        icon.classList.remove('text-gray-400', 'dark:text-slate-500');
                        icon.classList.add('text-white');
                    }
                } else {
                    pill.classList.remove('bg-blue-600', 'text-white', 'border-blue-600');
                    pill.classList.add('bg-gray-100', 'dark:bg-slate-700', 'text-gray-700', 'dark:text-slate-300', 'hover:bg-gray-200', 'dark:hover:bg-slate-600', 'border-transparent');
                    
                    // Update icon color back to normal
                    const icon = pill.querySelector('i');
                    if(icon) {
                        icon.classList.add('text-gray-400', 'dark:text-slate-500');
                        icon.classList.remove('text-white');
                    }
                }
            });
        } else if (type === 'employee') {
            currentEmployeeFilter = value;
        }

        const cards = document.querySelectorAll('.task-card');
        
        cards.forEach(card => {
            const clientId = card.getAttribute('data-client-id') || '';
            const assigneeIdsStr = card.getAttribute('data-assignee-ids') || '';
            const assigneeIds = assigneeIdsStr ? assigneeIdsStr.split(',') : [];

            let showClient = true;
            let showEmployee = true;

            if (currentClientFilter !== '') {
                showClient = (clientId == currentClientFilter);
            }

            if (currentEmployeeFilter !== '') {
                showEmployee = assigneeIds.includes(currentEmployeeFilter);
            }

            if (showClient && showEmployee) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });

        // Update column counts and handle empty state
        ['To-Do', 'In-Progress', 'Waiting-Approval', 'Completed'].forEach(status => {
            const col = document.querySelector(`[data-status="${status}"]`);
            if (col) {
                const visibleCards = Array.from(col.querySelectorAll('.task-card')).filter(c => c.style.display !== 'none');
                
                // Also update the UI column if no tasks are available
                const taskList = col.querySelector('.task-list');
                const emptyMessageQuery = col.querySelector('.empty-message');
                if (visibleCards.length === 0) {
                    if (!emptyMessageQuery && taskList) {
                        const msg = document.createElement('div');
                        msg.className = 'empty-message text-center p-4 text-xs italic text-gray-500 w-full opacity-50 select-none';
                        msg.textContent = 'No tasks found';
                        taskList.appendChild(msg);
                    }
                } else {
                    if (emptyMessageQuery) emptyMessageQuery.remove();
                }

                // Update count badge explicitly.
                const countBadge = col.querySelector('.rounded-full');
                if (countBadge) {
                    countBadge.textContent = visibleCards.length;
                    
                    if (visibleCards.length === 0) {
                        countBadge.classList.add('opacity-50');
                    } else {
                        countBadge.classList.remove('opacity-50');
                    }
                }
            }
        });
    }
</script>
@endpush
