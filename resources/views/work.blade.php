@extends('layouts.site')

@section('title', 'Work - XpertVA')
@section('meta_description', 'XpertVA case studies: $9.2M in Amazon sales, 6x revenue growth, and proven eCommerce success stories across Amazon, Shopify, and Walmart.')
@section('head_tone', 'site-head--on-dark')

@push('head')
<link rel="canonical" href="{{ url('/work') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="Work | XpertVA">
<meta property="og:description" content="Real Seller Central reports and catalogue work from managed XpertVA client accounts.">
<meta property="og:url" content="{{ url('/work') }}">
<meta property="og:image" content="{{ asset('assets/proof/case-year.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@section('content')

<section class="phead phead--photo">
    <img class="phead__bg" src="{{ asset('assets/photos/warehouse-aisles.jpg') }}" alt="Long aisles of racked inventory inside a fulfilment warehouse." fetchpriority="high" decoding="async">
    <div class="wrap">
        <div class="phead__grid">
            <h1 class="display">Work</h1>
            <div>
                <p class="lede">
                    Screenshots from live client accounts, not mockups. Brand names are removed
                    because most of these accounts are still trading.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- The three headline reports, at full size --}}
<section class="section">
    <div class="wrap">
        <h2 class="h2 mb-4" data-split-heading>Three reports worth<br>reading properly.</h2>
        <div class="stack-lg">
            @php
                $reports = [
                    [
                        'img'    => 'assets/proof/case-year.jpg',
                        'figure' => '$9,226,488.00',
                        'title'  => 'Fourteen months on one managed account',
                        'body'   => '54,039 orders and 85,277 units between September 2024 and November 2025, with units ordered climbing steadily across the period.',
                        'alt'    => 'Amazon Seller Central sales dashboard showing 9,226,488 dollars in ordered product sales and a rising units ordered trend from September 2024 to November 2025.',
                    ],
                    [
                        'img'    => 'assets/proof/case-q4.jpg',
                        'figure' => '$2,086,577.20',
                        'title'  => 'Peak season, October to December 2024',
                        'body'   => '7,638 orders and 12,585 units through the busiest quarter of the retail year.',
                        'alt'    => 'Amazon Seller Central sales snapshot for October to December 2024 showing 2,086,577 dollars and 20 cents in ordered product sales.',
                    ],
                    [
                        'img'    => 'assets/proof/case-q1.jpg',
                        'figure' => '$976,715.50',
                        'title'  => 'A single quarter, earlier in the same account',
                        'body'   => '4,308 orders and 7,355 units of ordered product sales across the quarter.',
                        'alt'    => 'Amazon Seller Central sales snapshot showing 976,715 dollars and 50 cents in ordered product sales from 4,308 order items.',
                    ],
                ];
            @endphp
            @foreach ($reports as $r)
                <article class="duo {{ $loop->odd ? '' : 'duo--flip' }}" data-anim>
                    <div class="photo reveal-media duo__media" style="aspect-ratio:2/1">
                        <img src="{{ asset($r['img']) }}" alt="{{ $r['alt'] }}" loading="lazy" decoding="async">
                    </div>
                    <div>
                        <p class="case__figure num mb-2">{{ $r['figure'] }}</p>
                        <h3 class="h3 mb-2">{{ $r['title'] }}</h3>
                        <p class="body">{{ $r['body'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- Filterable catalogue of day to day work --}}
<section class="section" style="background:var(--paper-2)">
    <div class="wrap">
        <h2 class="h2 mb-3" data-split-heading>The daily record</h2>
        <p class="body mb-3">
            Claims won, cases closed, listings fixed, campaigns rebuilt.
            Showing <span data-filter-count class="num">all</span> pieces of work.
        </p>

        <div class="chips mb-4" data-filters role="group" aria-label="Filter work by category">
            @php
                $categories = [
                    'All', 'Success Stories', 'Keyword Research', 'Infographics', 'Listing Optimization',
                    'MAP Enforcement', 'A to Z Claim', 'Amazon Cases', 'Account Health',
                    'Listing Issues', 'A+ Premium', 'Storefront Creation',
                    'Amazon PPC Optimization', 'Coupon & Promotion', 'Reimbursement',
                ];
            @endphp
            @foreach ($categories as $cat)
                <button type="button" class="chip" data-cat-filter="{{ $cat }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">{{ $cat }}</button>
            @endforeach
        </div>

        @php
        $portfolio = [
        // INFOGRAPHICS
        ['title' => 'Collins smart Ceiling fan', 'cat' => 'Infographics', 'img' => 'images/fan.jpg', 'desc' => 'Infographics & lifestyle images.'],
        ['title' => 'Rechargeable table lamps', 'cat' => 'Infographics', 'img' => 'images/lightning-lamp.jpg', 'desc' => 'Lighting solutions for modern living.'],
        ['title' => 'Legrand - 15a Self Test Outlet', 'cat' => 'Infographics', 'img' => 'images/self-test-outlet.jpg', 'desc' => 'Product feature highlights.'],
        ['title' => 'BUBRITE:Traverse LED', 'cat' => 'Infographics', 'img' => 'images/Transverse-led.jpg', 'desc' => 'High quality rendering.'],
        ['title' => 'Chandelier Lift System', 'cat' => 'Infographics', 'img' => 'images/chandelier-lift-system.jpg', 'desc' => 'Infographics integration.'],

        // A TO Z CLAIM
        ['title' => 'A to Z Claim Success', 'cat' => 'A to Z Claim', 'img' => 'A-to-z Guarantee Claims/1.jpg', 'desc' => 'Claim dispute resolution'],
        ['title' => 'A to Z Claim Success', 'cat' => 'A to Z Claim', 'img' => 'A-to-z Guarantee Claims/2.jpg', 'desc' => 'Claim dispute resolution'],
        ['title' => 'A to Z Claim Success', 'cat' => 'A to Z Claim', 'img' => 'A-to-z Guarantee Claims/3.jpg', 'desc' => 'Claim dispute resolution'],
        ['title' => 'A to Z Claim Success', 'cat' => 'A to Z Claim', 'img' => 'A-to-z Guarantee Claims/4.jpg', 'desc' => 'Claim dispute resolution'],
        ['title' => 'A to Z Claim Success', 'cat' => 'A to Z Claim', 'img' => 'A-to-z Guarantee Claims/5.jpg', 'desc' => 'Claim dispute resolution'],

        // ACCOUNT HEALTH
        ['title' => 'Account Health Safety', 'cat' => 'Account Health', 'img' => 'Account Health/c3hrneItb1.jpg', 'desc' => 'Account reinstatement & health'],

        // AMAZON CASES
        ['title' => 'Amazon Case Resolve', 'cat' => 'Amazon Cases', 'img' => 'Amazon Cases/1.jpg', 'desc' => 'Seller support resolution'],
        ['title' => 'Amazon Case Resolve', 'cat' => 'Amazon Cases', 'img' => 'Amazon Cases/2.jpg', 'desc' => 'Seller support resolution'],
        ['title' => 'Amazon Case Resolve', 'cat' => 'Amazon Cases', 'img' => 'Amazon Cases/3.jpg', 'desc' => 'Seller support resolution'],
        ['title' => 'Amazon Case Resolve', 'cat' => 'Amazon Cases', 'img' => 'Amazon Cases/4.jpg', 'desc' => 'Seller support resolution'],
        ['title' => 'Amazon Case Resolve', 'cat' => 'Amazon Cases', 'img' => 'Amazon Cases/5.jpg', 'desc' => 'Seller support resolution'],
        ['title' => 'Amazon Case Resolve', 'cat' => 'Amazon Cases', 'img' => 'Amazon Cases/6.jpg', 'desc' => 'Seller support resolution'],
        ['title' => 'Amazon Case Resolve', 'cat' => 'Amazon Cases', 'img' => 'Amazon Cases/8.jpg', 'desc' => 'Seller support resolution'],
        ['title' => 'Amazon Case Resolve', 'cat' => 'Amazon Cases', 'img' => 'Amazon Cases/9.jpg', 'desc' => 'Seller support resolution'],
        ['title' => 'Amazon Case Resolve', 'cat' => 'Amazon Cases', 'img' => 'Amazon Cases/10.jpg', 'desc' => 'Seller support resolution'],

        // KEYWORD RESEARCH
        ['title' => 'Keyword Optimization', 'cat' => 'Keyword Research', 'img' => 'Keyword Research/final.jpg', 'desc' => 'Search volume & rank tracking'],

        // LISTING ISSUES
        ['title' => 'Listing Fix', 'cat' => 'Listing Issues', 'img' => 'Listing Issues/74qzypE9bI.jpg', 'desc' => 'Stranded inventory fixed'],
        ['title' => 'Listing Fix', 'cat' => 'Listing Issues', 'img' => 'Listing Issues/867qLvJCNQ.jpg', 'desc' => 'Category approvals'],
        ['title' => 'Listing Fix', 'cat' => 'Listing Issues', 'img' => 'Listing Issues/VbUbvEIDmB.jpg', 'desc' => 'Suppressed listing active'],
        ['title' => 'Listing Fix', 'cat' => 'Listing Issues', 'img' => 'Listing Issues/fAYJdtfv2V.jpg', 'desc' => 'Error 5665 / 8541 resolution'],

        // LISTING OPTIMIZATION
        ['title' => 'Listing Rank Boost', 'cat' => 'Listing Optimization', 'img' => 'Listing Optimization/final-1.jpg', 'desc' => 'SEO optimized copy'],

        // MAP ENFORCEMENT
        ['title' => 'Pricing Control', 'cat' => 'MAP Enforcement', 'img' => 'MAP Enforcement/All Blur 2.png', 'desc' => 'Unauthorized seller removal'],

        // PPC OPTIMIZATION
        ['title' => 'PPC ACOS Drop', 'cat' => 'Amazon PPC Optimization', 'img' => 'PPC Campaign Management & Optimization/TCWQ4nKt8K.jpg', 'desc' => 'Ad spend efficiency'],
        ['title' => 'PPC Sales Boost', 'cat' => 'Amazon PPC Optimization', 'img' => 'PPC Campaign Management & Optimization/gA69WkFEUI.jpg', 'desc' => 'Campaign structure overview'],

        // A+ PREMIUM
        ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'Premium-Basic A%2B Content/54kbqy3MU4.jpg', 'desc' => 'Brand registry EBC'],
        ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'Premium-Basic A%2B Content/DO4pwaZzIp.jpg', 'desc' => 'Brand registry EBC'],
        ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'Premium-Basic A%2B Content/QlRcqWsLX5.jpg', 'desc' => 'Brand registry EBC'],
        ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'Premium-Basic A%2B Content/SIc4i0qSam.jpg', 'desc' => 'Brand registry EBC'],
        ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'Premium-Basic A%2B Content/UzpT4epgtC.jpg', 'desc' => 'Brand registry EBC'],
        ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'Premium-Basic A%2B Content/uRaNcIWJHx.jpg', 'desc' => 'Brand registry EBC'],
        ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'Premium-Basic A%2B Content/xuJ2Pv0W3g.jpg', 'desc' => 'Brand registry EBC'],
        ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'Premium-Basic A%2B Content/yzDXOce00J.jpg', 'desc' => 'Brand registry EBC'],

        // STOREFRONT
        ['title' => 'Brand Storefront', 'cat' => 'Storefront Creation', 'img' => 'Storefront/b1lyQ4S1zi.jpg', 'desc' => 'Custom branded pages'],
        ['title' => 'Brand Storefront', 'cat' => 'Storefront Creation', 'img' => 'Storefront/yOhjU6le9N.jpg', 'desc' => 'Custom branded pages'],

        // COUPON & PROMO
        ['title' => 'Promo Success', 'cat' => 'Coupon & Promotion', 'img' => 'Coupon & Promotion Management/Coupon.png', 'desc' => 'Sales velocity increment'],
        ['title' => 'Promo Success', 'cat' => 'Coupon & Promotion', 'img' => 'Coupon & Promotion Management/Running Coupon.png', 'desc' => 'Velocity campaign'],

        // REIMBURSEMENT
        ['title' => 'FBA Reimbursement', 'cat' => 'Reimbursement', 'img' => 'Reimbursement/1.jpg', 'desc' => 'Lost inventory recovered'],
        ['title' => 'FBA Reimbursement', 'cat' => 'Reimbursement', 'img' => 'Reimbursement/2.jpg', 'desc' => 'Lost inventory recovered'],
        ['title' => 'FBA Reimbursement', 'cat' => 'Reimbursement', 'img' => 'Reimbursement/3.jpg', 'desc' => 'Lost inventory recovered'],

        // SUCCESS STORIES
        ['title' => 'SDS Account Growth', 'cat' => 'Success Stories', 'img' => 'SDS Account - success story/March 2024.jpg', 'desc' => 'Yearly growth metrics'],
        ['title' => 'SDS Account Growth', 'cat' => 'Success Stories', 'img' => 'SDS Account - success story/Last 3 month 2025.jpg', 'desc' => 'Quarterly progress'],
        ['title' => 'SDS Account Growth', 'cat' => 'Success Stories', 'img' => 'SDS Account - success story/2024 1st quater.jpg', 'desc' => 'Sales explosion'],
        ['title' => 'SDS Account Growth', 'cat' => 'Success Stories', 'img' => 'SDS Account - success story/2024 Last Quater.jpg', 'desc' => 'Peak season review'],
        ['title' => 'SDS Account Growth', 'cat' => 'Success Stories', 'img' => 'SDS Account - success story/Sep 2024.jpg', 'desc' => 'Constant momentum'],

        ['title' => 'Tubelox Toyz Growth', 'cat' => 'Success Stories', 'img' => 'Tubelox Toyz Sales/1st Qtr 2024.png', 'desc' => 'Bestseller rankings'],
        ['title' => 'Tubelox Toyz Growth', 'cat' => 'Success Stories', 'img' => 'Tubelox Toyz Sales/4th Qtr 2024.png', 'desc' => 'Holiday rush sales'],
        ];
        @endphp

        <div class="masonry">
            @foreach ($portfolio as $item)
                <figure class="tile" data-cat="{{ $item['cat'] }}">
                    <img src="{{ asset('assets/' . $item['img']) }}" alt="{{ $item['title'] }}: {{ $item['desc'] }}" loading="lazy" decoding="async">
                    <figcaption class="tile__cap">
                        <span class="eyebrow">{{ $item['cat'] }}</span>
                        <h3>{{ $item['title'] }}</h3>
                    </figcaption>
                </figure>
            @endforeach
        </div>

        <div class="empty mt-4" data-filter-empty hidden>
            <p class="h3">Nothing in that category yet</p>
            <p class="body">Pick another filter, or ask us for examples from your own category.</p>
            <button type="button" class="btn btn--ghost mt-2" data-open="consult">Book a consultation</button>
        </div>
    </div>
</section>

@include('site.cta', [
    'heading' => 'Want a report like these?',
    'body'    => 'Book thirty minutes. We will look at your account together and tell you what we would change first, whether or not you hire us.',
])

@endsection
