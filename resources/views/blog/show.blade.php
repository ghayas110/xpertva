@extends('layouts.app')

@section('content')
<div class="bg-black text-white min-h-screen pt-32 pb-20">
    <article class="max-w-4xl mx-auto px-6">
        @if($blog)
            <div class="mb-12">
                <a href="{{ route('blog.index') }}" class="text-indigo-400 hover:underline mb-8 inline-block">← Back to Blog</a>
                <div class="flex items-center gap-4 text-sm text-gray-400 mb-6 uppercase tracking-widest">
                    <span class="bg-indigo-600/20 text-indigo-400 px-3 py-1 rounded-full">{{ $blog->category }}</span>
                    <span>•</span>
                    <span>{{ $blog->created_at->format('M d, Y') }}</span>
                </div>
                <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-8">{{ $blog->title }}</h1>
                
                <div class="rounded-3xl overflow-hidden mb-12 border border-gray-800">
                    <img src="{{ filter_var($blog->image, FILTER_VALIDATE_URL) ? $blog->image : asset('assets/images/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-full h-auto object-cover"/>
                </div>

                <div class="prose prose-invert prose-indigo max-w-none text-gray-300 text-lg leading-relaxed">
                    {!! nl2br(e($blog->content)) !!}
                </div>
                
                @if($blog->tags)
                <div class="mt-12 pt-8 border-t border-gray-800">
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $blog->tags) as $tag)
                        <span class="px-3 py-1 bg-gray-900 border border-gray-800 rounded-full text-sm text-gray-400">#{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        @else
            <div class="text-center py-20">
                <h1 class="text-4xl font-bold mb-4">Blog Post Not Found</h1>
                <a href="{{ route('blog.index') }}" class="text-indigo-400 hover:underline">Return to Blog</a>
            </div>
        @endif
    </article>
</div>
@endsection
