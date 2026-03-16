<!DOCTYPE html>
<html lang="en" :class="{ 'dark': darkMode }" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Portal</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js for interactivity (sidebar, dropdowns) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom scrollbar for sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        /* Chart specific stylings */
        .chart-container {
            position: relative;
            height: 100%;
            width: 100%;
        }
    </style>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>
<body class="text-slate-800 dark:text-slate-200 antialiased bg-[#f8fafc] dark:bg-slate-900 transition-colors duration-300" x-data="{ sidebarOpen: true, profileDropdownOpen: false, notificationsOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="flex-shrink-0 bg-white dark:bg-slate-800 border-r border-slate-200 dark:border-slate-700 transition-all duration-300 flex flex-col z-20 h-full">
            <!-- Logo area -->
            <div class="h-16 flex items-center justify-between px-4 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center gap-3 overflow-hidden">
                    <img src="{{ asset('assets/images/logo-xpertva.png') }}" alt="XpertVA" class="w-8 h-8 rounded flex-shrink-0 object-contain">
                    <span x-show="sidebarOpen" x-transition.opacity class="font-bold text-xl text-slate-800 dark:text-white tracking-tight whitespace-nowrap">XpertVA</span>
                </div>
                <!-- Mobile close button -->
                <button @click="sidebarOpen = false" class="md:hidden text-slate-500 hover:text-slate-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto sidebar-scroll py-4 px-3 space-y-1">
                <p x-show="sidebarOpen" class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 mt-4 transition-opacity">Menu</p>
                
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white' }} transition-colors group">
                    <i class="fa-solid fa-border-all w-5 text-center {{ request()->routeIs('dashboard') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-200' }}"></i>
                    <span x-show="sidebarOpen" class="font-medium whitespace-nowrap transition-opacity">Dashboard</span>
                </a>

                <a href="{{ route('tasks.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('tasks.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white' }} transition-colors group">
                    <i class="fa-solid fa-list-check w-5 text-center {{ request()->routeIs('tasks.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-200' }}"></i>
                    <span x-show="sidebarOpen" class="font-medium whitespace-nowrap transition-opacity">Tasks</span>
                </a>

                @if(in_array(auth()->user()->role, ['super_admin', 'sales', 'onboarding', 'va', 'hr', 'accounts']))
                <a href="{{ route('clients.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('clients.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white' }} transition-colors group">
                    <i class="fa-solid fa-users w-5 text-center {{ request()->routeIs('clients.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-200' }}"></i>
                    <span x-show="sidebarOpen" class="font-medium whitespace-nowrap transition-opacity">Clients</span>
                </a>
                @endif

                @if(in_array(auth()->user()->role, ['super_admin', 'accounts', 'hr']))
                <a href="{{ route('financials.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('financials.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white' }} transition-colors group">
                    <i class="fa-solid fa-file-invoice-dollar w-5 text-center {{ request()->routeIs('financials.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-200' }}"></i>
                    <span x-show="sidebarOpen" class="font-medium whitespace-nowrap transition-opacity">Financials</span>
                </a>
                @endif

                @if(in_array(auth()->user()->role, ['super_admin', 'hr']))
                <a href="{{ route('hr.progress') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('hr.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white' }} transition-colors group">
                    <i class="fa-solid fa-chart-line w-5 text-center {{ request()->routeIs('hr.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-200' }}"></i>
                    <span x-show="sidebarOpen" class="font-medium whitespace-nowrap transition-opacity">Progress Report</span>
                </a>
                @endif

                <a href="{{ route('attendance.my') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('attendance.my') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white' }} transition-colors group">
                    <i class="fa-solid fa-calendar-days w-5 text-center {{ request()->routeIs('attendance.my') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-200' }}"></i>
                    <span x-show="sidebarOpen" class="font-medium whitespace-nowrap transition-opacity">My Attendance</span>
                </a>

                @if(in_array(auth()->user()->role, ['super_admin', 'hr']))
                <a href="{{ route('attendance.manage') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('attendance.manage') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white' }} transition-colors group">
                    <i class="fa-solid fa-users-viewfinder w-5 text-center {{ request()->routeIs('attendance.manage') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-200' }}"></i>
                    <span x-show="sidebarOpen" class="font-medium whitespace-nowrap transition-opacity">Attendance Management</span>
                </a>
                @endif

                <a href="{{ route('leaves.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('leaves.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white' }} transition-colors group">
                    <i class="fa-solid fa-calendar-check w-5 text-center {{ request()->routeIs('leaves.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-200' }}"></i>
                    <span x-show="sidebarOpen" class="font-medium whitespace-nowrap transition-opacity">Leaves</span>
                </a>

                <a href="{{ route('webmail.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('webmail.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white' }} transition-colors group">
                    <i class="fa-solid fa-envelope w-5 text-center {{ request()->routeIs('webmail.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-200' }}"></i>
                    <span x-show="sidebarOpen" class="font-medium whitespace-nowrap transition-opacity">Email</span>
                </a>

                <a href="{{ route('messages.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('messages.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white' }} transition-colors group relative">
                    <i class="fa-regular fa-envelope w-5 text-center {{ request()->routeIs('messages.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-200' }}"></i>
                    <span x-show="sidebarOpen" class="font-medium whitespace-nowrap transition-opacity">Inbox</span>
                    <!-- Example badge -->
                    <!-- <span x-show="sidebarOpen" class="absolute right-3 top-1/2 -translate-y-1/2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">3</span> -->
                </a>

                @if(auth()->user()->role === 'super_admin')
                <p x-show="sidebarOpen" class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 mt-6 transition-opacity">Admin</p>
                <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('users.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white' }} transition-colors group">
                    <i class="fa-solid fa-user-gear w-5 text-center {{ request()->routeIs('users.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-200' }}"></i>
                    <span x-show="sidebarOpen" class="font-medium whitespace-nowrap transition-opacity">Employees</span>
                </a>
                <a href="{{ route('admin.activities') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.activities') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white' }} transition-colors group">
                    <i class="fa-solid fa-desktop w-5 text-center {{ request()->routeIs('admin.activities') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-200' }}"></i>
                    <span x-show="sidebarOpen" class="font-medium whitespace-nowrap transition-opacity">Activity Monitor</span>
                </a>
                <a href="{{ route('admin.blogs.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.blogs.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white' }} transition-colors group">
                    <i class="fa-solid fa-blog w-5 text-center {{ request()->routeIs('admin.blogs.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-200' }}"></i>
                    <span x-show="sidebarOpen" class="font-medium whitespace-nowrap transition-opacity">Blogs</span>
                </a>
                @endif

            </nav>

            <!-- Bottom settings / logout area -->
            <div class="p-4 border-t border-slate-200 dark:border-slate-700">
                <!-- Toggle sidebar button (desktop only) -->
                <button @click="sidebarOpen = !sidebarOpen" class="hidden md:flex w-full items-center justify-center py-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors bg-slate-50 dark:bg-slate-700 hover:bg-slate-100 dark:hover:bg-slate-600 rounded-lg mb-2">
                    <i class="fa-solid fa-chevron-left transition-transform duration-300" :class="!sidebarOpen && 'rotate-180'"></i>
                </button>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <!-- Top Header -->
            <header class="h-16 bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between px-4 sm:px-6 lg:px-8 shrink-0 z-10">
                
                <div class="flex items-center gap-4 flex-1">
                    <button @click="sidebarOpen = true" class="md:hidden text-slate-500 hover:text-slate-700">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    
                    <!-- Search Bar -->
                    <div class="hidden sm:flex relative max-w-md w-full items-center">
                        <i class="fa-solid fa-search absolute left-3 text-slate-400"></i>
                        <input type="text" placeholder="Search or type command..." class="w-full bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg pl-10 pr-12 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-700 dark:text-slate-200 placeholder-slate-400">
                        <div class="absolute right-3 flex items-center">
                            <kbd class="hidden sm:inline-block border border-slate-200 rounded px-1.5 text-[10px] font-sans font-medium text-slate-400 bg-white">⌘ K</kbd>
                        </div>
                    </div>
                </div>

                <!-- Right Nav -->
                <div class="flex items-center gap-3 sm:gap-5">
                    
                    <!-- Clock-in/out form embedded in the button for simplicity -->
                    <form action="{{ route('attendance.toggle') }}" method="POST" class="m-0">
                        @csrf
                        @if(auth()->user()->status === 'online')
                            <button type="submit" class="hidden sm:flex items-center gap-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors border border-emerald-200">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Online (Clock Out)
                            </button>
                            <!-- Mobile version icon -->
                            <button type="submit" class="sm:hidden flex items-center justify-center w-8 h-8 rounded-full bg-emerald-50 text-emerald-600">
                                <i class="fa-solid fa-toggle-on"></i>
                            </button>
                        @else
                            <button type="submit" class="hidden sm:flex items-center gap-2 bg-slate-100 text-slate-600 hover:bg-slate-200 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors border border-slate-200">
                                <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                Offline (Clock In)
                            </button>
                            <!-- Mobile version icon -->
                            <button type="submit" class="sm:hidden flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-500">
                                <i class="fa-solid fa-toggle-off"></i>
                            </button>
                        @endif
                    </form>

                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 dark:hover:bg-slate-700">
                        <i class="fa-regular fa-moon" x-show="!darkMode"></i>
                        <i class="fa-regular fa-sun text-yellow-400" x-show="darkMode" x-cloak></i>
                    </button>

                    <!-- Notifications -->
                    <div class="relative" @click.away="notificationsOpen = false">
                        <button @click="notificationsOpen = !notificationsOpen" class="relative text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 dark:hover:bg-slate-700">
                            <i class="fa-regular fa-bell"></i>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] bg-red-500 text-white text-[10px] font-bold flex items-center justify-center rounded-full border-2 border-white dark:border-slate-800">{{ auth()->user()->unreadNotifications->count() }}</span>
                            @endif
                        </button>

                        <!-- Notifications Dropdown -->
                        <div x-show="notificationsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" x-cloak class="absolute right-0 mt-2 w-80 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-200 dark:border-slate-700 z-50 overflow-hidden">
                            <div class="px-4 py-3 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                                <h3 class="font-semibold text-sm text-slate-800 dark:text-white">Notifications</h3>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <form action="{{ route('notifications.markAllRead') }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="text-xs text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 font-medium">Mark all read</button>
                                    </form>
                                @endif
                            </div>
                            <div class="max-h-72 overflow-y-auto">
                                @forelse(auth()->user()->notifications()->latest()->take(10)->get() as $notification)
                                    <a href="{{ isset($notification->data['task_id']) ? route('tasks.index') . '?open_task=' . $notification->data['task_id'] : '#' }}" class="block px-4 py-3 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors border-b border-slate-100 dark:border-slate-700/50 {{ is_null($notification->read_at) ? 'bg-indigo-50/50 dark:bg-indigo-900/20' : '' }}">
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 {{ is_null($notification->read_at) ? 'bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400' : 'bg-slate-100 dark:bg-slate-700 text-slate-400' }}">
                                                <i class="{{ $notification->data['icon'] ?? 'fa-solid fa-bell' }} text-sm"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $notification->data['title'] ?? 'Notification' }}</p>
                                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 truncate">{{ $notification->data['message'] ?? '' }}</p>
                                                <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                            @if(is_null($notification->read_at))
                                                <span class="w-2 h-2 rounded-full bg-indigo-500 mt-2 shrink-0"></span>
                                            @endif
                                        </div>
                                    </a>
                                @empty
                                    <div class="px-4 py-8 text-center">
                                        <i class="fa-regular fa-bell-slash text-3xl text-slate-300 dark:text-slate-600 mb-2"></i>
                                        <p class="text-sm text-slate-400 dark:text-slate-500">No notifications yet</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative ml-2" @click.away="profileDropdownOpen = false">
                        <button @click="profileDropdownOpen = !profileDropdownOpen" class="flex items-center gap-2 focus:outline-none">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=E0E7FF&color=4F46E5" alt="Profile" class="h-8 w-8 rounded-full object-cover ring-2 ring-white dark:ring-slate-700 shadow-sm">
                            <span class="hidden md:block text-sm font-medium text-slate-700 dark:text-slate-200">{{ explode(' ', trim(auth()->user()->name))[0] }}</span>
                            <i class="fa-solid fa-chevron-down text-xs text-slate-400 hidden md:block"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="profileDropdownOpen" x-transition.enter="transition ease-out duration-100" x-transition.enter-start="transform opacity-0 scale-95" x-transition.enter-end="transform opacity-100 scale-100" x-transition.leave="transition ease-in duration-75" x-transition.leave-start="transform opacity-100 scale-100" x-transition.leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700 py-1 z-50 hidden" :class="{'hidden': !profileDropdownOpen}">
                            <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-700">
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ auth()->user()->email }}</p>
                                <p class="text-xs text-indigo-600 dark:text-indigo-400 mt-1 uppercase font-semibold">{{ str_replace('_', ' ', auth()->user()->role) }}</p>
                            </div>
                            <a href="#" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">Your Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">Settings</a>
                            
                            <form action="{{ route('logout') }}" method="POST" class="border-t border-slate-100 dark:border-slate-700 m-0">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-[#f8fafc] dark:bg-slate-900 p-4 sm:p-6 lg:p-8 transition-colors duration-300">
                @if(session('success'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-lg mb-6 shadow-sm flex items-start">
                        <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 mr-3"></i>
                        <div>
                            <p class="font-medium">Success</p>
                            <p class="text-sm mt-1">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-r-lg mb-6 shadow-sm flex items-start">
                        <i class="fa-solid fa-circle-xmark text-red-500 mt-0.5 mr-3"></i>
                        <div>
                            <p class="font-medium">Error</p>
                            <p class="text-sm mt-1">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-r-lg mb-6 shadow-sm flex items-start">
                        <i class="fa-solid fa-triangle-exclamation text-red-500 mt-0.5 mr-3"></i>
                        <div>
                            <p class="font-medium">Please fix the following validation errors:</p>
                            <ul class="list-disc ml-5 mt-1 text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
            
        </div>
    </div>
    
    @stack('scripts')

    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let activeTime = 0;
            let idleTime = 0;
            let mouseMoveCount = 0;
            let clickCount = 0;
            let keystrokeCount = 0;
            let isIdle = false;
            let idleTimer = null;
            const IDLE_TIMEOUT = 30000; // 30 seconds of no activity = idle
            const SYNC_INTERVAL = 60000; // Sync every 60 seconds

            // Reset idle timer on any activity
            function resetIdleTimer() {
                if (isIdle) {
                    isIdle = false;
                }
                clearTimeout(idleTimer);
                idleTimer = setTimeout(() => {
                    isIdle = true;
                }, IDLE_TIMEOUT);
            }

            // Track mouse moves
            document.addEventListener('mousemove', function() {
                mouseMoveCount++;
                resetIdleTimer();
            });

            // Track clicks
            document.addEventListener('click', function() {
                clickCount++;
                resetIdleTimer();
            });

            // Track keystrokes
            document.addEventListener('keydown', function() {
                keystrokeCount++;
                resetIdleTimer();
            });

            // Time counting loop (runs every second)
            setInterval(() => {
                if (isIdle) {
                    idleTime++;
                } else {
                    activeTime++;
                }
            }, 1000);

            // Start initial timer
            resetIdleTimer();

            // Sync with server
            setInterval(() => {
                // Prepare payload
                const payload = {
                    url: window.location.href,
                    active_time: activeTime,
                    idle_time: idleTime,
                    mouse_move_count: mouseMoveCount,
                    click_count: clickCount,
                    keystroke_count: keystrokeCount,
                    _token: '{{ csrf_token() }}'
                };

                // Fast reset local counters so we don't double count if request fails/delays
                activeTime = 0;
                idleTime = 0;
                mouseMoveCount = 0;
                clickCount = 0;
                keystrokeCount = 0;

                fetch('{{ route("activity.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(payload)
                }).catch(error => console.error('Error syncing activity:', error));

            }, SYNC_INTERVAL);
        });
    </script>
    @endauth
</body>
</html>
