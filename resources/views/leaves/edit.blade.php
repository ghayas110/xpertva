@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold dark:text-white">Review Leave Request</h1>
            <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Employee: <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $leave->user->name }}</span> ({{ $leave->type }} leave)</p>
        </div>
        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
            {{ $leave->status === 'approved' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400' : '' }}
            {{ $leave->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
            {{ $leave->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}">
            {{ ucfirst($leave->status) }}
        </span>
    </div>

    <div class="bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg p-5 mb-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">Dates Of Leave:</p>
                <p class="text-slate-900 dark:text-slate-100">{{ $leave->start_date->format('M d, Y') }} - {{ $leave->end_date->format('M d, Y') }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">Days Difference Calculation:</p>
                <p class="text-slate-900 dark:text-slate-100">{{ $leave->start_date->diffInDays($leave->end_date) + 1 }} Days</p>
            </div>
            <div class="col-span-2 mt-3">
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Reason Provided:</p>
                <p class="text-slate-900 dark:text-slate-200 bg-white dark:bg-slate-800 p-3 border border-slate-200 dark:border-slate-700 rounded leading-relaxed">{{ $leave->reason }}</p>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 dark:bg-red-900/30 dark:border-red-800 dark:text-red-300 px-4 py-3 rounded relative mb-6">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-200 dark:border-slate-700 rounded-lg px-8 pt-6 pb-8">
        <form action="{{ route('leaves.update', $leave) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2" for="status">
                    Action Decision
                </label>
                <select name="status" id="status" class="shadow-sm border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white rounded w-full py-2.5 px-3 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="" disabled {{ $leave->status === 'pending' ? 'selected' : '' }}>Select Action</option>
                    <option value="approved" {{ $leave->status === 'approved' ? 'selected' : '' }}>Approve Request</option>
                    <option value="rejected" {{ $leave->status === 'rejected' ? 'selected' : '' }}>Reject Request</option>
                </select>
                <p class="text-xs text-indigo-600 dark:text-indigo-400 font-medium italic mt-2">Note: Policy dictates max 1 paid casual leave per month. If approved and they exceed 1 casual leave, the system will automatically mark it as deducted.</p>
            </div>

            <div class="mb-6">
                <label class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2" for="admin_remarks">
                    HR / Admin Remarks (Optional)
                </label>
                <textarea class="shadow-sm border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white rounded w-full py-2 px-3 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400 dark:placeholder-slate-400" id="admin_remarks" name="admin_remarks" rows="3" placeholder="Provide reason for rejection, or general notes...">{{ old('admin_remarks', $leave->admin_remarks) }}</textarea>
            </div>

            <div class="flex items-center justify-between pt-2">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-slate-800 transition-colors" type="submit">
                    Save Decision
                </button>
                <a href="{{ route('leaves.index') }}" class="inline-block align-baseline font-medium text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                    Cancel & Return
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
