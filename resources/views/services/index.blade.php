@extends('layouts.site')

@section('title', 'Services - XpertVA')
@section('meta_description', 'Explore XpertVA\'s full range of eCommerce services: Amazon, eBay, Shopify, Walmart management, virtual assistants, web development, and digital marketing.')
@section('head_tone', 'site-head--on-dark')

@push('head')
<link rel="canonical" href="{{ url('/services') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="Services | XpertVA">
<meta property="og:description" content="Marketplace operations, advertising, creative and build work for eCommerce brands on Amazon, Shopify, Walmart and eBay.">
<meta property="og:url" content="{{ url('/services') }}">
<meta property="og:image" content="{{ asset('assets/photos/open-office.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@section('content')

<section class="phead phead--photo">
    <img class="phead__bg" src="{{ asset('assets/photos/open-office.jpg') }}" alt="An open plan studio floor with account teams at work." fetchpriority="high" decoding="async">
    <div class="wrap">
        <div class="phead__grid">
            <h1 class="display">Everything a<br>catalogue needs.</h1>
            <div>
                <p class="lede">
                    Four marketplaces, the advertising on top of them, the creative that fills them
                    and the software underneath. Staffed in house, run by the same team every day.
                </p>
                <div class="mt-3">
                    <button type="button" class="btn btn--primary" data-open="consult">
                        Book a consultation
                        @include('site.arrow')
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Marketplaces --}}
<section class="section">
    <div class="wrap">
        <h2 class="h2 mb-4" data-split-heading>Where you sell</h2>
        <div class="grid grid--2">
            @php
                $channels = [
                    ['Amazon', 'Seller Central end to end. Listings, advertising, account health, brand protection and the daily operations underneath.', 'services.amazon', 'assets/photos/warehouse-aisles.jpg', 'Racked inventory aisles inside a fulfilment warehouse.'],
                    ['Shopify', 'Store builds, theme work, catalogue and the checkout tuning that decides whether traffic pays.', 'services.shopify', 'assets/photos/retail-store.jpg', 'A merchandised retail interior with considered product display.'],
                    ['Walmart', 'Item setup to Walmart specification, WFS, Connect advertising and Buy Box recovery.', 'services.walmart', 'assets/photos/pos-counter.jpg', 'A shop counter with a tablet point of sale system in use.'],
                    ['eBay', 'Listing volume, store design, Promoted Listings and the daily order and feedback work.', 'services.ebay', 'assets/photos/fulfilment-floor.jpg', 'A fulfilment warehouse floor stacked with outbound cartons.'],
                ];
            @endphp
            @foreach ($channels as [$name, $desc, $r, $img, $alt])
                <a class="card card--media" href="{{ route($r) }}" data-anim data-anim-delay="{{ $loop->index * 0.06 }}">
                    <div class="reveal-media" style="overflow:hidden">
                        <img src="{{ asset($img) }}" alt="{{ $alt }}" loading="lazy" decoding="async">
                    </div>
                    <div class="card__text">
                        <div class="card__top">
                            <h3 class="h3">{{ $name }}</h3>
                            @include('site.arrow')
                        </div>
                        <p class="body">{{ $desc }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Disciplines --}}
<section class="section" style="background:var(--paper-2)">
    <div class="wrap">
        <h2 class="h2 mb-4" data-split-heading>What we do on top</h2>
        <ul class="channels" data-anim>
            @foreach ([
                ['Virtual assistants', 'A trained operator inside your account daily. Catalogue work, buyer messages, orders and reporting.', 'services.va'],
                ['Amazon operations', 'Inventory, FBA shipments, cases, pricing and reimbursement recovery. The work that protects margin.', 'services.amazon-ops'],
                ['Marketing solutions', 'Search, paid social, email and marketplace ads planned against blended acquisition cost.', 'services.marketing'],
                ['Content and branding', 'Photography, infographics, copy and video produced for a whole catalogue in one pass.', 'services.content-branding'],
                ['Web development', 'Shopify, WooCommerce and custom builds with performance and accessibility in the build.', 'services.web-dev'],
                ['Design and development', 'Interface design and the front end build, done by the same people.', 'services.design'],
                ['Mobile app development', 'iOS, Android and progressive web apps, shipped to the stores and maintained after.', 'services.mobile-app'],
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

{{-- Why it holds together --}}
<section class="section">
    <div class="wrap">
        <div class="duo">
            <div class="photo photo--wide reveal-media duo__media">
                <img src="{{ asset('assets/photos/team-workshop.jpg') }}" loading="lazy" decoding="async"
                     alt="A working session mapping account priorities across a wall of notes.">
            </div>
            <div>
                <h2 class="h2 mb-3" data-split-heading>One team, or none of it works</h2>
                <p class="body mb-3">
                    Split a catalogue across a listing agency, an ads agency and a freelance designer and
                    you spend your week being the integration layer between them.
                </p>
                <ul class="ticks">
                    <li>The person writing the listing knows what the ads are bidding on.</li>
                    <li>The person watching stock knows what the campaigns are about to spend.</li>
                    <li>One weekly report covers the account, not three that disagree.</li>
                    <li>Nothing gets resold to a fourth party you never agreed to.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

@include('site.cta')

@endsection
