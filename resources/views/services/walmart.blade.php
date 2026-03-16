@extends('layouts.app')

@section('title', 'Walmart Services - XpertVA')

@section('content')
<div class="min-h-screen bg-[#0b0b0b] text-white">
    <!-- Hero Section -->
    <section class="relative w-full pt-36 pb-20 bg-gradient-to-br from-[#0d0d0d] via-[#111] to-[#0c0c0c] overflow-hidden">
        <!-- Top Glow -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,140,0,0.15),transparent_60%)]"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-orange-300 transition mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                Back to Services
            </a>

            <div class="flex items-center gap-4 mb-6">
                <!-- Icon Placeholder -->
                <div class="p-3 rounded-2xl bg-orange-500/10 border border-orange-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-12 h-12 text-orange-300"><path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"/><path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"/></svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight text-white">
                    Walmart Services
                </h1>
            </div>
            <p class="text-gray-300 leading-relaxed max-w-2xl text-lg mb-8">
                Comprehensive walmart services solutions tailored to your business needs. 
                We handle the complexities so you can focus on growth.
            </p>
        </div>
    </section>

    <!-- Services Details Section -->
    <section class="max-w-7xl mx-auto px-6 py-20">
        <div class="mb-12">
            <h2 class="text-3xl font-bold mb-4">What We Offer</h2>
            <p class="text-gray-400 max-w-3xl">
                Our specialized team provides end-to-end support for all your Walmart Services needs.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $walmartServices = [
                ['title' => 'Account Setup & Management', 'desc' => 'Getting your Walmart Marketplace account approved and set up.'],
                ['title' => 'Product Listing & Optimization', 'desc' => 'Creating high-quality listings that meet Walmart\'s standards.'],
                ['title' => 'Inventory Management', 'desc' => 'Syncing inventory and preventing stockouts.'],
                ['title' => 'Order Fulfillment', 'desc' => 'Managing orders and ensuring compliance with shipping metrics.'],
                ['title' => 'Customer Service', 'desc' => 'Providing top-notch support to Walmart customers.'],
                ['title' => 'Walmart SEO Optimization', 'desc' => 'Optimizing titles and attributes for Walmart\'s search algorithm.'],
                ['title' => 'Account Health Monitoring', 'desc' => 'Tracking performance metrics to maintain good standing.'],
                ['title' => 'Walmart Cases', 'desc' => 'Handling support tickets and disputes with Walmart.']
            ];
            @endphp

            @foreach($walmartServices as $service)
            <div class="bg-[#121212] border border-[#1f1f1f] rounded-2xl p-8 hover:border-orange-300 transition-all group flex flex-col items-start shadow-xl">
                <div class="bg-orange-500/10 p-3 rounded-lg mb-4 group-hover:bg-orange-500/20 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-orange-300"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <h3 class="text-xl font-semibold mb-3 text-white">{{ $service['title'] }}</h3>
                <p class="text-gray-400 text-sm leading-relaxed mb-6">{{ $service['desc'] }}</p>
                <div class="mt-auto pt-6 border-t border-white/5 w-full">
                    <a href="#" class="text-orange-300 text-sm font-medium flex items-center gap-1 hover:gap-2 transition-all">
                        Read More <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 text-center bg-gradient-to-b from-[#1a1a1a] to-[#0b0b0b] border-t border-[#222]">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">
            Ready to Optimize Your Walmart Services?
        </h2>
        <p class="text-gray-400 max-w-2xl mx-auto mb-8 px-6">
            Get in touch with us today for a free consultation and see how we can help you scale.
        </p>
        <button onclick="document.getElementById('audit-modal').classList.remove('hidden')" class="bg-orange-300 text-black px-10 py-4 rounded-xl text-lg font-semibold hover:opacity-80 transition shadow-xl inline-block">
            Book Free Consultation
        </button>
    </section>
</div>
@endsection
