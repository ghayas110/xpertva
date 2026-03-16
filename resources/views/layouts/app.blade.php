<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'XpertVA - Professional Virtual Assistant Services')</title>
    <meta name="description" content="@yield('meta_description', 'Professional virtual assistant services to help you grow your business. Streamline operations, manage ecommerce stores, support Amazon sellers, and more.')">
    
    <!-- Original Preloads -->
    <link rel="preload" as="image" href="/logos/FLY.png"/><link rel="preload" as="image" href="/logos/GAX.png"/><link rel="preload" as="image" href="/logos/GLOBAL WALKOUT.png"/><link rel="preload" as="image" href="/logos/GRAPEXX.png"/><link rel="preload" as="image" href="/logos/GYMKHANA.png"/><link rel="preload" as="image" href="/logos/H.png"/><link rel="preload" as="image" href="/logos/HOLIDAY APARTMENT.png"/><link rel="preload" as="image" href="/logos/HOMELUX.png"/><link rel="preload" as="image" href="/logos/LONDON LABS.png"/><link rel="preload" as="image" href="/logos/LOOKSMITT.png"/>
    <link rel="preload" as="image" href="/logos/NOVAVITA NUTRITION.png"/><link rel="preload" as="image" href="/logos/OFFICE-SUPPLY.png"/><link rel="preload" as="image" href="/logos/Trecto Solution.png"/><link rel="preload" as="image" href="/logos/WE LOVE RESTURANT.png"/><link rel="preload" as="image" href="/logos/eq sport.png"/><link rel="preload" as="image" href="/logos/humminghemp.png"/><link rel="preload" as="image" href="/logos/stand-store.png"/><link rel="preload" as="image" href="{{ asset('assets/images/bg-call.jpg') }}"/>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    
    @stack('head')
