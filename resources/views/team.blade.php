@extends('layouts.site')

@section('title', 'About XpertVA - Professional Virtual Assistant Services')
@section('meta_description', 'Learn about XpertVA, founded in 2017, 9+ years helping eCommerce sellers on Amazon, Shopify, eBay, and Walmart. Meet our leadership team in Englishtown, NJ.')
@section('head_tone', 'site-head--on-dark')

@push('head')
<link rel="canonical" href="{{ url('/team') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="About XpertVA">
<meta property="og:description" content="Founded 2017 in Englishtown, New Jersey. We run marketplace operations for eCommerce brands.">
<meta property="og:url" content="{{ url('/team') }}">
<meta property="og:image" content="{{ asset('assets/photos/team-workshop.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@section('content')

<section class="phead phead--photo">
    <img class="phead__bg" src="{{ asset('assets/photos/team-workshop.jpg') }}" alt="A working session mapping account priorities across a wall of notes." fetchpriority="high" decoding="async">
    <div class="wrap">
        <div class="phead__grid">
            <h1 class="display">Nine years of<br>other people's<br>catalogues.</h1>
            <div>
                <p class="lede">
                    XpertVA started in 2017 in Englishtown, New Jersey, doing the marketplace work
                    founders could not get to. That is still the job.
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

<section class="band section--tight">
    <div class="wrap">
        <ul class="stats">
            <li data-anim>
                <p class="stat__value"><span data-count="500" data-suffix="+">500+</span></p>
                <p class="stat__label">Brands supported since we opened in 2017</p>
            </li>
            <li data-anim data-anim-delay="0.08">
                <p class="stat__value"><span data-count="100" data-suffix="+">100+</span></p>
                <p class="stat__label">Websites and digital products delivered</p>
            </li>
            <li data-anim data-anim-delay="0.16">
                <p class="stat__value"><span data-count="98" data-suffix="%">98%</span></p>
                <p class="stat__label">Client satisfaction across active accounts</p>
            </li>
            <li data-anim data-anim-delay="0.24">
                <p class="stat__value"><span data-count="4.9" data-decimals="1">4.9</span></p>
                <p class="stat__label">Average client rating out of five</p>
            </li>
        </ul>
    </div>
</section>

{{-- What the company is actually for --}}
<section class="section">
    <div class="wrap">
        <div class="duo">
            <div>
                <h2 class="h2 mb-3" data-split-heading>We are an operations<br>company, not an agency.</h2>
                <p class="body mb-3">
                    Agencies deliver projects and leave. Marketplace selling is not a project. It is a
                    catalogue that has to be worked every day by somebody who knows where the money leaks.
                </p>
                <p class="body">
                    So we hire operators rather than account managers, keep every discipline in house,
                    and put one named person on each account with a second who knows it well enough to cover.
                </p>
            </div>
            <div class="photo photo--wide reveal-media duo__media">
                <img src="{{ asset('assets/photos/team-laptops.jpg') }}" loading="lazy" decoding="async"
                     alt="Account managers working through marketplace reports together at a shared desk.">
            </div>
        </div>
    </div>
</section>

{{-- Leadership: the two real portraits we have --}}
<section class="section" style="background:var(--paper-2)">
    <div class="wrap">
        <h2 class="h2 mb-4" data-split-heading>Leadership</h2>
        <div class="grid grid--2" style="max-width:52rem">
            @foreach ([
                ['Ali Zaidi', 'Chief Executive Officer and founder', 'assets/images/alizaidi.jpeg'],
                ['Ebraheem Azhar', 'Chief Operating Officer', 'assets/images/Ebraheem.jpeg'],
            ] as [$name, $role, $img])
                <figure style="margin:0" data-anim data-anim-delay="{{ $loop->index * 0.08 }}">
                    <div class="photo photo--square reveal-media">
                        <img src="{{ asset($img) }}" alt="Portrait of {{ $name }}, {{ $role }} at XpertVA." loading="lazy" decoding="async">
                    </div>
                    <figcaption class="mt-2">
                        <p class="h3">{{ $name }}</p>
                        <p class="small">{{ $role }}</p>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>

{{-- How we work, as commitments rather than values --}}
<section class="section">
    <div class="wrap">
        <div class="proc">
            <div class="proc__head">
                <h2 class="h2" data-split-heading>What you can<br>hold us to.</h2>
            </div>
            <div>
                @foreach ([
                    ['Findings before contracts', 'You get the account audit in writing before you commit to anything. If the answer is that you do not need us yet, we will say so.'],
                    ['A named operator', 'Not a pool, not a ticket queue. One person on your account with a backup who knows it, and you have both names.'],
                    ['Nothing resold', 'Every discipline is staffed in house. Your account is never quietly handed to a fourth party you did not agree to.'],
                    ['Reports you can read', 'A weekly note in plain language covering what changed, what it cost and what happens next. Two minutes, not a dashboard login.'],
                ] as [$title, $desc])
                    <div class="proc__row" data-anim>
                        <h3 class="h3">{{ $title }}</h3>
                        <p class="body">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Testimonial --}}
<section class="section" style="background:var(--paper-2)">
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

{{-- Careers --}}
<section class="section">
    <div class="wrap">
        <h2 class="h2 mb-3" data-split-heading>Open roles</h2>
        <p class="body mb-4">
            We hire people who have run a seller account, not people who have read about one.
            Send your CV and the account you are proudest of to
            <a class="tlink" href="mailto:hello@xpertva.com">hello@xpertva.com</a>.
        </p>
        <ul class="channels" data-anim>
            @foreach ([
                ['Senior Amazon operator', 'Deep Seller Central experience across listings, cases and inventory. You will own accounts, not tickets.'],
                ['Web developer', 'Shopify, Laravel and Next.js. You will build the stores and keep them fast.'],
                ['Customer support specialist', 'Buyer messages and returns across Amazon, Walmart and Shopify, inside marketplace response windows.'],
                ['Marketing specialist', 'Paid search, paid social and marketplace ads measured on blended acquisition cost.'],
            ] as [$role, $note])
                <li>
                    <a href="mailto:hello@xpertva.com?subject={{ rawurlencode('Application: ' . $role) }}">
                        <span class="channels__name">{{ $role }}</span>
                        <span class="channels__note">{{ $note }}</span>
                        <span class="cindex__go" aria-hidden="true">@include('site.arrow')</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</section>

@include('site.cta')

@endsection
