@extends('layouts.app')

@section('title', 'XpertVA - Professional Virtual Assistant Services')

@section('content')
<!-- Hero Section -->
<section class="text-white flex flex-col px-4 sm:px-6 md:px-12 py-24 sm:py-32 md:py-44 text-center">
    <div class="w-full mt-10">
        <h1 class="text-3xl sm:text-4xl md:text-7xl font-light mb-8 leading-snug md:leading-tight">A complete suite of digital solutions <br class="hidden md:block"/>designed to grow <span class="text-indigo-500 font-medium transition-all duration-500">BSR Optimization</span></h1>
        
        <div class="w-full mt-12 sm:mt-16 md:mt-20 mx-auto">
            <video autoplay loop muted playsinline class="w-full max-w-7xl mx-auto rounded-xl shadow-xl border border-gray-700 cursor-pointer" title="Click to toggle mute">
                <source src="{{ asset('assets/videos/hero-video.mp4') }}" type="video/mp4"/>
                Your browser does not support video.
            </video>
        </div>
    </div>
</section>

<!-- Values Section -->
<div class="transition-all duration-700 w-full bg-cover bg-center">
    <div class="min-h-64 border-t border-white flex items-center text-white transition-all duration-700 px-6 sm:px-12 md:px-24 justify-start text-left">
        <h2 class="text-4xl sm:text-5xl md:text-7xl font-medium transform transition-all duration-700 ease-out -translate-x-10 opacity-50">Create</h2>
    </div>
    <div class="min-h-64 border-t border-white flex items-center text-white transition-all duration-700 px-6 sm:px-12 md:px-24 justify-end text-right">
        <h2 class="text-4xl sm:text-5xl md:text-7xl font-medium transform transition-all duration-700 ease-out -translate-x-10 opacity-50">Collaborate</h2>
    </div>
    <div class="min-h-64 border-t border-white flex items-center text-white transition-all duration-700 border-b px-6 sm:px-12 md:px-24 justify-start text-left">
        <h2 class="text-4xl sm:text-5xl md:text-7xl font-medium transform transition-all duration-700 ease-out -translate-x-10 opacity-50">Disrupt</h2>
    </div>
    <div class="bg-black/60 text-white flex flex-col md:flex-row justify-end px-6 sm:px-12 py-12 space-y-8 md:space-y-0">
        <p class="text-base sm:text-lg md:w-1/2 leading-relaxed">We view our clients as creative partners.</p>
        <p class="text-base sm:text-lg md:w-1/2 leading-relaxed">Together, we transform digital platforms through the fusion of diverse ideas.</p>
    </div>
</div>

<!-- What We Do -->
<section class="py-24 bg-black text-white px-6 sm:px-12 md:px-24">
    <div class="flex justify-between items-center mb-16">
        <h2 class="text-4xl font-semibold">What We Do</h2>
        <a href="{{ route('services.index') }}" class="text-indigo-400 hover:text-indigo-300 flex items-center gap-2 group">
            All Services <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="group-hover:translate-x-1 transition-transform"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
        </a>
    </div>

    <!-- Service Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @php
        $main_services = [
            ['title' => 'Amazon Services', 'icon' => 'shopping-cart', 'url' => route('services.amazon'), 'color' => 'text-yellow-400'],
            ['title' => 'eBay Services', 'icon' => 'package', 'url' => route('services.ebay'), 'color' => 'text-blue-400'],
            ['title' => 'Shopify Services', 'icon' => 'globe', 'url' => route('services.shopify'), 'color' => 'text-green-400'],
            ['title' => 'Walmart Services', 'icon' => 'store', 'url' => route('services.walmart'), 'color' => 'text-blue-500']
        ];
        @endphp

        @foreach($main_services as $service)
        <a href="{{ $service['url'] }}" class="group bg-gray-900/50 border border-gray-800 p-10 rounded-3xl hover:bg-gray-800/50 transition duration-500">
            <h3 class="text-2xl font-semibold mb-4 {{ $service['color'] }}">{{ $service['title'] }}</h3>
            <p class="text-gray-400 mb-8 leading-relaxed">Expert management and growth strategies tailored for {{ $service['title'] }}.</p>
            <div class="flex justify-end">
                <div class="w-12 h-12 bg-white/5 rounded-full flex items-center justify-center group-hover:bg-indigo-600 transition duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>

