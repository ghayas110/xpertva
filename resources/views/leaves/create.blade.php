@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold dark:text-white">Request Leave</h1>
        <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Policy: 1 casual leave allowed per month. Additional leaves will result in salary deduction.</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 dark:bg-red-900/30 dark:border-red-800 dark:text-red-300 px-4 py-3 rounded relative mb-6">
            <ul class="list-disc ml-5 mt-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-200 dark:border-slate-700 rounded-lg px-8 pt-6 pb-8 mb-4">
        <form action="{{ route('leaves.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2" for="type">
                    Leave Type
                </label>
                <select name="type" id="type" class="shadow-sm border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white rounded w-full py-2.5 px-3 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="casual">Casual</option>
                    <option value="sick">Sick</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2" for="start_date">
                        Start Date
                    </label>
                    <input class="shadow-sm border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white rounded w-full py-2.5 px-3 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="start_date" name="start_date" type="date" required min="{{ date('Y-m-d') }}">
                </div>
                <div>
                    <label class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2" for="end_date">
                        End Date
                    </label>
                    <input class="shadow-sm border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white rounded w-full py-2.5 px-3 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="end_date" name="end_date" type="date" required min="{{ date('Y-m-d') }}">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2" for="reason">
                    Reason
                </label>
                <textarea class="shadow-sm border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white rounded w-full py-2 px-3 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400 dark:placeholder-slate-400" id="reason" name="reason" rows="4" required placeholder="Please provide details for your leave request..."></textarea>
            </div>

            <div class="flex items-center justify-between pt-2">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-slate-800 transition-colors" type="submit">
                    Submit Request
                </button>
                <a href="{{ route('leaves.index') }}" class="inline-block align-baseline font-medium text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
