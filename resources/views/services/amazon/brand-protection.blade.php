@extends('layouts.app')

@section('title', 'Amazon Brand Protection Services | Hijacker Removal & MAP Enforcement | XpertVA')
@section('meta_description', 'Amazon brand protection services — hijacker removal, counterfeit takedowns, MAP enforcement, IP infringement reporting, and Brand Registry support to protect your listings.')

@push('head')
<link rel="canonical" href="{{ url('/services/amazon/brand-protection') }}">
<meta property="og:title" content="Amazon Brand Protection Services | XpertVA">
<meta property="og:description" content="Remove hijackers, enforce MAP, and stop counterfeit sellers on Amazon with Brand Registry-trained specialists.">
<meta name="keywords" content="amazon brand protection, amazon hijacker removal, amazon map enforcement, amazon counterfeit removal, amazon ip infringement, amazon brand registry, transparency program, project zero amazon">
@endpush

@push('schema')
@verbatim
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "name": "Amazon Brand Protection Services",
  "serviceType": "Amazon Brand Protection and IP Enforcement",
  "provider": { "@id": "https://xpertva.com/#organization" },
  "description": "Amazon brand protection services including listing hijacker removal, counterfeit and IP infringement takedowns, MAP policy enforcement, Brand Registry support, Transparency, and Project Zero enrollment.",
  "url": "{{ url('/services/amazon/brand-protection') }}"
}
</script>
@endverbatim
@verbatim
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    { "@type": "Question", "name": "What is an Amazon listing hijacker?", "acceptedAnswer": { "@type": "Answer", "text": "An Amazon hijacker is an unauthorized seller who lists their product on your branded ASIN to win the Buy Box, often selling counterfeit, expired, or used inventory. Hijackers are removed through test buys, IP complaints, cease-and-desist notices, and Brand Registry reports." } },
    { "@type": "Question", "name": "How do you remove an Amazon hijacker?", "acceptedAnswer": { "@type": "Answer", "text": "We perform a test buy to document the violation, file an IP infringement or counterfeit report through Brand Registry, send a cease-and-desist letter, and escalate to Amazon's Counterfeit Crimes Unit if needed. Most hijackers are removed within 24–72 hours." } },
    { "@type": "Question", "name": "What is MAP enforcement on Amazon?", "acceptedAnswer": { "@type": "Answer", "text": "MAP (Minimum Advertised Price) enforcement is the process of monitoring resellers and stopping those who advertise below your floor price. We track price violations daily, send MAP warning letters, and remove repeat-offender resellers through unauthorized-seller policies." } },
    { "@type": "Question", "name": "What is Amazon Brand Registry?", "acceptedAnswer": { "@type": "Answer", "text": "Amazon Brand Registry is a free program for trademarked brands that unlocks A+ Content, Storefronts, brand analytics, automated brand protection, and access to the Report a Violation tool used to remove hijackers, counterfeits, and policy violators." } },
    { "@type": "Question", "name": "What are Project Zero and Transparency?", "acceptedAnswer": { "@type": "Answer", "text": "Project Zero gives qualified brands self-service counterfeit removal authority. Transparency is a unit-level serialization program where every product carries a unique scannable code that Amazon verifies in the FBA fulfillment center, blocking counterfeits before they ship." } }
  ]
}
</script>
@endverbatim
@endpush

