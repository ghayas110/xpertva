@extends('layouts.app')

@section('title', ($blog->title ?? 'Article') . ' | XpertVA Journal')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($blog->description ?? $blog->content), 155))

@push('head')
<link rel="canonical" href="{{ url()->current() }}">
<meta property="og:type" content="article">
<meta property="og:title" content="{{ $blog->title }}">
<meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($blog->description ?? $blog->content), 155) }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ filter_var($blog->image, FILTER_VALIDATE_URL) ? $blog->image : asset('assets/images/' . $blog->image) }}">
<meta property="article:published_time" content="{{ $blog->created_at->toIso8601String() }}">
<meta property="article:modified_time" content="{{ $blog->updated_at->toIso8601String() }}">
<meta property="article:section" content="{{ $blog->category }}">
<meta name="twitter:card" content="summary_large_image">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,700;1,500&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
@endpush

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BlogPosting",
  "headline": {!! json_encode($blog->title) !!},
  "description": {!! json_encode(\Illuminate\Support\Str::limit(strip_tags($blog->description ?? $blog->content), 155)) !!},
  "image": "{{ filter_var($blog->image, FILTER_VALIDATE_URL) ? $blog->image : asset('assets/images/' . $blog->image) }}",
  "wordCount": {{ $wordCount }},
  "articleSection": {!! json_encode($blog->category) !!},
  "datePublished": "{{ $blog->created_at->toIso8601String() }}",
  "dateModified": "{{ $blog->updated_at->toIso8601String() }}",
  "author": { "@@type": "Organization", "name": "XpertVA Editorial Team", "url": "https://xpertva.com" },
  "publisher": {
    "@@type": "Organization",
    "name": "XpertVA",
    "logo": { "@@type": "ImageObject", "url": "https://xpertva.com/assets/images/logo-xpertva.png" }
  },
  "mainEntityOfPage": { "@@type": "WebPage", "@@id": "{{ url()->current() }}" }
}
</script>
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    { "@@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
    { "@@type": "ListItem", "position": 2, "name": "Blog", "item": "{{ route('blog.index') }}" },
    { "@@type": "ListItem", "position": 3, "name": {!! json_encode($blog->title) !!}, "item": "{{ url()->current() }}" }
  ]
}
</script>
@endpush

@section('content')
<!-- Reading Progress Bar -->
<div id="reading-progress" class="fixed top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-indigo-500 via-indigo-400 to-purple-400 origin-left scale-x-0 z-[60] transition-transform duration-100"></div>

