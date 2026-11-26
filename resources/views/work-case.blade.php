@extends('layouts.site')

{{-- One case study. Content lives in config/content.php (case_studies).
     Every figure there was read off a Seller Central screenshot, and each
     row on this page links to the screenshot it came from. --}}
@section('title', $study['title'] . ' | XpertVA')
@section('meta_description', \Illuminate\Support\Str::limit($study['summary'], 155))

@php
    $url = route('work.case', $slug);
    $others = collect(config('content.case_studies', []))->except($slug);
    $review = config('content.review_profile');
@endphp

@push('head')
<link rel="canonical" href="{{ $url }}">
<meta property="og:type" content="article">
<meta property="og:title" content="{{ $study['title'] }}">
<meta property="og:description" content="{{ $study['summary'] }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:image" content="{{ asset($study['cover']) }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@include('site.breadcrumbs', ['trail' => [['Work', route('work')]], 'current' => $study['h1']])

@section('content')

<section class="phead">
    <div class="wrap">
        <a class="crumb" href="{{ route('work') }}">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 3 5 8l5 5"/></svg>
            All work
        </a>
        <p class="eyebrow mb-2">Case study &middot; {{ $study['account'] }}</p>
        <h1 class="display display--sm mb-3" style="max-width:22ch">{{ $study['h1'] }}</h1>
        <p class="lede" style="max-width:60ch">{{ $study['summary'] }}</p>
        <dl class="casefacts mt-3">
            <div><dt>Timeframe</dt><dd>{{ $study['timeframe'] }}</dd></div>
            <div><dt>Channel</dt><dd>{{ $study['channel'] }}</dd></div>
            <div><dt>Source</dt><dd>Seller Central sales dashboard</dd></div>
        </dl>
    </div>
</section>

<section class="band section--tight">
    <div class="wrap">
        <ul class="stats">
            @foreach ($study['headline'] as $stat)
                <li data-anim data-anim-delay="{{ $loop->index * 0.08 }}">
                    <p class="stat__value">{{ $stat['value'] }}</p>
                    <p class="stat__label">{{ $stat['label'] }}</p>
                </li>
            @endforeach
        </ul>
    </div>
</section>

@if ($study['challenge'])
<section class="section">
    <div class="wrap" style="max-width:60rem">
        <h2 class="h2 mb-3" data-split-heading>The challenge</h2>
        @foreach ((array) $study['challenge'] as $para)
            <p class="body mb-2">{{ $para }}</p>
        @endforeach
    </div>
</section>
@endif

<section class="section">
    <div class="wrap">
        <h2 class="h2 mb-2" data-split-heading>Before and after</h2>
        <p class="body mb-4" style="max-width:60ch">
            Two sales reports from this account, with the figures exactly as Seller Central shows them.
        </p>
        <div class="beforeafter">
            @foreach (['before' => 'Earlier', 'after' => 'Later'] as $key => $tag)
                @php $side = $study[$key]; @endphp
                <div class="beforeafter__side beforeafter__side--{{ $key }}">
                    <p class="eyebrow">{{ $tag }}</p>
                    <h3 class="h3 mb-3">{{ $side['label'] }}</h3>
                    <dl class="kv">
                        @foreach ($side['rows'] as [$label, $value])
                            <div><dt>{{ $label }}</dt><dd class="num">{{ $value }}</dd></div>
                        @endforeach
                    </dl>
                    @if (! empty($side['note']))
                        <p class="small mt-2">{{ $side['note'] }}</p>
                    @endif
                    @if ($side['source'])
                        <p class="small mt-2"><a class="tlink" href="{{ asset($side['source']) }}" target="_blank" rel="noopener">View the report</a></p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

