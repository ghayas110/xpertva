@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold dark:text-white">Attendance Management</h1>
            <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Select an employee to review their attendance and leave records.</p>
        </div>

        <!-- Employee Selection Form -->
        <form action="{{ route('attendance.manage') }}" method="GET" class="flex items-center space-x-2">
            <select name="user_id" onchange="this.form.submit()" class="shadow-sm border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white rounded py-2 px-3 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 min-w-[250px]">
                <option value="">-- Select Employee --</option>
                @foreach($users as $userOption)
                    <option value="{{ $userOption->id }}" {{ ($selectedUser && $selectedUser->id === $userOption->id) ? 'selected' : '' }}>
                        {{ $userOption->name }} ({{ $userOption->role ?? 'Employee' }})
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    @if(!$selectedUser)
        <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-200 dark:border-slate-700 rounded-lg p-12 text-center text-slate-500 dark:text-slate-400">
            <svg class="w-12 h-12 mx-auto mb-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <p>Please select an employee from the dropdown above to view their calendar.</p>
        </div>
    @elseif(empty($calendarData['years']))
        <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-200 dark:border-slate-700 rounded-lg p-8 text-center">
            <h3 class="text-lg font-medium text-slate-900 dark:text-white mb-2">No Records Found</h3>
            <p class="text-slate-500 dark:text-slate-400"><strong>{{ $selectedUser->name }}</strong> does not have any physical attendance or leave records yet.</p>
        </div>
    @else

        <!-- Overall Stats Accordion (Closed by default) -->
        <div class="mb-6 border border-slate-200 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 overflow-hidden shadow-sm" x-data="{ expandedStats: false }">
            <button @click="expandedStats = !expandedStats" class="w-full px-6 py-4 flex justify-between items-center bg-slate-50 dark:bg-slate-800/50 hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors">
                <span class="text-lg font-bold text-slate-800 dark:text-slate-200">Overall Statistics ({{ $selectedUser->name }})</span>
                <svg class="w-5 h-5 text-slate-500 transform transition-transform duration-200" :class="{'rotate-180': expandedStats}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="expandedStats" x-collapse class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 p-4 rounded-lg shadow-sm border border-emerald-100 dark:border-emerald-800/50 text-center">
                        <p class="text-sm font-medium uppercase tracking-wider">Total Days Present</p>
                        <p class="text-3xl font-bold mt-2">{{ $calendarData['overall_totals']['present'] }}</p>
                    </div>
                    <div class="bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 p-4 rounded-lg shadow-sm border border-red-100 dark:border-red-800/50 text-center">
                        <p class="text-sm font-medium uppercase tracking-wider">Total Absentee</p>
                        <p class="text-3xl font-bold mt-2">{{ $calendarData['overall_totals']['absent'] }}</p>
                    </div>
                    <div class="bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 p-4 rounded-lg shadow-sm border border-amber-100 dark:border-amber-800/50 text-center">
                        <p class="text-sm font-medium uppercase tracking-wider">Total Leaves</p>
                        <p class="text-3xl font-bold mt-2">{{ $calendarData['overall_totals']['leaves'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        @php
            $years = array_keys($calendarData['years']);
            $hasMultipleYears = count($years) > 1;
        @endphp

        <div x-data="{ selectedYear: {{ $years[0] }} }">
            
            @if($hasMultipleYears)
            <!-- Year Filter -->
            <div class="mb-4 flex space-x-2">
                @foreach($years as $yr)
                    <button @click="selectedYear = {{ $yr }}" 
                            :class="{'bg-indigo-600 text-white border-indigo-600': selectedYear === {{ $yr }}, 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700': selectedYear !== {{ $yr }}}"
                            class="px-4 py-2 rounded-lg border font-medium transition-colors shadow-sm">
                            {{ $yr }}
                    </button>
                @endforeach
            </div>
            @endif

            <div class="space-y-6">
                @foreach($calendarData['years'] as $year => $months)
                <div x-show="selectedYear === {{ $year }}" class="space-y-4">
                    @foreach($months as $month => $monthData)
                        <div class="border border-slate-200 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 overflow-hidden shadow-sm" x-data="{ expandedMonth: false }">
                            <button @click="expandedMonth = !expandedMonth" class="w-full px-6 py-4 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50 dark:bg-slate-800/50 hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors">
                                <div class="flex items-center text-xl font-semibold text-indigo-600 dark:text-indigo-400">
                                    {{ $monthData['month_name'] }} {{ $year }}
                                    <svg class="w-4 h-4 ml-2 transform transition-transform duration-200" :class="{'rotate-180': expandedMonth}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>

                                <!-- Summary Panel -->
                                <div class="flex space-x-4 text-sm font-medium">
                                    <div class="text-emerald-700 dark:text-emerald-400">
                                        Present: <span class="font-bold">{{ $monthData['totals']['present'] }}</span>
                                    </div>
                                    <div class="text-red-700 dark:text-red-400">
                                        Absent: <span class="font-bold">{{ $monthData['totals']['absent'] }}</span>
                                    </div>
                                    <div class="text-amber-700 dark:text-amber-400">
                                        Leaves: <span class="font-bold">{{ $monthData['totals']['leaves'] }}</span>
                                    </div>
                                </div>
                            </button>

                            <!-- Month Details -->
                            <div x-show="expandedMonth" x-collapse class="p-6 border-t border-slate-200 dark:border-slate-700">
                                <div class="grid grid-cols-7 gap-1 mb-8">
                                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                                        <div class="text-center text-xs font-semibold text-slate-500 uppercase tracking-wider py-2">{{ $dayName }}</div>
                                    @endforeach

                                    @for($i = 0; $i < $monthData['start_day_of_week']; $i++)
                                        <div class="aspect-square bg-slate-50 dark:bg-slate-800/30 rounded-md border border-slate-100 dark:border-slate-800/50 opacity-50"></div>
                                    @endfor

                                    @foreach($monthData['days'] as $day => $dayInfo)
                                        @php
                                            $statusClass = 'bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700'; 
                                            $textClass = 'text-slate-700 dark:text-slate-300';
                                            
                                            if ($dayInfo['status'] === 'present') {
                                                $statusClass = 'bg-emerald-100 dark:bg-emerald-900/40 border-emerald-300 dark:border-emerald-700';
                                                $textClass = 'text-emerald-800 dark:text-emerald-300 font-semibold';
                                            } elseif ($dayInfo['status'] === 'absent') {
                                                if (\Carbon\Carbon::parse($dayInfo['date']) <= \Carbon\Carbon::now()) {
                                                    $statusClass = 'bg-red-100 dark:bg-red-900/40 border-red-300 dark:border-red-700';
                                                    $textClass = 'text-red-800 dark:text-red-300 font-semibold';
                                                } else {
                                                    $textClass = 'text-slate-400 dark:text-slate-500';
                                                }
                                            } elseif ($dayInfo['status'] === 'leave') {
                                                $statusClass = 'bg-amber-100 dark:bg-amber-900/40 border-amber-300 dark:border-amber-700';
                                                $textClass = 'text-amber-800 dark:text-amber-300 font-semibold';
                                            } elseif ($dayInfo['status'] === 'weekend') {
                                                $statusClass = 'bg-slate-100 dark:bg-slate-700 border-slate-200 dark:border-slate-600';
                                                $textClass = 'text-slate-400 dark:text-slate-400';
                                            }
                                        @endphp
                                        
                                        <div class="aspect-square group relative flex flex-col items-center justify-center p-1 border rounded-md {{ ($dayInfo['status'] === 'weekend' && $dayInfo['record']) ? 'bg-emerald-100 dark:bg-emerald-900/40 border-emerald-300 dark:border-emerald-700' : $statusClass }} overflow-hidden">
                                            <span class="text-[10px] sm:text-xs absolute top-0.5 right-1 {{ $textClass }}">
                                                {{ $day }}
                                            </span>
                                            
                                            <div class="flex flex-col items-center justify-center text-center space-y-0.5 mt-2">
                                                <span class="text-[8px] sm:text-[10px] uppercase font-bold tracking-tighter {{ $textClass }}">
                                                    {{ ($dayInfo['status'] === 'weekend' && $dayInfo['record']) ? 'present' : $dayInfo['status'] }}
                                                </span>

                                                @if(isset($dayInfo['is_late']) && $dayInfo['is_late'])
                                                    <span class="bg-red-500 text-white text-[6px] sm:text-[8px] px-1 rounded-sm font-bold animate-pulse">LATE</span>
                                                @endif
                                                
                                                @if($dayInfo['status'] === 'present' && $dayInfo['record'] || ($dayInfo['status'] === 'weekend' && $dayInfo['record']))
                                                    <div class="flex flex-col text-[7px] sm:text-[9px] text-slate-500 dark:text-slate-400 leading-tight">
                                                        <span>In: {{ \Carbon\Carbon::parse($dayInfo['record']->clock_in_time)->format('h:i A') }}</span>
                                                        @if($dayInfo['record']->clock_out_time)
                                                            <span>Out: {{ \Carbon\Carbon::parse($dayInfo['record']->clock_out_time)->format('h:i A') }}</span>
                                                        @else
                                                            <span class="text-indigo-500 font-medium">Online</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Detailed Log -->
                                <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider mb-4 border-b border-slate-200 dark:border-slate-700 pb-2">Daily Summary Log</h4>
                                <div class="space-y-3">
                                    @foreach($monthData['days'] as $day => $dayInfo)
                                        @if(($dayInfo['status'] !== 'weekend' || $dayInfo['record']) && \Carbon\Carbon::parse($dayInfo['date']) <= \Carbon\Carbon::now())
                                            <div class="flex items-center justify-between p-3 rounded bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700 text-sm">
                                                <div class="font-medium text-slate-700 dark:text-slate-300 flex items-center w-32">
                                                    {{ \Carbon\Carbon::parse($dayInfo['date'])->format('M d, Y') }}
                                                </div>
                                                
                                                <div class="flex-1 px-4">
                                                    @if($dayInfo['status'] === 'present' || ($dayInfo['status'] === 'weekend' && $dayInfo['record']))
                                                        <span class="text-emerald-600 dark:text-emerald-400 font-semibold flex items-center break-all">
                                                            <i class="fa-solid fa-check-circle mr-2 w-4"></i> 
                                                            {{ ($dayInfo['status'] === 'weekend') ? 'Present (Weekend)' : 'Present' }}
                                                            @if(isset($dayInfo['is_late']) && $dayInfo['is_late'])
                                                                <span class="ml-2 px-1.5 py-0.5 bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-400 text-[10px] rounded border border-red-200 dark:border-red-800">LATE</span>
                                                            @endif
                                                            @if($dayInfo['record'])
                                                                <span class="text-slate-500 font-normal ml-3">
                                                                    (Check-in: {{ \Carbon\Carbon::parse($dayInfo['record']->clock_in_time)->format('h:i A') }}
                                                                    @if($dayInfo['record']->clock_out_time)
                                                                        , Check-out: {{ \Carbon\Carbon::parse($dayInfo['record']->clock_out_time)->format('h:i A') }}
                                                                    @else
                                                                        , Still Online
                                                                    @endif
                                                                    )
                                                                </span>
                                                            @endif
                                                        </span>
                                                    @elseif($dayInfo['status'] === 'absent')
                                                        <span class="text-red-500 font-semibold flex items-center">
                                                            <i class="fa-solid fa-times-circle mr-2 w-4"></i> Absent
                                                        </span>
                                                    @elseif($dayInfo['status'] === 'leave')
                                                        <span class="text-amber-500 font-semibold flex items-center">
                                                            <i class="fa-solid fa-umbrella-beach mr-2 w-4"></i> Leave Approved
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                
                            </div>
                        </div>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
