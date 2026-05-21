@extends('layouts.dashboard')

@section('title', 'Your Profile')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Your Profile</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage your personal information, password, and contact details.</p>
        </div>
    </div>

    {{-- Profile Info --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700">
            <h2 class="font-semibold text-slate-800 dark:text-white"><i class="fa-regular fa-user mr-2 text-indigo-500"></i>Profile Information</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Update your picture, name, and primary email.</p>
        </div>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            @method('PATCH')

            <div class="flex items-center gap-5">
                <img src="{{ $user->avatar_url }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover ring-4 ring-indigo-50 dark:ring-slate-700">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Profile Picture</label>
                    <input type="file" name="avatar" class="block text-sm text-slate-600 dark:text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-xs text-slate-400 mt-1">Any file type, any size.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-700 dark:text-slate-200">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Primary Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-700 dark:text-slate-200">
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Save Changes</button>
            </div>
        </form>
    </div>

    {{-- Contact Info --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700">
            <h2 class="font-semibold text-slate-800 dark:text-white"><i class="fa-solid fa-address-card mr-2 text-indigo-500"></i>Contact Details</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Add or update phone numbers and a secondary email.</p>
        </div>
        <form action="{{ route('profile.contact') }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Primary Phone</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+1 555 000 0000" class="w-full bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-700 dark:text-slate-200">
                    <p class="text-xs text-slate-400 mt-1">Full international format with country code.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Secondary Phone</label>
                    <input type="tel" name="secondary_phone" value="{{ old('secondary_phone', $user->secondary_phone) }}" placeholder="+1 555 000 0000" class="w-full bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-700 dark:text-slate-200">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Secondary Email</label>
                    <input type="email" name="secondary_email" value="{{ old('secondary_email', $user->secondary_email) }}" placeholder="you@example.com" class="w-full bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-700 dark:text-slate-200">
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Save Contact Info</button>
            </div>
        </form>
    </div>

    {{-- Password --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700">
            <h2 class="font-semibold text-slate-800 dark:text-white"><i class="fa-solid fa-lock mr-2 text-indigo-500"></i>Change Password</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Use a strong password you don't reuse elsewhere.</p>
        </div>
        <form action="{{ route('profile.password') }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Current Password</label>
                    <input type="password" name="current_password" required class="w-full bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-700 dark:text-slate-200">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">New Password</label>
                    <input type="password" name="password" required class="w-full bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-700 dark:text-slate-200">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Confirm New Password</label>
                    <input type="password" name="password_confirmation" required class="w-full bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-700 dark:text-slate-200">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">Forgot password? Reset via login</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Update Password</button>
            </div>
        </form>
    </div>

</div>
@endsection