</head>
<body class="geist_a71539c9-module__T19VSG__variable geist_mono_8d43a2aa-module__8Li5zG__variable antialiased overflow-x-hidden">
    
    <!-- Header -->
    <header class="w-full fixed top-0 left-0 z-50 px-4 sm:px-8 md:px-12 py-4 flex items-center justify-between transition-all duration-500 ease-in-out bg-transparent py-6">
        <div class="transition-all duration-500 ease-in-out translate-x-2">
            <a href="{{ route('home') }}">
                <img alt="iDC Logo" width="128" height="128" decoding="async" class="w-24 md:w-32 h-auto cursor-pointer" src="{{ asset('assets/images/logo-xpertva.png') }}">
            </a>
        </div>
        <div class="transition-all duration-500 ease-in-out hidden md:block opacity-100 scale-100">
            <button class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2 rounded-full flex items-center gap-2" onclick="document.getElementById('contact-modal').classList.remove('hidden')">
                Get in touch 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-right" aria-hidden="true">
                    <path d="M7 7h10v10"></path>
                    <path d="M7 17 17 7"></path>
                </svg>
            </button>
        </div>
        <div id="hamburger-btn" class="text-white flex items-center gap-2 cursor-pointer" onclick="document.getElementById('menu-modal').classList.remove('hidden')">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5m-16.5 6h16.5m-16.5 6h16.5"></path>
            </svg>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-black text-white py-16 text-sm">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between gap-12">
            <div class="flex-1 flex justify-center md:justify-start hidden md:flex">
                <img alt="iDC Logo" loading="lazy" width="100" height="100" class="h-20 cursor-pointer" src="{{ asset('assets/images/logo-xpertva.png') }}">
            </div>
            <div class="flex-[2] grid grid-cols-2 gap-8 md:gap-6 text-white">
                <ul class="space-y-2">
                    <li class="flex items-center justify-between border-b border-gray-700 py-2 cursor-pointer hover:text-gray-400 transition-colors">
                        <a href="{{ route('home') }}" class="flex items-center justify-between w-full">Home <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-right" aria-hidden="true"><path d="M7 7h10v10"></path><path d="M7 17 17 7"></path></svg></a>
                    </li>
                    <li class="flex items-center justify-between border-b border-gray-700 py-2 cursor-pointer hover:text-gray-400 transition-colors">
                        <a href="{{ route('work') }}" class="flex items-center justify-between w-full">Work <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-right" aria-hidden="true"><path d="M7 7h10v10"></path><path d="M7 17 17 7"></path></svg></a>
                    </li>
                    <li class="flex items-center justify-between border-b border-gray-700 py-2 cursor-pointer hover:text-gray-400 transition-colors">
                        <a href="{{ route('services.index') }}" class="flex items-center justify-between w-full">Services <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-right" aria-hidden="true"><path d="M7 7h10v10"></path><path d="M7 17 17 7"></path></svg></a>
                    </li>
                    <li class="flex items-center justify-between border-b border-gray-700 py-2 cursor-pointer hover:text-gray-400 transition-colors">
                        <a href="{{ route('contact') }}" class="flex items-center justify-between w-full">Contact <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-right" aria-hidden="true"><path d="M7 7h10v10"></path><path d="M7 17 17 7"></path></svg></a>
                    </li>
                </ul>
                <ul class="space-y-2">
                    <li class="flex items-center justify-between border-b border-gray-700 py-2 cursor-pointer hover:text-gray-400 transition-colors">
                        <a href="{{ route('privacy-policy') }}" class="flex items-center justify-between w-full">Privacy Policy <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-right" aria-hidden="true"><path d="M7 7h10v10"></path><path d="M7 17 17 7"></path></svg></a>
                    </li>
                    <li class="flex items-center justify-between border-b border-gray-700 py-2 cursor-pointer hover:text-gray-400 transition-colors">
                        <a href="{{ route('team') }}" class="flex items-center justify-between w-full">Team <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-right" aria-hidden="true"><path d="M7 7h10v10"></path><path d="M7 17 17 7"></path></svg></a>
                    </li>
                    <li class="flex items-center justify-between border-b border-gray-700 py-2 cursor-pointer hover:text-gray-400 transition-colors">
                        <a href="{{ route('blog.index') }}" class="flex items-center justify-between w-full">Blog <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-right" aria-hidden="true"><path d="M7 7h10v10"></path><path d="M7 17 17 7"></path></svg></a>
                    </li>
                </ul>
            </div>
            <div class="flex-1 text-right space-y-4">
                <div class="flex justify-end items-center gap-4 mb-4">
                    <a href="https://www.facebook.com/xpertva" target="_blank" class="text-white hover:text-gray-400"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z"></path></svg></a>
                    <a href="https://www.instagram.com/xpertva/" target="_blank" class="text-white hover:text-gray-400"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M13.0281 2.00073C14.1535 2.00259 14.7238 2.00855 15.2166 2.02322L15.4107 2.02956C15.6349 2.03753 15.8561 2.04753 16.1228 2.06003C17.1869 2.1092 17.9128 2.27753 18.5503 2.52503C19.2094 2.7792 19.7661 3.12253 20.3219 3.67837C20.8769 4.2342 21.2203 4.79253 21.4753 5.45003C21.7219 6.0867 21.8903 6.81337 21.9403 7.87753C21.9522 8.1442 21.9618 8.3654 21.9697 8.58964L21.976 8.78373C21.9906 9.27647 21.9973 9.84686 21.9994 10.9723L22.0002 11.7179C22.0003 11.809 22.0003 11.903 22.0003 12L22.0002 12.2821L21.9996 13.0278C21.9977 14.1532 21.9918 14.7236 21.9771 15.2163L21.9707 15.4104C21.9628 15.6347 21.9528 15.8559 21.9403 16.1225C21.8911 17.1867 21.7219 17.9125 21.4753 18.55C21.2211 19.2092 20.8769 19.7659 20.3219 20.3217C19.7661 20.8767 19.2069 21.22 18.5503 21.475C17.9128 21.7217 17.1869 21.89 16.1228 21.94C15.8561 21.9519 15.6349 21.9616 15.4107 21.9694L15.2166 21.9757C14.7238 21.9904 14.1535 21.997 13.0281 21.9992L12.2824 22C12.1913 22 12.0973 22 12.0003 22L11.7182 22L10.9725 21.9993C9.8471 21.9975 9.27672 21.9915 8.78397 21.9768L8.58989 21.9705C8.36564 21.9625 8.14444 21.9525 7.87778 21.94C6.81361 21.8909 6.08861 21.7217 5.45028 21.475C4.79194 21.2209 4.23444 20.8767 3.67861 20.3217C3.12278 19.7659 2.78028 19.2067 2.52528 18.55C2.27778 17.9125 2.11028 17.1867 2.06028 16.1225C2.0484 15.8559 2.03871 15.6347 2.03086 15.4104L2.02457 15.2163C2.00994 14.7236 2.00327 14.1532 2.00111 13.0278L2.00098 10.9723C2.00284 9.84686 2.00879 9.27647 2.02346 8.78373L2.02981 8.58964C2.03778 8.3654 2.04778 8.1442 2.06028 7.87753C2.10944 6.81253 2.27778 6.08753 2.52528 5.45003C2.77944 4.7917 3.12278 4.2342 3.67861 3.67837C4.23444 3.12253 4.79278 2.78003 5.45028 2.52503C6.08778 2.27753 6.81278 2.11003 7.87778 2.06003C8.14444 2.04816 8.36564 2.03847 8.58989 2.03062L8.78397 2.02433C9.27672 2.00969 9.8471 2.00302 10.9725 2.00086L13.0281 2.00073ZM12.0003 7.00003C9.23738 7.00003 7.00028 9.23956 7.00028 12C7.00028 14.7629 9.23981 17 12.0003 17C14.7632 17 17.0003 14.7605 17.0003 12C17.0003 9.23713 14.7607 7.00003 12.0003 7.00003ZM12.0003 9.00003C13.6572 9.00003 15.0003 10.3427 15.0003 12C15.0003 13.6569 13.6576 15 12.0003 15C10.3434 15 9.00028 13.6574 9.00028 12C9.00028 10.3431 10.3429 9.00003 12.0003 9.00003ZM17.2503 5.50003C16.561 5.50003 16.0003 6.05994 16.0003 6.74918C16.0003 7.43843 16.5602 7.9992 17.2503 7.9992C17.9395 7.9992 18.5003 7.4393 18.5003 6.74918C18.5003 6.05994 17.9386 5.49917 17.2503 5.50003Z"></path></svg></a>
                </div>
                <div class="text-gray-500 text-xs mt-2">© {{ date('Y') }}. XPERTVA. All Rights Reserved.</div>
            </div>
        </div>
    </footer>

    <!-- Modals -->
    @include('partials.modals')

    <!-- Scripts -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')
    <script>
        // Basic modal toggle logic
        document.querySelectorAll('.modal-close').forEach(btn => {
            btn.onclick = () => {
                btn.closest('.fixed').classList.add('hidden');
            };
        });
        document.getElementById('hamburger-btn').onclick = () => {
             document.getElementById('menu-modal').classList.remove('hidden');
        };
    </script>
</body>
</html>
