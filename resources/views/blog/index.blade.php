@extends('layouts.app')

@section('title', 'Blog & Insights | Amazon, eBay, Shopify & Walmart Growth | XpertVA')
@section('meta_description', 'Editorial insights, playbooks, and case studies on Amazon listing optimization, PPC strategy, Shopify growth, and virtual assistant best practices from the XpertVA team.')

@push('head')
<link rel="canonical" href="{{ url('/blog') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="Blog & Insights | XpertVA">
<meta property="og:description" content="Playbooks, case studies, and expert insights for Amazon, eBay, Shopify, and Walmart sellers.">
<meta property="og:url" content="{{ url('/blog') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,700;1,500&display=swap" rel="stylesheet">
@endpush

@section('content')
@php
    $featured = $blogs->first();
    $rest = $blogs->skip(1);
    $byCategory = $rest->groupBy('category');
    $latestSix = $rest->take(6);
@endphp

<div class="bg-[#0a0a0a] text-white min-h-screen">

    {{-- =========================  HERO BANNER  ========================= --}}
    @if($featured && !request('category') && !request('q') && $blogs->currentPage() === 1)
    <section class="relative w-full overflow-hidden" style="min-height: 880px; height: 100vh;">
        <!-- Banner image -->
        <img src="{{ filter_var($featured->image, FILTER_VALIDATE_URL) ? $featured->image : asset('assets/images/' . $featured->image) }}"
             alt="{{ $featured->title }}"
             class="absolute inset-0 w-full h-full object-cover"
             style="object-position: center;"
             fetchpriority="high"/>

        <!-- DARK MASTER OVERLAY — solid 70% black wash over the entire banner for guaranteed text readability -->
        <div class="absolute inset-0" style="background-color: rgba(0,0,0,0.72);"></div>

        <!-- Top header-protection band — pure black at the very top so navbar is always readable -->
        <div class="absolute inset-x-0 top-0 pointer-events-none" style="height: 220px; background: linear-gradient(to bottom, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.5) 60%, rgba(0,0,0,0) 100%);"></div>

        <!-- Bottom fade to body background for smooth transition into search bar -->
        <div class="absolute inset-x-0 bottom-0 pointer-events-none" style="height: 280px; background: linear-gradient(to top, #0a0a0a 0%, rgba(10,10,10,0.7) 50%, rgba(10,10,10,0) 100%);"></div>

        <!-- Indigo brand accent -->
        <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at top right, rgba(99,99,255,0.22), transparent 55%);"></div>

        <!-- Hero content — ABSOLUTELY pinned to the bottom of the banner -->
        <div class="absolute inset-x-0 bottom-0 px-6 pb-24 md:pb-32">
            <div class="max-w-7xl mx-auto">
                <!-- Eyebrow -->
                <div class="inline-flex items-center gap-3 mb-7">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 backdrop-blur-md border border-white/25 shadow-2xl">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                        <span class="text-[11px] uppercase tracking-[0.22em] font-semibold text-white">Featured</span>
                    </span>
                    <span class="px-3.5 py-1.5 rounded-full bg-indigo-500/35 backdrop-blur-md border border-indigo-300/40 text-[11px] uppercase tracking-[0.22em] font-semibold text-indigo-50 shadow-2xl">{{ $featured->category }}</span>
                </div>

                <!-- Title -->
                <a href="{{ route('blog.show', $featured->slug) }}" class="block group max-w-4xl">
                    <h1 class="font-serif text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold leading-[1.05] tracking-tight mb-6 text-white group-hover:text-indigo-200 transition-colors"
                        style="font-family: 'Playfair Display', Georgia, serif; text-shadow: 0 6px 32px rgba(0,0,0,0.85), 0 2px 8px rgba(0,0,0,0.7);">
                        {{ $featured->title }}
                    </h1>

                    <p class="text-base md:text-xl text-gray-100 leading-relaxed mb-9 max-w-2xl line-clamp-3"
                       style="text-shadow: 0 3px 14px rgba(0,0,0,0.85), 0 1px 4px rgba(0,0,0,0.6);">
                        {{ $featured->description }}
                    </p>

                    <!-- Meta + CTA -->
                    <div class="flex flex-wrap items-center gap-6">
                        <span class="inline-flex items-center gap-3 px-7 py-3.5 rounded-full bg-white text-black font-semibold text-sm group-hover:bg-indigo-300 group-hover:gap-4 transition-all shadow-2xl">
                            Read the story
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </span>

                        <div class="flex items-center gap-3 text-xs text-gray-100 uppercase tracking-[0.22em] font-semibold"
                             style="text-shadow: 0 2px 8px rgba(0,0,0,0.8);">
                            <time>{{ $featured->created_at->format('M j, Y') }}</time>
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            <span>{{ max(1, (int) ceil(str_word_count(strip_tags($featured->content)) / 220)) }} min read</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>
    @else
    {{-- Compact header for filtered / paginated views --}}
    <header class="relative pt-32 pb-14 overflow-hidden border-b border-white/5">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(99,99,255,0.15),transparent_55%)] pointer-events-none"></div>
        <div class="relative max-w-5xl mx-auto px-6 text-center">
            <p class="text-[11px] uppercase tracking-[0.25em] text-indigo-300 font-semibold mb-4">XpertVA Journal</p>
            <h1 class="font-serif text-4xl md:text-6xl font-bold leading-tight" style="font-family: 'Playfair Display', Georgia, serif;">
                @if(request('q'))
                    <em class="italic text-indigo-300">"{{ request('q') }}"</em>
                @elseif(request('category'))
                    {{ request('category') }}
                @else
                    All articles
                @endif
            </h1>
            <p class="text-gray-400 mt-4">
                @if(request('q')) Search results @elseif(request('category')) Articles in this category @else Latest from our editorial team @endif
            </p>
        </div>
    </header>
    @endif

    {{-- =========================  SEARCH + CATEGORIES  ========================= --}}
    <div class="relative bg-[#0a0a0a]/95 backdrop-blur-xl border-b border-white/5 z-30 mt-2">
        <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col lg:flex-row items-stretch lg:items-center gap-4">
            <!-- Search -->
            <form action="{{ route('blog.index') }}" method="GET" class="lg:flex-1 lg:max-w-md">
                <div class="relative">
                    <svg class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Search articles…" class="w-full bg-white/[0.04] border border-white/10 focus:border-indigo-400/60 focus:bg-white/[0.07] rounded-full pl-12 pr-5 py-3 text-sm placeholder-gray-500 outline-none transition">
                    @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                </div>
            </form>

            <!-- Category pills -->
            @if($categories->count())
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar lg:ml-auto -mx-6 px-6 lg:mx-0 lg:px-0">
                <a href="{{ route('blog.index', request()->only('q')) }}"
                   class="shrink-0 px-4 py-2 rounded-full text-[11px] uppercase tracking-[0.18em] font-semibold transition border {{ !request('category') ? 'bg-white text-black border-white' : 'border-white/10 text-gray-400 hover:text-white hover:border-white/30' }}">
                    All
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('blog.index', array_merge(request()->only('q'), ['category' => $cat])) }}"
                   class="shrink-0 px-4 py-2 rounded-full text-[11px] uppercase tracking-[0.18em] font-semibold transition border {{ request('category') === $cat ? 'bg-white text-black border-white' : 'border-white/10 text-gray-400 hover:text-white hover:border-white/30' }}">
                    {{ $cat }}
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-6 py-20">

        @if($blogs->count())

        {{-- =========================  LATEST GRID  ========================= --}}
        @if($latestSix->count() && !request('category') && !request('q') && $blogs->currentPage() === 1)
        <section class="mb-24">
            <div class="flex items-end justify-between mb-10 pb-6 border-b border-white/5">
                <div>
                    <p class="text-[11px] uppercase tracking-[0.25em] text-indigo-400 font-semibold mb-2">Fresh ink</p>
                    <h2 class="font-serif text-3xl md:text-4xl font-bold" style="font-family: 'Playfair Display', Georgia, serif;">Latest articles</h2>
                </div>
                <span class="hidden md:block text-[11px] uppercase tracking-widest text-gray-500">{{ $blogs->total() }} {{ Str::plural('article', $blogs->total()) }}</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-14">
                @foreach($latestSix as $post)
                    @include('blog._card', ['post' => $post])
                @endforeach
            </div>
        </section>
        @endif

        {{-- =========================  BY CATEGORY  ========================= --}}
        @if(!request('category') && !request('q') && $blogs->currentPage() === 1 && $byCategory->count() > 1)
            @foreach($byCategory as $catName => $catPosts)
                @if($catName && $catPosts->count() >= 2)
                <section class="mb-24">
                    <div class="flex items-end justify-between mb-10 pb-6 border-b border-white/5">
                        <div>
                            <p class="text-[11px] uppercase tracking-[0.25em] text-indigo-400 font-semibold mb-2">Category</p>
                            <h2 class="font-serif text-3xl md:text-4xl font-bold" style="font-family: 'Playfair Display', Georgia, serif;">{{ $catName }}</h2>
                        </div>
                        <a href="{{ route('blog.index', ['category' => $catName]) }}" class="hidden md:inline-flex items-center gap-2 text-[11px] uppercase tracking-[0.2em] text-gray-400 hover:text-white transition font-semibold">
                            View all {{ $catPosts->count() }}
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-14">
                        @foreach($catPosts->take(3) as $post)
                            @include('blog._card', ['post' => $post])
                        @endforeach
                    </div>
                </section>
                @endif
            @endforeach
        @else
            {{-- Filtered / paginated grid --}}
            <section>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-14">
                    @foreach($blogs as $post)
                        @include('blog._card', ['post' => $post])
                    @endforeach
                </div>

                @if($blogs->hasPages())
                <div class="mt-20 pt-10 border-t border-white/5 flex justify-center">
                    {{ $blogs->links() }}
                </div>
                @endif
            </section>
        @endif

        @else
        <div class="text-center py-32">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/5 border border-white/10 mb-6">
                <svg class="w-7 h-7 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <h2 class="font-serif text-3xl font-bold mb-3" style="font-family: 'Playfair Display', Georgia, serif;">No articles found</h2>
            <p class="text-gray-400 mb-8 max-w-md mx-auto">Try a different search term or browse another category.</p>
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-white text-black font-semibold hover:bg-indigo-300 transition">Browse all articles</a>
        </div>
        @endif

        {{-- =========================  NEWSLETTER  ========================= --}}
        <section class="mt-32 relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600/15 via-purple-600/5 to-transparent border border-white/10 p-10 md:p-16">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(99,99,255,0.22),transparent_60%)]"></div>
            <div class="relative grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
                <div>
                    <p class="text-[11px] uppercase tracking-[0.25em] text-indigo-300 font-semibold mb-4">The Weekly Brief</p>
                    <h3 class="font-serif text-3xl md:text-4xl font-bold leading-tight mb-4" style="font-family: 'Playfair Display', Georgia, serif;">
                        eCommerce playbooks in your inbox
                    </h3>
                    <p class="text-gray-400 leading-relaxed">One sharp, actionable article every Tuesday — Amazon strategy, listing teardowns, PPC frameworks. No fluff, ever.</p>
                </div>
                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="fullName" value="Newsletter Signup">
                    <input type="hidden" name="phone" value="N/A">
                    <input type="hidden" name="message" value="Subscribe to weekly brief">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input type="email" name="email" required placeholder="your@email.com" class="flex-1 bg-black/40 border border-white/15 focus:border-indigo-400 rounded-full px-6 py-4 text-sm placeholder-gray-500 outline-none transition">
                        <button type="submit" class="px-8 py-4 rounded-full bg-white text-black font-semibold text-sm hover:bg-indigo-300 transition">Subscribe</button>
                    </div>
                    <p class="text-xs text-gray-500">No spam. Unsubscribe anytime.</p>
                </form>
            </div>
        </section>
    </main>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection
