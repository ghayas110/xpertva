@extends('layouts.site')

@section('title', 'Blog & Insights | Amazon, eBay, Shopify & Walmart Growth | XpertVA')
@section('meta_description', 'Editorial insights, playbooks, and case studies on Amazon listing optimization, PPC strategy, Shopify growth, and virtual assistant best practices from the XpertVA team.')

@push('head')
<link rel="canonical" href="{{ url('/blog') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="Blog & Insights | XpertVA">
<meta property="og:description" content="Playbooks, case studies, and expert insights for Amazon, eBay, Shopify, and Walmart sellers.">
<meta property="og:url" content="{{ url('/blog') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@section('content')

<section class="phead">
    <div class="wrap">
        <div class="phead__grid">
            <h1 class="display">Writing</h1>
            <div>
                <p class="lede">
                    What we learn running marketplace accounts, written up so you can use it
                    whether or not you ever hire us.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:clamp(1.5rem,3vw,2.5rem)">
    <div class="wrap">

        {{-- Search and category filters --}}
        <form method="GET" action="{{ route('blog.index') }}" class="mb-4">
            <div class="field" style="max-width:26rem;margin-bottom:1rem">
                <label for="blog-q">Search articles</label>
                <input id="blog-q" type="search" name="q" value="{{ request('q') }}" placeholder="Listing optimisation, ACoS, reimbursement">
            </div>
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <button type="submit" class="btn btn--ghost">Search</button>
            @if (request('q') || request('category'))
                <a class="btn btn--ghost" href="{{ route('blog.index') }}">Clear</a>
            @endif
        </form>

        @if ($categories->count())
            <div class="chips mb-4" role="group" aria-label="Filter articles by category">
                <a class="chip" href="{{ route('blog.index', array_filter(['q' => request('q')])) }}"
                   aria-pressed="{{ request('category') ? 'false' : 'true' }}">All</a>
                @foreach ($categories as $category)
                    <a class="chip" href="{{ route('blog.index', array_filter(['category' => $category, 'q' => request('q')])) }}"
                       aria-pressed="{{ request('category') === $category ? 'true' : 'false' }}">{{ $category }}</a>
                @endforeach
            </div>
        @endif

        @if ($blogs->count())
            @php
                $featured = $blogs->first();
                $rest = $blogs->slice(1);
            @endphp

            <div class="posts">
                @include('blog._card', ['post' => $featured, 'lead' => true])
                @foreach ($rest as $post)
                    @include('blog._card', ['post' => $post])
                @endforeach
            </div>

            @if ($blogs->hasPages())
                <nav class="pager" aria-label="Article pages">
                    {{ $blogs->onEachSide(1)->links('blog._pager') }}
                </nav>
            @endif
        @else
            <div class="empty">
                <p class="h3">Nothing matches that yet</p>
                <p class="body">
                    @if (request('q') || request('category'))
                        Try a different search, or browse everything we have published.
                    @else
                        The first articles are on their way.
                    @endif
                </p>
                <a class="btn btn--ghost mt-2" href="{{ route('blog.index') }}">Show all articles</a>
            </div>
        @endif
    </div>
</section>

@include('site.cta', [
    'heading' => 'Rather have this done for you?',
    'body'    => 'Book thirty minutes with an operator who runs accounts like yours. You leave with a written view of what to change first.',
])

@endsection