<!-- Success Stories -->
<section class="py-24 bg-[#050505] text-white px-6 sm:px-12 md:px-24">
    <div class="text-center mb-20">
        <h2 class="text-4xl md:text-6xl font-bold mb-6">Success Stories</h2>
        <p class="text-gray-400 max-w-2xl mx-auto text-lg">Real results from brands who trusted us. Explore how we helped them grow, scale, and succeed.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
        <article class="bg-[#111] border border-gray-800 rounded-3xl overflow-hidden group">
            <div class="aspect-video overflow-hidden">
                <img src="{{ asset('assets/images/1st-quarter.jpg') }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500"/>
            </div>
            <div class="p-8">
                <h3 class="text-xl font-semibold mb-2">1st Quarter Sales</h3>
                <p class="text-indigo-400 text-sm mb-4 font-medium uppercase tracking-wider">Case Study</p>
                <p class="text-gray-400 line-clamp-3">Virtual Assistant Service Boosted Sales by 3x. Delivered $976,715.50 in ordered product sales.</p>
            </div>
        </article>
        
        <article class="bg-[#111] border border-gray-800 rounded-3xl overflow-hidden group">
            <div class="aspect-video overflow-hidden">
                <img src="{{ asset('assets/images/last-quarter.jpg') }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500"/>
            </div>
            <div class="p-8">
                <h3 class="text-xl font-semibold mb-2">Last Quarter Sales</h3>
                <p class="text-indigo-400 text-sm mb-4 font-medium uppercase tracking-wider">Case Study</p>
                <p class="text-gray-400 line-clamp-3">Virtual Assistant Service Boosted Sales by 6x. Generating $9,226,488.00 in ordered product sales.</p>
            </div>
        </article>

        <article class="bg-[#111] border border-gray-800 rounded-3xl overflow-hidden group">
            <div class="aspect-video overflow-hidden">
                <img src="{{ asset('assets/images/SDS.jpg') }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500"/>
            </div>
            <div class="p-8">
                <h3 class="text-xl font-semibold mb-2">3 Months Sales</h3>
                <p class="text-indigo-400 text-sm mb-4 font-medium uppercase tracking-wider">Case Study</p>
                <p class="text-gray-400 line-clamp-3">Virtual Assistant Service Boosted Sales by 10x. Resulting in $2,086,577.20 in ordered product sales.</p>
            </div>
        </article>
    </div>
</section>

<!-- CTA Section -->


 <section class="relative w-full h-[60vh] overflow-hidden bg-black"><img alt="Call to Action Background"
                decoding="async" data-nimg="fill" class="opacity-90"
                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;object-fit:cover;color:transparent"
                src="../assets/images/bg-call.jpg" />
            <div
                class="relative z-10 flex flex-col sm:flex-row items-center sm:items-center justify-center sm:justify-between h-full px-6 sm:px-12 max-w-7xl mx-auto text-center sm:text-left">
                <div class="text-white text-2xl sm:text-4xl md:text-6xl font-semibold leading-snug sm:leading-tight">
                    <p>Have an idea?</p>
                    <p>Let’s bring it to life</p>
                </div><button
                    class="mt-8 sm:mt-0 sm:absolute sm:bottom-8 sm:right-8 flex items-center justify-center  w-14 h-14 text-sm font-medium rounded-full  bg-[#6563ff] text-white hover:bg-indigo-600  transition-all duration-300 sm:w-32 sm:h-32 sm:text-lg"><span
                        class="hidden sm:inline">Get started</span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-arrow-up-right w-5 h-5 sm:ml-2" aria-hidden="true">
                        <path d="M7 7h10v10"></path>
                        <path d="M7 17 17 7"></path>
                    </svg></button>
            </div>
        </section>
@endsection