@if ($study['actions'])
<section class="section" style="background:var(--paper-2)">
    <div class="wrap">
        <h2 class="h2 mb-4" data-split-heading>What we did</h2>
        <div class="seq">
            @foreach ($study['actions'] as $step)
                <div class="seq__item" data-anim>
                    <h3><span class="num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>{{ $step['name'] }}</h3>
                    <p>{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section" style="background:var(--paper-2)">
    <div class="wrap">
        <h2 class="h2 mb-4" data-split-heading>Report by report</h2>
        <p class="body mb-4" style="max-width:62ch">
            Each row is a separate Seller Central sales dashboard for this account. The figures are copied from the
            report exactly; click through to see the screenshot.
        </p>
        <div class="tablewrap">
            <table class="dtable">
                <thead><tr><th>Period</th><th>Ordered product sales</th><th>Detail</th><th>Screenshot</th></tr></thead>
                <tbody>
                    @foreach ($study['timeline'] as [$period, $figure, $detail, $source])
                        <tr>
                            <td>{{ $period }}</td>
                            <td class="num">{{ $figure }}</td>
                            <td>{{ $detail }}</td>
                            <td>@if ($source)<a class="tlink" href="{{ asset($source) }}" target="_blank" rel="noopener">View</a>@endif</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<section class="section">
    <div class="wrap" style="max-width:60rem">
        <h2 class="h3 mb-3">How to read these numbers</h2>
        <dl class="kv">
            <div><dt>Ordered product sales</dt><dd style="font-weight:400;text-align:left;max-width:38rem">The value of everything customers ordered in the period, before Amazon fees, refunds and advertising costs. It is revenue, not profit.</dd></div>
            <div><dt>Order items</dt><dd style="font-weight:400;text-align:left;max-width:38rem">The number of product lines ordered. An order with two different products counts as two order items.</dd></div>
            <div><dt>Units ordered</dt><dd style="font-weight:400;text-align:left;max-width:38rem">The number of individual units across those order items.</dd></div>
            <div><dt>Featured offer share</dt><dd style="font-weight:400;text-align:left;max-width:38rem">How often this seller's offer was the one shown in the Buy Box when shoppers viewed the listing. When it is low, most shoppers are buying from another seller.</dd></div>
        </dl>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <figure class="photo reveal-media" style="margin:0">
            <x-img src="{{ asset($study['cover']) }}" alt="Seller Central sales dashboard for this account, {{ $study['timeframe'] }}. Brand name blurred." loading="lazy" decoding="async" sizes="(min-width: 1200px) 1100px, 100vw" />
        </figure>
        <p class="small mt-2">
            Screenshot of the client's own Seller Central sales dashboard. The brand name is blurred because the account is still trading.
            @if ($review)
                Read what clients say about us on <a class="tlink" href="{{ $review['url'] }}" target="_blank" rel="noopener">{{ $review['name'] }}</a>.
            @endif
        </p>
    </div>
</section>

<section class="section--tight" style="background:var(--paper-2);padding-block:clamp(3rem,6vw,5rem)">
    <div class="wrap">
        <div class="duo" style="align-items:start">
            <div>
                <h2 class="h3 mb-3">Services for accounts like this</h2>
                <div class="related">
                    @foreach ($study['related'] as $route)
                        @php $svc = config('content.services', [])[$route] ?? null; @endphp
                        @if ($svc && Route::has($route))
                            <a href="{{ route($route) }}"><span>{{ $svc['label'] }}</span>@include('site.arrow')</a>
                        @endif
                    @endforeach
                </div>
            </div>
            @if ($others->count())
                <div>
                    <h2 class="h3 mb-3">More case studies</h2>
                    <div class="related">
                        @foreach ($others as $otherSlug => $other)
                            <a href="{{ route('work.case', $otherSlug) }}"><span>{{ $other['h1'] }}</span>@include('site.arrow')</a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

@include('site.cta', [
    'heading' => 'Want a report like this?',
    'body'    => 'Book thirty minutes. We will look at your account together and tell you what we would change first, whether or not you hire us.',
])

@endsection
