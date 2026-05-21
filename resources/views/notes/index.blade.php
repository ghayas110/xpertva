@extends('layouts.dashboard')

@section('title', 'Notes')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Notes</h2>
    <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Keep your ideas and reminders in one place.</p>
</div>

<!-- Create Note Box -->
<div id="createNoteBox" class="max-w-xl mx-auto mb-8">
    <div id="noteCollapsed" onclick="expandNoteBox()" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-xl shadow-sm px-5 py-3.5 cursor-text text-slate-400 dark:text-slate-500 text-sm font-medium hover:shadow-md transition-shadow select-none">
        Take a note...
    </div>
    <div id="noteExpanded" class="hidden border border-slate-200 dark:border-slate-600 rounded-xl shadow-lg overflow-hidden note-create-card note-color-default">
        <input id="newNoteTitle" type="text" placeholder="Title"
               class="w-full px-5 pt-4 pb-1 text-base font-semibold text-slate-800 dark:text-white bg-transparent outline-none placeholder-slate-400 dark:placeholder-slate-500">
        <textarea id="newNoteContent" rows="4" placeholder="Take a note..."
                  class="w-full px-5 py-2 text-sm text-slate-700 dark:text-slate-300 bg-transparent outline-none resize-y placeholder-slate-400 dark:placeholder-slate-500 min-h-[80px]"></textarea>

        <!-- Image preview area -->
        <div id="newNoteImagePreview" class="px-5 pb-2 hidden">
            <img id="newNoteImageEl" src="" alt="Note image" class="max-h-48 rounded-lg object-cover border border-slate-200 dark:border-slate-600">
            <button type="button" onclick="clearNewNoteImage()" class="text-xs text-red-500 hover:text-red-700 mt-1 flex items-center gap-1"><i class="fa-solid fa-xmark"></i> Remove image</button>
        </div>

        <!-- Bottom toolbar -->
        <div class="px-5 py-2 flex items-center gap-3 flex-wrap border-t border-slate-100 dark:border-slate-700">
            <!-- Color Picker -->
            <div class="flex items-center gap-1.5">
                @foreach(['default','yellow','green','blue','pink','purple','orange','teal','red','gray'] as $c)
                <button type="button" onclick="setNewNoteColor('{{ $c }}')"
                        class="note-color-btn w-5 h-5 rounded-full border-2 border-transparent hover:scale-110 transition-transform"
                        data-color="{{ $c }}" title="{{ ucfirst($c) }}"></button>
                @endforeach
            </div>
            <!-- Image upload -->
            <label class="cursor-pointer text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors" title="Add image">
                <i class="fa-regular fa-image text-base"></i>
                <input type="file" id="newNoteImageInput" accept="image/*" class="hidden" onchange="handleNewNoteImage(event)">
            </label>
        </div>
        <div class="px-5 py-3 flex justify-end gap-2 border-t border-slate-100 dark:border-slate-700">
            <button type="button" onclick="collapseNoteBox()" class="px-4 py-1.5 text-sm text-slate-600 dark:text-slate-300 hover:bg-black/10 rounded-lg transition-colors font-medium">Close</button>
            <button type="button" onclick="createNote()" class="px-4 py-1.5 text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors font-medium shadow-sm">Save</button>
        </div>
    </div>
</div>

<!-- Search -->
<div class="mb-6 max-w-sm">
    <div class="relative">
        <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
        <input type="text" id="noteSearch" oninput="filterNotes()" placeholder="Search notes..."
               class="w-full pl-9 pr-4 py-2 text-sm bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white">
    </div>
</div>

<!-- Pinned Notes -->
<div id="pinnedSection" class="{{ $notes->where('is_pinned', true)->count() > 0 ? '' : 'hidden' }}">
    <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-3 px-1">Pinned</p>
    <div id="pinnedGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
        @foreach($notes->where('is_pinned', true) as $note)
            @include('notes._card', ['note' => $note])
        @endforeach
    </div>
</div>

<!-- Other Notes -->
<div id="othersSection" class="{{ $notes->where('is_pinned', false)->count() === 0 ? 'hidden' : '' }}">
    <p id="othersLabel" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-3 px-1 {{ $notes->where('is_pinned', true)->count() === 0 ? 'hidden' : '' }}">Others</p>
    <div id="notesGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($notes->where('is_pinned', false) as $note)
            @include('notes._card', ['note' => $note])
        @endforeach
    </div>
