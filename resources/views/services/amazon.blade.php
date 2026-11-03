@extends('layouts.site')

@section('title', 'Amazon Services - XpertVA')
@section('meta_description', 'XpertVA Amazon Seller Central management, listing optimization, PPC advertising, inventory management, BSR improvement, and full account management.')
@section('head_tone', 'site-head--on-dark')

@push('head')
<link rel="canonical" href="{{ url('/services/amazon') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="Amazon Services | XpertVA">
<meta property="og:description" content="Amazon Seller Central run end to end: listings, advertising, creative, account health and brand protection.">
<meta property="og:url" content="{{ url('/services/amazon') }}">
<meta property="og:image" content="{{ asset('assets/proof/case-year.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": "Amazon Seller Central Management",
  "serviceType": "Amazon Marketplace Management",
  "provider": { "@@id": "https://xpertva.com/#organization" },
  "areaServed": "Worldwide",
  "description": "Full service Amazon Seller Central management covering listing optimisation, PPC advertising, SEO and keyword research, A+ content and storefront design, account health and brand protection.",
  "url": "{{ url('/services/amazon') }}",
  "offers": { "@@type": "Offer", "priceCurrency": "USD", "availability": "https://schema.org/InStock" }
}
</script>
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    { "@@type": "ListItem", "position": 1, "name": "Services", "item": "{{ url('/services') }}" },
    { "@@type": "ListItem", "position": 2, "name": "Amazon", "item": "{{ url('/services/amazon') }}" }
  ]
}
</script>
@endpush

@section('content')

<section class="phead phead--photo">
    <img class="phead__bg" src="{{ asset('assets/photos/warehouse-aisles.jpg') }}" alt="Long aisles of racked inventory inside a fulfilment warehouse." fetchpriority="high" decoding="async">
    <div class="wrap">
        <a class="crumb" href="{{ route('services.index') }}">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 3 5 8l5 5"/></svg>
            All services
        </a>
        <div class="phead__grid">
            <h1 class="display">Amazon,<br>run properly.</h1>
            <div>
                <p class="lede">
                    Six disciplines inside one Seller Central account, worked by operators who have run
                    accounts of their own. No reselling to a third agency.
                </p>
                <div class="mt-3" style="display:flex;flex-wrap:wrap;gap:.6rem">
                    <button type="button" class="btn btn--primary" data-open="consult">
                        Book a consultation
                        @include('site.arrow')
                    </button>
                    <button type="button" class="btn btn--ghost" data-open="audit">Free listing audit</button>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- The proof, before the pitch --}}
<section class="band section--tight">
    <div class="wrap">
        <ul class="stats">
            <li data-anim>
                <p class="stat__value"><span data-count="9.2" data-decimals="1" data-prefix="$" data-suffix="M">$9.2M</span></p>
                <p class="stat__label">Ordered product sales on one managed account over 14 months</p>
            </li>
            <li data-anim data-anim-delay="0.08">
                <p class="stat__value"><span data-count="85277">85,277</span></p>
                <p class="stat__label">Units shipped on that same account</p>
            </li>
            <li data-anim data-anim-delay="0.16">
                <p class="stat__value"><span data-count="500" data-suffix="+">500+</span></p>
                <p class="stat__label">Brands supported since we opened in 2017</p>
            </li>
            <li data-anim data-anim-delay="0.24">
                <p class="stat__value"><span data-count="98" data-suffix="%">98%</span></p>
                <p class="stat__label">Client satisfaction across active accounts</p>
            </li>
        </ul>
    </div>
</section>

