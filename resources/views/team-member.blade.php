@extends('layouts.site')

{{-- Author bio page. Everything comes from config/content.php (authors), so
     adding a LinkedIn URL or a longer bio there updates this page, every
     byline and the Person schema at once. --}}
@section('title', $author['name'] . ', ' . $author['role'] . ' | XpertVA')
@section('meta_description', \Illuminate\Support\Str::limit($author['name'] . ' is ' . $author['role'] . ' at XpertVA. ' . implode(' ', $author['bio']), 155))

@push('head')
<link rel="canonical" href="{{ $author['url'] }}">
<meta property="og:type" content="profile">
<meta property="og:title" content="{{ $author['name'] }} | XpertVA">
<meta property="og:url" content="{{ $author['url'] }}">
<meta property="og:image" content="{{ asset($author['photo']) }}">
<meta name="twitter:card" content="summary">
@endpush

@push('schema')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'ProfilePage',
    'url' => $author['url'],
    'mainEntity' => \App\Support\Authors::schema($author),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Team', 'item' => route('team')],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $author['name'], 'item' => $author['url']],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')

<section class="phead">
    <div class="wrap">
        <a class="crumb" href="{{ route('team') }}">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 3 5 8l5 5"/></svg>
            Team
        </a>
        <div class="duo" style="align-items:start">
            <div>
                <p class="eyebrow mb-2">{{ $author['role'] }}</p>
                <h1 class="display display--sm mb-3">{{ $author['name'] }}</h1>
                @foreach ($author['bio'] as $para)
                    <p class="lede {{ $loop->last ? '' : 'mb-2' }}">{{ $para }}</p>
                @endforeach
                @if ($author['linkedin'])
                    <p class="mt-3"><a class="tlink" href="{{ $author['linkedin'] }}" target="_blank" rel="noopener noreferrer me">{{ $author['name'] }} on LinkedIn</a></p>
                @endif
            </div>
            <div class="photo photo--square" style="max-width:24rem">
                <x-img src="{{ asset($author['photo']) }}" alt="Portrait of {{ $author['name'] }}, {{ $author['role'] }} at XpertVA." fetchpriority="high" decoding="async" sizes="(min-width: 900px) 24rem, 100vw" />
            </div>
        </div>
    </div>
</section>

@if (! empty($author['knowsAbout']))
<section class="section--tight" style="padding-block:clamp(2rem,4vw,3rem)">
    <div class="wrap">
        <h2 class="h3 mb-3">Writes about</h2>
        <ul class="chips" style="flex-wrap:wrap">
            @foreach ($author['knowsAbout'] as $topic)
                <li><span class="chip">{{ $topic }}</span></li>
            @endforeach
        </ul>
    </div>
</section>
@endif

@if ($posts->count())
<section class="section" style="background:var(--paper-2)">
    <div class="wrap">
        <h2 class="h2 mb-4" data-split-heading>Articles by {{ \Illuminate\Support\Str::before($author['name'], ' ') }}</h2>
        <div class="posts">
            @foreach ($posts as $post)
                @include('blog._card', ['post' => $post])
            @endforeach
        </div>
    </div>
</section>
@endif

@include('site.cta')

@endsection
