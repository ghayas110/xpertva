{{-- Consultation panel: primary conversion path, reachable from every page --}}
<div class="overlay overlay--form" data-panel="consult" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="consult-title">
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
            <div>
                <h2 id="consult-title">Book a consultation</h2>
                <p class="panel-note">Tell us what you sell and where it is stuck. You get a 30 minute call with an operator who has run your marketplace, not a sales rep.</p>
                <p class="panel-note">Replies within one business day.</p>
            </div>
            <form action="{{ route('contact.submit') }}" method="POST" data-async-feedback>
                @csrf
                <div class="form-2col">
                    <div class="field">
                        <label for="c-name">Full name</label>
                        <input id="c-name" name="fullName" type="text" required autocomplete="name" placeholder="Jordan Whitfield">
                    </div>
                    <div class="field">
                        <label for="c-email">Work email</label>
                        <input id="c-email" name="email" type="email" required autocomplete="email" placeholder="jordan@brand.com">
                    </div>
                </div>
                <div class="field">
                    <label for="c-phone">Phone <span class="hint">(optional)</span></label>
                    <input id="c-phone" name="phone" type="tel" autocomplete="tel" placeholder="+1 732 000 0000">
                </div>
                <div class="field">
                    <label for="c-message">What do you need help with?</label>
                    <textarea id="c-message" name="message" rows="4" required placeholder="Marketplaces you sell on, monthly revenue, and the problem you want solved."></textarea>
                    <span class="hint">The more specific you are, the more useful the call is.</span>
                </div>
                <button type="submit" class="btn btn--primary btn--lg">
                    Send request
                    @include('site.arrow')
                </button>
                <p class="form-note">We use your details only to reply to this request.</p>
            </form>
        </div>
    </div>
</div>

{{-- Audit panel: a separate offer, not a second wording of "contact us" --}}
<div class="overlay overlay--form" data-panel="audit" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="audit-title">
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
            <div>
                <h2 id="audit-title">Free listing audit</h2>
                <p class="panel-note">Send us one ASIN. We return a written breakdown of the listing, its keyword coverage, and the ad spend leaking against it.</p>
                <p class="panel-note">No charge, no obligation.</p>
            </div>
            <form action="{{ route('audit.submit') }}" method="POST" data-async-feedback>
                @csrf
                <div class="form-2col">
                    <div class="field">
                        <label for="a-name">Full name</label>
                        <input id="a-name" name="fullName" type="text" required autocomplete="name" placeholder="Jordan Whitfield">
                    </div>
                    <div class="field">
                        <label for="a-email">Work email</label>
                        <input id="a-email" name="email" type="email" required autocomplete="email" placeholder="jordan@brand.com">
                    </div>
                </div>
                <div class="form-2col">
                    <div class="field">
                        <label for="a-phone">Phone</label>
                        <input id="a-phone" name="phone" type="tel" required autocomplete="tel" placeholder="+1 732 000 0000">
                    </div>
                    <div class="field">
                        <label for="a-asin">Preferred ASIN</label>
                        <input id="a-asin" name="preferredAsin" type="text" required placeholder="B08XXXXXXX">
                    </div>
                </div>
                <div class="field">
                    <label for="a-store">Store link</label>
                    <input id="a-store" name="storeLink" type="text" required placeholder="amazon.com/stores/yourbrand">
                </div>
                <div class="field">
                    <label for="a-message">Anything we should know?</label>
                    <textarea id="a-message" name="message" rows="3" required placeholder="Category, current ACoS, and what you have already tried."></textarea>
                </div>
                <button type="submit" class="btn btn--primary btn--lg">
                    Request the audit
                    @include('site.arrow')
                </button>
                <p class="form-note">We use your details only to deliver this audit.</p>
            </form>
        </div>
    </div>
</div>
