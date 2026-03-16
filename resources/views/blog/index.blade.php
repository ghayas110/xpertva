@extends('layouts.app')

@section('title', 'Blog - XpertVA')

@section('content')
<div class="bg-black text-white min-h-screen pt-32 pb-20">
    <main class="max-w-7xl mx-auto px-6">
        @php
            $featured = $blogs->first();
        @endphp

        <!-- Featured Banner -->
        @if($featured)
        <div class="mb-20">
            <h1 class="text-4xl md:text-7xl font-bold mb-12">Our Blog</h1>
            
            <a href="{{ route('blog.show', $featured->slug) }}" class="relative group block rounded-3xl overflow-hidden bg-gray-900 border border-white/5 hover:border-indigo-500/50 transition-all duration-500 shadow-2xl">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <div class="relative aspect-video lg:aspect-auto overflow-hidden">
                        <img src="{{ filter_var($featured->image, FILTER_VALIDATE_URL) ? $featured->image : asset('assets/images/' . $featured->image) }}" alt="{{ $featured->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"/>
                        <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent lg:hidden"></div>
                    </div>
                    <div class="p-8 md:p-12 flex flex-col justify-center">
                        <div class="flex items-center gap-4 text-sm text-indigo-400 font-bold uppercase tracking-widest mb-6">
                            <span>Featured Post</span>
                            <span>•</span>
                            <span>{{ $featured->created_at->format('M d, Y') }}</span>
                        </div>
                        <h2 class="text-3xl md:text-5xl font-bold mb-6 leading-tight group-hover:text-indigo-400 transition-colors">{{ $featured->title }}</h2>
                        <p class="text-gray-400 text-lg mb-8 line-clamp-3">{{ $featured->description }}</p>
                        <div class="flex items-center gap-2 text-white font-bold group-hover:gap-4 transition-all">
                            Read Article <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Blog Grid -->
        <h2 class="text-2xl font-bold mb-8 uppercase tracking-widest text-gray-400">Latest Articles</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($blogs->skip(1) as $blog)
            <a href="{{ route('blog.show', $blog->slug) }}" class="bg-gray-900/50 border border-white/5 rounded-2xl overflow-hidden shadow-lg hover:border-indigo-500/30 transition-all hover:-translate-y-1 group">
                <div class="aspect-[16/10] overflow-hidden bg-black p-4">
                    <img alt="{{ $blog->title }}" loading="lazy" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500" src="{{ filter_var($blog->image, FILTER_VALIDATE_URL) ? $blog->image : asset('assets/images/' . $blog->image) }}">
                </div>
                <div class="p-8">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs text-indigo-400 font-bold uppercase tracking-widest">{{ $blog->category }}</span>
                        <span class="text-xs text-gray-500">{{ $blog->created_at->format('M d, Y') }}</span>
                    </div>
                    <h4 class="text-xl font-bold mb-4 group-hover:text-indigo-400 transition-colors line-clamp-2">{{ $blog->title }}</h4>
                    <p class="text-sm text-gray-400 line-clamp-3 leading-relaxed">{{ $blog->description }}</p>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center py-20">
            <h1 class="text-4xl font-bold mb-4">No blogs found</h1>
            <p class="text-gray-400 mb-8">Stay tuned for more updates.</p>
        </div>
        @endif
    </main>
</div>
@endsection
