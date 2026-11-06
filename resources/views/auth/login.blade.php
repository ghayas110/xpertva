<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - XpertVA Portal</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    {{-- Portal manifest, not the marketing one: this app opens on /dashboard. --}}
    <link rel="manifest" href="{{ asset('portal.webmanifest') }}">
    <meta name="theme-color" content="#0f172a">
    {{-- iOS ignores the manifest, so standalone mode is requested with these. --}}
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="XpertVA">
    <script>
        // Chrome fires this early, often before the body has parsed, so the
        // listener is registered here and the UI picks the event up later.
        window.__xvInstall = null;
        window.addEventListener('beforeinstallprompt', function (e) {
            e.preventDefault();
            window.__xvInstall = e;
            document.dispatchEvent(new CustomEvent('xv-install-ready'));
        });
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        /* A Tailwind display class such as inline-flex outranks the UA rule for
           the hidden attribute, so hidden elements would still paint. */
        [hidden] { display: none !important; }
        .bg-amazon-ops {
            background-image: linear-gradient(to right, rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.6)), url('/assets/images/amazon_operations.png');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="h-screen overflow-hidden flex items-center justify-center">

<div class="flex w-full h-full">

    <!-- Left side: Amazon Operations Image -->
    <div class="hidden lg:flex lg:w-1/2 bg-amazon-ops relative flex-col justify-between p-12 text-white">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-500 rounded flex items-center justify-center font-bold text-xl shadow-lg">
                    X
                </div>
                <h1 class="text-3xl font-bold tracking-tight">XpertVA</h1>
            </div>
        </div>
        
        <div class="max-w-xl">
            <h2 class="text-5xl font-extrabold mb-6 leading-tight">Master Your <span class="text-orange-400">Amazon Operations</span></h2>
            <p class="text-lg text-slate-300 font-light leading-relaxed mb-8">
                Empowering businesses with top-tier virtual assistance, seamless logistics management, deep analytics, and optimized e-commerce strategies. Log in to your hub.
            </p>
            <div class="flex gap-4">
                <span class="bg-white/10 px-4 py-2 rounded-full text-sm font-medium backdrop-blur-md border border-white/20"><i class="fa-brands fa-amazon text-orange-400 mr-2"></i> Amazon FBA</span>
                <span class="bg-white/10 px-4 py-2 rounded-full text-sm font-medium backdrop-blur-md border border-white/20"><i class="fa-solid fa-chart-line text-emerald-400 mr-2"></i> Logistics Intelligence</span>
            </div>
        </div>
        
        <div class="text-sm text-slate-400">
            &copy; {{ date('Y') }} XpertVA Global. All rights reserved.
        </div>
    </div>

    <!-- Right side: Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white overflow-y-auto">
        <div class="w-full max-w-md">
            
            <div class="lg:hidden flex items-center gap-3 mb-10 justify-center">
                <div class="w-10 h-10 bg-orange-500 rounded flex items-center justify-center text-white font-bold text-xl shadow-lg">
                    X
                </div>
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">XpertVA</h1>
            </div>

            <div class="mb-10 text-center lg:text-left">
                <h2 class="text-3xl font-bold text-slate-900 mb-2">Welcome Back</h2>
                <p class="text-slate-500">Please enter your details to sign in.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2" for="email">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-regular fa-envelope text-slate-400"></i>
                        </div>
                        <input class="block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all shadow-sm @error('email') border-red-500 focus:ring-red-500 @enderror" 
                            id="email" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm font-medium mt-2"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2" for="password">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-slate-400"></i>
                        </div>
                        <input class="block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all shadow-sm @error('password') border-red-500 focus:ring-red-500 @enderror" 
                            id="password" type="password" name="password" placeholder="••••••••" required>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm font-medium mt-2"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded cursor-pointer">
                        <label for="remember-me" class="ml-2 block text-sm text-slate-700 cursor-pointer">
                            Remember me
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors shadow-blue-500/30">
                        Sign In <i class="fa-solid fa-arrow-right-to-bracket ml-2"></i>
                    </button>
                </div>
            </form>

            {{-- Install the portal as an app. Shown only when installing is
                 actually possible, and never once it is already installed. --}}
            <div id="pwa-install" class="mt-8 border border-slate-200 rounded-xl p-5 bg-slate-50" hidden>
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-slate-900 text-white flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-semibold text-slate-900 text-sm">Install the portal on your phone</p>
                        <p class="text-slate-500 text-xs mt-1 leading-relaxed">
                            Adds an XpertVA icon to your home screen and opens the portal full screen, without browser bars.
                        </p>

                        {{-- Chrome, Edge, Samsung Internet on Android, and desktop Chrome. --}}
                        <button type="button" id="pwa-install-btn"
                                class="mt-3 w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold rounded-lg px-4 py-2.5 transition-colors"
                                hidden>
                            <i class="fa-solid fa-download"></i> Install app
                        </button>

                        {{-- iPhone and iPad: Safari has no install API, only the Share sheet. --}}
                        <ol id="pwa-ios" class="mt-3 text-xs text-slate-600 space-y-2 list-none" hidden>
                            <li class="flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded bg-slate-200 text-slate-700 text-[10px] font-bold grid place-items-center shrink-0 mt-px">1</span>
                                <span class="leading-relaxed">Tap <i class="fa-solid fa-arrow-up-from-bracket text-blue-600"></i> <strong>Share</strong> at the bottom of Safari</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded bg-slate-200 text-slate-700 text-[10px] font-bold grid place-items-center shrink-0 mt-px">2</span>
                                <span class="leading-relaxed">Scroll down and tap <strong>Add to Home Screen</strong></span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded bg-slate-200 text-slate-700 text-[10px] font-bold grid place-items-center shrink-0 mt-px">3</span>
                                <span class="leading-relaxed">Tap <strong>Add</strong>, then open XpertVA from your home screen</span>
                            </li>
                        </ol>

                        {{-- Anything else that can still add a shortcut manually. --}}
                        <p id="pwa-generic" class="mt-3 text-xs text-slate-600" hidden>
                            Open your browser menu and choose <strong>Add to Home screen</strong> or <strong>Install app</strong>.
                        </p>

                        <p id="pwa-done" class="mt-3 text-xs text-emerald-600 font-medium" hidden>
                            <i class="fa-solid fa-circle-check mr-1"></i> Installed. Open XpertVA from your home screen.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
