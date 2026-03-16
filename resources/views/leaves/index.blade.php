@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold dark:text-white">Leave Requests</h1>
        @if(auth()->user()->role !== 'hr' && auth()->user()->role !== 'admin')
            <a href="{{ route('leaves.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700 transition-colors">Request Leave</a>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 dark:bg-emerald-900/30 dark:border-emerald-800 dark:text-emerald-400 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800 shadow-md border border-slate-200 dark:border-slate-700 rounded my-6 overflow-x-auto">
        <table class="text-left w-full border-collapse">
            <thead>
                <tr>
                    <th class="py-4 px-6 bg-slate-50 dark:bg-slate-700/50 font-bold text-sm text-slate-700 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700">Employee</th>
                    <th class="py-4 px-6 bg-slate-50 dark:bg-slate-700/50 font-bold text-sm text-slate-700 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700">Dates</th>
                    <th class="py-4 px-6 bg-slate-50 dark:bg-slate-700/50 font-bold text-sm text-slate-700 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700">Type</th>
                    <th class="py-4 px-6 bg-slate-50 dark:bg-slate-700/50 font-bold text-sm text-slate-700 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700">Status</th>
                    <th class="py-4 px-6 bg-slate-50 dark:bg-slate-700/50 font-bold text-sm text-slate-700 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700">Paid/Deducted</th>
                    <th class="py-4 px-6 bg-slate-50 dark:bg-slate-700/50 font-bold text-sm text-slate-700 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaves as $leave)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="py-4 px-6 border-b border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300">{{ $leave->user->name }}</td>
                        <td class="py-4 px-6 border-b border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300">
                            {{ $leave->start_date->format('M d, Y') }} - {{ $leave->end_date->format('M d, Y') }}
                        </td>
                        <td class="py-4 px-6 border-b border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 capitalize">{{ $leave->type }}</td>
                        <td class="py-4 px-6 border-b border-slate-200 dark:border-slate-700">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $leave->status === 'approved' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400' : '' }}
                                {{ $leave->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                {{ $leave->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}">
                                {{ ucfirst($leave->status) }}
                            </span>
                        </td>
                        <td class="py-4 px-6 border-b border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300">
                            @if($leave->status === 'approved')
                                <span class="{{ $leave->is_paid ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }} font-semibold">
                                    {{ $leave->is_paid ? 'Paid' : 'Deducted' }}
                                </span>
                            @else
                                <span class="text-slate-400 dark:text-slate-500">-</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 border-b border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300">
                            @if(auth()->user()->role === 'hr' || auth()->user()->role === 'admin')
                                <a href="{{ route('leaves.edit', $leave) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">Review</a>
                            @else
                                <button type="button" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium" onclick="alert('Reason: {{ addslashes($leave->reason) }}\n\nAdmin Remarks: {{ addslashes($leave->admin_remarks ?? 'None') }}')">View</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 px-6 text-center text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">No leave requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
