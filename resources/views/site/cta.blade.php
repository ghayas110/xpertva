{{-- Closing CTA. One label, one intent, used on every public page. --}}
<section class="cta section">
    <div class="wrap">
        <div class="cta__inner">
            <h2 data-anim>{{ $heading ?? 'Let us look at your numbers.' }}</h2>
            <div data-anim data-anim-delay="0.1">
                <p>{{ $body ?? 'Thirty minutes with an operator who has run your marketplace. You leave with a written view of what is costing you revenue, whether or not you hire us.' }}</p>
                <div class="mt-3" style="display:flex;flex-wrap:wrap;gap:.75rem">
                    <button type="button" class="btn btn--solid btn--lg" data-open="consult">
                        Book a consultation
                        @include('site.arrow')
                    </button>
                    <button type="button" class="btn btn--ghost btn--lg" data-open="audit">
                        Free listing audit
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
