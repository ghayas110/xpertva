@extends('layouts.site')

{{-- Hub for the Amazon case files. Links to every case, and every case
     links back here and to its service pages. --}}
@section('title', 'Amazon Seller Central Case Results | XpertVA')
@section('meta_description', 'Real Seller Central cases we resolved: lost FBA inventory reimbursed, ASINs reinstated, feedback removed, Buy Box restored, list price and title fixed.')
@section('head_tone', 'site-head--on-dark')

@php
    $groups = collect($cases)->groupBy('category', true);
@endphp

@push('head')
<link rel="canonical" href="{{ route('work.amazon-cases') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="Amazon Seller Central Case Results | XpertVA">
<meta property="og:description" content="Real Seller Central cases we resolved, with Amazon's replies and how each one was handled.">
<meta property="og:url" content="{{ route('work.amazon-cases') }}">
<meta property="og:image" content="{{ asset('assets/amazon-cases/fba-lost-inventory-reimbursed.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@push('schema')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'ItemList',
    'name' => 'Amazon Seller Central case files',
    'itemListElement' => collect(array_keys($cases))->values()->map(fn ($slug, $i) => [
        '@type' => 'ListItem',
        'position' => $i + 1,
        'url' => route('work.amazon-case', $slug),
        'name' => $cases[$slug]['h1'],
    ])->all(),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@include('site.breadcrumbs', ['trail' => [['Work', route('work')]], 'current' => 'Amazon case files'])

@section('content')

<section class="phead phead--photo">
    <x-img class="phead__bg" src="{{ asset('assets/photos/analytics-screen.jpg') }}" alt="" fetchpriority="high" decoding="async" sizes="100vw" />
    <div class="wrap">
        <a class="crumb" href="{{ route('work') }}">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 3 5 8l5 5"/></svg>
            All work
        </a>
        <div class="phead__grid">
            <h1 class="display display--sm">Amazon Seller Central case results</h1>
            <div>
                <p class="lede">
                    Cases we opened for client accounts and the answers Amazon sent back. Each one explains the problem,
                    what we filed, what Amazon replied and how to handle the same case yourself.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <div class="stack-lg">
            @foreach ($groups as $category => $items)
                <div>
                    <h2 class="h3 mb-3">{{ $category }}</h2>
                    <div class="related">
                        @foreach ($items as $caseSlug => $case)
                            <a href="{{ route('work.amazon-case', $caseSlug) }}">
                                <span><strong>{{ $case['h1'] }}</strong><br><span class="small">{{ $case['resolution'] }}</span></span>
                                @include('site.arrow')
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section--tight" style="background:var(--paper-2);padding-block:clamp(3rem,6vw,5rem)">
    <div class="wrap">
        <h2 class="h3 mb-3">The services behind these cases</h2>
        <div class="related">
            @foreach (['services.amazon.account-management', 'services.amazon.listing-optimization', 'services.amazon.a-plus-storefront', 'services.amazon.brand-protection', 'services.amazon-ops', 'services.amazon-va'] as $r)
                @php $svc = config('content.services', [])[$r] ?? null; @endphp
                @if ($svc && Route::has($r))
                    <a href="{{ route($r) }}"><span>{{ $svc['label'] }}</span>@include('site.arrow')</a>
                @endif
            @endforeach
        </div>
    </div>
</section>

@include('site.cta', [
    'heading' => 'Stuck on an Amazon case?',
    'body'    => 'Book thirty minutes. Tell us what Amazon said, and we will tell you what we would file next.',
])

@endsection
