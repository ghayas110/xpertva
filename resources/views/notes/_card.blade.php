@php
$colorClass = 'note-color-' . ($note->color ?? 'default');
$titleEsc   = addslashes($note->title   ?? '');
$contentEsc = addslashes($note->content ?? '');
$imgEsc     = addslashes($note->image_url ?? '');
// Escape newlines for JS string
$titleEsc   = str_replace(["\r\n", "\r", "\n"], '\\n', $titleEsc);
$contentEsc = str_replace(["\r\n", "\r", "\n"], '\\n', $contentEsc);
@endphp
<div class="note-card {{ $colorClass }} group rounded-xl p-4 relative cursor-pointer"
     data-id="{{ $note->id }}"
     data-pinned="{{ $note->is_pinned ? 1 : 0 }}"
     onclick="openEditModal({{ $note->id }}, '{{ $titleEsc }}', '{{ $contentEsc }}', '{{ $note->color }}', {{ $note->is_pinned ? 'true' : 'false' }}, '{{ $imgEsc }}')">

    <!-- Pin button -->
    <button type="button"
            onclick="event.stopPropagation(); togglePin({{ $note->id }}, {{ $note->is_pinned ? 'true' : 'false' }})"
            class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity p-1 rounded-full hover:bg-black/10"
            title="{{ $note->is_pinned ? 'Unpin' : 'Pin' }}">
        @if($note->is_pinned)
            <i class="fa-solid fa-thumbtack text-indigo-500 text-xs"></i>
        @else
            <i class="fa-regular fa-thumbtack text-slate-300 dark:text-slate-600 group-hover:text-slate-400 text-xs"></i>
        @endif
    </button>

    <div class="pr-6">
        @if($note->title)
            <h3 class="font-semibold text-slate-800 dark:text-white text-sm mb-1 break-words">{{ $note->title }}</h3>
        @endif
        @if($note->content)
            <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed whitespace-pre-wrap break-words line-clamp-8">{{ $note->content }}</p>
        @endif
        @if($note->image_url)
            <img src="{{ $note->image_url }}" alt="" class="mt-2 rounded-lg max-h-48 object-cover w-full">
        @endif
    </div>

    <!-- Action buttons -->
    <div class="mt-3 flex justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
        <button type="button"
                onclick="event.stopPropagation(); archiveNote({{ $note->id }})"
                class="p-1.5 rounded-full hover:bg-black/10 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors"
                title="Archive">
            <i class="fa-regular fa-folder text-xs"></i>
        </button>
        <button type="button"
                onclick="event.stopPropagation(); triggerDelete({{ $note->id }})"
                class="p-1.5 rounded-full hover:bg-black/10 text-slate-400 hover:text-red-500 transition-colors"
                title="Delete">
            <i class="fa-regular fa-trash-can text-xs"></i>
        </button>
    </div>
</div>
