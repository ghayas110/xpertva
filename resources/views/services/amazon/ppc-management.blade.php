@extends('layouts.app')

@section('title', 'Amazon PPC Management Services | Sponsored Ads & ACoS Reduction | XpertVA')
@section('meta_description', 'Amazon PPC management services that lower ACoS and scale revenue. Sponsored Products, Sponsored Brands, Sponsored Display, and DSP campaigns managed by certified Amazon Ads experts.')

@push('head')
<link rel="canonical" href="{{ url('/services/amazon/ppc-management') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="Amazon PPC Management Services | XpertVA">
<meta property="og:description" content="Lower ACoS, raise TACoS-aware profit, and scale Amazon ad spend with certified Amazon Ads specialists.">
<meta property="og:url" content="{{ url('/services/amazon/ppc-management') }}">
<meta name="keywords" content="amazon ppc management, amazon advertising agency, sponsored products management, amazon ppc agency, lower acos amazon, amazon ads management, amazon dsp, amazon sponsored brands">
@endpush

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": "Amazon PPC Management Services",
  "serviceType": "Amazon Advertising Management",
  "provider": { "@@id": "https://xpertva.com/#organization" },
  "areaServed": "Worldwide",
  "description": "Full-service Amazon PPC management including Sponsored Products, Sponsored Brands, Sponsored Display, and Amazon DSP. We lower ACoS, scale profitable spend, and protect branded search.",
  "url": "{{ url('/services/amazon/ppc-management') }}"
}
</script>
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "FAQPage",
  "mainEntity": [
    { "@@type": "Question", "name": "What is Amazon PPC management?", "acceptedAnswer": { "@@type": "Answer", "text": "Amazon PPC management is the ongoing process of building, optimizing, and scaling Sponsored Products, Sponsored Brands, Sponsored Display, and DSP campaigns inside Amazon Ads to drive profitable sales while controlling ACoS and TACoS." } },
    { "@@type": "Question", "name": "What is a good ACoS on Amazon?", "acceptedAnswer": { "@@type": "Answer", "text": "A healthy Amazon ACoS depends on profit margin, but most sellers target an ACoS between 15% and 30%. The break-even ACoS equals your profit margin before ad spend; anything below that is profitable." } },
    { "@@type": "Question", "name": "What is the difference between ACoS and TACoS?", "acceptedAnswer": { "@@type": "Answer", "text": "ACoS (Advertising Cost of Sale) measures ad spend against ad-attributed revenue only. TACoS (Total ACoS) measures ad spend against total revenue including organic. A falling TACoS while sales grow signals a healthy account." } },
    { "@@type": "Question", "name": "How much do Amazon PPC management services cost?", "acceptedAnswer": { "@@type": "Answer", "text": "Amazon PPC management typically costs either a flat $500–$2,500 per month or 10%–20% of monthly ad spend, depending on account size, marketplaces, and whether DSP is included." } },
    { "@@type": "Question", "name": "How long does it take to lower ACoS?", "acceptedAnswer": { "@@type": "Answer", "text": "Most accounts see ACoS drop within 30–60 days as negative keywords, bid adjustments, and search-term harvesting compound. Significant restructures can show measurable change within the first 14 days." } }
  ]
}
</script>
@endpush