<article class="bg-[#0a0a0a] text-white">
    <!-- Hero -->
    <header class="relative pt-36 pb-16 overflow-hidden border-b border-white/5">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(99,99,255,0.15),transparent_55%)] pointer-events-none"></div>
        <div class="relative max-w-3xl mx-auto px-6 text-center">
            <!-- Breadcrumb -->
            <nav class="flex items-center justify-center gap-2 text-xs uppercase tracking-[0.2em] text-gray-500 mb-10">
                <a href="{{ route('blog.index') }}" class="hover:text-indigo-300 transition">Journal</a>
                <span class="text-gray-700">/</span>
                <a href="{{ route('blog.index', ['category' => $blog->category]) }}" class="hover:text-indigo-300 transition">{{ $blog->category }}</a>
            </nav>

            <h1 class="font-serif text-4xl sm:text-5xl md:text-6xl font-bold leading-[1.1] tracking-tight mb-8" style="font-family: 'Playfair Display', Georgia, serif;">
                {{ $blog->title }}
            </h1>

            @if($blog->description)
            <p class="text-lg md:text-xl text-gray-400 leading-relaxed max-w-2xl mx-auto italic" style="font-family: 'Playfair Display', Georgia, serif;">
                {{ $blog->description }}
            </p>
            @endif

            <!-- Byline -->
            <div class="mt-12 flex items-center justify-center gap-4">
                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm shrink-0">XV</div>
                <div class="text-left">
                    <p class="text-sm font-semibold">XpertVA Editorial Team</p>
                    <p class="text-xs text-gray-500">
                        <time datetime="{{ $blog->created_at->toIso8601String() }}">{{ $blog->created_at->format('F j, Y') }}</time>
                        <span class="mx-1.5">·</span>
                        {{ $readingMinutes }} min read
                        @if($blog->updated_at->ne($blog->created_at))
                            <span class="mx-1.5">·</span>Updated {{ $blog->updated_at->format('M j, Y') }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Image with attached Share Rail -->
    @php
        $shareUrl = urlencode(url()->current());
        $shareTitle = urlencode($blog->title);
    @endphp
    <div class="max-w-5xl mx-auto px-6 -mt-2 mb-16">
        <div class="relative">
            <figure class="relative aspect-[16/9] overflow-hidden rounded-2xl bg-gray-900 shadow-2xl">
                <img src="{{ filter_var($blog->image, FILTER_VALIDATE_URL) ? $blog->image : asset('assets/images/' . $blog->image) }}"
                     alt="{{ $blog->title }}"
                     class="w-full h-full object-cover"/>
            </figure>

            {{-- Share rail — attached to the right edge of the cover image (desktop) --}}
            <div class="hidden lg:flex absolute top-1/2 -translate-y-1/2 -right-7 xl:-right-8 flex-col items-center gap-3 bg-[#0a0a0a]/90 backdrop-blur-md border border-white/10 rounded-full p-2 shadow-2xl z-10">
                <span class="px-1 py-2 text-[9px] uppercase tracking-[0.2em] text-gray-500 font-semibold" style="writing-mode: vertical-rl; transform: rotate(180deg);">Share</span>

                <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank" rel="noopener" aria-label="Share on X / Twitter" title="Share on X"
                   class="w-11 h-11 rounded-full bg-white/5 hover:bg-white hover:text-black text-gray-300 flex items-center justify-center transition-all hover:scale-110">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>

                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener" aria-label="Share on LinkedIn" title="Share on LinkedIn"
                   class="w-11 h-11 rounded-full bg-white/5 hover:bg-[#0a66c2] hover:text-white text-gray-300 flex items-center justify-center transition-all hover:scale-110">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                </a>

                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener" aria-label="Share on Facebook" title="Share on Facebook"
                   class="w-11 h-11 rounded-full bg-white/5 hover:bg-[#1877f2] hover:text-white text-gray-300 flex items-center justify-center transition-all hover:scale-110">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036 26.805 26.805 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.686 1.686 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 2.103-.287 1.564h-3.246v8.245C19.396 23.238 24 18.179 24 12.044c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.628 3.874 10.35 9.101 11.647Z"/></svg>
                </a>

                <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank" rel="noopener" aria-label="Share on WhatsApp" title="Share on WhatsApp"
                   class="w-11 h-11 rounded-full bg-white/5 hover:bg-[#25D366] hover:text-white text-gray-300 flex items-center justify-center transition-all hover:scale-110">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 0 1 8.413 3.488 11.824 11.824 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.71.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                </a>

                <button type="button"
                        data-copy-link
                        aria-label="Copy article link"
                        title="Copy link"
                        class="w-11 h-11 rounded-full bg-white/5 hover:bg-indigo-500 hover:text-white text-gray-300 flex items-center justify-center transition-all hover:scale-110">
                    <svg class="copy-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                    <svg class="check-icon hidden" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Mobile share row (under cover image) --}}
        <div class="lg:hidden mt-6 flex items-center justify-center gap-3 flex-wrap">
            <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank" rel="noopener" aria-label="Share on X" class="w-12 h-12 rounded-full bg-white/5 border border-white/10 hover:bg-white hover:text-black text-gray-300 flex items-center justify-center transition">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener" aria-label="Share on LinkedIn" class="w-12 h-12 rounded-full bg-white/5 border border-white/10 hover:bg-[#0a66c2] hover:text-white text-gray-300 flex items-center justify-center transition">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452z"/></svg>
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener" aria-label="Share on Facebook" class="w-12 h-12 rounded-full bg-white/5 border border-white/10 hover:bg-[#1877f2] hover:text-white text-gray-300 flex items-center justify-center transition">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036 26.805 26.805 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.686 1.686 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 2.103-.287 1.564h-3.246v8.245Z"/></svg>
            </a>
            <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank" rel="noopener" aria-label="Share on WhatsApp" class="w-12 h-12 rounded-full bg-white/5 border border-white/10 hover:bg-[#25D366] hover:text-white text-gray-300 flex items-center justify-center transition">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 0 1 8.413 3.488 11.824 11.824 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
            </a>
            <button type="button" data-copy-link aria-label="Copy article link" class="w-12 h-12 rounded-full bg-white/5 border border-white/10 hover:bg-indigo-500 hover:text-white text-gray-300 flex items-center justify-center transition">
                <svg class="copy-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                <svg class="check-icon hidden" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </button>
        </div>
    </div>

    <!-- Body with Right Rail -->
    <div class="max-w-7xl mx-auto px-6 pb-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Article Body -->
            <div class="lg:col-span-8 min-w-0">
                <div id="article-body" class="article-prose text-gray-200 leading-relaxed">
                    {!! nl2br(e($blog->content)) !!}
                </div>

                <!-- Tags -->
                @if($blog->tags)
                <div class="mt-16 pt-10 border-t border-white/10">
                    <p class="text-xs uppercase tracking-[0.25em] text-gray-500 font-semibold mb-4">Filed under</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach(array_filter(array_map('trim', explode(',', $blog->tags))) as $tag)
                        <a href="{{ route('blog.index', ['q' => $tag]) }}" class="px-4 py-2 bg-white/5 border border-white/10 rounded-full text-xs text-gray-300 hover:bg-white/10 hover:border-indigo-400/40 hover:text-white transition">#{{ $tag }}</a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Author Bio -->
                <div class="mt-16 p-8 md:p-10 rounded-2xl bg-gradient-to-br from-white/[0.04] to-transparent border border-white/10">
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shrink-0">XV</div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.25em] text-indigo-300 font-semibold mb-2">Written by</p>
                            <h3 class="text-xl font-bold mb-2">XpertVA Editorial Team</h3>
                            <p class="text-gray-400 text-sm leading-relaxed">
                                Amazon, eBay, Shopify, and Walmart specialists publishing playbooks and case studies from real seller accounts. Founded 2017 · 500+ brands served worldwide.
                            </p>
                            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 mt-4 text-sm text-indigo-300 hover:text-indigo-200 font-semibold">
                                Work with our team
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right rail (desktop) -->
            <aside class="hidden lg:block lg:col-span-4 min-w-0">
                <div class="sticky top-32 space-y-8">
                    <div class="p-6 rounded-2xl bg-gradient-to-br from-indigo-600/15 to-transparent border border-white/10">
                        <p class="text-xs uppercase tracking-[0.25em] text-indigo-300 font-semibold mb-3">Free Consultation</p>
                        <h4 class="font-serif text-xl md:text-2xl font-bold mb-3 leading-tight break-words" style="font-family: 'Playfair Display', Georgia, serif;">Scale your store this quarter</h4>
                        <p class="text-sm text-gray-400 leading-relaxed mb-5">Get an Amazon listing audit and 90-day growth plan from a certified specialist.</p>
                        <button onclick="document.getElementById('audit-modal').classList.remove('hidden')" class="w-full px-5 py-3 rounded-full bg-white text-black text-sm font-semibold hover:bg-indigo-300 transition whitespace-nowrap">
                            Request Free Audit
                        </button>
                    </div>

                    @if($related->count())
                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] text-gray-500 font-semibold mb-5">Continue reading</p>
                        <div class="space-y-5">
                            @foreach($related->take(3) as $rel)
                            <a href="{{ route('blog.show', $rel->slug) }}" class="block group">
                                <div class="aspect-[16/10] rounded-lg overflow-hidden mb-3 bg-gray-900">
                                    <img src="{{ filter_var($rel->image, FILTER_VALIDATE_URL) ? $rel->image : asset('assets/images/' . $rel->image) }}" alt="{{ $rel->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"/>
                                </div>
                                <p class="text-[10px] uppercase tracking-[0.2em] text-indigo-400 font-semibold mb-1.5">{{ $rel->category }}</p>
                                <h5 class="text-sm font-bold leading-snug group-hover:text-indigo-300 transition line-clamp-3">{{ $rel->title }}</h5>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </aside>
        </div>
    </div>

    <!-- Related Posts (full width below body) -->
    @if($related->count())
    <section class="border-t border-white/5 bg-[#080808] py-24">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-end justify-between mb-12 pb-6 border-b border-white/5">
                <div>
                    <p class="text-xs uppercase tracking-[0.25em] text-indigo-400 font-semibold mb-2">Keep reading</p>
                    <h2 class="font-serif text-3xl md:text-4xl font-bold" style="font-family: 'Playfair Display', Georgia, serif;">Related articles</h2>
                </div>
                <a href="{{ route('blog.index') }}" class="hidden md:inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white transition">
                    All articles
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-12">
                @foreach($related as $rel)
                <article class="group">
                    <a href="{{ route('blog.show', $rel->slug) }}" class="block">
                        <div class="relative aspect-[4/3] overflow-hidden rounded-xl bg-gray-900 mb-5">
                            <img src="{{ filter_var($rel->image, FILTER_VALIDATE_URL) ? $rel->image : asset('assets/images/' . $rel->image) }}" alt="{{ $rel->title }}" loading="lazy" class="absolute inset-0 w-full h-full object-cover group-hover:scale-[1.05] transition-transform duration-700"/>
                        </div>
                        <div class="flex items-center gap-3 text-[10px] text-gray-500 uppercase tracking-[0.2em] mb-3">
                            <span class="text-indigo-400 font-semibold">{{ $rel->category }}</span>
                            <span class="w-1 h-1 rounded-full bg-gray-700"></span>
                            <time>{{ $rel->created_at->format('M j, Y') }}</time>
                        </div>
                        <h3 class="font-serif text-xl md:text-2xl font-bold leading-tight mb-3 group-hover:text-indigo-300 transition line-clamp-3" style="font-family: 'Playfair Display', Georgia, serif;">{{ $rel->title }}</h3>
                        <p class="text-gray-400 text-sm leading-relaxed line-clamp-2">{{ $rel->description }}</p>
                    </a>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</article>

<style>
    .article-prose { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 1.125rem; line-height: 1.8; }
    .article-prose > p:first-of-type::first-letter,
    .article-prose > br + p:first-of-type::first-letter {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 4.5rem;
        line-height: 1;
        float: left;
        padding: 0.35rem 0.75rem 0 0;
        color: #a5b4fc;
        font-weight: 700;
    }
    .article-prose h2, .article-prose h3 { font-family: 'Playfair Display', Georgia, serif; font-weight: 700; color: #fff; margin-top: 2.5rem; margin-bottom: 1rem; line-height: 1.25; }
    .article-prose h2 { font-size: 2rem; }
    .article-prose h3 { font-size: 1.5rem; }
    .article-prose p { margin-bottom: 1.5rem; }
    .article-prose a { color: #a5b4fc; text-decoration: underline; text-decoration-thickness: 1px; text-underline-offset: 3px; transition: color 0.2s; }
    .article-prose a:hover { color: #c7d2fe; }
    .article-prose blockquote { border-left: 3px solid #6366f1; padding: 0.5rem 0 0.5rem 1.5rem; margin: 2rem 0; font-style: italic; font-family: 'Playfair Display', Georgia, serif; font-size: 1.35rem; color: #d1d5db; }
    .article-prose ul, .article-prose ol { margin-bottom: 1.5rem; padding-left: 1.5rem; }
    .article-prose li { margin-bottom: 0.5rem; }
    .article-prose img { border-radius: 0.75rem; margin: 2rem 0; }
    .article-prose code { background: rgba(255,255,255,0.08); padding: 0.15em 0.4em; border-radius: 4px; font-size: 0.9em; color: #fbbf24; }
    .article-prose pre { background: #050505; border: 1px solid rgba(255,255,255,0.08); padding: 1.25rem; border-radius: 0.75rem; overflow-x: auto; margin: 1.75rem 0; }
</style>

<script>
    // Reading progress bar
    (function () {
        const bar = document.getElementById('reading-progress');
        const article = document.getElementById('article-body');
        if (!bar || !article) return;
        function update() {
            const rect = article.getBoundingClientRect();
            const total = rect.height - window.innerHeight + rect.top + window.scrollY;
            const scrolled = window.scrollY - (rect.top + window.scrollY);
            const pct = Math.min(1, Math.max(0, scrolled / Math.max(1, rect.height - window.innerHeight)));
            bar.style.transform = `scaleX(${pct})`;
        }
        window.addEventListener('scroll', update, { passive: true });
        window.addEventListener('resize', update);
        update();
    })();

    // Copy article link to clipboard — works for all [data-copy-link] buttons
    document.querySelectorAll('[data-copy-link]').forEach(btn => {
        btn.addEventListener('click', async () => {
            const url = window.location.href;
            try {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(url);
                } else {
                    // Fallback for non-HTTPS / older browsers
                    const ta = document.createElement('textarea');
                    ta.value = url;
                    ta.style.position = 'fixed';
                    ta.style.opacity = '0';
                    document.body.appendChild(ta);
                    ta.select();
                    document.execCommand('copy');
                    document.body.removeChild(ta);
                }
                const copyIcon = btn.querySelector('.copy-icon');
                const checkIcon = btn.querySelector('.check-icon');
                if (copyIcon && checkIcon) {
                    copyIcon.classList.add('hidden');
                    checkIcon.classList.remove('hidden');
                    btn.classList.add('!bg-green-500', '!text-white');
                    setTimeout(() => {
                        copyIcon.classList.remove('hidden');
                        checkIcon.classList.add('hidden');
                        btn.classList.remove('!bg-green-500', '!text-white');
                    }, 1800);
                }
            } catch (err) {
                console.error('Copy failed:', err);
            }
        });
    });

    // Native Web Share API enhancement — falls back to platform-specific links if not supported
    if (navigator.share) {
        // Optional: add a "More…" button later if needed. For now, the platform-specific links work everywhere.
    }
</script>
@endsection