{{-- Disciplines with real work behind each one --}}
<section class="section" data-cindex>
    <div class="wrap">
        <div class="cindex">
            <div>
                <h2 class="h2 mb-3" data-split-heading>Six disciplines</h2>
                <p class="body mb-4">
                    Each one is a service in its own right. Most accounts need four or five of them
                    running at once, which is the reason they sit under one team.
                </p>
                <ul class="cindex__list">
                    @php
                        $disciplines = [
                            ['listing', 'Listing optimization', 'Titles, bullets, backend keywords and A+ modules written to rank and convert.', 'services.amazon.listing-optimization'],
                            ['ppc',     'PPC management',       'Sponsored Products, Brands, Display and DSP, structured for a target ACoS.', 'services.amazon.ppc-management'],
                            ['seo',     'SEO and keyword research', 'Helium 10, Cerebro and Brand Analytics mapped to the terms that actually sell.', 'services.amazon.seo-keyword-research'],
                            ['aplus',   'A+ content and storefront', 'Premium A+, Brand Story and shoppable storefronts built around the catalogue.', 'services.amazon.a-plus-storefront'],
                            ['health',  'Account management',   'Cases, suspensions, stranded inventory and FBA reimbursement recovery.', 'services.amazon.account-management'],
                            ['brand',   'Brand protection',     'Hijacker removal, MAP enforcement, counterfeit takedowns and Brand Registry.', 'services.amazon.brand-protection'],
                        ];
                    @endphp
                    @foreach ($disciplines as [$key, $name, $meta, $r])
                        <li>
                            <a class="cindex__row" href="{{ route($r) }}" data-cindex-key="{{ $key }}">
                                <span>
                                    <span class="cindex__name">{{ $name }}</span>
                                    <span class="cindex__meta">{{ $meta }}</span>
                                </span>
                                <span class="cindex__go" aria-hidden="true">@include('site.arrow')</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="cindex__preview" aria-hidden="true">
                <img data-cindex-img="listing" loading="lazy" src="{{ asset('assets/Storefront/b1lyQ4S1zi.jpg') }}" alt="">
                <img data-cindex-img="ppc" loading="lazy" src="{{ asset('assets/PPC Campaign Management & Optimization/gA69WkFEUI.jpg') }}" alt="">
                <img data-cindex-img="seo" loading="lazy" src="{{ asset('assets/Keyword Research/final.jpg') }}" alt="">
                <img data-cindex-img="aplus" loading="lazy" src="{{ asset('assets/Premium-Basic A%2B Content/QlRcqWsLX5.jpg') }}" alt="">
                <img data-cindex-img="health" loading="lazy" src="{{ asset('assets/Account Health/c3hrneItb1.jpg') }}" alt="">
                <img data-cindex-img="brand" loading="lazy" src="{{ asset('assets/MAP Enforcement/All Blur 2.png') }}" alt="">
            </div>
        </div>
    </div>
</section>

{{-- Everything else that lands on an account manager --}}
<section class="section" style="background:var(--paper-2)">
    <div class="wrap">
        <h2 class="h2 mb-3" data-split-heading>And the rest of it</h2>
        <p class="body mb-4">
            The work nobody sells you on, which is usually the work that decides the quarter.
        </p>
        <div class="caps">
            @foreach ([
                ['Customer support', 'Buyer messages and returns answered inside Amazon response windows, every working day.'],
                ['A to Z guarantee claims', 'Claims contested with evidence before they land on your order defect rate.'],
                ['Seller Support cases', 'Cases opened, escalated and chased to a written resolution.'],
                ['Listing issues', 'Suppressed and stranded listings, error 5665 and 8541, category approvals.'],
                ['Coupons and promotions', 'Deal and coupon calendars planned around inventory rather than around Amazon emails.'],
                ['Infringement reporting', 'IP complaints filed through Brand Registry with the documentation they require.'],
                ['Business reports', 'A monthly profit view after fees, ads, returns and storage.'],
                ['MAP enforcement', 'Unauthorised sellers identified, warned and removed on a repeating schedule.'],
            ] as $item)
                <div class="caps__item" data-anim>
                    <h3>{{ $item[0] }}</h3>
                    <p>{{ $item[1] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

@include('site.cta', [
    'heading' => 'Send us one ASIN.',
    'body'    => 'We will return a written breakdown of the listing, its keyword coverage and the ad spend leaking against it. No charge, and no obligation to go further.',
])

@endsection