@section('content')
<div class="min-h-screen bg-[#0b0b0b] text-white">
    <section class="relative w-full pt-36 pb-20 bg-gradient-to-br from-[#0d0d0d] via-[#111] to-[#0c0c0c] overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,140,0,0.15),transparent_60%)]"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <a href="{{ route('services.amazon') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-orange-300 transition mb-8">← Back to Amazon Services</a>
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Amazon PPC Management Services</h1>
            <p class="text-gray-300 leading-relaxed max-w-3xl text-lg mb-6">
                Lower ACoS, scale profitable ad spend, and own branded search with certified Amazon Ads specialists managing Sponsored Products, Sponsored Brands, Sponsored Display, and Amazon DSP.
            </p>
            <div class="bg-[#121212] border border-orange-500/20 rounded-2xl p-6 max-w-3xl">
                <p class="text-orange-300 text-sm font-semibold mb-2">Quick Answer</p>
                <p class="text-gray-200 leading-relaxed">
                    <strong>Amazon PPC management</strong> is the ongoing optimization of Sponsored Products, Sponsored Brands, Sponsored Display, and DSP campaigns to drive profitable sales while controlling ACoS and TACoS. A well-managed Amazon Ads account typically lowers ACoS by 20–35% within 60 days.
                </p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-20">
        <h2 class="text-3xl font-bold mb-4">Amazon Ad Types We Manage</h2>
        <p class="text-gray-400 max-w-3xl mb-12">Coverage across every campaign type in Amazon Advertising Console and Amazon DSP.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach([
                ['Sponsored Products', 'Manual, automatic, and category-targeted Sponsored Products campaigns optimized for keyword harvest, bid placement, and search-term negation.'],
                ['Sponsored Brands', 'Headline Search and Sponsored Brands Video campaigns that drive branded discovery and protect your top-of-search real estate.'],
                ['Sponsored Display', 'Audience and product targeting that retargets viewers, defends listings, and conquests competitor ASINs on and off Amazon.'],
                ['Amazon DSP', 'Programmatic display and video advertising for upper-funnel reach, audience building, and remarketing across Amazon-owned sites and the open web.'],
                ['Brand Defense Campaigns', 'Branded keyword campaigns that block competitors from buying your brand name and stealing high-intent traffic.'],
                ['Coupons & Deals Strategy', 'Deal scheduling — Lightning, Best Deal, Prime Exclusive, and coupons — coordinated with PPC for ranking pushes and Q4 events.'],
            ] as [$title, $desc])
            <div class="bg-[#121212] border border-[#1f1f1f] rounded-2xl p-8 hover:border-orange-300 transition">
                <h3 class="text-xl font-semibold mb-3">{{ $title }}</h3>
                <p class="text-gray-400 text-sm leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-20 border-t border-[#1f1f1f]">
        <h2 class="text-3xl font-bold mb-10">Amazon PPC Metrics We Optimize</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead><tr class="border-b border-[#222]"><th class="py-3 pr-4 text-orange-300">Metric</th><th class="py-3 pr-4 text-orange-300">What It Means</th><th class="py-3 text-orange-300">Healthy Benchmark</th></tr></thead>
                <tbody class="text-gray-300">
                    <tr class="border-b border-[#1a1a1a]"><td class="py-3 pr-4 font-semibold">ACoS</td><td class="py-3 pr-4">Ad spend ÷ ad-attributed revenue</td><td class="py-3">15%–30%</td></tr>
                    <tr class="border-b border-[#1a1a1a]"><td class="py-3 pr-4 font-semibold">TACoS</td><td class="py-3 pr-4">Ad spend ÷ total revenue (org + ads)</td><td class="py-3">5%–15%</td></tr>
                    <tr class="border-b border-[#1a1a1a]"><td class="py-3 pr-4 font-semibold">CTR</td><td class="py-3 pr-4">Clicks ÷ impressions</td><td class="py-3">0.4%+</td></tr>
                    <tr class="border-b border-[#1a1a1a]"><td class="py-3 pr-4 font-semibold">CVR</td><td class="py-3 pr-4">Orders ÷ clicks</td><td class="py-3">10%+</td></tr>
                    <tr><td class="py-3 pr-4 font-semibold">ROAS</td><td class="py-3 pr-4">Revenue ÷ ad spend</td><td class="py-3">4x+</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="max-w-4xl mx-auto px-6 py-20 border-t border-[#1f1f1f]">
        <h2 class="text-3xl font-bold mb-10">Frequently Asked Questions</h2>
        <div class="space-y-4">
            @foreach([
                ['What is Amazon PPC management?', 'Amazon PPC management is the ongoing process of building, optimizing, and scaling Sponsored Products, Sponsored Brands, Sponsored Display, and DSP campaigns to drive profitable sales while controlling ACoS and TACoS.'],
                ['What is a good ACoS on Amazon?', 'Most sellers target an ACoS between 15% and 30%. Your break-even ACoS equals your profit margin before ad spend; anything below that is profitable.'],
                ['What is the difference between ACoS and TACoS?', 'ACoS measures ad spend against ad-attributed revenue only. TACoS measures ad spend against total revenue including organic. Falling TACoS while sales grow signals a healthy account.'],
                ['How much does Amazon PPC management cost?', 'Most agencies charge a flat $500–$2,500/month or 10%–20% of monthly ad spend, depending on account size, marketplaces, and whether DSP is included.'],
                ['How long does it take to lower ACoS?', 'Most accounts see ACoS drop within 30–60 days. Significant structural changes — match-type splits, negative harvesting — can show measurable lift within 14 days.'],
            ] as [$q, $a])
            <details class="bg-[#121212] border border-[#1f1f1f] rounded-2xl p-6 group">
                <summary class="cursor-pointer text-lg font-semibold flex justify-between items-center">{{ $q }}<span class="text-orange-300 group-open:rotate-45 transition">+</span></summary>
                <p class="text-gray-400 mt-4 leading-relaxed">{{ $a }}</p>
            </details>
            @endforeach
        </div>
    </section>

    <section class="py-24 text-center bg-gradient-to-b from-[#1a1a1a] to-[#0b0b0b] border-t border-[#222]">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Lower Your Amazon ACoS This Quarter</h2>
        <p class="text-gray-400 max-w-2xl mx-auto mb-8 px-6">Free PPC audit with a 90-day scaling plan from a certified Amazon Ads specialist.</p>
        <button onclick="document.getElementById('audit-modal').classList.remove('hidden')" class="bg-orange-300 text-black px-10 py-4 rounded-xl text-lg font-semibold hover:opacity-80 transition shadow-xl">Get Free PPC Audit</button>
    </section>
</div>
@endsection
