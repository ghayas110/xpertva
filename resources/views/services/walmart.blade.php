@extends('layouts.site')

@section('title', 'Walmart Marketplace Management Services | XpertVA')
@section('meta_description', 'XpertVA Walmart Marketplace: account setup, listing optimization, inventory management, and advertising to grow your Walmart seller account.')
@section('head_tone', 'site-head--on-dark')

@push('head')
<link rel="canonical" href="{{ url('/services/walmart') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="Walmart Marketplace Services | XpertVA">
<meta property="og:description" content="Walmart Marketplace setup, item optimisation, WFS and Connect advertising managed end to end.">
<meta property="og:url" content="{{ url('/services/walmart') }}">
<meta property="og:image" content="{{ asset('assets/photos/pos-counter.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": "Walmart Marketplace Management",
  "serviceType": "Walmart Marketplace Management",
  "provider": { "@@id": "https://xpertva.com/#organization" },
  "areaServed": "Worldwide",
  "description": "Walmart Marketplace account setup, item content optimisation, Walmart Fulfilment Services, Connect advertising and Buy Box recovery.",
  "url": "{{ url('/services/walmart') }}",
  "offers": { "@@type": "Offer", "priceCurrency": "USD", "availability": "https://schema.org/InStock" }
}
</script>
@endpush

@section('content')
@include('site.service', [
    'title' => 'Walmart Marketplace Management Services',
    'kicker' => 'Walmart Marketplace',
    'lede'     => 'Less crowded than Amazon and still growing. The sellers who set it up properly early are the ones taking the Buy Box now.',
    'photo'    => 'assets/photos/pos-counter.jpg',
    'photoAlt' => 'A shop counter with a tablet point of sale system in use.',
    'intro'    => 'Walmart rewards clean item data and punishes the sellers who copied their Amazon listings across. We set the catalogue up to Walmart specification and run it against Walmart metrics, not Amazon ones.',
    'definition' => 'Walmart Marketplace management is the ongoing running of a Walmart seller account: onboarding and item setup, listing content to Walmart\'s quality standards, pricing for the Buy Box, Walmart Fulfillment Services, Walmart Connect advertising and performance standards. XpertVA handles that work against Walmart\'s own metrics rather than copying an Amazon playbook.',
    'process' => [
        ['name' => 'Account review', 'desc' => 'We check item setup, Listing Quality scores, pricing, fulfilment settings and performance standards, and list what to fix first.'],
        ['name' => 'Fix item data', 'desc' => 'Titles, key features, attributes and images are rebuilt to Walmart\'s specification so items publish and rank.'],
        ['name' => 'Run the account', 'desc' => 'Pricing, WFS inventory, orders and performance metrics are handled every working day.'],
        ['name' => 'Advertise and report', 'desc' => 'Walmart Connect campaigns run against a target spend ratio, with a written weekly summary.'],
    ],
    'deliverables' => [
        'A written account review',
        'Item content rebuilt to Listing Quality standards',
        'Pricing and Buy Box strategy',
        'WFS enrolment and inventory planning',
        'Walmart Connect campaigns',
        'Weekly written reporting',
    ],
    'fitFor' => [
        'Amazon sellers ready to add a second marketplace with less competition',
        'Brands approved on Walmart whose items are unpublished or scoring poorly',
        'Sellers losing the Buy Box on Walmart to other offers',
        'Businesses considering WFS who want the inbound and inventory planned properly',
    ],
    'notFitFor' => [
        'You have not been approved and do not meet Walmart\'s seller requirements',
        'You want your Amazon listings copied across unchanged',
        'You only sell a few units a month',
    ],
    'faqs' => [
        ['How is selling on Walmart different from Amazon?', 'Walmart scores listings with its own Listing Quality measure, has different content rules and a smaller, less crowded seller base. Copying Amazon listings across usually underperforms.'],
        ['Can you help us get approved to sell on Walmart?', 'Yes. We prepare the application and the information Walmart asks for, then set up the account and first items once approved.'],
        ['What is Walmart Fulfillment Services?', 'WFS is Walmart\'s fulfilment programme, similar to Amazon FBA. We handle enrolment, inbound shipments and inventory planning.'],
        ['Do you run Walmart Connect ads?', 'Yes. We build Sponsored Products and Search Brand Amplifier campaigns and manage bids against a target ad spend ratio.'],
        ['How much does Walmart Marketplace management cost?', 'We quote after a free consultation, in writing, based on the channels, catalogue size and hours the work actually needs. You see the scope and the monthly figure before you commit to anything.'],
    ],
    'capabilities' => [
        ['name' => 'Account and item setup', 'desc' => 'Seller onboarding, taxonomy mapping, bulk item feeds and the spec sheet work that stops items sitting unpublished for weeks.'],
        ['name' => 'Content optimisation', 'desc' => 'Titles, key features, descriptions and rich media written to Walmart Listing Quality Score, which scores differently from Amazon.'],
        ['name' => 'Buy Box and pricing', 'desc' => 'Repricing strategy, shipping settings and offer quality work aimed at winning and holding the Buy Box.'],
        ['name' => 'Walmart Fulfilment Services', 'desc' => 'WFS enrolment, inbound planning, inventory forecasting and the storage decisions that keep fees down.'],
        ['name' => 'Walmart Connect advertising', 'desc' => 'Sponsored Products and Search Brand Amplifier campaigns built and bid against a target ad spend ratio.'],
        ['name' => 'Performance standards', 'desc' => 'Order defect rate, on time delivery and cancellation monitoring, with the fixes made before Walmart flags them.'],
    ],
    'proof' => [
        ['value' => '500+', 'label' => 'Brands supported since we opened in 2017'],
        ['value' => '98%', 'label' => 'Client satisfaction across active accounts'],
    ],
    'related' => [
        ['Amazon services', 'services.amazon'],
        ['eBay services', 'services.ebay'],
        ['Shopify services', 'services.shopify'],
        ['Marketing solutions', 'services.marketing'],
    ],
])
@endsection
