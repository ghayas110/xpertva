@php
    $navLinks = [
        ['label' => 'Work',     'route' => 'work'],
        ['label' => 'Services', 'route' => 'services.index'],
        ['label' => 'Team',     'route' => 'team'],
        ['label' => 'Blog',     'route' => 'blog.index'],
        ['label' => 'Contact',  'route' => 'contact'],
    ];
@endphp

<header class="site-head {{ $headTone ?? '' }}">
    <div class="site-head__inner">
        <a href="{{ route('home') }}" class="brand" aria-label="XpertVA home">
            <img src="{{ asset('assets/images/logo-xpertva.png') }}" alt="" width="34" height="34">
            <span>XpertVA</span>
        </a>

        <nav class="nav" aria-label="Primary">
            @foreach ($navLinks as $link)
                <a href="{{ route($link['route']) }}"
                   @if (request()->routeIs($link['route']) || request()->routeIs($link['route'] . '.*')) aria-current="page" @endif>{{ $link['label'] }}</a>
            @endforeach
        </nav>

        <div class="head-actions">
            <button type="button" class="btn btn--primary" data-open="consult">
                Book a consultation
                @include('site.arrow')
            </button>
            <button type="button" class="menu-btn" data-open="menu" aria-label="Open menu">
                Menu
                <span class="menu-btn__bars" aria-hidden="true"><i></i><i></i></span>
            </button>
        </div>
    </div>
</header>

<div class="overlay" data-panel="menu" aria-hidden="true" role="dialog" aria-modal="true" aria-label="Site menu">
    <div class="overlay__bar">
        <span class="brand">
            <img src="{{ asset('assets/images/logo-xpertva.png') }}" alt="" width="34" height="34">
            <span>XpertVA</span>
        </span>
        <button type="button" class="close-btn" data-close>
            Close
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
        </button>
    </div>
    <div class="overlay__body">
        <div class="overlay__grid">
            <ul class="mlinks">
                <li><a href="{{ route('home') }}">Home</a></li>
                @foreach ($navLinks as $link)
                    <li><a href="{{ route($link['route']) }}">{{ $link['label'] }}</a></li>
                @endforeach
            </ul>
            <div class="overlay__aside">
                <p>
                    <button type="button" class="btn btn--primary btn--lg" data-open="consult" data-close>
                        Book a consultation
                        @include('site.arrow')
                    </button>
                </p>
                <p>XpertVA runs eCommerce operations for brands selling on Amazon, Shopify, Walmart and eBay. Founded 2017, Englishtown NJ.</p>
                <p>
                    <a href="mailto:hello@xpertva.com">hello@xpertva.com</a><br>
                    <a href="tel:+17324906272">+1 (732) 490-6272</a>
                </p>
                <p><a href="{{ route('login') }}">Team portal</a></p>
            </div>
        </div>
    </div>
</div>
