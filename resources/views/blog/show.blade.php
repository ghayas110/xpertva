@extends('layouts.site')

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

@php
    $cover = filter_var($blog->image, FILTER_VALIDATE_URL) ? $blog->image : asset('assets/images/' . $blog->image);
    $shareUrl = urlencode(url()->current());
    $shareTitle = urlencode($blog->title);
@endphp

<div class="reading-bar" data-reading-bar aria-hidden="true"><span></span></div>

<article>
    <header class="phead">
        <div class="wrap" style="max-width:56rem">
            <a class="crumb" href="{{ route('blog.index') }}">
                <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 3 5 8l5 5"/></svg>
                All writing
            </a>

            <h1 class="display display--sm mb-3">{{ $blog->title }}</h1>

            @if ($blog->description)
                <p class="lede mb-3">{{ $blog->description }}</p>
            @endif

            <p class="post__meta">
                <a href="{{ route('blog.index', ['category' => $blog->category]) }}">{{ $blog->category }}</a>
                &nbsp;&nbsp;
                <time datetime="{{ $blog->created_at->toIso8601String() }}">{{ $blog->created_at->format('F j, Y') }}</time>
                &nbsp;&nbsp;{{ $readingMinutes }} min read
                @if ($blog->updated_at->ne($blog->created_at))
                    &nbsp;&nbsp;Updated {{ $blog->updated_at->format('M j, Y') }}
                @endif
            </p>
        </div>
    </header>

    @if ($blog->image)
        <div class="wrap" style="max-width:68rem">
            <div class="photo photo--wide reveal-media">
                <img src="{{ $cover }}" alt="{{ $blog->title }}" fetchpriority="high" decoding="async">
            </div>
        </div>
    @endif

    <div class="section">
        <div class="wrap" style="max-width:56rem">
            <div class="prose" id="article-body">{!! nl2br(e($blog->content)) !!}</div>

            @if ($blog->tags)
                <ul class="chips mt-4" style="flex-wrap:wrap">
                    @foreach (array_filter(array_map('trim', explode(',', $blog->tags))) as $tag)
                        <li><a class="chip" href="{{ route('blog.index', ['q' => $tag]) }}">{{ $tag }}</a></li>
                    @endforeach
                </ul>
            @endif

            <div class="crail__item mt-4" style="border-bottom:1px solid var(--line)">
                <span class="small">Share this article</span>
                <span style="display:flex;gap:1.25rem;flex-wrap:wrap">
                    <a class="tlink" href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener noreferrer">LinkedIn</a>
                    <a class="tlink" href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener noreferrer">Facebook</a>
                    <a class="tlink" href="https://x.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank" rel="noopener noreferrer">X</a>
                    <a class="tlink" href="mailto:?subject={{ $shareTitle }}&body={{ $shareUrl }}">Email</a>
                </span>
            </div>
        </div>
    </div>
</article>

@if ($related->count())
    <section class="section" style="background:var(--paper-2)">
        <div class="wrap">
            <h2 class="h2 mb-4" data-split-heading>Keep reading</h2>
            <div class="posts">
                @foreach ($related as $post)
                    @include('blog._card', ['post' => $post])
                @endforeach
            </div>
        </div>
    </section>
@endif

@include('site.cta', [
    'heading' => 'Rather have this done for you?',
    'body'    => 'Book thirty minutes with an operator who runs accounts like yours. You leave with a written view of what to change first.',
])

@endsection
