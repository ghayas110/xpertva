@extends('layouts.app')

@section('title', 'Work - XpertVA')

@section('content')
<section class="text-white overflow-hidden bg-black min-h-screen relative">
    <!-- Background Image -->
    <div class="absolute top-0 inset-0 z-0 h-[60vh]">
        <img alt="Work Background" class="opacity-80 w-full h-full object-cover" src="{{ asset('assets/images/bg-work.jpg') }}"/>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black"></div>
    </div>

    <div class="relative z-10 px-4 md:px-10 pt-36 pb-20 max-w-7xl mx-auto">
        <!-- Hero Section -->
        <div class="mb-12 pt-16 md:pt-32 px-4 md:px-12 text-left max-w-full">
            <h1 class="text-4xl md:text-7xl font-bold mb-6 text-white">Work</h1>
            <p class="text-lg md:text-2xl text-gray-200 max-w-4xl leading-relaxed">
                We follow a creative step-by-step process to transform your vision into reality by creating a digital identity that integrates diverse marketing elements to resonate with your target audience. Explore our work by clicking on a case study below.
            </p>
        </div>

        <!-- Category Filter -->
        <div class="relative mb-16 px-4 md:px-12 max-w-[100vw] overflow-hidden md:overflow-visible">
            <div class="relative group flex items-center">
                <!-- Scroll Left Button -->
                <button id="scroll-left-btn" class="absolute left-0 z-20 w-8 h-8 md:w-10 md:h-10 md:-ml-5 rounded-full bg-[#111] border border-white/20 text-white flex items-center justify-center shadow-[0_0_15px_rgba(0,0,0,0.8)] hover:bg-[#222] transition-colors hidden cursor-pointer">
                    <i class="fa-solid fa-arrow-left text-xs md:text-sm"></i>
                </button>

                <div id="category-bar" class="flex gap-4 md:gap-6 overflow-x-auto pb-4 border-b border-white/10 no-scrollbar scroll-smooth w-full px-8 md:px-12">
                    @php
                    $categories = [
                        'All', 'Keyword Research', 'Infographics', 'Listing Optimization', 
                        'MAP Enforcement', 'A to Z Claim', 'Amazon Cases', 'Account Health', 
                        'Listing Issues', 'A+ Premium', 'Storefront Creation', 
                        'Amazon PPC Optimization', 'Coupon & Promotion', 
                        'Reimbursement', 'Success Stories'
                    ];
                    @endphp
                    
                    @foreach($categories as $index => $cat)
                    <button class="category-btn text-sm font-medium whitespace-nowrap px-4 py-2 border-b-2 transition-all duration-300 {{ $index === 0 ? 'border-indigo-500 text-white' : 'border-transparent text-gray-400 hover:text-white' }}" data-category="{{ $cat }}">
                        {{ $cat }}
                    </button>
                    @endforeach
                </div>

                <!-- Scroll Right Button -->
                <button id="scroll-right-btn" class="absolute right-0 z-20 w-8 h-8 md:w-10 md:h-10 md:-mr-5 rounded-full bg-[#111] border border-white/20 text-white flex items-center justify-center shadow-[0_0_15px_rgba(0,0,0,0.8)] hover:bg-[#222] transition-colors flex cursor-pointer">
                    <i class="fa-solid fa-arrow-right text-xs md:text-sm"></i>
                </button>
            </div>
        </div>

        <!-- Portfolio Grid -->
        <div id="portfolio-grid" class="grid grid-cols-1 md:grid-cols-2 gap-8 px-4 md:px-12">
            @php
            $portfolio = [
                // INFOGRAPHICS
                ['title' => 'Collins smart Ceiling fan', 'cat' => 'Infographics', 'img' => 'images/fan.jpg', 'desc' => 'Infographics & lifestyle images.'],
                ['title' => 'Rechargeable table lamps', 'cat' => 'Infographics', 'img' => 'images/lightning-lamp.jpg', 'desc' => 'Lighting solutions for modern living.'],
                ['title' => 'Legrand - 15a Self Test Outlet', 'cat' => 'Infographics', 'img' => 'images/self-test-outlet.jpg', 'desc' => 'Product feature highlights.'],
                ['title' => 'BUBRITE:Traverse LED', 'cat' => 'Infographics', 'img' => 'images/Transverse-led.jpg', 'desc' => 'High quality rendering.'],
                ['title' => 'Chandelier Lift System', 'cat' => 'Infographics', 'img' => 'images/chandelier-lift-system.jpg', 'desc' => 'Infographics integration.'],

                // A TO Z CLAIM
                ['title' => 'A to Z Claim Success', 'cat' => 'A to Z Claim', 'img' => 'A-to-z Guarantee Claims/1.jpg', 'desc' => 'Claim dispute resolution'],
                ['title' => 'A to Z Claim Success', 'cat' => 'A to Z Claim', 'img' => 'A-to-z Guarantee Claims/2.jpg', 'desc' => 'Claim dispute resolution'],
                ['title' => 'A to Z Claim Success', 'cat' => 'A to Z Claim', 'img' => 'A-to-z Guarantee Claims/3.jpg', 'desc' => 'Claim dispute resolution'],
                ['title' => 'A to Z Claim Success', 'cat' => 'A to Z Claim', 'img' => 'A-to-z Guarantee Claims/4.jpg', 'desc' => 'Claim dispute resolution'],
                ['title' => 'A to Z Claim Success', 'cat' => 'A to Z Claim', 'img' => 'A-to-z Guarantee Claims/5.jpg', 'desc' => 'Claim dispute resolution'],

                // ACCOUNT HEALTH
                ['title' => 'Account Health Safety', 'cat' => 'Account Health', 'img' => 'Account Health/c3hrneItb1.jpg', 'desc' => 'Account reinstatement & health'],

                // AMAZON CASES
                ['title' => 'Amazon Case Resolve', 'cat' => 'Amazon Cases', 'img' => 'Amazon Cases/1.jpg', 'desc' => 'Seller support resolution'],
                ['title' => 'Amazon Case Resolve', 'cat' => 'Amazon Cases', 'img' => 'Amazon Cases/2.jpg', 'desc' => 'Seller support resolution'],
                ['title' => 'Amazon Case Resolve', 'cat' => 'Amazon Cases', 'img' => 'Amazon Cases/3.jpg', 'desc' => 'Seller support resolution'],
                ['title' => 'Amazon Case Resolve', 'cat' => 'Amazon Cases', 'img' => 'Amazon Cases/4.jpg', 'desc' => 'Seller support resolution'],
                ['title' => 'Amazon Case Resolve', 'cat' => 'Amazon Cases', 'img' => 'Amazon Cases/5.jpg', 'desc' => 'Seller support resolution'],
                ['title' => 'Amazon Case Resolve', 'cat' => 'Amazon Cases', 'img' => 'Amazon Cases/6.jpg', 'desc' => 'Seller support resolution'],
                ['title' => 'Amazon Case Resolve', 'cat' => 'Amazon Cases', 'img' => 'Amazon Cases/8.jpg', 'desc' => 'Seller support resolution'],
                ['title' => 'Amazon Case Resolve', 'cat' => 'Amazon Cases', 'img' => 'Amazon Cases/9.jpg', 'desc' => 'Seller support resolution'],
                ['title' => 'Amazon Case Resolve', 'cat' => 'Amazon Cases', 'img' => 'Amazon Cases/10.jpg', 'desc' => 'Seller support resolution'],

                // KEYWORD RESEARCH
                ['title' => 'Keyword Optimization', 'cat' => 'Keyword Research', 'img' => 'Keyword Research/final.jpg', 'desc' => 'Search volume & rank tracking'],

                // LISTING ISSUES
                ['title' => 'Listing Fix', 'cat' => 'Listing Issues', 'img' => 'Listing Issues/74qzypE9bI.jpg', 'desc' => 'Stranded inventory fixed'],
                ['title' => 'Listing Fix', 'cat' => 'Listing Issues', 'img' => 'Listing Issues/867qLvJCNQ.jpg', 'desc' => 'Category approvals'],
                ['title' => 'Listing Fix', 'cat' => 'Listing Issues', 'img' => 'Listing Issues/VbUbvEIDmB.jpg', 'desc' => 'Suppressed listing active'],
                ['title' => 'Listing Fix', 'cat' => 'Listing Issues', 'img' => 'Listing Issues/fAYJdtfv2V.jpg', 'desc' => 'Error 5665 / 8541 resolution'],

                // LISTING OPTIMIZATION
                ['title' => 'Listing Rank Boost', 'cat' => 'Listing Optimization', 'img' => 'Listing Optimization/final-1.jpg', 'desc' => 'SEO optimized copy'],

                // MAP ENFORCEMENT
                ['title' => 'Pricing Control', 'cat' => 'MAP Enforcement', 'img' => 'MAP Enforcement/All Blur 2.png', 'desc' => 'Unauthorized seller removal'],

                // PPC OPTIMIZATION
                ['title' => 'PPC ACOS Drop', 'cat' => 'Amazon PPC Optimization', 'img' => 'PPC Campaign Management & Optimization/TCWQ4nKt8K.jpg', 'desc' => 'Ad spend efficiency'],
                ['title' => 'PPC Sales Boost', 'cat' => 'Amazon PPC Optimization', 'img' => 'PPC Campaign Management & Optimization/gA69WkFEUI.jpg', 'desc' => 'Campaign structure overview'],

                // A+ PREMIUM
                ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'Premium-Basic A%2B Content/54kbqy3MU4.jpg', 'desc' => 'Brand registry EBC'],
                ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'Premium-Basic A%2B Content/DO4pwaZzIp.jpg', 'desc' => 'Brand registry EBC'],
                ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'Premium-Basic A%2B Content/QlRcqWsLX5.jpg', 'desc' => 'Brand registry EBC'],
                ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'Premium-Basic A%2B Content/SIc4i0qSam.jpg', 'desc' => 'Brand registry EBC'],
                ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'Premium-Basic A%2B Content/UzpT4epgtC.jpg', 'desc' => 'Brand registry EBC'],
                ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'Premium-Basic A%2B Content/uRaNcIWJHx.jpg', 'desc' => 'Brand registry EBC'],
                ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'Premium-Basic A%2B Content/xuJ2Pv0W3g.jpg', 'desc' => 'Brand registry EBC'],
                ['title' => 'A+ Module Design', 'cat' => 'A+ Premium', 'img' => 'Premium-Basic A%2B Content/yzDXOce00J.jpg', 'desc' => 'Brand registry EBC'],

                // STOREFRONT
                ['title' => 'Brand Storefront', 'cat' => 'Storefront Creation', 'img' => 'Storefront/b1lyQ4S1zi.jpg', 'desc' => 'Custom branded pages'],
                ['title' => 'Brand Storefront', 'cat' => 'Storefront Creation', 'img' => 'Storefront/yOhjU6le9N.jpg', 'desc' => 'Custom branded pages'],

                // COUPON & PROMO
                ['title' => 'Promo Success', 'cat' => 'Coupon & Promotion', 'img' => 'Coupon & Promotion Management/Coupon.png', 'desc' => 'Sales velocity increment'],
                ['title' => 'Promo Success', 'cat' => 'Coupon & Promotion', 'img' => 'Coupon & Promotion Management/Running Coupon.png', 'desc' => 'Velocity campaign'],

                // REIMBURSEMENT
                ['title' => 'FBA Reimbursement', 'cat' => 'Reimbursement', 'img' => 'Reimbursement/1.jpg', 'desc' => 'Lost inventory recovered'],
                ['title' => 'FBA Reimbursement', 'cat' => 'Reimbursement', 'img' => 'Reimbursement/2.jpg', 'desc' => 'Lost inventory recovered'],
                ['title' => 'FBA Reimbursement', 'cat' => 'Reimbursement', 'img' => 'Reimbursement/3.jpg', 'desc' => 'Lost inventory recovered'],

                // SUCCESS STORIES
                ['title' => 'SDS Account Growth', 'cat' => 'Success Stories', 'img' => 'SDS Account - success story/March 2024.jpg', 'desc' => 'Yearly growth metrics'],
                ['title' => 'SDS Account Growth', 'cat' => 'Success Stories', 'img' => 'SDS Account - success story/Last 3 month 2025.jpg', 'desc' => 'Quarterly progress'],
                ['title' => 'SDS Account Growth', 'cat' => 'Success Stories', 'img' => 'SDS Account - success story/2024 1st quater.jpg', 'desc' => 'Sales explosion'],
                ['title' => 'SDS Account Growth', 'cat' => 'Success Stories', 'img' => 'SDS Account - success story/2024 Last Quater.jpg', 'desc' => 'Peak season review'],
                ['title' => 'SDS Account Growth', 'cat' => 'Success Stories', 'img' => 'SDS Account - success story/Sep 2024.jpg', 'desc' => 'Constant momentum'],
                
                ['title' => 'Tubelox Toyz Growth', 'cat' => 'Success Stories', 'img' => 'Tubelox Toyz Sales/1st Qtr 2024.png', 'desc' => 'Bestseller rankings'],
                ['title' => 'Tubelox Toyz Growth', 'cat' => 'Success Stories', 'img' => 'Tubelox Toyz Sales/4th Qtr 2024.png', 'desc' => 'Holiday rush sales'],
            ];
            @endphp

            @foreach($portfolio as $item)
            <div class="portfolio-item relative rounded-2xl overflow-hidden group cursor-pointer bg-[#111] border border-white/5 hover:border-indigo-500/50 transition-all duration-500" data-category="{{ $item['cat'] }}">
                <div class="aspect-[4/3] overflow-hidden">
                    <img alt="{{ $item['title'] }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" src="{{ asset('assets/' . $item['img']) }}"/>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-100 group-hover:via-black/40 transition-all duration-500"></div>
                <div class="absolute bottom-8 left-8 right-8 text-white z-10 transition-transform duration-500 group-hover:-translate-y-2">
                    <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest mb-3 block">{{ $item['cat'] }}</span>
                    <h3 class="text-2xl font-bold mb-2">{{ $item['title'] }}</h3>
                    <p class="text-sm text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity duration-300">{{ $item['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.category-btn');
    const portfolioItems = document.querySelectorAll('.portfolio-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const category = button.getAttribute('data-category');

            // Update button styles
            filterButtons.forEach(btn => {
                btn.classList.remove('border-indigo-500', 'text-white');
                btn.classList.add('border-transparent', 'text-gray-400');
            });
            button.classList.add('border-indigo-500', 'text-white');
            button.classList.remove('border-transparent', 'text-gray-400');

            // Filter items
            portfolioItems.forEach(item => {
                if (category === 'All' || item.getAttribute('data-category') === category) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1)';
                    }, 10);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        });
    });

    // --- Scrolling Logic ---
    const catBar = document.getElementById('category-bar');
    const scrollLeftBtn = document.getElementById('scroll-left-btn');
    const scrollRightBtn = document.getElementById('scroll-right-btn');

    if (scrollLeftBtn && scrollRightBtn && catBar) {
        scrollLeftBtn.addEventListener('click', () => {
            catBar.scrollBy({ left: -300, behavior: 'smooth' });
        });

        scrollRightBtn.addEventListener('click', () => {
            catBar.scrollBy({ left: 300, behavior: 'smooth' });
        });

        const updateScrollButtons = () => {
            // Check if we can scroll left
            if (catBar.scrollLeft <= 5) {
                scrollLeftBtn.classList.remove('flex');
                scrollLeftBtn.classList.add('hidden');
            } else {
                scrollLeftBtn.classList.add('flex');
                scrollLeftBtn.classList.remove('hidden');
            }
            
            // Check if we can scroll right
            if (Math.ceil(catBar.scrollLeft + catBar.clientWidth) >= catBar.scrollWidth - 5) {
                scrollRightBtn.classList.remove('flex');
                scrollRightBtn.classList.add('hidden');
            } else {
                scrollRightBtn.classList.add('flex');
                scrollRightBtn.classList.remove('hidden');
            }
        };

        catBar.addEventListener('scroll', updateScrollButtons);
        window.addEventListener('resize', updateScrollButtons);
        
        // Initial check 
        setTimeout(updateScrollButtons, 100);
    }
});
</script>

<style>
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
@endsection
