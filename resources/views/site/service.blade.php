{{--
  Shared service page. Expects:
    $title, $lede, $photo, $photoAlt, $intro
    $capabilities : array of ['name' => ..., 'desc' => ...]
    $related      : array of [label, route name]   (optional)
    $proof        : array of ['value' => ..., 'label' => ...]  (optional)
    $parent       : ['label' => ..., 'route' => ...]  (optional breadcrumb, defaults to Services)
--}}
@php
    $parent = $parent ?? ['label' => 'All services', 'route' => 'services.index'];
@endphp

<section class="phead phead--photo">
    <img class="phead__bg" src="{{ asset($photo) }}" alt="{{ $photoAlt }}" fetchpriority="high" decoding="async">
    <div class="wrap">
        <a class="crumb" href="{{ route($parent['route']) }}">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 3 5 8l5 5"/></svg>
            {{ $parent['label'] }}
        </a>
        <div class="phead__grid">
            <h1 class="display display--sm">{{ $title }}</h1>
            <div>
                <p class="lede">{{ $lede }}</p>
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

<section class="section">
    <div class="wrap">
        <div class="duo mb-4">
            <div>
                <h2 class="h2 mb-3" data-split-heading>What this covers</h2>
                <p class="body">{{ $intro }}</p>
            </div>
            @isset($proof)
                <ul class="stats">
                    @foreach ($proof as $stat)
                        <li data-anim>
                            <p class="stat__value">{{ $stat['value'] }}</p>
                            <p class="stat__label">{{ $stat['label'] }}</p>
                        </li>
                    @endforeach
                </ul>
            @endisset
        </div>

        <div class="caps">
            @foreach ($capabilities as $cap)
                <div class="caps__item" data-anim data-anim-delay="{{ min($loop->index * 0.04, 0.24) }}">
                    <h3>{{ $cap['name'] }}</h3>
                    <p>{{ $cap['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

@isset($related)
<section class="section--tight" style="background:var(--paper-2);padding-block:clamp(3rem,6vw,5rem)">
    <div class="wrap">
        <h2 class="h3 mb-3">Often paired with</h2>
        <div class="related">
            @foreach ($related as [$label, $routeName])
                <a href="{{ route($routeName) }}">
                    <span>{{ $label }}</span>
                    @include('site.arrow')
                </a>
            @endforeach
        </div>
    </div>
</section>
@endisset

@include('site.cta', [
    'heading' => 'Want this run properly?',
    'body'    => 'Book thirty minutes. We will look at your account together and tell you what we would change first, whether or not you hire us.',
])