</div>

<!-- Empty State -->
<div id="emptyState" class="{{ $notes->isEmpty() ? '' : 'hidden' }} text-center py-24">
    <i class="fa-regular fa-lightbulb text-5xl text-slate-200 dark:text-slate-700 mb-4 block"></i>
    <p class="text-slate-400 dark:text-slate-500 text-base font-medium">Notes you add appear here</p>
</div>

<!-- Edit Note Modal -->
<div id="editNoteModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-4 backdrop-blur-sm">
    <div id="editNoteCard" class="note-modal-card w-full max-w-lg rounded-xl shadow-2xl overflow-hidden border border-slate-200 dark:border-slate-600 note-color-default">
        <input id="editNoteTitle" type="text" placeholder="Title"
               class="w-full px-5 pt-5 pb-1 text-base font-semibold text-slate-800 dark:text-white bg-transparent outline-none placeholder-slate-400">
        <textarea id="editNoteContent" rows="8" placeholder="Take a note..."
                  class="w-full px-5 py-3 text-sm text-slate-700 dark:text-slate-300 bg-transparent outline-none resize-y placeholder-slate-400 min-h-[120px]"
                  style="field-sizing: content;"></textarea>

        <!-- Image in edit modal -->
        <div id="editNoteImagePreview" class="px-5 pb-2 hidden">
            <img id="editNoteImageEl" src="" alt="" class="max-h-48 rounded-lg object-cover border border-slate-200 dark:border-slate-600">
            <button type="button" onclick="clearEditNoteImage()" class="text-xs text-red-500 hover:text-red-700 mt-1 flex items-center gap-1"><i class="fa-solid fa-xmark"></i> Remove image</button>
        </div>

        <!-- Toolbar -->
        <div class="px-5 py-2 flex items-center gap-3 flex-wrap border-t border-black/10">
            <div class="flex items-center gap-1.5">
                @foreach(['default','yellow','green','blue','pink','purple','orange','teal','red','gray'] as $c)
                <button type="button" onclick="setEditNoteColor('{{ $c }}')"
                        class="edit-color-btn w-5 h-5 rounded-full border-2 border-transparent hover:scale-110 transition-transform"
                        data-color="{{ $c }}" title="{{ ucfirst($c) }}"></button>
                @endforeach
            </div>
            <label class="cursor-pointer text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors" title="Add image">
                <i class="fa-regular fa-image text-base"></i>
                <input type="file" id="editNoteImageInput" accept="image/*" class="hidden" onchange="handleEditNoteImage(event)">
            </label>
        </div>
        <div class="px-5 py-3 flex justify-between items-center border-t border-black/10">
            <button type="button" onclick="confirmDeleteNote()" class="text-red-500 hover:text-red-700 text-sm font-medium flex items-center gap-1 transition-colors">
                <i class="fa-solid fa-trash text-xs"></i> Delete
            </button>
            <div class="flex gap-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-1.5 text-sm text-slate-600 dark:text-slate-300 hover:bg-black/10 rounded-lg transition-colors font-medium">Close</button>
                <button type="button" onclick="saveEditNote()" class="px-4 py-1.5 text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors font-medium shadow-sm">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteNoteModal" class="fixed inset-0 bg-black/50 hidden z-[60] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-sm p-6 border border-slate-200 dark:border-slate-700">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center shrink-0">
                <i class="fa-solid fa-trash text-red-500 text-sm"></i>
            </div>
            <div>
                <h3 class="font-bold text-slate-800 dark:text-white text-base">Delete Note</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">This action cannot be undone.</p>
            </div>
        </div>
        <p class="text-slate-600 dark:text-slate-300 text-sm mb-6">Are you sure you want to permanently delete this note?</p>
        <div class="flex gap-3 justify-end">
            <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition-colors">Cancel</button>
            <button type="button" onclick="executeDelete()" class="px-4 py-2 text-sm font-medium bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors shadow-sm">Delete</button>
        </div>
    </div>
</div>

