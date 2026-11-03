@extends('layouts.site')

@section('title', 'Contact Us - XpertVA')
@section('meta_description', 'Get in touch with XpertVA. Call +1 (732) 490-6272 or email hello@xpertva.com. Located in Englishtown, NJ. We respond within 24 hours.')

@push('head')
<link rel="canonical" href="{{ url('/contact') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="Contact XpertVA">
<meta property="og:description" content="Book a consultation with an operator who has run your marketplace. Replies within one business day.">
<meta property="og:url" content="{{ url('/contact') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@section('content')

<section class="phead">
    <div class="wrap">
        <div class="phead__grid">
            <h1 class="display">Book a<br>consultation.</h1>
            <div>
                <p class="lede">
                    Thirty minutes with someone who has run your marketplace. You leave with a written
                    view of what is costing you revenue, whether or not you hire us.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:clamp(1.5rem,3vw,2.5rem)">
    <div class="wrap">
        <div class="duo" style="align-items:start">
            <div>
                @if ($errors->any())
                    <div class="flash" role="alert">
                        <strong>We could not send that.</strong>
                        <ul class="ticks mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" data-async-feedback>
                    @csrf
                    <div class="form-2col">
                        <div class="field">
                            <label for="p-name">Full name</label>
                            <input id="p-name" name="fullName" type="text" required autocomplete="name"
                                   value="{{ old('fullName') }}" placeholder="Jordan Whitfield"
                                   @error('fullName') aria-invalid="true" @enderror>
                            @error('fullName')<span class="err">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label for="p-email">Work email</label>
                            <input id="p-email" name="email" type="email" required autocomplete="email"
                                   value="{{ old('email') }}" placeholder="jordan@brand.com"
                                   @error('email') aria-invalid="true" @enderror>
                            @error('email')<span class="err">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="field">
                        <label for="p-phone">Phone <span class="hint">(optional)</span></label>
                        <input id="p-phone" name="phone" type="tel" autocomplete="tel"
                               value="{{ old('phone') }}" placeholder="+1 732 000 0000">
                    </div>

                    <div class="field">
                        <label for="p-message">What do you need help with?</label>
                        <textarea id="p-message" name="message" rows="6" required
                                  placeholder="Marketplaces you sell on, roughly what you turn over, and the problem you want solved."
                                  @error('message') aria-invalid="true" @enderror>{{ old('message') }}</textarea>
                        <span class="hint">The more specific you are, the more useful the call is.</span>
                        @error('message')<span class="err">{{ $message }}</span>@enderror
                    </div>

                    <button type="submit" class="btn btn--primary btn--lg">
                        Send request
                        @include('site.arrow')
                    </button>
                    <p class="form-note">
                        We use your details only to reply to this request. Read our
                        <a class="tlink" href="{{ route('privacy-policy') }}">privacy policy</a>.
                    </p>
                </form>
            </div>

            <div>
                <div class="photo photo--wide reveal-media mb-3">
                    <img src="{{ asset('assets/photos/strategy-desk.jpg') }}" loading="lazy" decoding="async"
                         alt="Two people reviewing account notes and a laptop across a desk.">
                </div>

                <div class="crail">
                    <div class="crail__item">
                        <span class="small">Office</span>
                        <span>XpertVA, Englishtown, New Jersey 07726, United States</span>
                    </div>
                    <div class="crail__item">
                        <span class="small">Call or WhatsApp</span>
                        <a href="tel:+17324906272">+1 (732) 490-6272</a>
                    </div>
                    <div class="crail__item">
                        <span class="small">Email</span>
                        <a href="mailto:hello@xpertva.com">hello@xpertva.com</a>
                    </div>
                    <div class="crail__item">
                        <span class="small">Hours</span>
                        <span>Monday to Friday, 09:00 to 18:00 Eastern. Replies within one business day.</span>
                    </div>
                </div>

                <p class="small mt-3">
                    Already know you want the listing audit instead?
                    <button type="button" class="tlink" data-open="audit">Request a free listing audit</button>
                </p>
            </div>
        </div>
    </div>
</section>

@endsection
