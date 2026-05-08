@extends('layouts.app')

@section('title', 'Amazon SEO & Keyword Research Services | Rank Higher in Amazon Search | XpertVA')
@section('meta_description', 'Amazon SEO and keyword research services using Helium 10, Brand Analytics, and Cerebro. Rank for high-intent buyer keywords on Amazon US, UK, EU, and CA marketplaces.')

@push('head')
<link rel="canonical" href="{{ url('/services/amazon/seo-keyword-research') }}">
<meta property="og:title" content="Amazon SEO & Keyword Research Services | XpertVA">
<meta property="og:description" content="Rank for high-intent buyer keywords on Amazon with research-backed SEO from certified Seller Central experts.">
<meta name="keywords" content="amazon keyword research, amazon seo, amazon a10 algorithm, helium 10 keyword research, amazon search ranking, amazon keyword tool, brand analytics keywords, amazon seo agency">
@endpush

@push('schema')
@verbatim
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "name": "Amazon SEO & Keyword Research",
  "serviceType": "Amazon Search Engine Optimization",
  "provider": { "@id": "https://xpertva.com/#organization" },
  "areaServed": "Worldwide",
  "description": "Data-driven Amazon keyword research and SEO services. We map high-volume buyer-intent keywords to your listings, backend search terms, and PPC campaigns to rank higher in Amazon's A10 search algorithm.",
  "url": "{{ url('/services/amazon/seo-keyword-research') }}"
}
</script>
@endverbatim
@verbatim
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    { "@type": "Question", "name": "What is Amazon SEO?", "acceptedAnswer": { "@type": "Answer", "text": "Amazon SEO is the practice of optimizing product listings — title, bullets, description, A+ content, images, backend keywords, reviews, and pricing — to rank higher in Amazon's A10 search algorithm and increase organic sales." } },
    { "@type": "Question", "name": "How does the Amazon A10 algorithm work?", "acceptedAnswer": { "@type": "Answer", "text": "The Amazon A10 algorithm ranks products based on relevance (keyword match), conversion rate, sales velocity, organic sales weight, seller authority, click-through rate, and review quality. Internal traffic and direct shopper conversion are weighted more heavily than in the older A9 algorithm." } },
    { "@type": "Question", "name": "Which Amazon keyword research tools are best?", "acceptedAnswer": { "@type": "Answer", "text": "The top Amazon keyword research tools are Helium 10 Cerebro and Magnet, Jungle Scout Keyword Scout, Amazon Brand Analytics Search Query Performance, and DataDive. Brand Analytics is the most authoritative because the data comes directly from Amazon." } },
    { "@type": "Question", "name": "How many keywords should an Amazon listing target?", "acceptedAnswer": { "@type": "Answer", "text": "A well-optimized Amazon listing typically indexes for 200–500 relevant keywords through the title, bullets, description, A+ content, and 250-byte backend search terms field. Focus on 5–10 primary buyer-intent keywords for the title and bullets." } }
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
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Amazon SEO & Keyword Research Services</h1>
            <p class="text-gray-300 leading-relaxed max-w-3xl text-lg mb-6">
                Data-driven Amazon keyword research using Helium 10, Brand Analytics Search Query Performance, and DataDive — mapped to your listings, backend search terms, and PPC campaigns to rank higher in Amazon's A10 algorithm.
            </p>
            <div class="bg-[#121212] border border-orange-500/20 rounded-2xl p-6 max-w-3xl">
                <p class="text-orange-300 text-sm font-semibold mb-2">Quick Answer</p>
                <p class="text-gray-200 leading-relaxed">
                    <strong>Amazon SEO</strong> is the practice of optimizing a product listing to rank higher in Amazon's A10 search algorithm. The biggest ranking factors are keyword relevance, conversion rate, sales velocity, organic sales weight, and review quality. Most listings index for 200–500 keywords when optimized correctly.
                </p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-20">
        <h2 class="text-3xl font-bold mb-4">Amazon SEO Ranking Factors We Optimize</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            @foreach([
                ['Keyword Relevance', 'Primary keywords placed in the first 80 characters of the title and the opening of every bullet point.'],
                ['Conversion Rate (CVR)', 'Listings rewritten and imaged to lift unit-session percentage — the strongest A10 ranking signal.'],
                ['Sales Velocity', 'PPC, deals, and external traffic strategies that compound organic sales velocity over 7- and 30-day windows.'],
                ['Organic Sales Weight', 'Keyword rank pushed by attributing more sales to organic — not paid — through stronger listings and review velocity.'],
                ['Backend Search Terms', '250-byte hidden field optimized with no duplicates, no punctuation, and Spanish + misspellings included.'],
                ['Review Quality & Velocity', 'Review request automation through Seller Central, Vine enrollment, and brand-tail review programs.'],
            ] as [$title, $desc])
            <div class="bg-[#121212] border border-[#1f1f1f] rounded-2xl p-8 hover:border-orange-300 transition">
                <h3 class="text-xl font-semibold mb-3">{{ $title }}</h3>
                <p class="text-gray-400 text-sm leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-20 border-t border-[#1f1f1f]">
        <h2 class="text-3xl font-bold mb-4">Tools We Use for Amazon Keyword Research</h2>
        <ul class="text-gray-300 space-y-3 mt-8 max-w-3xl">
            <li>• <strong class="text-white">Helium 10 Cerebro & Magnet</strong> — reverse ASIN keyword discovery and search-volume sizing.</li>
            <li>• <strong class="text-white">Amazon Brand Analytics</strong> — Search Query Performance data direct from Amazon.</li>
            <li>• <strong class="text-white">Jungle Scout Keyword Scout</strong> — historical search trend and competitor exact-phrase analysis.</li>
            <li>• <strong class="text-white">DataDive & Smartscout</strong> — keyword gap and category-share insights.</li>
            <li>• <strong class="text-white">Amazon Search Suggestions</strong> — auto-complete mining for long-tail buyer-intent terms.</li>
        </ul>
    </section>

    <section class="max-w-4xl mx-auto px-6 py-20 border-t border-[#1f1f1f]">
        <h2 class="text-3xl font-bold mb-10">Frequently Asked Questions</h2>
        <div class="space-y-4">
            @foreach([
                ['What is Amazon SEO?', 'Amazon SEO is the practice of optimizing product listings — title, bullets, description, A+ content, images, backend keywords, reviews, and pricing — to rank higher in Amazon\'s A10 algorithm and increase organic sales.'],
                ['How does the Amazon A10 algorithm work?', 'A10 ranks products by relevance, conversion rate, sales velocity, organic sales weight, seller authority, CTR, and review quality. Internal traffic and shopper conversion are weighted more heavily than in the older A9 algorithm.'],
                ['Which Amazon keyword research tools are best?', 'Helium 10 Cerebro/Magnet, Jungle Scout Keyword Scout, Amazon Brand Analytics Search Query Performance, and DataDive. Brand Analytics is the most authoritative since it comes directly from Amazon.'],
                ['How many keywords should an Amazon listing target?', 'A well-optimized listing typically indexes for 200–500 keywords through the title, bullets, description, A+ content, and 250-byte backend field. Focus 5–10 primary buyer-intent keywords on the title and bullets.'],
            ] as [$q, $a])
            <details class="bg-[#121212] border border-[#1f1f1f] rounded-2xl p-6 group">
                <summary class="cursor-pointer text-lg font-semibold flex justify-between items-center">{{ $q }}<span class="text-orange-300 group-open:rotate-45 transition">+</span></summary>
                <p class="text-gray-400 mt-4 leading-relaxed">{{ $a }}</p>
            </details>
            @endforeach
        </div>
    </section>

    <section class="py-24 text-center bg-gradient-to-b from-[#1a1a1a] to-[#0b0b0b] border-t border-[#222]">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Get Your Free Amazon SEO Audit</h2>
        <p class="text-gray-400 max-w-2xl mx-auto mb-8 px-6">We'll benchmark your top 5 keywords against the category leader and send a 1-page priority list.</p>
        <button onclick="document.getElementById('audit-modal').classList.remove('hidden')" class="bg-orange-300 text-black px-10 py-4 rounded-xl text-lg font-semibold hover:opacity-80 transition shadow-xl">Get Free SEO Audit</button>
    </section>
</div>
@endsection