<style>
/* ── Note card animations ── */
.note-card { transition: transform 0.15s ease, box-shadow 0.15s ease; }
.note-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.12); }

/* ── Note color backgrounds (cards & modals) ── */
.note-color-default { background: #ffffff !important; }
.dark .note-color-default { background: #1e293b !important; }
.note-color-yellow  { background: #fef9c3 !important; }
.dark .note-color-yellow { background: #3b2900 !important; }
.note-color-green   { background: #dcfce7 !important; }
.dark .note-color-green { background: #052e16 !important; }
.note-color-blue    { background: #dbeafe !important; }
.dark .note-color-blue { background: #1e3a5f !important; }
.note-color-pink    { background: #fce7f3 !important; }
.dark .note-color-pink { background: #4a0020 !important; }
.note-color-purple  { background: #f3e8ff !important; }
.dark .note-color-purple { background: #2e1065 !important; }
.note-color-orange  { background: #ffedd5 !important; }
.dark .note-color-orange { background: #431407 !important; }
.note-color-teal    { background: #ccfbf1 !important; }
.dark .note-color-teal { background: #022c22 !important; }
.note-color-red     { background: #fee2e2 !important; }
.dark .note-color-red { background: #450a0a !important; }
.note-color-gray    { background: #f3f4f6 !important; }
.dark .note-color-gray { background: #1f2937 !important; }

/* ── Color swatch buttons ── */
[data-color="default"] { background: #ffffff; border-color: #94a3b8 !important; box-shadow: inset 0 0 0 1px #94a3b8; }
[data-color="yellow"]  { background: #fde047; }
[data-color="green"]   { background: #86efac; }
[data-color="blue"]    { background: #93c5fd; }
[data-color="pink"]    { background: #f9a8d4; }
[data-color="purple"]  { background: #d8b4fe; }
[data-color="orange"]  { background: #fdba74; }
[data-color="teal"]    { background: #5eead4; }
[data-color="red"]     { background: #fca5a5; }
[data-color="gray"]    { background: #d1d5db; }
[data-color].active    { border-color: #4f46e5 !important; transform: scale(1.25); box-shadow: 0 0 0 2px #4f46e5; }

/* Textarea auto-grow */
#newNoteContent, #editNoteContent { overflow-y: auto; }

/* Paste image cursor */
#editNoteContent:focus { cursor: text; }
</style>

<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;
let currentEditId = null;
let newNoteColor = 'default';
let editNoteColor = 'default';
let newNoteImageData = null;   // base64 data URL
let editNoteImageData = null;  // base64 data URL or existing URL
let pendingDeleteId = null;

/* ══════════════════════════════════════════
   CREATE NOTE
══════════════════════════════════════════ */
function expandNoteBox() {
    document.getElementById('noteCollapsed').classList.add('hidden');
    document.getElementById('noteExpanded').classList.remove('hidden');
    document.getElementById('newNoteContent').focus();
}

function collapseNoteBox() {
    document.getElementById('noteCollapsed').classList.remove('hidden');
    document.getElementById('noteExpanded').classList.add('hidden');
    document.getElementById('newNoteTitle').value = '';
    document.getElementById('newNoteContent').value = '';
    newNoteColor = 'default';
    newNoteImageData = null;
    document.getElementById('newNoteImagePreview').classList.add('hidden');
    document.getElementById('newNoteImageEl').src = '';
    document.getElementById('newNoteImageInput').value = '';
    document.querySelectorAll('.note-color-btn').forEach(b => b.classList.remove('active'));
    applyCardColorToEl(document.getElementById('noteExpanded'), 'default');
}

function setNewNoteColor(color) {
    newNoteColor = color;
    document.querySelectorAll('.note-color-btn').forEach(b => b.classList.toggle('active', b.dataset.color === color));
    applyCardColorToEl(document.getElementById('noteExpanded'), color);
}

function handleNewNoteImage(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(ev) {
        newNoteImageData = ev.target.result;
        document.getElementById('newNoteImageEl').src = ev.target.result;
        document.getElementById('newNoteImagePreview').classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}

function clearNewNoteImage() {
    newNoteImageData = null;
    document.getElementById('newNoteImageEl').src = '';
    document.getElementById('newNoteImagePreview').classList.add('hidden');
    document.getElementById('newNoteImageInput').value = '';
}

async function createNote() {
    const title   = document.getElementById('newNoteTitle').value.trim();
    const content = document.getElementById('newNoteContent').value.trim();
    if (!title && !content && !newNoteImageData) { collapseNoteBox(); return; }

    const res = await fetch('{{ route("notes.store") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ title, content, color: newNoteColor, image: newNoteImageData })
    });
    const data = await res.json();
    if (data.success) {
        // Immediately render the new card without refresh
        renderNewCard(data.note);
        document.getElementById('emptyState').classList.add('hidden');
        updateSectionVisibility();
        collapseNoteBox();
    }
}

function renderNewCard(note) {
    // Ensure the others grid exists
    let grid = document.getElementById('notesGrid');
    if (!grid) {
        grid = document.createElement('div');
        grid.id = 'notesGrid';
        grid.className = 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4';
        document.getElementById('othersSection').appendChild(grid);
    }
    const div = document.createElement('div');
    div.innerHTML = buildCardHTML(note);
    grid.prepend(div.firstElementChild);
    document.getElementById('othersSection').classList.remove('hidden');
}

/* ══════════════════════════════════════════
   CARD HTML BUILDER (used for JS rendering)
══════════════════════════════════════════ */
function buildCardHTML(note) {
    const safeTitle   = note.title   ? `<h3 class="font-semibold text-slate-800 dark:text-white text-sm mb-1 break-words">${esc(note.title)}</h3>` : '';
    const safeContent = note.content ? `<p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed whitespace-pre-wrap break-words line-clamp-8">${esc(note.content)}</p>` : '';
    const imgHtml     = note.image_url ? `<img src="${esc(note.image_url)}" alt="" class="mt-2 rounded-lg max-h-48 object-cover w-full">` : '';
    const pinSolid    = `<i class="fa-solid fa-thumbtack text-indigo-500 text-xs"></i>`;
    const pinOutline  = `<i class="fa-regular fa-thumbtack text-slate-300 dark:text-slate-600 group-hover:text-slate-400 text-xs"></i>`;
    const pinIcon     = note.is_pinned ? pinSolid : pinOutline;
    const pinLabel    = note.is_pinned ? 'true' : 'false';

    // Inline onclick data — escape for HTML attribute usage
    const titleEsc   = escAttr(note.title   || '');
    const contentEsc = escAttr(note.content || '');
    const imgEsc     = escAttr(note.image_url || '');

    return `
    <div class="note-card note-color-${note.color} group rounded-xl p-4 relative cursor-pointer"
         data-id="${note.id}"
         data-pinned="${note.is_pinned ? 1 : 0}"
         onclick="openEditModal(${note.id}, '${titleEsc}', '${contentEsc}', '${note.color}', ${pinLabel}, '${imgEsc}')">
        <button type="button"
                onclick="event.stopPropagation(); togglePin(${note.id}, ${pinLabel})"
                class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity p-1 rounded-full hover:bg-black/10"
                title="${note.is_pinned ? 'Unpin' : 'Pin'}">
            ${pinIcon}
        </button>
        <div class="pr-6">
            ${safeTitle}
            ${safeContent}
            ${imgHtml}
        </div>
        <div class="mt-3 flex justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
            <button type="button" onclick="event.stopPropagation(); archiveNote(${note.id})"
                    class="p-1.5 rounded-full hover:bg-black/10 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors" title="Archive">
                <i class="fa-regular fa-folder text-xs"></i>
            </button>
            <button type="button" onclick="event.stopPropagation(); triggerDelete(${note.id})"
                    class="p-1.5 rounded-full hover:bg-black/10 text-slate-400 hover:text-red-500 transition-colors" title="Delete">
                <i class="fa-regular fa-trash-can text-xs"></i>
            </button>
        </div>
    </div>`;
}

function esc(str) {
    if (!str) return '';
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}
function escAttr(str) {
    if (!str) return '';
    return String(str).replace(/\\/g,'\\\\').replace(/'/g,"\\'").replace(/\r?\n/g,'\\n');
}

/* ══════════════════════════════════════════
   COLOR HELPER
══════════════════════════════════════════ */
function applyCardColorToEl(el, color) {
    // Remove any existing note-color-* classes
    const classes = Array.from(el.classList);
    classes.forEach(c => { if (c.startsWith('note-color-')) el.classList.remove(c); });
    el.classList.add('note-color-' + color);
}

/* ══════════════════════════════════════════
   EDIT MODAL
══════════════════════════════════════════ */
function openEditModal(id, title, content, color, isPinned, imageUrl) {
    currentEditId     = id;
    editNoteColor     = color;
    editNoteImageData = imageUrl || null;

    document.getElementById('editNoteTitle').value   = title   || '';
    document.getElementById('editNoteContent').value = content || '';

    // Apply color to the modal card
    applyCardColorToEl(document.getElementById('editNoteCard'), color);

    // Highlight active color swatch
    document.querySelectorAll('.edit-color-btn').forEach(b =>
        b.classList.toggle('active', b.dataset.color === color));

    // Show image if present
    if (imageUrl) {
        document.getElementById('editNoteImageEl').src = imageUrl;
        document.getElementById('editNoteImagePreview').classList.remove('hidden');
    } else {
        document.getElementById('editNoteImageEl').src = '';
        document.getElementById('editNoteImagePreview').classList.add('hidden');
    }
    document.getElementById('editNoteImageInput').value = '';

    document.getElementById('editNoteModal').classList.remove('hidden');
    // Focus at end of content
    const ta = document.getElementById('editNoteContent');
    ta.focus();
    const len = ta.value.length;
    ta.setSelectionRange(len, len);
}

function closeEditModal() {
    document.getElementById('editNoteModal').classList.add('hidden');
    currentEditId     = null;
    editNoteImageData = null;
}

function setEditNoteColor(color) {
    editNoteColor = color;
    document.querySelectorAll('.edit-color-btn').forEach(b =>
        b.classList.toggle('active', b.dataset.color === color));
    applyCardColorToEl(document.getElementById('editNoteCard'), color);
}

function handleEditNoteImage(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(ev) {
        editNoteImageData = ev.target.result;
        document.getElementById('editNoteImageEl').src = ev.target.result;
        document.getElementById('editNoteImagePreview').classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}

function clearEditNoteImage() {
    editNoteImageData = null;
    document.getElementById('editNoteImageEl').src = '';
    document.getElementById('editNoteImagePreview').classList.add('hidden');
    document.getElementById('editNoteImageInput').value = '';
}

async function saveEditNote() {
    if (!currentEditId) return;
    const title   = document.getElementById('editNoteTitle').value.trim();
    const content = document.getElementById('editNoteContent').value.trim();

    const res = await fetch(`/notes/${currentEditId}`, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ title, content, color: editNoteColor, image: editNoteImageData })
    });
    const data = await res.json();
    if (data.success) {
        const card = document.querySelector(`[data-id="${currentEditId}"]`);
        if (card) {
            const tmp = document.createElement('div');
            tmp.innerHTML = buildCardHTML(data.note);
            card.replaceWith(tmp.firstElementChild);
        }
        closeEditModal();
        updateSectionVisibility();
    }
}

/* ══════════════════════════════════════════
   DELETE (proper modal, no confirm())
══════════════════════════════════════════ */
function triggerDelete(id) {
    pendingDeleteId = id;
    document.getElementById('deleteNoteModal').classList.remove('hidden');
}

function confirmDeleteNote() {
    // Called from inside edit modal
    pendingDeleteId = currentEditId;
    document.getElementById('deleteNoteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    pendingDeleteId = null;
    document.getElementById('deleteNoteModal').classList.add('hidden');
}

async function executeDelete() {
    if (!pendingDeleteId) return;
    const id = pendingDeleteId;
    closeDeleteModal();
    // Also close edit modal if open
    if (currentEditId === id) closeEditModal();

    const res = await fetch(`/notes/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': CSRF }
    });
    const data = await res.json();
    if (data.success) {
        document.querySelector(`[data-id="${id}"]`)?.remove();
        updateSectionVisibility();
    }
}

/* ══════════════════════════════════════════
   ARCHIVE & PIN
══════════════════════════════════════════ */
async function archiveNote(id) {
    const res = await fetch(`/notes/${id}`, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ is_archived: true })
    });
    const data = await res.json();
    if (data.success) {
        document.querySelector(`[data-id="${id}"]`)?.remove();
        updateSectionVisibility();
    }
}

async function togglePin(id, currentlyPinned) {
    const pinned = currentlyPinned === true || currentlyPinned === 'true';
    const res = await fetch(`/notes/${id}`, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ is_pinned: !pinned })
    });
    const data = await res.json();
    if (data.success) {
        document.querySelector(`[data-id="${id}"]`)?.remove();
        const targetGrid = data.note.is_pinned
            ? document.getElementById('pinnedGrid')
            : document.getElementById('notesGrid');
        if (targetGrid) {
            const tmp = document.createElement('div');
            tmp.innerHTML = buildCardHTML(data.note);
            targetGrid.prepend(tmp.firstElementChild);
        }
        updateSectionVisibility();
    }
}

/* ══════════════════════════════════════════
   VISIBILITY HELPERS
══════════════════════════════════════════ */
function updateSectionVisibility() {
    const pinnedGrid    = document.getElementById('pinnedGrid');
    const pinnedSection = document.getElementById('pinnedSection');
    const notesGrid     = document.getElementById('notesGrid');
    const othersSection = document.getElementById('othersSection');
    const othersLabel   = document.getElementById('othersLabel');
    const emptyState    = document.getElementById('emptyState');

    const hasPinned  = pinnedGrid  && pinnedGrid.children.length  > 0;
    const hasOthers  = notesGrid   && notesGrid.children.length   > 0;

    pinnedSection?.classList.toggle('hidden', !hasPinned);
    othersSection?.classList.toggle('hidden', !hasOthers);
    othersLabel?.classList.toggle('hidden', !hasPinned); // "Others" label only when pinned also exist

    const isEmpty = !hasPinned && !hasOthers;
    emptyState?.classList.toggle('hidden', !isEmpty);
}

/* ══════════════════════════════════════════
   SEARCH
══════════════════════════════════════════ */
function filterNotes() {
    const q = document.getElementById('noteSearch').value.toLowerCase();
    document.querySelectorAll('.note-card').forEach(card => {
        card.style.display = card.innerText.toLowerCase().includes(q) ? '' : 'none';
    });
}

/* ══════════════════════════════════════════
   PASTE IMAGE (Ctrl+V into create / edit)
══════════════════════════════════════════ */
document.addEventListener('paste', function(e) {
    const items = (e.clipboardData || e.originalEvent?.clipboardData)?.items;
    if (!items) return;
    for (const item of items) {
        if (item.type.startsWith('image/')) {
            const file = item.getAsFile();
            const reader = new FileReader();
            // Determine which box is open
            const editOpen   = !document.getElementById('editNoteModal').classList.contains('hidden');
            const createOpen = !document.getElementById('noteExpanded').classList.contains('hidden');
            reader.onload = function(ev) {
                if (editOpen) {
                    editNoteImageData = ev.target.result;
                    document.getElementById('editNoteImageEl').src = ev.target.result;
                    document.getElementById('editNoteImagePreview').classList.remove('hidden');
                } else if (createOpen) {
                    newNoteImageData = ev.target.result;
                    document.getElementById('newNoteImageEl').src = ev.target.result;
                    document.getElementById('newNoteImagePreview').classList.remove('hidden');
                }
            };
            reader.readAsDataURL(file);
            break;
        }
    }
});

/* ══════════════════════════════════════════
   CLOSE ON BACKDROP CLICK
══════════════════════════════════════════ */
document.getElementById('editNoteModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});
document.getElementById('deleteNoteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});

/* Close create box when clicking outside */
document.addEventListener('click', function(e) {
    const expanded  = document.getElementById('noteExpanded');
    const collapsed = document.getElementById('noteCollapsed');
    if (expanded.classList.contains('hidden')) return;
    if (expanded.contains(e.target) || collapsed.contains(e.target)) return;
    // Don't collapse if file picker is active
    const title   = document.getElementById('newNoteTitle').value.trim();
    const content = document.getElementById('newNoteContent').value.trim();
    if (title || content || newNoteImageData) createNote();
    else collapseNoteBox();
});
</script>
@endsection
