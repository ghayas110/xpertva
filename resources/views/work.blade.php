@extends('layouts.site')

@section('title', 'eCommerce Case Studies and Results | XpertVA')
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
    <x-img class="phead__bg" src="{{ asset('assets/photos/warehouse-aisles.jpg') }}" alt="Long aisles of racked inventory inside a fulfilment warehouse." fetchpriority="high" decoding="async" />
    <div class="wrap">
        <div class="phead__grid">
            <p class="eyebrow">Work</p>
            <h1 class="display">eCommerce Case Studies and Results</h1>
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
        ['title' => 'Collins smart Ceiling fan', 'cat' => 'Infographics', 'img' => 'images/fan.jpg', 'desc' => 'Infographics & lifestyle images.', 'ar' => 1.0],
        ['title' => 'Rechargeable table lamps', 'cat' => 'Infographics', 'img' => 'images/lightning-lamp.jpg', 'desc' => 'Lighting solutions for modern living.', 'ar' => 1.0],
        ['title' => 'Legrand - 15a Self Test Outlet', 'cat' => 'Infographics', 'img' => 'images/self-test-outlet.jpg', 'desc' => 'Product feature highlights.', 'ar' => 1.0],
        ['title' => 'BUBRITE:Traverse LED', 'cat' => 'Infographics', 'img' => 'images/Transverse-led.jpg', 'desc' => 'High quality rendering.', 'ar' => 1.0],
        ['title' => 'Chandelier Lift System', 'cat' => 'Infographics', 'img' => 'images/chandelier-lift-system.jpg', 'desc' => 'Infographics integration.', 'ar' => 1.0],

        // A TO Z CLAIM
        ['title' => 'A to Z Claim Success', 'cat' => 'A to Z Claim', 'img' => 'a-to-z-claims/a-to-z-claim-granted-odr-reversed-1.jpg', 'desc' => 'Claim dispute resolution', 'ar' => 0.256],
        ['title' => 'A to Z Claim Success', 'cat' => 'A to Z Claim', 'img' => 'a-to-z-claims/a-to-z-claim-granted-odr-reversed-2.jpg', 'desc' => 'Claim dispute resolution', 'ar' => 0.26],
        ['title' => 'A to Z Claim Success', 'cat' => 'A to Z Claim', 'img' => 'a-to-z-claims/a-to-z-claim-granted-odr-reversed-3.jpg', 'desc' => 'Claim dispute resolution', 'ar' => 0.16],
        ['title' => 'A to Z Claim Success', 'cat' => 'A to Z Claim', 'img' => 'a-to-z-claims/a-to-z-claim-granted-odr-reversed-4.jpg', 'desc' => 'Claim dispute resolution', 'ar' => 0.35],
        ['title' => 'A to Z Claim Success', 'cat' => 'A to Z Claim', 'img' => 'a-to-z-claims/a-to-z-claim-granted-odr-reversed-5.jpg', 'desc' => 'Claim dispute resolution', 'ar' => 0.175],

        // ACCOUNT HEALTH
        ['title' => 'Account Health Safety', 'cat' => 'Account Health', 'img' => 'account-health/amazon-account-health-dashboard.jpg', 'desc' => 'Seller Central dashboard with every policy healthy', 'ar' => 0.497],

        // AMAZON CASES
        ['title' => 'Buy Box Recovered', 'cat' => 'Amazon Cases', 'img' => 'amazon-cases/featured-offer-buy-box-won.jpg', 'desc' => 'Featured Offer won after case escalation', 'ar' => 0.266],
        ['title' => 'Feedback Removed', 'cat' => 'Amazon Cases', 'img' => 'amazon-cases/negative-feedback-removal-approved.jpg', 'desc' => 'Policy-violating seller feedback struck', 'ar' => 0.376],
        ['title' => 'ASINs Reinstated', 'cat' => 'Amazon Cases', 'img' => 'amazon-cases/asin-reinstatement-approved.jpg', 'desc' => 'Suppressed ASINs returned to active', 'ar' => 0.281],
        ['title' => 'List Price Corrected', 'cat' => 'Amazon Cases', 'img' => 'amazon-cases/list-price-update-approved.jpg', 'desc' => 'Price fixed with manufacturer documentation', 'ar' => 0.256],
        ['title' => 'DG Capacity Raised', 'cat' => 'Amazon Cases', 'img' => 'amazon-cases/dangerous-goods-capacity-increase.jpg', 'desc' => 'Dangerous goods storage limit increased', 'ar' => 0.235],
        ['title' => 'Title Updated', 'cat' => 'Amazon Cases', 'img' => 'amazon-cases/product-title-change-approved.jpg', 'desc' => 'Product title changed via Brand Registry', 'ar' => 0.309],
        ['title' => 'Lost Units Recovered', 'cat' => 'Amazon Cases', 'img' => 'amazon-cases/fba-lost-inventory-reimbursed.jpg', 'desc' => 'Warehouse investigation found and reimbursed stock', 'ar' => 0.527],
        ['title' => 'Detail Page Fixed', 'cat' => 'Amazon Cases', 'img' => 'amazon-cases/product-page-image-fix.jpg', 'desc' => 'Incorrect product images corrected', 'ar' => 0.344],
        ['title' => 'Byline Link Restored', 'cat' => 'Amazon Cases', 'img' => 'amazon-cases/brand-byline-link-fix.jpg', 'desc' => 'Brand byline reconnected to the Store', 'ar' => 0.284],

        // KEYWORD RESEARCH
        ['title' => 'Keyword Optimization', 'cat' => 'Keyword Research', 'img' => 'keyword-research/amazon-keyword-research-competitor-matrix.jpg', 'desc' => 'Competitor keyword matrix with search volumes', 'ar' => 0.412],

        // LISTING ISSUES
        ['title' => 'Listing Fix', 'cat' => 'Listing Issues', 'img' => 'listing-issues/amazon-listing-issue-resolved-1.jpg', 'desc' => 'Stranded inventory fixed', 'ar' => 0.387],
        ['title' => 'Listing Fix', 'cat' => 'Listing Issues', 'img' => 'listing-issues/amazon-listing-issue-resolved-2.jpg', 'desc' => 'Category approvals', 'ar' => 0.52],
        ['title' => 'Listing Fix', 'cat' => 'Listing Issues', 'img' => 'listing-issues/amazon-listing-issue-resolved-3.jpg', 'desc' => 'Suppressed listing active', 'ar' => 0.554],
        ['title' => 'Listing Fix', 'cat' => 'Listing Issues', 'img' => 'listing-issues/amazon-listing-issue-resolved-4.jpg', 'desc' => 'Error 5665 / 8541 resolution', 'ar' => 0.628],

        // LISTING OPTIMIZATION
        ['title' => 'Listing Rank Boost', 'cat' => 'Listing Optimization', 'img' => 'listing-optimization/amazon-listing-quality-score-analysis.jpg', 'desc' => 'Listing Quality Score analysis scoring 10 of 10', 'ar' => 0.355],

        // MAP ENFORCEMENT
        ['title' => 'Pricing Control', 'cat' => 'MAP Enforcement', 'img' => 'map-enforcement/map-enforcement-violation-tracker.png', 'desc' => 'MAP violation tracker across monitored resellers', 'ar' => 0.573],

        // PPC OPTIMIZATION
        ['title' => 'PPC ACOS Drop', 'cat' => 'Amazon PPC Optimization', 'img' => 'ppc-management/amazon-ppc-campaign-performance.jpg', 'desc' => 'Sponsored Products spend and sales trend', 'ar' => 0.492],
        ['title' => 'PPC Sales Boost', 'cat' => 'Amazon PPC Optimization', 'img' => 'ppc-management/amazon-ppc-campaign-manager-dashboard.jpg', 'desc' => 'Amazon Ads campaign manager performance dashboard', 'ar' => 0.492],

        // A+ PREMIUM
        ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'a-plus-content/amazon-a-plus-content-module-2.jpg', 'desc' => 'Brand registry EBC', 'ar' => 1.8],
        ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'a-plus-content/amazon-a-plus-content-module-3.jpg', 'desc' => 'Brand registry EBC', 'ar' => 1.8],
        ['title' => 'A+ Content Build', 'cat' => 'A+ Premium', 'img' => 'a-plus-content/amazon-a-plus-content-ceiling-fan.jpg', 'desc' => 'A+ modules for a smart ceiling fan listing', 'ar' => 1.8],
        ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'a-plus-content/amazon-a-plus-content-module-4.jpg', 'desc' => 'Brand registry EBC', 'ar' => 1.8],
        ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'a-plus-content/amazon-a-plus-content-module-5.jpg', 'desc' => 'Brand registry EBC', 'ar' => 1.8],
        ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'a-plus-content/amazon-a-plus-content-module-6.jpg', 'desc' => 'Brand registry EBC', 'ar' => 1.8],
        ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'a-plus-content/amazon-a-plus-content-module-7.jpg', 'desc' => 'Brand registry EBC', 'ar' => 1.8],
        ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'a-plus-content/amazon-a-plus-content-module-8.jpg', 'desc' => 'Brand registry EBC', 'ar' => 1.8],

        // STOREFRONT
        ['title' => 'Storefront Build', 'cat' => 'Storefront Creation', 'img' => 'storefront/amazon-brand-storefront-nitrile-gloves.jpg', 'desc' => 'Amazon Brand Store built for a nitrile glove range', 'ar' => 1.8],
        ['title' => 'Storefront Design', 'cat' => 'Storefront Creation', 'img' => 'storefront/amazon-brand-storefront-design.jpg', 'desc' => 'Multi-page Amazon Brand Store layout', 'ar' => 1.8],

        // COUPON & PROMO
        ['title' => 'Promo Success', 'cat' => 'Coupon & Promotion', 'img' => 'coupon-promotions/amazon-coupon-setup.png', 'desc' => 'Sales velocity increment', 'ar' => 0.437],
        ['title' => 'Promo Success', 'cat' => 'Coupon & Promotion', 'img' => 'coupon-promotions/amazon-running-coupon.png', 'desc' => 'Velocity campaign', 'ar' => 0.461],

        // REIMBURSEMENT
        ['title' => 'Label Refunds', 'cat' => 'Reimbursement', 'img' => 'reimbursement/fba-shipping-label-reimbursement.jpg', 'desc' => 'Unused FBA shipping labels reimbursed', 'ar' => 0.34],
        ['title' => 'FBA Reimbursement', 'cat' => 'Reimbursement', 'img' => 'reimbursement/fba-reimbursement-approved-2.jpg', 'desc' => 'Lost inventory recovered', 'ar' => 0.348],
        ['title' => 'FBA Reimbursement', 'cat' => 'Reimbursement', 'img' => 'reimbursement/fba-reimbursement-approved-3.jpg', 'desc' => 'Lost inventory recovered', 'ar' => 0.228],

        // SUCCESS STORIES
        ['title' => 'SDS Account Growth', 'cat' => 'Success Stories', 'img' => 'case-study-sds/sales-march-2024.jpg', 'desc' => 'Yearly growth metrics', 'ar' => 0.506],
        ['title' => 'SDS Account Growth', 'cat' => 'Success Stories', 'img' => 'case-study-sds/sales-last-quarter-2025.jpg', 'desc' => 'Quarterly progress', 'ar' => 0.5],
        ['title' => 'SDS Account Growth', 'cat' => 'Success Stories', 'img' => 'case-study-sds/sales-q1-2024.jpg', 'desc' => 'Sales explosion', 'ar' => 0.506],
        ['title' => 'SDS Account Growth', 'cat' => 'Success Stories', 'img' => 'case-study-sds/sales-q4-2024.jpg', 'desc' => 'Peak season review', 'ar' => 0.509],
        ['title' => 'SDS Account Growth', 'cat' => 'Success Stories', 'img' => 'case-study-sds/sales-september-2024.jpg', 'desc' => 'Constant momentum', 'ar' => 0.505],

        ['title' => 'Tubelox Toyz Growth', 'cat' => 'Success Stories', 'img' => 'case-study-tubelox/sales-q1-2024.png', 'desc' => 'Bestseller rankings', 'ar' => 0.556],
        ['title' => 'Tubelox Toyz Growth', 'cat' => 'Success Stories', 'img' => 'case-study-tubelox/sales-q4-2024.png', 'desc' => 'Holiday rush sales', 'ar' => 0.555],
        ];
        @endphp

        <div class="masonry">
            @foreach ($portfolio as $item)
                <figure class="tile" data-cat="{{ $item['cat'] }}" style="--ar:{{ $item['ar'] ?? 1 }}">
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