(function () {
    var card    = document.getElementById('pwa-install');
    var btn     = document.getElementById('pwa-install-btn');
    var iosHelp = document.getElementById('pwa-ios');
    var generic = document.getElementById('pwa-generic');
    var done    = document.getElementById('pwa-done');
    if (!card) return;

    var ua = navigator.userAgent || '';
    // iPadOS 13+ reports itself as a Mac, so touch points disambiguate it.
    var isIOS = (/iPad|iPhone|iPod/.test(ua) && !window.MSStream) ||
                (/Macintosh/.test(ua) && navigator.maxTouchPoints > 1);
    var isSafari = /^((?!chrome|android|crios|fxios|edgios).)*safari/i.test(ua);
    var isMobile = isIOS || /Android|Mobile/i.test(ua);

    function installed() {
        return window.matchMedia('(display-mode: standalone)').matches ||
               window.navigator.standalone === true;
    }

    function show(el) { if (el) el.hidden = false; card.hidden = false; }

    if (installed()) return;  // nothing to offer

    // The service worker is what makes Chrome treat this as installable.
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw-notifications.js', { scope: '/' }).catch(function () {});
    }

    function offerNativePrompt() {
        show(btn);
        if (iosHelp) iosHelp.hidden = true;
        if (generic) generic.hidden = true;
    }

    if (window.__xvInstall) offerNativePrompt();
    document.addEventListener('xv-install-ready', offerNativePrompt);

    if (btn) {
        btn.addEventListener('click', function () {
            var evt = window.__xvInstall;
            if (!evt) return;
            btn.disabled = true;
            evt.prompt();
            evt.userChoice.then(function (choice) {
                window.__xvInstall = null;
                if (choice && choice.outcome === 'accepted') {
                    btn.hidden = true;
                    show(done);
                } else {
                    btn.disabled = false;
                }
            }).catch(function () { btn.disabled = false; });
        });
    }

    window.addEventListener('appinstalled', function () {
        if (btn) btn.hidden = true;
        if (iosHelp) iosHelp.hidden = true;
        if (generic) generic.hidden = true;
        show(done);
    });

    if (isIOS && isSafari) {
        show(iosHelp);
    } else if (isMobile) {
        // Chrome on Android usually fires beforeinstallprompt; give it a moment,
        // and only fall back to manual instructions if it never arrives.
        setTimeout(function () {
            if (!window.__xvInstall && (!btn || btn.hidden) && !installed()) show(generic);
        }, 1500);
    }
})();
</script>

</body>
</html>
