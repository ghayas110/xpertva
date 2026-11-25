{{--
  Shared service page. Expects:
    $title, $lede, $photo, $photoAlt, $intro
    $capabilities : array of ['name' => ..., 'desc' => ...]
    $related      : array of [label, route name]   (optional)
    $proof        : array of ['value' => ..., 'label' => ...]  (optional)
    $parent       : ['label' => ..., 'route' => ...]  (optional breadcrumb, defaults to Services)
    $kicker       : short editorial line above the H1 (optional)
    $definition   : 40-60 word plain answer to "what is this service" (optional)
    $process      : array of ['name' => ..., 'desc' => ...], the order of work (optional)
    $deliverables : array of strings, what the client actually receives (optional)
    $faqs         : array of [question, answer] (optional)
    $fitFor       : array of strings, who the service suits (optional)
    $notFitFor    : array of strings, who it does not suit (optional)

  The last four exist because the SEO audit found these pages at 194-251
  words: enough to name the service, not enough to answer anyone deciding
  whether to buy it. FAQs are rendered as plain content on purpose. Google
  retired FAQ rich results in May 2026, so there is no FAQPage schema.
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
            @isset($kicker)
                {{-- The editorial line keeps its place; the H1 below now names
                     the service, because an H1 reading "Shopify services" told
                     a searcher less than the page deserved. --}}
                <p class="eyebrow">{{ $kicker }}</p>
            @endisset
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
        @isset($definition)
            <div class="callout mb-4">
                <p class="callout__label">In short</p>
                <p>{{ $definition }}</p>
            </div>
        @endisset

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

@isset($process)
<section class="section" style="background:var(--paper-2)">
    <div class="wrap">
        <h2 class="h2 mb-4" data-split-heading>How the work runs</h2>
        <div class="seq">
            @foreach ($process as $step)
                <div class="seq__item" data-anim data-anim-delay="{{ min($loop->index * 0.04, 0.2) }}">
                    <h3><span class="num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>{{ $step['name'] }}</h3>
                    <p>{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endisset

@isset($deliverables)
<section class="section">
    <div class="wrap">
        <div class="duo">
            <div>
                <h2 class="h2 mb-3" data-split-heading>What you get</h2>
                <p class="body">Written down before the work starts, so you can check it was done.</p>
            </div>
            <ul class="ticks">
                @foreach ($deliverables as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
@endisset

@isset($fitFor)
<section class="section" style="background:var(--paper-2)">
    <div class="wrap">
        <div class="duo">
            <div>
                <h2 class="h3 mb-3">A good fit if</h2>
                <ul class="ticks">
                    @foreach ($fitFor as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            @isset($notFitFor)
                <div>
                    <h2 class="h3 mb-3">Probably not the right fit if</h2>
                    <ul class="ticks">
                        @foreach ($notFitFor as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            @endisset
        </div>
    </div>
</section>
@endisset

@isset($faqs)
<section class="section">
    <div class="wrap" style="max-width:60rem">
        <h2 class="h2 mb-4" data-split-heading>Questions we get asked</h2>
        <div class="faq">
            @foreach ($faqs as [$q, $a])
                <details>
                    <summary>{{ $q }}</summary>
                    <p>{{ $a }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>
@endisset

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

@include('site.reading')


@include('site.cta', [
    'heading' => 'Want this run properly?',
    'body'    => 'Book thirty minutes. We will look at your account together and tell you what we would change first, whether or not you hire us.',
])
