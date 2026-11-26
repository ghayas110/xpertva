@extends('layouts.site')

{{-- One Amazon case file. Content: resources/data/amazon-cases.json.
     Each page links to the service pages it belongs to, and those pages
     link back through site/case-files.blade.php. --}}
@section('title', $case['title'] . ' | XpertVA')
@section('meta_description', \Illuminate\Support\Str::limit($case['summary'], 155))
@section('head_tone', 'site-head--on-dark')

@php
    $url = route('work.amazon-case', $slug);
    $services = collect($case['services'])
        ->map(fn ($r) => (config('content.services', [])[$r] ?? null) ? ['route' => $r] + config('content.services')[$r] : null)
        ->filter(fn ($s) => $s && Route::has($s['route']))
        ->values();
    $primary = $services->first();
    $others = collect(\App\Support\AmazonCases::all())->except($slug);
@endphp

@push('head')
<link rel="canonical" href="{{ $url }}">
<meta property="og:type" content="article">
<meta property="og:title" content="{{ $case['title'] }}">
<meta property="og:description" content="{{ $case['summary'] }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:image" content="{{ asset($case['image']) }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@include('site.breadcrumbs', [
    'trail'   => [['Work', route('work')], ['Amazon case files', route('work.amazon-cases')]],
    'current' => $case['h1'],
])

@section('content')

<section class="phead phead--photo">
    <x-img class="phead__bg" src="{{ asset('assets/photos/analytics-screen.jpg') }}" alt="" fetchpriority="high" decoding="async" sizes="100vw" />
    <div class="wrap">
        <a class="crumb" href="{{ route('work.amazon-cases') }}">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 3 5 8l5 5"/></svg>
            All Amazon case files
        </a>
        <p class="eyebrow mb-2">Amazon case file &middot; {{ $case['category'] }}</p>
        <h1 class="display display--sm mb-3" style="max-width:24ch">{{ $case['h1'] }}</h1>
        <p class="lede" style="max-width:62ch">{{ $case['summary'] }}</p>
        <dl class="casefacts">
            <div><dt>Answered by</dt><dd>{{ $case['team'] }}</dd></div>
            <div><dt>Outcome</dt><dd>{{ $case['resolution'] }}</dd></div>
            @if ($primary)
                <div><dt>Service</dt><dd><a class="tlink" href="{{ route($primary['route']) }}">{{ $primary['label'] }}</a></dd></div>
            @endif
        </dl>
    </div>
</section>

@if (! empty($case['stats']))
<section class="band section--tight">
    <div class="wrap">
        <ul class="stats">
            @foreach ($case['stats'] as [$value, $label])
                <li data-anim data-anim-delay="{{ $loop->index * 0.08 }}">
                    <p class="stat__value">{{ $value }}</p>
                    <p class="stat__label">{{ $label }}</p>
                </li>
            @endforeach
        </ul>
    </div>
</section>
@endif

<section class="section">
    <div class="wrap">
        <div class="duo" style="align-items:start">
            <div>
                <h2 class="h2 mb-3" data-split-heading>The problem</h2>
                @foreach ($case['problem'] as $para)
                    <p class="body mb-2">{{ $para }}</p>
                @endforeach
            </div>
            <div>
                <h2 class="h2 mb-3" data-split-heading>What we filed</h2>
                <ul class="ticks mb-4">
                    @foreach ($case['filed'] as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
                <h2 class="h3 mb-2">What Amazon replied</h2>
                <p class="body mb-2">{{ $case['reply'] }}</p>
                <blockquote class="callout" style="margin:0">
                    <p class="callout__label">From Amazon's reply</p>
                    <p>&ldquo;{{ $case['quote'] }}&rdquo;</p>
                </blockquote>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <figure style="margin:0">
            <div class="photo reveal-media">
                <x-img src="{{ asset($case['image']) }}" alt="{{ $case['alt'] }}" loading="lazy" decoding="async" sizes="(min-width: 1200px) 1100px, 100vw" />
            </div>
            <figcaption class="small mt-2">
                The case in Seller Central. Brand names, ASINs, order numbers and contact details are blurred because the account is still trading.
            </figcaption>
        </figure>
    </div>
</section>

<section class="section" style="background:var(--paper-2)">
    <div class="wrap">
        <h2 class="h2 mb-2" data-split-heading>How to handle this case yourself</h2>
        <p class="body mb-4" style="max-width:62ch">The steps we follow on cases like this one. Amazon's forms and wording change, so check the current Seller Central help page before you file.</p>
        <div class="seq">
            @foreach ($case['steps'] as [$name, $desc])
                <div class="seq__item" data-anim data-anim-delay="{{ min($loop->index * 0.04, 0.2) }}">
                    <h3><span class="num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>{{ $name }}</h3>
                    <p>{{ $desc }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section">
    <div class="wrap" style="max-width:60rem">
        <h2 class="h2 mb-4" data-split-heading>Questions about this kind of case</h2>
        <div class="faq">
            @foreach ($case['faqs'] as [$q, $a])
                <details>
                    <summary>{{ $q }}</summary>
                    <p>{{ $a }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

<section class="section--tight" style="background:var(--paper-2);padding-block:clamp(3rem,6vw,5rem)">
    <div class="wrap">
        <div class="duo" style="align-items:start">
            <div>
                <h2 class="h3 mb-2">Rather have us handle it?</h2>
                <p class="body mb-3">Cases like this are part of these services.</p>
                <div class="related">
                    @foreach ($services as $svc)
                        <a href="{{ route($svc['route']) }}"><span>{{ $svc['label'] }}</span>@include('site.arrow')</a>
                    @endforeach
                </div>
            </div>
            <div>
                <h2 class="h3 mb-3">More Amazon case files</h2>
                <div class="related">
                    @foreach ($others as $otherSlug => $other)
                        <a href="{{ route('work.amazon-case', $otherSlug) }}"><span>{{ $other['h1'] }}</span>@include('site.arrow')</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@include('site.cta', [
    'heading' => 'Stuck on an Amazon case?',
    'body'    => 'Book thirty minutes. Tell us what Amazon said, and we will tell you what we would file next.',
])

@endsection
