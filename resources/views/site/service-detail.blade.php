{{--
  The middle of a service page: process, deliverables, fit lists and FAQs.
  Shared by site/service.blade.php and the six /services/amazon/* pages, so
  every service page answers the same buyer questions in the same order.
  All four blocks are optional; pass whichever the page has.
--}}
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

