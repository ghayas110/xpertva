@extends('layouts.site')

@section('title', 'Privacy Policy - XpertVA')
@section('meta_description', 'How XpertVA collects, uses, shares and protects your data, and the choices you have.')

@push('head')
<link rel="canonical" href="{{ url('/privacy-policy') }}">
<meta name="robots" content="index,follow">
@endpush

@section('content')

<section class="phead">
    <div class="wrap" style="max-width:62rem">
        <div class="phead__grid">
            <h1 class="display display--sm">Privacy policy</h1>
            <div>
                <p class="lede">
                    What we collect, why we collect it, how we use it, and the choices you have.
                    This applies to visitors, clients, and anyone using our services or website.
                </p>
                <p class="small mt-2">Last updated 1 January 2025. Applies globally.</p>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:clamp(1.5rem,3vw,2.5rem)">
    <div class="wrap" style="max-width:62rem">

        <div class="callout mb-4">
            <p class="callout__label">In short</p>
            <p>
                We collect only what we need to deliver and improve our services, we protect it with
                layered security controls, and we do not sell it.
            </p>
        </div>

        <h2 class="h2 mb-3" data-split-heading>Information we collect</h2>
        <div class="caps mb-4">
            <div class="caps__item">
                <h3>Account and contact details</h3>
                <p>Name, email, phone, company and role, when you request a consultation or engage our services.</p>
            </div>
            <div class="caps__item">
                <h3>Usage and device data</h3>
                <p>Log data, page views, IP address, browser type and device identifiers, used to keep the site secure and reliable.</p>
            </div>
        </div>

        <h2 class="h2 mb-3" data-split-heading>How we use data</h2>
        <ul class="ticks mb-4">
            <li>To provide and maintain our services, including onboarding, support and delivery.</li>
            <li>To personalise content and recommendations based on your activity and preferences.</li>
            <li>To reply to enquiries you send us through the forms on this site.</li>
            <li>To keep the site and our systems secure, and to diagnose faults.</li>
        </ul>

        <h2 class="h2 mb-3" data-split-heading>Sharing and disclosure</h2>
        <p class="body mb-3">
            We do not sell your data. Where we do share it, the sharing is limited, purposeful and
            covered by contract.
        </p>
        <ul class="ticks mb-4">
            <li>Infrastructure, analytics and communication vendors that support our operations.</li>
            <li>Professional advisers, where they are bound by confidentiality obligations.</li>
            <li>Authorities, where we are legally required to disclose.</li>
        </ul>

        <h2 class="h2 mb-3" data-split-heading>Your choices</h2>
        <p class="body mb-4">
            You can ask us for a copy of the data we hold about you, ask us to correct it, or ask us
            to delete it. Write to
            <a class="tlink" href="mailto:hello@xpertva.com">hello@xpertva.com</a>
            and we will respond within a reasonable period.
        </p>

        <h2 class="h2 mb-3" data-split-heading>Contact</h2>
        <address class="body" style="font-style:normal">
            XpertVA, Englishtown, New Jersey 07726, United States<br>
            <a class="tlink" href="mailto:hello@xpertva.com">hello@xpertva.com</a><br>
            <a class="tlink" href="tel:+17324906272">+1 (732) 490-6272</a>
        </address>
    </div>
</section>

@endsection
