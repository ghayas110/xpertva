<div class="border dark:border-slate-600 rounded-lg p-4 mb-3 bg-white dark:bg-slate-800 shadow-sm cursor-grab active:cursor-grabbing border-l-[6px] 
    @if($task->priority == 'high') border-red-500
    @elseif($task->priority == 'medium') border-yellow-500
    @else border-blue-500 @endif
    hover:shadow-md transition-shadow relative group"
    id="task-{{ $task->id }}"
    draggable="true"
    ondragstart="drag(event)"
    onclick="openEditModal({{ $task->id }})">
    
    <div class="flex justify-between items-start mb-2 pr-6">
        <div class="flex flex-col gap-0.5">
            @if($task->parent_id && $task->parent)
                <span class="text-[10px] uppercase font-bold text-indigo-500 flex items-center gap-1">
                    <i class="fa-solid fa-level-up fa-rotate-90 text-[8px]"></i> 
                    Main: {{ $task->parent->title }}
                </span>
            @endif
            <h4 class="font-bold text-gray-800 dark:text-white leading-tight block">{{ $task->title }}</h4>
        </div>
    </div>
    
    <p class="text-sm text-gray-600 dark:text-slate-400 mb-4 line-clamp-2">{{ $task->description }}</p>
    
    <div class="flex justify-between items-center text-xs text-gray-500 dark:text-slate-400 mb-2">
        <span class="flex items-center gap-1.5"><i class="fa-regular fa-calendar text-gray-400 dark:text-slate-500"></i> {{ $task->created_at->format('M d') }}</span>
        <div class="flex flex-col items-end gap-1">
            @if($task->assignees && $task->assignees->count() > 0)
                <div class="flex flex-wrap justify-end gap-1 max-w-[140px]">
                @foreach($task->assignees as $assignee)
                    <span id="assignee-name-{{ $task->id }}-{{ $assignee->id }}" class="bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 px-2 py-1 rounded flex items-center gap-1.5 max-w-[120px] truncate" title="{{ $assignee->name }}">
                        <i class="fa-regular fa-user"></i> {{ $assignee->name }}
                    </span>
                @endforeach
                </div>
            @else
                <span id="assignee-name-{{ $task->id }}" class="bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 px-2 py-1 rounded flex items-center gap-1.5 max-w-[120px] truncate" title="Unassigned">
                    <i class="fa-regular fa-user"></i> Unassigned
                </span>
            @endif
            @if($task->client_id)
                <span class="text-[10px] text-indigo-500 dark:text-indigo-400 font-medium truncate max-w-[120px]" title="{{ $task->client->company_name ?? 'Client' }}">
                    <i class="fa-solid fa-building"></i> {{ $task->client->company_name ?? 'Client' }}
                </span>
            @endif
        </div>
    </div>

    <!-- Action Buttons (Delete) -->
    @if(in_array(auth()->user()->role, ['super_admin', 'hr', 'onboarding', 'va']) || auth()->id() == $task->creator_id)
    <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
        <button onclick="event.stopPropagation(); openDeleteModal({{ $task->id }})" class="text-gray-400 hover:text-red-500">
            <i class="fa-solid fa-trash-can"></i>
        </button>
    </div>
    @endif
</div>
