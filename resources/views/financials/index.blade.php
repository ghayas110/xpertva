@extends('layouts.dashboard')

@section('title', 'Financial Ledger')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Financial Ledger</h2>
    <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Manage global and regional records.</p>
</div>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Account Ledger 
            <span class="text-sm font-normal text-gray-500 dark:text-slate-400 ml-2">({{ $region ?? 'Global View' }})</span>
        </h2>
        <button onclick="document.getElementById('createTransactionModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Record Transaction
        </button>
    </div>

    <!-- Modals moved to bottom -->

    <!-- Ledger Table -->
    <div class="bg-white dark:bg-slate-800 rounded shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-slate-700 text-gray-700 dark:text-slate-300 border-b">
                    <th class="py-3 px-6">ID</th>
                    <th class="py-3 px-6">Date</th>
                    <th class="py-3 px-6">Category</th>
                    <th class="py-3 px-6">Client</th>
                    <th class="py-3 px-6">Region</th>
                    <th class="py-3 px-6 text-right">Amount</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($financials as $record)
                <tr class="border-b hover:bg-gray-50 dark:bg-slate-700">
                    <td class="py-3 px-6">#{{ $record->id }}</td>
                    <td class="py-3 px-6">{{ $record->created_at->format('Y-m-d H:i') }}</td>
                    <td class="py-3 px-6 font-semibold">{{ $record->category }}</td>
                    <td class="py-3 px-6">{{ $record->client->company_name ?? '-' }}</td>
                    <td class="py-3 px-6 text-sm text-gray-500 dark:text-slate-400">{{ $record->region_tag }}</td>
                    <td class="py-3 px-6 text-right font-bold 
                        @if($record->category == 'Invoicing') text-green-600 
                        @else text-red-600 @endif">
                        {{ $record->currency }} {{ number_format($record->amount, 2) }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            @if(!(auth()->user()->region === 'Pakistan' && $record->category === 'Invoicing'))
                                <button type="button" 
                                    onclick="openEditTransactionModal({{ $record->id }}, '{{ $record->category }}', '{{ $record->client_id }}', '{{ $record->amount }}', '{{ $record->currency }}')" 
                                    class="text-blue-500 hover:text-blue-700" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('financials.destroy', $record) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" title="Delete">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 dark:text-slate-500 text-xs italic">Read-only</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-6 text-center text-gray-500 dark:text-slate-400">No transactions recorded.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Create Transaction Modal -->
    <div id="createTransactionModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-opacity p-4">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl w-full max-w-2xl mx-auto overflow-hidden">
            <div class="flex justify-between items-center p-6 border-b">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Record Transaction</h3>
                <button onclick="document.getElementById('createTransactionModal').classList.add('hidden')" class="text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:text-slate-400 transition-colors">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6">
                <form action="{{ route('financials.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-2 gap-4 mb-5">
                        <div>
                            <label class="block text-sm text-gray-700 dark:text-slate-300 font-bold mb-2">Category <span class="text-red-500">*</span></label>
                            <select name="category" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none" required>
                                @if(auth()->user()->region !== 'Pakistan')
                                    <option value="Invoicing">Invoicing</option>
                                @endif
                                <option value="Expense Log">Expense Log</option>
                                <option value="Internal Transfer">Internal Transfer</option>
                                <option value="Payroll">Payroll</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700 dark:text-slate-300 font-bold mb-2">Client (Optional)</label>
                            <select name="client_id" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="">-- No Client --</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm text-gray-700 dark:text-slate-300 font-bold mb-2">Amount <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" name="amount" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700 dark:text-slate-300 font-bold mb-2">Currency <span class="text-red-500">*</span></label>
                            <select name="currency" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none" required>
                                <option value="USD">USD</option>
                                <option value="PKR">PKR</option>
                                <option value="EUR">EUR</option>
                                <option value="GBP">GBP</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <button type="button" onclick="document.getElementById('createTransactionModal').classList.add('hidden')" class="px-5 py-2.5 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 text-gray-800 dark:text-white font-medium rounded-lg transition-colors">Cancel</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg transition-colors shadow-sm">
                            Save Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Transaction Modal -->
    <div id="editTransactionModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-opacity p-4">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl w-full max-w-2xl mx-auto overflow-hidden">
            <div class="flex justify-between items-center p-6 border-b">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Edit Transaction</h3>
                <button onclick="document.getElementById('editTransactionModal').classList.add('hidden')" class="text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:text-slate-400 transition-colors">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6">
                <form id="editTransactionForm" method="POST">
                    @csrf @method('PUT')
                    
                    <div class="grid grid-cols-2 gap-4 mb-5">
                        <div>
                            <label class="block text-sm text-gray-700 dark:text-slate-300 font-bold mb-2">Category <span class="text-red-500">*</span></label>
                            <select name="category" id="editCategory" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none" required>
                                @if(auth()->user()->region !== 'Pakistan')
                                    <option value="Invoicing">Invoicing</option>
                                @endif
                                <option value="Expense Log">Expense Log</option>
                                <option value="Internal Transfer">Internal Transfer</option>
                                <option value="Payroll">Payroll</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700 dark:text-slate-300 font-bold mb-2">Client (Optional)</label>
                            <select name="client_id" id="editClient" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="">-- No Client --</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm text-gray-700 dark:text-slate-300 font-bold mb-2">Amount <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" name="amount" id="editAmount" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700 dark:text-slate-300 font-bold mb-2">Currency <span class="text-red-500">*</span></label>
                            <select name="currency" id="editCurrency" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none" required>
                                <option value="USD">USD</option>
                                <option value="PKR">PKR</option>
                                <option value="EUR">EUR</option>
                                <option value="GBP">GBP</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <button type="button" onclick="document.getElementById('editTransactionModal').classList.add('hidden')" class="px-5 py-2.5 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 text-gray-800 dark:text-white font-medium rounded-lg transition-colors">Cancel</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg transition-colors shadow-sm">
                            Update Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function openEditTransactionModal(id, category, clientId, amount, currency) {
        document.getElementById('editCategory').value = category;
        document.getElementById('editClient').value = clientId || "";
        document.getElementById('editAmount').value = amount;
        document.getElementById('editCurrency').value = currency;
        
        // Update form action dynamically
        document.getElementById('editTransactionForm').action = `/financials/${id}`;
        
        document.getElementById('editTransactionModal').classList.remove('hidden');
    }
</script>
@endpush
