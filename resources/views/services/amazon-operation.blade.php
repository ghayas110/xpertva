@extends('layouts.app')

@section('title', 'Amazon E-Commerce Operations - XpertVA')

@section('content')
<div class="min-h-screen bg-[#0b0b0b] text-white overflow-hidden">
    <!-- Hero Section -->
    <section class="relative w-full pt-36 pb-40 bg-gradient-to-br from-[#0d0d0d] via-[#111] to-[#0c0c0c] overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,140,0,0.18),transparent_60%)]"></div>
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center relative z-10">
            <div>
                <p class="inline-flex items-center gap-2 text-sm uppercase tracking-[0.2em] text-orange-300/80 mb-3">
                    Amazon E-Commerce Operations
                </p>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">Listings, Optimization & Full Amazon Store Management</h1>
                <p class="text-gray-300 leading-relaxed mb-4 max-w-xl">XpertVA helps you run a high-performing Amazon store with professional operations: product research, listing creation, SEO-driven optimization, catalog hygiene, and day-to-day account management.</p>
                <div class="flex flex-wrap gap-4">
                    <button onclick="document.getElementById('audit-modal').classList.remove('hidden')" class="inline-block bg-orange-300 text-black px-8 py-4 rounded-xl text-lg font-semibold hover:opacity-85 transition shadow-lg">Schedule Consultation</button>
                    <a href="#services" class="inline-block border border-[#333] text-gray-200 px-7 py-3 rounded-xl text-sm font-medium hover:border-orange-300/80 hover:text-orange-300 transition">View Services</a>
                </div>
            </div>
            <div class="bg-[#141414] border border-[#222] rounded-2xl p-8 shadow-xl">
                <h3 class="text-xl font-semibold mb-2">Get Amazon Store Audit & Proposal</h3>
                <form class="flex flex-col gap-4">
                    <input class="bg-black border border-[#333] rounded-lg px-4 py-3 text-sm focus:border-orange-300 outline-none placeholder:text-gray-600" placeholder="Name"/>
                    <input class="bg-black border border-[#333] rounded-lg px-4 py-3 text-sm focus:border-orange-300 outline-none placeholder:text-gray-600" placeholder="Email"/>
                    <button type="submit" class="bg-orange-300 text-black font-semibold py-3 rounded-lg hover:opacity-90 transition">Submit</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Services Grid -->
    <section id="services" class="max-w-7xl mx-auto px-6 py-24">
        <h2 class="text-3xl font-bold mb-4">Our Amazon Operations Expertise</h2>
        <p class="text-gray-400 max-w-3xl mb-12">Scale your Amazon business with specialized support for listings, optimization, and account health.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $amazonExpertise = [
                ['title' => 'Product Research & Sourcing', 'icon' => 'search', 'desc' => 'Finding high-opportunity products with low competition and reliable supply chains.'],
                ['title' => 'Listing Creation & Optimization', 'icon' => 'pen-tool', 'desc' => 'SEO-driven titles, bullets, and descriptions that improve visibility and sales.'],
                ['title' => 'Amazon PPC Management', 'icon' => 'zap', 'desc' => 'Data-backed advertising campaigns to maximize ROAS and reduce ACOS.'],
                ['title' => 'Enhanced Brand Content (A+)', 'icon' => 'image', 'desc' => 'Visual storytelling and modular designs that build trust and identity.'],
                ['title' => 'Account Health & Hygiene', 'icon' => 'shield-check', 'desc' => 'Monitoring performance, handling suspensions, and ensuring policy compliance.'],
                ['title' => 'Inventory & Catalog Management', 'icon' => 'layers', 'desc' => 'Forecasting demand, managing stock levels, and keeping your store organized.']
            ];
            @endphp

            @foreach($amazonExpertise as $item)
            <div class="bg-[#121212] border border-[#1f1f1f] rounded-2xl p-6 hover:border-orange-300 transition group">
                <div class="text-orange-300 mb-4 group-hover:scale-110 transition">
                    @if($item['icon'] === 'search')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21 21-4.34-4.34"></path><circle cx="11" cy="11" r="8"></circle></svg>
                    @elseif($item['icon'] === 'pen-tool')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15.707 21.293a1 1 0 0 1-1.414 0l-1.586-1.586a1 1 0 0 1 0-1.414l5.586-5.586a1 1 0 0 1 1.414 0l1.586 1.586a1 1 0 0 1 0 1.414z"></path><path d="m18 13-1.375-6.874a1 1 0 0 0-.746-.776L3.235 2.028a1 1 0 0 0-1.207 1.207L5.35 15.879a1 1 0 0 0 .776.746L13 18"></path><path d="m2.3 2.3 7.286 7.286"></path><circle cx="11" cy="11" r="2"></circle></svg>
                    @elseif($item['icon'] === 'zap')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path></svg>
                    @elseif($item['icon'] === 'image')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><circle cx="9" cy="9" r="2"></circle><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path></svg>
                    @elseif($item['icon'] === 'shield-check')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m9 12 2 2 4-4"></path></svg>
                    @elseif($item['icon'] === 'layers')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"></path><path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"></path><path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"></path></svg>
                    @endif
                </div>
                <h3 class="text-lg font-semibold mb-2">{{ $item['title'] }}</h3>
                <p class="text-gray-400 text-sm leading-relaxed">{{ $item['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Final CTA -->
    <section class="py-20 text-center bg-gradient-to-b from-[#151515] to-[#0b0b0b] border-t border-[#222]">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Run Your Amazon Store Like a Pro</h2>
        <p class="text-gray-400 max-w-2xl mx-auto mb-6">Let XpertVA handle the operations, so you can focus on inventory and strategy.</p>
        <button onclick="document.getElementById('audit-modal').classList.remove('hidden')" class="bg-orange-300 text-black px-10 py-4 rounded-xl text-lg font-semibold hover:opacity-80 transition shadow-xl inline-block">Request Store Audit</button>
    </section>
</div>
@endsection
