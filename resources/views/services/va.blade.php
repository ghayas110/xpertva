@extends('layouts.site')

@section('title', 'eCommerce Virtual Assistant Services | XpertVA')
@section('meta_description', 'Hire a professional virtual assistant from XpertVA for eCommerce operations, customer support, data entry, order management, and more.')
@section('head_tone', 'site-head--on-dark')

@push('head')
<link rel="canonical" href="{{ url('/services/virtual-assistant') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="eCommerce Virtual Assistants | XpertVA">
<meta property="og:description" content="Trained eCommerce virtual assistants for Seller Central, customer support, order management and catalogue work.">
<meta property="og:url" content="{{ url('/services/virtual-assistant') }}">
<meta property="og:image" content="{{ asset('assets/photos/team-table.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": "eCommerce Virtual Assistant Services",
  "serviceType": "eCommerce Virtual Assistant",
  "provider": { "@@id": "https://xpertva.com/#organization" },
  "areaServed": "Worldwide",
  "description": "Dedicated eCommerce virtual assistants trained on Amazon Seller Central, Shopify, Walmart and eBay for catalogue work, customer support, order management and reporting.",
  "url": "{{ url('/services/virtual-assistant') }}",
  "offers": { "@@type": "Offer", "priceCurrency": "USD", "availability": "https://schema.org/InStock" }
}
</script>
@endpush

@section('content')
@include('site.service', [
    'title' => 'eCommerce Virtual Assistant Services',
    'kicker' => 'Virtual assistants',
    'lede'     => 'A trained operator inside your account every working day, for a fraction of a local hire.',
    'photo'    => 'assets/photos/team-table.jpg',
    'photoAlt' => 'Three colleagues working through account tasks at a shared table.',
    'intro'    => 'A general virtual assistant costs you time in training. Ours arrive knowing Seller Central, Shopify admin and Walmart Seller Center, because that is all they work in.',
    'definition' => 'An eCommerce virtual assistant is a remote team member who handles the daily operational work of an online store: listings, customer messages, orders, inventory, supplier follow up and reporting. XpertVA assistants are trained on Seller Central, Shopify, Walmart Seller Center and eBay before they join your account, so you skip the training.',
    'process' => [
        ['name' => 'Scope the role', 'desc' => 'We agree the tasks, tools, working hours and response times in writing, so both sides know what done looks like.'],
        ['name' => 'Match an assistant', 'desc' => 'We pick an assistant with experience in your marketplaces and category, plus a backup who learns the account too.'],
        ['name' => 'Onboard safely', 'desc' => 'Access is set up through named user accounts with limited permissions, never by sharing your main login.'],
        ['name' => 'Work and report', 'desc' => 'Your assistant works your hours and sends a weekly written summary of what was done and what needs your decision.'],
    ],
    'deliverables' => [
        'A written role scope with tasks and hours',
        'A named assistant plus a trained backup',
        'Access through limited user permissions',
        'Daily task handling in your tools',
        'Weekly written reports',
        'A replacement if the match is not right',
    ],
    'fitFor' => [
        'Founders spending their week on uploads, messages and order admin instead of growth',
        'Sellers who tried a general assistant and spent months training them',
        'Brands that need cover across several marketplaces with one person who knows them all',
        'Teams that want a named, accountable person rather than a task marketplace',
    ],
    'notFitFor' => [
        'You need someone for a few hours once a month',
        'You want an assistant who will also make strategic decisions with no oversight',
        'You cannot give an assistant their own limited user access',
    ],
    'faqs' => [
        ['What does an eCommerce virtual assistant do?', 'Typical work includes uploading and fixing listings, answering buyer messages, processing orders and returns, tracking inventory, chasing suppliers and preparing reports. The exact list is agreed in writing before they start.'],
        ['Is it safe to give a virtual assistant access to Seller Central?', 'Yes, if it is done properly. We add the assistant as a secondary user with only the permissions the work needs. You never share your primary login, and you can remove their access at any time.'],
        ['Do I get the same assistant every day?', 'Yes. You get one named assistant, plus a backup who knows your account so work continues through holidays and sick days.'],
        ['What if the assistant is not a good fit?', 'Tell us and we replace them. The backup already knows the account, so the handover does not set you back.'],
        ['How much does an eCommerce virtual assistant cost?', 'We quote after a free consultation, in writing, based on the channels, catalogue size and hours the work actually needs. You see the scope and the monthly figure before you commit to anything.'],
    ],
    'capabilities' => [
        ['name' => 'Dedicated, not shared', 'desc' => 'One named person on your account with a backup who knows it. You get their working hours, not a ticket queue.'],
        ['name' => 'Marketplace trained', 'desc' => 'Every assistant is trained on Seller Central, Shopify admin, Walmart Seller Center and eBay Seller Hub before they touch a client account.'],
        ['name' => 'Catalogue and listings', 'desc' => 'Product uploads, variation fixes, flat files, image updates and the steady maintenance a growing catalogue needs.'],
        ['name' => 'Customer support', 'desc' => 'Buyer messages, returns, A to Z claims and review follow up, answered inside marketplace response windows.'],
        ['name' => 'Order and inventory work', 'desc' => 'Order processing, stock counts, replenishment alerts, supplier chasing and third party logistics coordination.'],
        ['name' => 'Reporting you can read', 'desc' => 'A weekly written summary of what was done, what changed and what needs your decision.'],
    ],
    'proof' => [
        ['value' => '500+', 'label' => 'Brands supported since we opened in 2017'],
        ['value' => '98%', 'label' => 'Client satisfaction across active accounts'],
    ],
    'related' => [
        ['Amazon virtual assistant services', 'services.amazon-va'],
        ['Amazon services', 'services.amazon'],
        ['Shopify services', 'services.shopify'],
        ['eBay services', 'services.ebay'],
        ['Amazon operations', 'services.amazon-ops'],
    ],
])
@endsection
