@extends('layouts.site')

@section('title', 'eCommerce Marketing and SEO Services | XpertVA')
@section('meta_description', 'XpertVA digital marketing: data-driven campaigns, SEO, PPC, social media, and Amazon advertising strategies to grow your eCommerce brand.')
@section('head_tone', 'site-head--on-dark')

@push('head')
<link rel="canonical" href="{{ url('/services/marketing-solutions') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="Marketing Solutions | XpertVA">
<meta property="og:description" content="Search, paid social, email and marketplace advertising planned around one revenue number.">
<meta property="og:url" content="{{ url('/services/marketing-solutions') }}">
<meta property="og:image" content="{{ asset('assets/photos/retail-bags.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": "eCommerce Digital Marketing",
  "serviceType": "Digital Marketing",
  "provider": { "@@id": "https://xpertva.com/#organization" },
  "areaServed": "Worldwide",
  "description": "Search engine optimisation, paid search and social, email and lifecycle marketing, and marketplace advertising for eCommerce brands.",
  "url": "{{ url('/services/marketing-solutions') }}",
  "offers": { "@@type": "Offer", "priceCurrency": "USD", "availability": "https://schema.org/InStock" }
}
</script>
@endpush

@section('content')
@include('site.service', [
    'title' => 'eCommerce Marketing and SEO Services',
    'kicker' => 'Marketing solutions',
    'lede'     => 'Traffic is easy to buy and hard to make pay. We plan every channel against one number: what a customer is worth to you.',
    'photo'    => 'assets/photos/retail-bags.jpg',
    'photoAlt' => 'Retail shopping bags arranged on a dark surface.',
    'intro'    => 'Most eCommerce marketing fails because each channel is measured on its own dashboard. We work from blended acquisition cost across every channel, which is the only figure that tells you whether growth is profitable.',
    'definition' => 'eCommerce marketing services plan and run the channels that bring buyers to your store: SEO, paid search, paid social, email and marketplace advertising. XpertVA manages them together and judges every channel on blended customer acquisition cost, so you can see whether growth is actually profitable rather than reading five separate dashboards.',
    'process' => [
        ['name' => 'Measure the baseline', 'desc' => 'We set up or repair tracking and work out your current blended acquisition cost and customer value.'],
        ['name' => 'Plan by margin', 'desc' => 'Budget goes to the channels and products with the room to pay for it, written into a plan you approve.'],
        ['name' => 'Run and test', 'desc' => 'Campaigns, content and email flows go live with a test plan, so each change has a question it answers.'],
        ['name' => 'Report monthly', 'desc' => 'One monthly view of spend, revenue and acquisition cost, with the assumptions written down.'],
    ],
    'deliverables' => [
        'Tracking checked and fixed before spend increases',
        'A channel plan with budgets by margin',
        'SEO fixes and content for commercial pages',
        'Paid search and social campaigns with creative tests',
        'Email flows and a campaign calendar',
        'A monthly blended acquisition cost report',
    ],
    'fitFor' => [
        'eCommerce brands spending across several channels with no single view of what a customer costs',
        'Stores with good products and weak organic traffic to their category and product pages',
        'Sellers on Amazon who want to build demand outside the marketplace',
        'Teams that want marketing judged on profit, not on clicks or impressions',
    ],
    'notFitFor' => [
        'You want a viral campaign rather than steady, measured growth',
        'You cannot share sales and margin data with us',
        'You need results from SEO within a few weeks',
    ],
    'faqs' => [
        ['What is blended customer acquisition cost?', 'It is total marketing spend across every channel divided by the number of new customers in the same period. It stops channels taking credit for the same sale and shows the real cost of growth.'],
        ['Do you do SEO for eCommerce stores?', 'Yes. We fix technical problems, structure category and product pages around what buyers search, and write content aimed at commercial intent.'],
        ['Can you run Amazon ads and Google ads together?', 'Yes. We run marketplace advertising alongside off-platform spend so budgets are planned as one, not competing in isolation.'],
        ['How soon will we see results?', 'Paid channels show data within weeks. SEO takes longer, usually months, because search engines need time to recrawl and re-rank pages.'],
        ['How much do eCommerce marketing services cost?', 'We quote after a free consultation, in writing, based on the channels, catalogue size and hours the work actually needs. You see the scope and the monthly figure before you commit to anything.'],
    ],
    'capabilities' => [
        ['name' => 'Search engine optimisation', 'desc' => 'Technical fixes, category and product page structure, and content built around commercial intent rather than traffic for its own sake.'],
        ['name' => 'Paid search', 'desc' => 'Google and Bing shopping and search campaigns structured by margin, with feed work so Shopping actually serves your best products.'],
        ['name' => 'Paid social', 'desc' => 'Meta, TikTok and Pinterest creative testing with a clear read on what the creative did, separate from what the audience did.'],
        ['name' => 'Email and lifecycle', 'desc' => 'Welcome, browse abandon, cart, post purchase and win back flows, plus a campaign calendar you can actually staff.'],
        ['name' => 'Marketplace advertising', 'desc' => 'Amazon, Walmart Connect and eBay Promoted Listings run alongside off platform spend rather than in isolation.'],
        ['name' => 'Measurement', 'desc' => 'One monthly view of spend, revenue and blended acquisition cost, with the assumptions written down.'],
    ],
    'proof' => [
        ['value' => '500+', 'label' => 'Brands supported since we opened in 2017'],
        ['value' => '98%', 'label' => 'Client satisfaction across active accounts'],
    ],
    'related' => [
        ['Amazon PPC management', 'services.amazon.ppc-management'],
        ['Content and branding', 'services.content-branding'],
        ['Web development', 'services.web-dev'],
        ['Shopify services', 'services.shopify'],
    ],
])
@endsection
