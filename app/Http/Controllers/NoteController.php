<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NoteController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user() && Auth::user()->role === 'super_admin') {
                abort(403, 'Notes are not available for super admin.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $notes = Note::where('user_id', Auth::id())
            ->where('is_archived', false)
            ->orderByDesc('is_pinned')
            ->orderByDesc('updated_at')
            ->get();

        return view('notes.index', compact('notes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'color'   => 'nullable|string|max:50',
            'image'   => 'nullable|string', // base64 data URL
        ]);

        if (!$request->title && !$request->content && !$request->image) {
            return response()->json(['error' => 'Note cannot be empty'], 422);
        }

        $imageUrl = $this->storeBase64Image($request->image);

        $note = Note::create([
            'user_id'   => Auth::id(),
            'title'     => $request->title,
            'content'   => $request->content,
            'color'     => $request->color ?? 'default',
            'image_url' => $imageUrl,
        ]);

        return response()->json(['success' => true, 'note' => $note]);
    }

    public function update(Request $request, Note $note)
    {
        abort_if($note->user_id !== Auth::id(), 403);

        $request->validate([
            'title'       => 'nullable|string|max:255',
            'content'     => 'nullable|string',
            'color'       => 'nullable|string|max:50',
            'is_pinned'   => 'nullable|boolean',
            'is_archived' => 'nullable|boolean',
            'image'       => 'nullable|string',
        ]);

        $data = $request->only(['title', 'content', 'color', 'is_pinned', 'is_archived']);

        if ($request->has('image')) {
            $imgValue = $request->input('image');
            if ($imgValue === null || $imgValue === '') {
                $this->deleteStoredImage($note->image_url);
                $data['image_url'] = null;
            } elseif (Str::startsWith($imgValue, 'data:image/')) {
                $this->deleteStoredImage($note->image_url);
                $data['image_url'] = $this->storeBase64Image($imgValue);
            }
            // Existing URL passed back unchanged — don't touch image_url
        }

        $note->update($data);

        return response()->json(['success' => true, 'note' => $note->fresh()]);
    }

    public function destroy(Note $note)
    {
        abort_if($note->user_id !== Auth::id(), 403);

        $this->deleteStoredImage($note->image_url);
        $note->delete();

        return response()->json(['success' => true]);
    }

    private function deleteStoredImage(?string $imageUrl): void
    {
        if (!$imageUrl) return;
        if (Str::startsWith($imageUrl, '/storage/')) {
            Storage::disk('public')->delete(ltrim(Str::after($imageUrl, '/storage'), '/'));
        } elseif (Str::startsWith($imageUrl, 'notes/')) {
            Storage::disk('public')->delete($imageUrl);
        }
    }

    private function storeBase64Image(?string $dataUrl): ?string
    {
        if (!$dataUrl || !Str::startsWith($dataUrl, 'data:image/')) {
            return null;
        }

        preg_match('/data:image\/(\w+);base64,/', $dataUrl, $matches);
        $ext    = $matches[1] ?? 'png';
        $binary = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $dataUrl));

        $filename = 'notes/' . Auth::id() . '_' . Str::uuid() . '.' . $ext;
        Storage::disk('public')->put($filename, $binary);

        // Return a same-origin relative URL. Storage::url() honors APP_URL
        // which may not match the actual dev server port (8000), causing
        // broken images. A leading-slash path always resolves to the current host.
        return '/storage/' . $filename;
    }
}
