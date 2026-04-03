<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - XpertVA Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
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
            
        </div>
    </div>

</div>

</body>
</html>
