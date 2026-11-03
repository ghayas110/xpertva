@extends('layouts.site')

@section('title', 'Virtual Assistant Services for Amazon, eBay, Shopify & Walmart Sellers | XpertVA')
@section('meta_description', 'Expert virtual assistant services for Amazon, eBay, Shopify, and Walmart sellers. Listing optimization, PPC management, account health, and storefront design. 500+ brands scaled since 2017.')

@push('head')
<link rel="canonical" href="{{ url('/') }}">
<link rel="preload" as="image" href="{{ asset('assets/proof/hero-dashboard.jpg') }}" fetchpriority="high">
<meta property="og:type" content="website">
<meta property="og:title" content="Virtual Assistant Services for Amazon, eBay, Shopify & Walmart Sellers | XpertVA">
<meta property="og:description" content="Expert virtual assistant services for eCommerce sellers. Listing optimization, PPC, A+ content, account health, and brand protection on Amazon, eBay, Shopify, and Walmart.">
<meta property="og:url" content="{{ url('/') }}">
<meta property="og:image" content="{{ asset('assets/proof/hero-dashboard.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@section('content')

{{-- 1. Hero: asymmetric split. Real Seller Central proof sits above the fold. --}}
<section class="hero">
    <div class="wrap">
        <div class="hero__grid">
            <div>
                <h1 class="display hero__title">
                    <span class="reveal-line"><span>The team that runs</span></span>
                    <span class="reveal-line"><span>your <em>marketplace</em>.</span></span>
                </h1>
                <p class="lede" data-hero-in>
                    Listings, advertising, account health and creative for brands selling on
                    Amazon, Shopify, Walmart and eBay.
                </p>
                <div class="hero__ctas" data-hero-in>
                    <button type="button" class="btn btn--primary btn--lg" data-open="consult">
                        Book a consultation
                        @include('site.arrow')
                    </button>
                    <a class="btn btn--ghost btn--lg" href="{{ route('work') }}">See the work</a>
                </div>
            </div>

            {{-- The people, and the report they produced. Both above the fold. --}}
            <figure class="hero__stage" style="margin:0" data-hero-in>
                <div class="photo">
                    <img src="{{ asset('assets/photos/team-laptops.jpg') }}"
                         width="1800" height="1800" fetchpriority="high" decoding="async"
                         alt="Account managers working through marketplace reports together at a shared desk.">
                </div>
                <div class="hero__proof">
                    <img src="{{ asset('assets/proof/hero-dashboard.jpg') }}"
                         width="1600" height="1000" fetchpriority="high" decoding="async"
                         alt="Amazon Seller Central sales dashboard for a managed XpertVA client account showing 9,226,488 dollars in ordered product sales and a rising units-ordered trend line from September 2024 to November 2025.">
                </div>
                <figcaption class="hero__caption">
                    One managed account, 14 months. Brand name removed at the client's request.
                </figcaption>
            </figure>
        </div>
    </div>
</section>

{{-- 2. Client logos. Under the hero, marks only, one marquee on the page. --}}
<section class="section--tight" aria-label="Brands we work with">
    <div class="marquee">
        <div class="marquee__track">
            {{-- Only marks with a clean alpha channel are used here; the silhouette
                 treatment in site.css turns a mixed set of source files into one strip. --}}
            @foreach ([
                'Bulbrite', 'HOMELUX', 'LONDON LABS', 'NOVAVITA NUTRITION',
                'CREEK', 'ASTORIA', 'EAGLES', 'AGENTS MOTOR PARTS', 'ATTAR MIST',
                'CONRAD SHOPPING', 'FLY', 'WE LOVE RESTURANT',
                'DIAMOND EXCELLENCY', 'HOLIDAY APARTMENT',
            ] as $logo)
                <img src="{{ asset('assets/logos/' . $logo . '.png') }}" alt="{{ $logo }}" loading="lazy" decoding="async" height="40">
            @endforeach
        </div>
    </div>
</section>

{{-- 3. Proof numbers. --}}
<section class="band section--tight">
    <div class="wrap">
        <ul class="stats">
            <li data-anim>
                <p class="stat__value"><span data-count="9.2" data-decimals="1" data-prefix="$" data-suffix="M">$9.2M</span></p>
                <p class="stat__label">Ordered product sales on one managed account over 14 months</p>
            </li>
            <li data-anim data-anim-delay="0.08">
                <p class="stat__value"><span data-count="54039">54,039</span></p>
                <p class="stat__label">Orders processed on that same account</p>
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

