@extends('layouts.site')

@section('title', 'Amazon Seller Account Management | XpertVA')
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
    <x-img class="phead__bg" src="{{ asset('assets/photos/warehouse-aisles.jpg') }}" alt="Long aisles of racked inventory inside a fulfilment warehouse." fetchpriority="high" decoding="async" />
    <div class="wrap">
        <a class="crumb" href="{{ route('services.index') }}">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 3 5 8l5 5"/></svg>
            All services
        </a>
        <div class="phead__grid">
            {{-- The brand line stays as the eyebrow; the H1 names the service so
                 a searcher can tell what the page is about. --}}
            <p class="eyebrow">Amazon, run properly.</p>
            <h1 class="display display--sm">Amazon Seller Account Management Services</h1>
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
        <div class="callout mb-4">
            <p class="callout__label">In short</p>
            <p>
                Amazon seller account management is the day to day running of a Seller Central account:
                listings, advertising, keyword research, A+ content, account health, inventory and brand
                protection. XpertVA puts one named operator on your account to do that work, with a backup
                who knows it, and reports to you in writing every week.
            </p>
        </div>

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
                <x-img data-cindex-img="listing" loading="lazy" src="{{ asset('assets/storefront/amazon-brand-storefront-nitrile-gloves.jpg') }}" alt="" />
                <x-img data-cindex-img="ppc" loading="lazy" src="{{ asset('assets/ppc-management/amazon-ppc-campaign-manager-dashboard.jpg') }}" alt="" />
                <x-img data-cindex-img="seo" loading="lazy" src="{{ asset('assets/keyword-research/amazon-keyword-research-competitor-matrix.jpg') }}" alt="" />
                <x-img data-cindex-img="aplus" loading="lazy" src="{{ asset('assets/a-plus-content/amazon-a-plus-content-ceiling-fan.jpg') }}" alt="" />
                <x-img data-cindex-img="health" loading="lazy" src="{{ asset('assets/account-health/amazon-account-health-dashboard.jpg') }}" alt="" />
                <x-img data-cindex-img="brand" loading="lazy" src="{{ asset('assets/map-enforcement/map-enforcement-violation-tracker.png') }}" alt="" />
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

{{-- Order of work --}}
<section class="section">
    <div class="wrap">
        <h2 class="h2 mb-4" data-split-heading>How the work runs</h2>
        <div class="seq">
            @foreach ([
                ['Account audit', 'Listings, campaigns, account health, inventory and brand issues reviewed and written up, with the fixes ranked by what they are costing you.'],
                ['Fix what is leaking', 'Suppressed listings, wasted ad spend, open cases and unclaimed reimbursements are dealt with first, because they pay for everything after.'],
                ['Run it every day', 'Your operator works the account daily across the six disciplines, with a backup who knows it well enough to cover.'],
                ['Report in writing', 'A weekly note on what changed, what it cost and what happens next, plus a monthly profit view after fees, ads, returns and storage.'],
            ] as [$step, $desc])
                <div class="seq__item" data-anim data-anim-delay="{{ min($loop->index * 0.04, 0.2) }}">
                    <h3><span class="num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>{{ $step }}</h3>
                    <p>{{ $desc }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Plain content only: Google retired FAQ rich results in May 2026, so no FAQPage schema. --}}
<section class="section" style="background:var(--paper-2)">
    <div class="wrap" style="max-width:60rem">
        <h2 class="h2 mb-4" data-split-heading>Questions we get asked</h2>
        <div class="faq">
            @foreach ([
                ['What does an Amazon account manager do?', 'They run the account day to day: optimising listings, managing advertising, watching account health, handling Seller Support cases, planning inventory and protecting the brand from hijackers. The goal is a catalogue that ranks, converts and stays healthy.'],
                ['Is it safe to give you access to Seller Central?', 'Yes. We are added as a secondary user with only the permissions the work needs. You never share your primary login and can remove our access at any time from User Permissions.'],
                ['Do you work with both FBA and FBM sellers?', 'Yes. We manage FBA shipments, inventory and reimbursements, and merchant fulfilled order handling and shipping settings.'],
                ['Which marketplaces do you cover?', 'We work across Amazon marketplaces including the US, UK, EU and Canada, and can run the same catalogue in several of them.'],
                ['Can we hire you for one discipline only?', 'Yes. Each discipline, such as PPC or listing optimisation, is available on its own. Most accounts end up needing several, which is why they sit under one team.'],
                ['How much does Amazon account management cost?', 'We quote after a free consultation, in writing, based on catalogue size, marketplaces and which disciplines the account needs. You see the scope and the monthly figure before you commit to anything.'],
            ] as [$q, $a])
                <details>
                    <summary>{{ $q }}</summary>
                    <p>{{ $a }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

@include('site.reading')


@include('site.cta', [
    'heading' => 'Send us one ASIN.',
    'body'    => 'We will return a written breakdown of the listing, its keyword coverage and the ad spend leaking against it. No charge, and no obligation to go further.',
])

@endsection
