@extends('layouts.app')

@section('title', 'Professional Virtual Assistance - XpertVA')

@section('content')
<div class="min-h-screen bg-[#0b0b0b] text-white overflow-hidden">
    <!-- Hero Section -->
    <section class="relative w-full pt-36 pb-40 bg-gradient-to-br from-[#0d0d0d] via-[#111] to-[#0c0c0c] overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,140,0,0.15),transparent_60%)]"></div>
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center relative z-10">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">Professional Virtual Assistance for Your Business</h1>
                <p class="text-gray-300 leading-relaxed mb-6">XpertVA helps you streamline operations, optimize workflows, manage your online presence, and support your ecommerce or Amazon stores — so you can focus on growth while we handle the workload.</p>
                <a href="#services" class="inline-block bg-orange-300 text-black px-8 py-4 rounded-xl text-lg font-semibold hover:opacity-85 transition shadow-lg">Explore Services</a>
            </div>
            <div class="bg-[#141414] border border-[#222] rounded-2xl p-8 shadow-xl">
                <h3 class="text-xl font-semibold mb-4">Get Free Consultation</h3>
                <form class="flex flex-col gap-4">
                    <input class="bg-black border border-[#333] rounded-lg px-4 py-3 text-sm focus:border-orange-300 outline-none placeholder:text-gray-600" placeholder="Your Name"/>
                    <input class="bg-black border border-[#333] rounded-lg px-4 py-3 text-sm focus:border-orange-300 outline-none placeholder:text-gray-600" placeholder="Email Address"/>
                    <input class="bg-black border border-[#333] rounded-lg px-4 py-3 text-sm focus:border-orange-300 outline-none placeholder:text-gray-600" placeholder="Phone Number"/>
                    <button type="submit" class="bg-orange-300 text-black font-semibold py-3 rounded-lg hover:opacity-90 transition">Submit</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Services Grid -->
    <section id="services" class="max-w-7xl mx-auto px-6 py-24">
        <h2 class="text-3xl font-bold mb-4">Our Virtual Assistant Expertise</h2>
        <p class="text-gray-400 max-w-3xl mb-12">Efficient, reliable, and highly skilled virtual support services that help you manage your business smoothly.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $vaExpertise = [
                ['title' => 'Business Research', 'icon' => 'search', 'desc' => 'Professional support covering all aspects of business research.'],
                ['title' => 'Competitor Analysis', 'icon' => 'chart-column', 'desc' => 'Professional support covering all aspects of competitor analysis.'],
                ['title' => 'Amazon & Ecommerce Support', 'icon' => 'shopping-cart', 'desc' => 'Professional support covering all aspects of amazon & ecommerce support.'],
                ['title' => 'Administrative Assistance', 'icon' => 'shield-check', 'desc' => 'Professional support covering all aspects of administrative assistance.'],
                ['title' => 'Listing & Content Optimization', 'icon' => 'pen-tool', 'desc' => 'Professional support covering all aspects of listing & content optimization.'],
                ['title' => 'Customer Support & Communication', 'icon' => 'shield-check', 'desc' => 'Professional support covering all aspects of customer support & communication.']
            ];
            @endphp

            @foreach($vaExpertise as $item)
            <div class="bg-[#121212] border border-[#1f1f1f] rounded-2xl p-6 hover:border-orange-300 transition group">
                <div class="text-orange-300 mb-4 group-hover:scale-110 transition">
                    @if($item['icon'] === 'search')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21 21-4.34-4.34"></path><circle cx="11" cy="11" r="8"></circle></svg>
                    @elseif($item['icon'] === 'chart-column')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v16a2 2 0 0 0 2 2h16"></path><path d="M18 17V9"></path><path d="M13 17V5"></path><path d="M8 17v-3"></path></svg>
                    @elseif($item['icon'] === 'shopping-cart')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>
                    @elseif($item['icon'] === 'shield-check')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m9 12 2 2 4-4"></path></svg>
                    @elseif($item['icon'] === 'pen-tool')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15.707 21.293a1 1 0 0 1-1.414 0l-1.586-1.586a1 1 0 0 1 0-1.414l5.586-5.586a1 1 0 0 1 1.414 0l1.586 1.586a1 1 0 0 1 0 1.414z"></path><path d="m18 13-1.375-6.874a1 1 0 0 0-.746-.776L3.235 2.028a1 1 0 0 0-1.207 1.207L5.35 15.879a1 1 0 0 0 .776.746L13 18"></path><path d="m2.3 2.3 7.286 7.286"></path><circle cx="11" cy="11" r="2"></circle></svg>
                    @endif
                </div>
                <h3 class="text-lg font-semibold mb-2">{{ $item['title'] }}</h3>
                <p class="text-gray-400 text-sm leading-relaxed">{{ $item['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-24 bg-[#111] border-t border-[#222]">
        <div class="max-w-5xl mx-auto px-6">
            <h2 class="text-3xl font-bold mb-10">Frequently Asked Questions</h2>
            <div class="space-y-6">
                @php
                $faqs = [
                    ['q' => 'What is a virtual assistant?', 'a' => 'A virtual assistant (VA) is a skilled professional who remotely supports your business with tasks like research, communication, content handling, admin work, project management, customer support, and ecommerce operations.'],
                    ['q' => 'How can a VA help my business grow?', 'a' => 'By taking over repetitive and time-consuming tasks, a VA helps you focus on sales, strategy, and business expansion — improving productivity and saving operational costs.'],
                    ['q' => 'Do you offer Amazon or ecommerce-related support?', 'a' => 'Yes! We assist with Amazon PPC, product research, listing optimization, A+ content, store management, competitor analysis, and daily operations.'],
                    ['q' => 'Is communication easy with your virtual assistants?', 'a' => 'Absolutely — our VAs maintain consistent communication via WhatsApp, email, Zoom, Google Workspace, and preferred project management tools.'],
                    ['q' => 'Do you provide customized VA plans?', 'a' => 'Yes, we offer flexible hourly, weekly, and monthly service packages tailored to your needs.']
                ];
                @endphp

                @foreach($faqs as $faq)
                <div class="p-6 bg-[#161616] border border-[#222] rounded-xl">
                    <h4 class="text-lg font-semibold mb-2 text-orange-300">{{ $faq['q'] }}</h4>
                    <p class="text-gray-300 leading-relaxed">{{ $faq['a'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Action Banner -->
    <section class="py-24 text-center bg-gradient-to-b from-[#1a1a1a] to-[#0b0b0b] border-t border-[#222]">
        <h2 class="text-4xl font-bold mb-4">Work Smarter with Professional Virtual Assistance</h2>
        <p class="text-gray-400 max-w-2xl mx-auto mb-6">Let our experts manage your operations, communication, and ecommerce tasks while you focus on scaling your business.</p>
        <button onclick="document.getElementById('audit-modal').classList.remove('hidden')" class="bg-orange-300 text-black px-10 py-4 rounded-xl text-lg font-semibold hover:opacity-80 transition shadow-xl inline-block">Book Free Consultation</button>
    </section>
</div>
@endsection