@section('content')
<div class="min-h-screen bg-[#0b0b0b] text-white">
    <section class="relative w-full pt-36 pb-20 bg-gradient-to-br from-[#0d0d0d] via-[#111] to-[#0c0c0c] overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,140,0,0.15),transparent_60%)]"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <a href="{{ route('services.amazon') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-orange-300 transition mb-8">← Back to Amazon Services</a>
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Amazon Brand Protection Services</h1>
            <p class="text-gray-300 leading-relaxed max-w-3xl text-lg mb-6">
                Remove hijackers, take down counterfeits, enforce MAP, and protect your trademarked brand on Amazon with Brand Registry-trained specialists.
            </p>
            <div class="bg-[#121212] border border-orange-500/20 rounded-2xl p-6 max-w-3xl">
                <p class="text-orange-300 text-sm font-semibold mb-2">Quick Answer</p>
                <p class="text-gray-200 leading-relaxed">
                    An <strong>Amazon hijacker</strong> is an unauthorized seller who lists on your branded ASIN to win the Buy Box, often selling counterfeit or used inventory. We remove hijackers through test buys, Brand Registry IP complaints, cease-and-desist letters, and Amazon's Counterfeit Crimes Unit — typically within 24–72 hours.
                </p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-20">
        <h2 class="text-3xl font-bold mb-4">How We Protect Your Amazon Brand</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            @foreach([
                ['Hijacker Removal', 'Test buys, evidence collection, and IP infringement filings through Brand Registry to remove unauthorized sellers from your ASINs.'],
                ['Counterfeit Takedowns', 'Filed counterfeit reports, escalated to Amazon\'s Counterfeit Crimes Unit (CCU), and supported by trademark and patent documentation.'],
                ['MAP Enforcement', 'Daily price monitoring across all resellers, automated MAP warning letters, and unauthorized-seller dispute escalation.'],
                ['IP Infringement Reports', 'Trademark, copyright, and patent violation reports filed against listings stealing your images, logos, or design rights.'],
                ['Brand Registry Enrollment', 'Trademark filing assistance and full Amazon Brand Registry onboarding to unlock advanced brand protection tools.'],
                ['Transparency & Project Zero', 'Enrollment and serialized-code rollout for brands eligible for Amazon Transparency or Project Zero counterfeit prevention programs.'],
            ] as [$title, $desc])
            <div class="bg-[#121212] border border-[#1f1f1f] rounded-2xl p-8 hover:border-orange-300 transition">
                <h3 class="text-xl font-semibold mb-3">{{ $title }}</h3>
                <p class="text-gray-400 text-sm leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-20 border-t border-[#1f1f1f]">
        <h2 class="text-3xl font-bold mb-10">Our Hijacker Removal Process</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach([
                ['1', 'Detect', 'Buy Box monitoring 24/7 across all your branded ASINs flags new unauthorized sellers within hours.'],
                ['2', 'Evidence', 'Test buy is shipped, photographed, and documented to prove counterfeit or material difference from authentic stock.'],
                ['3', 'Enforce', 'IP infringement, counterfeit, or material-difference complaint filed through Brand Registry with full documentation.'],
                ['4', 'Escalate', 'Cease-and-desist letter and CCU escalation if the seller persists; legal-team handoff for repeat offenders.'],
            ] as [$step, $title, $desc])
            <div class="bg-[#121212] border border-[#1f1f1f] rounded-2xl p-6">
                <div class="text-orange-300 text-3xl font-bold mb-3">{{ $step }}</div>
                <h3 class="text-lg font-semibold mb-2">{{ $title }}</h3>
                <p class="text-gray-400 text-sm leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <section class="max-w-4xl mx-auto px-6 py-20 border-t border-[#1f1f1f]">
        <h2 class="text-3xl font-bold mb-10">Frequently Asked Questions</h2>
        <div class="space-y-4">
            @foreach([
                ['What is an Amazon listing hijacker?', 'An unauthorized seller who lists their product on your branded ASIN to win the Buy Box, often selling counterfeit, expired, or used inventory.'],
                ['How do you remove an Amazon hijacker?', 'Test buy, file an IP/counterfeit report through Brand Registry, send a cease-and-desist letter, and escalate to Amazon\'s Counterfeit Crimes Unit. Most hijackers are removed within 24–72 hours.'],
                ['What is MAP enforcement on Amazon?', 'Minimum Advertised Price enforcement: monitoring resellers, sending MAP warning letters, and removing repeat-offender resellers through unauthorized-seller policies.'],
                ['What is Amazon Brand Registry?', 'A free Amazon program for trademarked brands that unlocks A+ Content, Storefronts, brand analytics, and the Report a Violation tool used to remove hijackers and counterfeits.'],
                ['What are Project Zero and Transparency?', 'Project Zero gives qualified brands self-service counterfeit removal authority. Transparency is a unit-level serialized-code program where Amazon verifies authenticity in the FBA fulfillment center.'],
            ] as [$q, $a])
            <details class="bg-[#121212] border border-[#1f1f1f] rounded-2xl p-6 group">
                <summary class="cursor-pointer text-lg font-semibold flex justify-between items-center">{{ $q }}<span class="text-orange-300 group-open:rotate-45 transition">+</span></summary>
                <p class="text-gray-400 mt-4 leading-relaxed">{{ $a }}</p>
            </details>
            @endforeach
        </div>
    </section>

    <section class="py-24 text-center bg-gradient-to-b from-[#1a1a1a] to-[#0b0b0b] border-t border-[#222]">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Stop Hijackers and Counterfeiters Today</h2>
        <p class="text-gray-400 max-w-2xl mx-auto mb-8 px-6">Free brand protection scan — we'll identify unauthorized sellers and MAP violators on your ASINs.</p>
        <button onclick="document.getElementById('audit-modal').classList.remove('hidden')" class="bg-orange-300 text-black px-10 py-4 rounded-xl text-lg font-semibold hover:opacity-80 transition shadow-xl">Get Free Brand Scan</button>
    </section>
</div>
@endsection