{{-- 4. Capability index. Hovering a discipline shows real work from that discipline. --}}
<section class="section" data-cindex>
    <div class="wrap">
        <div class="cindex">
            <div>
                <h2 class="h2 mb-3" data-split-heading>Six disciplines,<br>run in house.</h2>
                <p class="body mb-4" data-anim>
                    No reselling to a third agency. Every account is worked by an operator who
                    has run a Seller Central account of their own.
                </p>

                <ul class="cindex__list">
                    @php
                        $disciplines = [
                            ['key' => 'listing', 'name' => 'Listing optimization', 'meta' => 'Titles, bullets, backend keywords and A+ modules written to rank and convert.', 'route' => 'services.amazon.listing-optimization'],
                            ['key' => 'ppc',     'name' => 'Advertising and PPC',  'meta' => 'Sponsored Products, Brands, Display and DSP, structured for a target ACoS.',       'route' => 'services.amazon.ppc-management'],
                            ['key' => 'seo',     'name' => 'SEO and keyword research', 'meta' => 'Helium 10, Cerebro and Brand Analytics, mapped to the terms that actually sell.', 'route' => 'services.amazon.seo-keyword-research'],
                            ['key' => 'aplus',   'name' => 'A+ content and storefront', 'meta' => 'Premium A+, Brand Story and shoppable storefronts built around the catalogue.', 'route' => 'services.amazon.a-plus-storefront'],
                            ['key' => 'health',  'name' => 'Account health',       'meta' => 'Cases, suspensions, stranded inventory and FBA reimbursement recovery.',        'route' => 'services.amazon.account-management'],
                            ['key' => 'brand',   'name' => 'Brand protection',     'meta' => 'Hijacker removal, MAP enforcement, counterfeit takedowns and Brand Registry.',   'route' => 'services.amazon.brand-protection'],
                        ];
                    @endphp
                    @foreach ($disciplines as $d)
                        <li>
                            <a class="cindex__row" href="{{ route($d['route']) }}" data-cindex-key="{{ $d['key'] }}">
                                <span>
                                    <span class="cindex__name">{{ $d['name'] }}</span>
                                    <span class="cindex__meta">{{ $d['meta'] }}</span>
                                </span>
                                <span class="cindex__go" aria-hidden="true">@include('site.arrow', ['class' => 'btn__arrow'])</span>
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

{{-- 5. Case studies. The pan turns three accounts into one horizontal story. --}}
<section class="pan" data-pan aria-label="Case studies">
    <div class="pan__track">
        <div class="pan__intro">
            <p class="eyebrow mb-3">Reports, not renderings</p>
            <h2 class="h2 mb-3" data-split-heading>Numbers straight<br>out of Seller Central.</h2>
            <p class="body">
                Every figure below is a screenshot of the client's own sales report.
                Brand names are removed because the accounts are still live.
            </p>
        </div>

        @php
            $cases = [
                [
                    'img'    => 'assets/proof/case-q1.jpg',
                    'figure' => '$976,715.50',
                    'title'  => 'A single quarter, one managed account',
                    'body'   => '4,308 orders and 7,355 units of ordered product sales across the quarter.',
                    'alt'    => 'Amazon Seller Central sales snapshot showing 976,715 dollars and 50 cents in ordered product sales from 4,308 order items.',
                ],
                [
                    'img'    => 'assets/proof/case-q4.jpg',
                    'figure' => '$2,086,577.20',
                    'title'  => 'Peak season, October to December 2024',
                    'body'   => '7,638 orders and 12,585 units through the busiest quarter of the year.',
                    'alt'    => 'Amazon Seller Central sales snapshot for October to December 2024 showing 2,086,577 dollars and 20 cents in ordered product sales.',
                ],
                [
                    'img'    => 'assets/proof/case-year.jpg',
                    'figure' => '$9,226,488.00',
                    'title'  => 'Fourteen months, September 2024 to November 2025',
                    'body'   => '54,039 orders and 85,277 units, with units ordered climbing through the period.',
                    'alt'    => 'Amazon Seller Central sales dashboard showing 9,226,488 dollars in ordered product sales and a rising units ordered trend from September 2024 to November 2025.',
                ],
            ];
        @endphp

        @foreach ($cases as $c)
            <article class="case">
                <div class="case__media reveal-media">
                    <img src="{{ asset($c['img']) }}" alt="{{ $c['alt'] }}" loading="lazy" decoding="async" width="1800" height="900">
                </div>
                <div class="case__body">
                    <p class="case__figure num">{{ $c['figure'] }}</p>
                    <h3 class="h3">{{ $c['title'] }}</h3>
                    <p class="body">{{ $c['body'] }}</p>
                </div>
            </article>
        @endforeach
    </div>
