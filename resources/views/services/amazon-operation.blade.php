@extends('layouts.site')

@section('title', 'Amazon Operations Management | XpertVA')
@section('meta_description', 'XpertVA Amazon operations management: full-service Amazon account management, case management, brand registry, and marketplace optimization.')
@section('head_tone', 'site-head--on-dark')

@push('head')
<link rel="canonical" href="{{ url('/services/amazon-operations') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="Amazon Operations | XpertVA">
<meta property="og:description" content="The daily running of a Seller Central account: inventory, cases, pricing, reimbursements and reporting.">
<meta property="og:url" content="{{ url('/services/amazon-operations') }}">
<meta property="og:image" content="{{ asset('assets/photos/fulfilment-floor.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": "Amazon Operations Management",
  "serviceType": "Amazon Operations Management",
  "provider": { "@@id": "https://xpertva.com/#organization" },
  "areaServed": "Worldwide",
  "description": "Day to day Amazon Seller Central operations including inventory planning, FBA shipments, case management, pricing, reimbursement recovery and reporting.",
  "url": "{{ url('/services/amazon-operations') }}",
  "offers": { "@@type": "Offer", "priceCurrency": "USD", "availability": "https://schema.org/InStock" }
}
</script>
@endpush

@section('content')
@include('site.service', [
    'title' => 'Amazon Operations Management',
    'kicker' => 'Amazon operations',
    'lede'     => 'The unglamorous daily work that decides whether a good catalogue actually earns.',
    'photo'    => 'assets/photos/fulfilment-floor.jpg',
    'photoAlt' => 'A fulfilment warehouse floor stacked with outbound cartons.',
    'intro'    => 'Listings and advertising get the attention. Stockouts, stranded inventory, unresolved cases and unclaimed reimbursements are what quietly take the margin. This is the service that covers all of it.',
    'definition' => 'Amazon operations management is the behind the scenes work that keeps an Amazon account profitable: inventory planning, FBA shipments, Seller Support cases, reimbursement claims, pricing and Buy Box monitoring, and profit reporting. XpertVA runs those tasks every working day so stock stays in, cases get closed and fees get recovered.',
    'process' => [
        ['name' => 'Operations audit', 'desc' => 'We review inventory health, open cases, stranded stock, fee charges and reimbursement history, and list where money is leaking.'],
        ['name' => 'Recover what is owed', 'desc' => 'Eligible lost, damaged and overcharged items are claimed inside Amazon\'s claim windows.'],
        ['name' => 'Run the routine', 'desc' => 'Replenishment, shipment creation, case follow up and Buy Box checks become a daily and weekly routine with an owner.'],
        ['name' => 'Report on profit', 'desc' => 'You get a weekly note and a monthly profit view that counts fees, ads, returns and storage.'],
    ],
    'deliverables' => [
        'An operations audit with money at risk listed',
        'Replenishment forecasts and restock plans',
        'FBA shipments created and tracked to check in',
        'Seller Support cases logged and followed to close',
        'Reimbursement claims filed and recorded',
        'A monthly profit view',
    ],
    'fitFor' => [
        'FBA sellers who keep running out of stock or paying long term storage fees',
        'Accounts with open cases, stranded inventory or reimbursements nobody has chased',
        'Brands whose profit is unclear once fees, ads, returns and storage are counted',
        'Teams growing fast enough that shipments and replenishment have become a full time job',
    ],
    'notFitFor' => [
        'You sell a single product with very low volume',
        'You only want advertising help, which our PPC management service covers',
        'You need a fully outsourced warehouse rather than account operations',
    ],
    'faqs' => [
        ['What is included in Amazon operations management?', 'Inventory planning, FBA shipments, case management, reimbursement recovery, pricing and Buy Box monitoring, and reporting. It covers the operational work that sits behind listings and advertising.'],
        ['How do you recover FBA reimbursements?', 'We audit inventory adjustments, returns and fee charges, find items Amazon lost, damaged or overcharged, and file claims with the evidence each one needs.'],
        ['Can you help with stranded or ageing inventory?', 'Yes. We fix the listing problems that strand stock and plan removals or promotions for ageing units before long term storage fees apply.'],
        ['Is this different from Amazon account management?', 'Account management covers listings, advertising and account health. Operations focuses on stock, shipments, cases and money owed. Many clients use both, run by the same operator.'],
        ['How much does Amazon operations management cost?', 'We quote after a free consultation, in writing, based on the channels, catalogue size and hours the work actually needs. You see the scope and the monthly figure before you commit to anything.'],
    ],
    'capabilities' => [
        ['name' => 'Inventory planning', 'desc' => 'Replenishment forecasting, restock limits, ageing stock and removal orders so you neither run out nor pay long term storage.'],
        ['name' => 'FBA shipment management', 'desc' => 'Shipment creation, box content, carrier booking, and chasing the receipts that never quite check in.'],
        ['name' => 'Case management', 'desc' => 'Seller Support cases opened, escalated and followed until they close, with a written record of each one.'],
        ['name' => 'Reimbursement recovery', 'desc' => 'Lost, damaged, and fee overcharge claims audited and filed inside the claim window.'],
        ['name' => 'Pricing and Buy Box', 'desc' => 'Repricing rules, Buy Box monitoring and the margin floor logic that stops a race to the bottom.'],
        ['name' => 'Reporting', 'desc' => 'A weekly written summary and a monthly profit view that accounts for fees, ads, returns and storage.'],
    ],
    'proof' => [
        ['value' => '$9.2M', 'label' => 'Ordered product sales on one managed account over 14 months'],
        ['value' => '54,039', 'label' => 'Orders processed on that same account'],
    ],
    'related' => [
        ['Account management', 'services.amazon.account-management'],
        ['Brand protection', 'services.amazon.brand-protection'],
        ['Amazon PPC management', 'services.amazon.ppc-management'],
        ['Virtual assistants', 'services.va'],
    ],
])
@endsection
