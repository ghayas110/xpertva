@extends('layouts.app')

@section('title', 'Services - XpertVA')

@section('content')
<section class="text-white overflow-hidden bg-black">
    <div class="absolute top-0 inset-0 z-0">
        <img alt="Work Background" width="1920" height="1000" decoding="async" class="opacity-80 w-full h-[600px]" src="{{ asset('assets/images/bg-services.jpg') }}"/>
    </div>
    <div class="relative z-10 max-w-8xl mx-auto px-4 md:px-10 pt-24 md:pt-36 pb-20">
        <div class="mb-12 pt-32 pl-2 sm:pl-8 md:pt-40 md:pl-20 text-left max-w-4xl">
            <h1 class="text-[6vw] sm:text-[4.5vw] md:text-[2.2vw] font-light mb-4 leading-tight">We provide a full range of web services</h1>
            <p class="text-sm sm:text-base md:text-lg text-gray-200 max-w-3xl">At XpertVA, we take a 360° approach to our projects. A successful digital experience requires the seamless integration of multiple elements, which is why our agency offers an array of services, from interface design to custom photography to digital marketing.</p>
        </div>
        
        <section class="relative bg-black text-white py-16 md:py-28 px-4 md:px-20">
            <div class="absolute inset-0 bg-gradient-to-b from-[#111] via-black to-black z-0 opacity-40"></div>
            <div class="relative z-10 max-w-7xl mx-auto">
                <h2 class="text-white text-[4vw] sm:text-[3vw] md:text-[2.2vw] mb-4 font-light">Our Professional Services</h2>
                <p class="text-gray-300 max-w-2xl mb-14">A complete suite of digital solutions designed to grow your brand and business.</p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                    <a href="{{ route('services.va') }}" class="bg-[#111] border border-neutral-800 rounded-2xl p-8 hover:border-gray-600 transition-all hover:-translate-y-1 group shadow-md block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lightbulb w-12 h-12 text-blue-400 mb-5 group-hover:scale-110 transition-all" aria-hidden="true"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"></path><path d="M9 18h6"></path><path d="M10 22h4"></path></svg>
                        <h3 class="text-xl font-semibold mb-3">Virtual Assistant Services</h3>
                        <p class="text-gray-400">Amazon, eBay, Shopify &amp; Walmart experts to manage your store end-to-end.</p>
                    </a>
                    
                    <a href="{{ route('services.marketing') }}" class="bg-[#111] border border-neutral-800 rounded-2xl p-8 hover:border-gray-600 transition-all hover:-translate-y-1 group shadow-md block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rocket w-12 h-12 text-blue-400 mb-5 group-hover:scale-110 transition-all" aria-hidden="true"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path></svg>
                        <h3 class="text-xl font-semibold mb-3">Marketing Solutions</h3>
                        <p class="text-gray-400">SEO, social media, PPC and conversion-focused campaigns.</p>
                    </a>
                    
                    <a href="{{ route('services.web-dev') }}" class="bg-[#111] border border-neutral-800 rounded-2xl p-8 hover:border-gray-600 transition-all hover:-translate-y-1 group shadow-md block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-code w-12 h-12 text-blue-400 mb-5 group-hover:scale-110 transition-all" aria-hidden="true"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
                        <h3 class="text-xl font-semibold mb-3">Web Development</h3>
                        <p class="text-gray-400">Custom websites, WordPress, E-Commerce, UI/UX &amp; branding.</p>
                    </a>

                    <a href="{{ route('services.amazon-ops') }}" class="bg-[#111] border border-neutral-800 rounded-2xl p-8 hover:border-gray-600 transition-all hover:-translate-y-1 group shadow-md block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart w-12 h-12 text-blue-400 mb-5 group-hover:scale-110 transition-all" aria-hidden="true"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>
                        <h3 class="text-xl font-semibold mb-3">Amazon Operations</h3>
                        <p class="text-gray-400">Listings, optimization, product research &amp; full store management.</p>
                    </a>

                    <a href="{{ route('services.content-branding') }}" class="bg-[#111] border border-neutral-800 rounded-2xl p-8 hover:border-gray-600 transition-all hover:-translate-y-1 group shadow-md block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pen-tool w-12 h-12 text-blue-400 mb-5 group-hover:scale-110 transition-all" aria-hidden="true"><path d="M15.707 21.293a1 1 0 0 1-1.414 0l-1.586-1.586a1 1 0 0 1 0-1.414l5.586-5.586a1 1 0 0 1 1.414 0l1.586 1.586a1 1 0 0 1 0 1.414z"></path><path d="m18 13-1.375-6.874a1 1 0 0 0-.746-.776L3.235 2.028a1 1 0 0 0-1.207 1.207L5.35 15.879a1 1 0 0 0 .776.746L13 18"></path><path d="m2.3 2.3 7.286 7.286"></path><circle cx="11" cy="11" r="2"></circle></svg>
                        <h3 class="text-xl font-semibold mb-3">Content &amp; Branding</h3>
                        <p class="text-gray-400">Brand identity, creative graphics, video editing &amp; product photography.</p>
                    </a>

                    <a href="{{ route('services.mobile-app') }}" class="bg-[#111] border border-neutral-800 rounded-2xl p-8 hover:border-gray-600 transition-all hover:-translate-y-1 group shadow-md block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-cpu w-12 h-12 text-blue-400 mb-5 group-hover:scale-110 transition-all" aria-hidden="true"><path d="M12 20v2"></path><path d="M12 2v2"></path><path d="M17 20v2"></path><path d="M17 2v2"></path><path d="M2 12h2"></path><path d="M2 17h2"></path><path d="M2 7h2"></path><path d="M20 12h2"></path><path d="M20 17h2"></path><path d="M20 7h2"></path><path d="M7 20v2"></path><path d="M7 2v2"></path><rect x="4" y="4" width="16" height="16" rx="2"></rect><rect x="8" y="8" width="8" height="8" rx="1"></rect></svg>
                        <h3 class="text-xl font-semibold mb-3">Mobile App Development</h3>
                        <p class="text-gray-400">Custom mobile apps for iOS and Android with user-focused design.</p>
                    </a>
                </div>
            </div>
        </section>

        <section class="relative bg-black text-white py-16 md:py-24 px-4 md:px-20">
            <div class="max-w-6xl mx-auto text-center">
                <h2 class="text-[4vw] sm:text-[4vw] md:text-[4vw] font-light mb-6">Why Choose Us</h2>
                <p class="text-gray-300 max-w-2xl mx-auto mb-16">We ensure premium quality, consistent communication, and real measurable results.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mt-12">
                    <div class="p-8 border border-neutral-800 rounded-2xl bg-[#0d0d0d] shadow-lg hover:border-gray-600 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe w-12 h-12 mb-4 text-blue-400 mx-auto" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path><path d="M2 12h20"></path></svg>
                        <h3 class="text-xl font-semibold mb-2">Global Expertise</h3>
                        <p class="text-gray-400 text-sm">We work with international clients across US, UK, UAE &amp; Europe.</p>
                    </div>
                    
                    <div class="p-8 border border-neutral-800 rounded-2xl bg-[#0d0d0d] shadow-lg hover:border-gray-600 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-12 h-12 mb-4 text-blue-400 mx-auto" aria-hidden="true"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path></svg>
                        <h3 class="text-xl font-semibold mb-2">Fast &amp; Reliable</h3>
                        <p class="text-gray-400 text-sm">Quick delivery, transparent reports, and tracked progress.</p>
                    </div>
                    
                    <div class="p-8 border border-neutral-800 rounded-2xl bg-[#0d0d0d] shadow-lg hover:border-gray-600 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rocket w-12 h-12 mb-4 text-blue-400 mx-auto" aria-hidden="true"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path></svg>
                        <h3 class="text-xl font-semibold mb-2">Results Focused</h3>
                        <p class="text-gray-400 text-sm">Everything we do aims to grow your brand and revenue.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="relative w-full h-[60vh] overflow-hidden bg-black">
            <img alt="Call to Action Background" class="opacity-90 absolute h-full w-full left-0 top-0 object-cover" src="{{ asset('assets/images/bg-call.jpg') }}"/>
            <div class="relative z-10 flex flex-col sm:flex-row items-center justify-center sm:justify-between h-full px-6 sm:px-12 max-w-7xl mx-auto text-center sm:text-left">
                <div class="text-white text-2xl sm:text-4xl md:text-6xl font-semibold leading-snug sm:leading-tight">
                    <p>Have an idea?</p>
                    <p>Let’s bring it to life</p>
                </div>
                <button onclick="document.getElementById('contact-modal').classList.remove('hidden')" class="mt-8 bg-[#6563ff] text-white rounded-full w-32 h-32 text-lg hover:bg-indigo-600 transition-all duration-300">
                    Get started
                </button>
            </div>
        </section>

  
    </div>
</section>
@endsection