</section>

{{-- 6. Other channels. --}}
<section class="section">
    <div class="wrap">
        <h2 class="h2 mb-4" data-split-heading>Amazon is where most<br>brands start with us.</h2>
        <ul class="channels" data-anim>
            @foreach ([
                ['Shopify',  'Theme builds, app stacks, subscription flows and checkout work on your own store.',        'services.shopify'],
                ['Walmart',  'Item setup, Walmart Fulfilment Services, Connect ads and Buy Box recovery.',              'services.walmart'],
                ['eBay',     'Store design, listing templates, Promoted Listings and returns handling.',                'services.ebay'],
                ['Web and marketing', 'Sites, mobile apps, SEO and paid social when the storefront is only part of it.', 'services.index'],
            ] as [$name, $note, $r])
                <li>
                    <a href="{{ route($r) }}">
                        <span class="channels__name">{{ $name }}</span>
                        <span class="channels__note">{{ $note }}</span>
                        <span class="cindex__go" aria-hidden="true">@include('site.arrow')</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</section>

{{-- 7. Photographic band. The parallax drift gives the scroll a beat between two dense sections. --}}
<section class="imgband" data-parallax>
    <img class="imgband__img" src="{{ asset('assets/photos/warehouse-aisles.jpg') }}"
         alt="Long aisles of racked inventory inside a fulfilment warehouse." loading="lazy" decoding="async">
    <div class="imgband__inner">
        <h2 data-split-heading>Your catalogue is an operation,<br>not a side task.</h2>
        <p data-anim data-anim-delay="0.1">
            Pricing, stock, cases, ad bids and compliance move every day. We staff that work
            so it stops landing on a founder at eleven at night.
        </p>
    </div>
</section>

{{-- 8. How an engagement runs. --}}
<section class="section" style="background:var(--paper-2)">
    <div class="wrap">
        <div class="proc">
            <div class="proc__head">
                <p class="eyebrow mb-3">How it runs</p>
                <h2 class="h2 mb-3" data-split-heading>Four weeks in,<br>you stop guessing.</h2>
                <div class="photo photo--wide reveal-media mt-2">
                    <img src="{{ asset('assets/photos/studio-meeting.jpg') }}" loading="lazy" decoding="async"
                         alt="An XpertVA account team reviewing marketplace performance together in the studio.">
                </div>
            </div>
            <div>
                @foreach ([
                    ['Audit',   'We pull the account apart. Listings, keyword coverage, ad structure, health metrics and reimbursement gaps. You get the findings in writing before anyone signs anything.'],
                    ['Rebuild', 'Copy, backend keywords, imagery and A+ modules ship in a planned sequence, so we can attribute what moved and what did not.'],
                    ['Run',     'A named operator works the account every day. Cases, inventory, pricing, campaign bids, competitor and MAP monitoring.'],
                    ['Report',  'A weekly note in plain language: what changed, what it cost, what happens next. You can read it in two minutes.'],
                ] as [$step, $desc])
                    <div class="proc__row" data-anim>
                        <h3 class="h3">{{ $step }}</h3>
                        <p class="body">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- 9. Testimonial. --}}
<section class="section">
    <div class="wrap">
        <figure class="quote">
            <div>
                <blockquote data-split-heading>
                    "XpertVA helped scale my Amazon business beyond expectations.
                    Their understanding of eCommerce sets them apart."
                </blockquote>
                {{-- TODO: replace with the client's name and company once cleared for publication. --}}
                <figcaption data-anim data-anim-delay="0.1">
                    <strong>Managed Amazon seller</strong>
                    US marketplace, home and lighting category
                </figcaption>
            </div>
            <div class="quote__media reveal-media" data-anim data-anim-delay="0.15">
                <video controls preload="none" playsinline
                       poster="{{ asset('assets/images/customer-poster.jpg') }}"
                       title="XpertVA client video testimonial">
                    <source src="{{ asset('assets/videos/customer.mp4') }}" type="video/mp4">
                    Your browser does not support video playback.
                </video>
            </div>
        </figure>
    </div>
</section>

{{-- 10. Closing CTA. --}}
@include('site.cta')

@endsection
