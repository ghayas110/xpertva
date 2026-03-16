@extends('layouts.dashboard')

@section('title', 'HR Progress Report')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Company Progress Report</h2>
    <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Showing data for Current Month</p>
</div>



    <div class="bg-white dark:bg-slate-800 rounded shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-slate-700 text-gray-700 dark:text-slate-300 border-b">
                    <th class="py-3 px-6">Employee</th>
                    <th class="py-3 px-6">Role / Region</th>
                    <th class="py-3 px-6 text-center">Current Status</th>
                    <th class="py-3 px-6 text-center">Hours Logged</th>
                    <th class="py-3 px-6 text-center">Total Tasks</th>
                    <th class="py-3 px-6 text-center">Tasks Completed</th>
                    <th class="py-3 px-6 text-center">Tasks Pending</th>
                    <th class="py-3 px-6 text-center">Efficiency</th>
                    <th class="py-3 px-6 text-center">Est. Salary</th>
                </tr>
            </thead>
            <tbody>
                @foreach($progressData as $emp)
                <tr class="border-b hover:bg-gray-50 dark:bg-slate-700">
                    <td class="py-3 px-6 font-bold">{{ $emp['name'] }}</td>
                    <td class="py-3 px-6 text-sm text-gray-600 dark:text-slate-400">
                        {{ ucfirst(str_replace('_', ' ', $emp['role'])) }}<br>
                        <span class="text-xs text-gray-400">{{ $emp['region'] ?? 'N/A' }}</span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <span class="w-3 h-3 rounded-full inline-block mr-1 
                            @if($emp['status'] == 'online') bg-green-500 @else bg-gray-400 @endif"></span>
                        <span class="text-sm">{{ ucfirst($emp['status']) }}</span>
                    </td>
                    <td class="py-3 px-6 text-center font-bold">{{ $emp['formatted_time'] }}</td>
                    <td class="py-3 px-6 text-center font-bold">{{ $emp['tasks_total'] }}</td>
                    <td class="py-3 px-6 text-center text-green-600 font-bold">{{ $emp['tasks_completed'] }}</td>
                    <td class="py-3 px-6 text-center text-orange-500 font-bold">{{ $emp['tasks_pending'] }}</td>
                    <td class="py-3 px-6 text-center font-mono">
                        @if($emp['hours_this_month'] > 0)
                            {{ number_format($emp['tasks_completed'] / $emp['hours_this_month'], 2) }} T/h
                        @else
                            -
                        @endif
                    </td>
                    <td class="py-3 px-6 text-center">
                        @if($emp['base_salary'] > 0)
                            <div class="text-sm" title="{{ $emp['days_absent'] }} days absent">
                                @if($emp['days_absent'] > 2)
                                    <span class="text-red-500 text-xs block mb-1">({{ $emp['days_absent'] - 2 }} penalty days)</span>
                                    <span class="text-gray-400 line-through text-xs">Rs {{ number_format($emp['base_salary'], 0) }}</span>
                                @else
                                    <span class="text-gray-400 text-xs">Rs {{ number_format($emp['base_salary'], 0) }}</span>
                                @endif
                                <span class="text-green-600 font-bold block">Rs {{ number_format($emp['earned_salary'], 0) }}</span>
                            </div>
                        @else
                            <span class="text-gray-400 text-sm">N/A</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
