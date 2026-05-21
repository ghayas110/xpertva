<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::query()->latest();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('title', 'like', "%{$q}%")
                  ->orWhere('description', 'like', "%{$q}%")
                  ->orWhere('content', 'like', "%{$q}%")
                  ->orWhere('tags', 'like', "%{$q}%");
            });
        }

        $blogs = $query->paginate(9)->withQueryString();
        $categories = Blog::select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->filter()
            ->values();

        return view('blog.index', compact('blogs', 'categories'));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

        $related = Blog::where('id', '!=', $blog->id)
            ->where(function ($q) use ($blog) {
                $q->where('category', $blog->category);
                if ($blog->tags) {
                    foreach (array_filter(array_map('trim', explode(',', $blog->tags))) as $tag) {
                        $q->orWhere('tags', 'like', "%{$tag}%");
                    }
                }
            })
            ->latest()
            ->take(3)
            ->get();

        // Reading time — average 220 words/minute
        $wordCount = str_word_count(strip_tags($blog->content));
        $readingMinutes = max(1, (int) ceil($wordCount / 220));

        return view('blog.show', compact('blog', 'related', 'readingMinutes', 'wordCount'));
    }
}
