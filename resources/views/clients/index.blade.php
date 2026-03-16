@extends('layouts.dashboard')

@section('title', 'Clients Management')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Clients & Leads</h2>
    <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Manage the CRM pipeline.</p>
</div>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Client Management</h2>
        @if(in_array(auth()->user()->role, ['sales', 'super_admin']))
        <button onclick="document.getElementById('createLeadModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-sm flex items-center gap-2 transition-colors">
            <i class="fa-solid fa-plus"></i> Create company
        </button>
        @endif
    </div>

    <div class="bg-white dark:bg-slate-800 rounded shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-slate-700 text-gray-700 dark:text-slate-300 border-b">
                    <th class="py-3 px-6 cursor-pointer">ID</th>
                    <th class="py-3 px-6 cursor-pointer">Company Name</th>
                    <th class="py-3 px-6 cursor-pointer">Website</th>
                    <th class="py-3 px-6 cursor-pointer">Source</th>
                    <th class="py-3 px-6 cursor-pointer">Status</th>
                    <th class="py-3 px-6 cursor-pointer">Sales Rep</th>
                    <th class="py-3 px-6 cursor-pointer">VA</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                <tr class="border-b hover:bg-gray-50 dark:bg-slate-700">
                    <td class="py-3 px-6">{{ $client->id }}</td>
                    <td class="py-3 px-6 font-bold">
                        {{ $client->company_name }}
                        @if($client->email) <span class="block text-xs font-normal text-gray-500 dark:text-slate-400">{{ is_array($client->email) ? implode(', ', $client->email) : $client->email }}</span> @endif
                        @if($client->phone) <span class="block text-xs font-normal text-gray-500 dark:text-slate-400">{{ is_array($client->phone) ? implode(', ', $client->phone) : $client->phone }}</span> @endif
                    </td>
                    <td class="py-3 px-6 text-sm text-gray-600 dark:text-slate-400">
                        @if($client->website) 
                            <a href="{{ Str::startsWith($client->website, 'http') ? $client->website : 'https://'.$client->website }}" target="_blank" class="text-blue-500 hover:underline"><i class="fa-solid fa-link text-xs"></i> Link</a>
                        @else N/A @endif
                    </td>
                    <td class="py-3 px-6 text-sm text-gray-600 dark:text-slate-400">{{ $client->source ?? 'N/A' }}</td>
                    <td class="py-3 px-6">
                        <span class="px-2 py-1 rounded text-xs text-white 
                            @if($client->status == 'Lead') bg-gray-500 dark:bg-slate-500 
                            @elseif($client->status == 'Onboarding') bg-blue-500 dark:bg-blue-600 
                            @elseif($client->status == 'Active') bg-green-500 dark:bg-green-600 
                            @else bg-red-500 dark:bg-red-600 @endif">
                            {{ $client->status }}
                        </span>
                    </td>
                    <td class="py-3 px-6">{{ $client->assignedSales->name ?? 'N/A' }}</td>
                    <td class="py-3 px-6">
                        {{ $client->assignedVA->name ?? 'N/A' }}
                        @if($client->attached_file)
                        <div class="mt-1">
                            <a href="{{ Storage::url($client->attached_file) }}" target="_blank" class="text-xs text-indigo-500 hover:underline flex items-center gap-1">
                                <i class="fa-solid fa-paperclip"></i> Document
                            </a>
                        </div>
                        @else
                        <div class="mt-1 text-xs text-gray-400 dark:text-gray-500">No Doc</div>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex items-center justify-center gap-3">
                            @php
                                // Ensure email and phone are strings for the JS function
                                $clientEmailStr = is_array($client->email) ? ($client->email[0] ?? '') : ($client->email ?? '');
                                $clientPhoneStr = is_array($client->phone) ? ($client->phone[0] ?? '') : ($client->phone ?? '');
                            @endphp

                            @if($client->status === 'Lead' && in_array(auth()->user()->role, ['sales', 'super_admin']))
                                <button onclick="document.getElementById('convertLeadModal-{{ $client->id }}').classList.remove('hidden')" class="text-green-500 hover:text-green-700 transition-colors" title="Convert to Client">
                                    <i class="fa-solid fa-right-left text-lg"></i>
                                </button>
                            @endif
                            
                            @if(in_array(auth()->user()->role, ['sales', 'super_admin', 'onboarding']))
                                <button onclick="openEditClientModal({{ $client->id }}, '{{ addslashes($client->company_name) }}', '{{ addslashes($clientEmailStr) }}', '{{ addslashes($clientPhoneStr) }}', '{{ addslashes($client->website) }}', '{{ addslashes($client->source) }}', '{{ addslashes($client->background_info) }}', '{{ $client->assigned_va_id }}')" class="text-blue-500 hover:text-blue-700 transition-colors block md:inline-block m-1" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-lg"></i>
                                </button>
                            @endif

                            @if(in_array(auth()->user()->role, ['sales', 'super_admin']))
                                <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline-block m-1" onsubmit="return confirm('Are you sure you want to delete this lead/client?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition-colors" title="Delete">
                                        <i class="fa-solid fa-trash-can text-lg"></i>
                                    </button>
                                </form>
                            @endif

                            @if(!in_array(auth()->user()->role, ['sales', 'super_admin', 'onboarding']))
                                <span class="text-gray-400 dark:text-slate-500 text-xs text-center block">No actions</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-6 text-center text-gray-500 dark:text-slate-400">No records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Convert Lead Modals -->
    @foreach($clients as $client)
        @if($client->status === 'Lead' && in_array(auth()->user()->role, ['sales', 'super_admin']))
        <div id="convertLeadModal-{{ $client->id }}" class="fixed inset-0 bg-black/40 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-opacity p-4">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-md mx-auto overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-handshake text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">Convert Lead to Client</h3>
                            <p class="text-sm text-gray-500 dark:text-slate-400">{{ $client->company_name }}</p>
                        </div>
                    </div>
                    
                    <p class="text-gray-600 dark:text-slate-400 mb-6">Are you sure you want to convert this lead? This action will formally change their status and notify the Onboarding team to begin their process.</p>

                    <form action="{{ route('clients.convert', $client) }}" method="POST">
                        @csrf @method('PATCH')
                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-slate-700">
                            <button type="button" onclick="document.getElementById('convertLeadModal-{{ $client->id }}').classList.add('hidden')" class="px-4 py-2 text-gray-600 dark:text-slate-400 hover:text-gray-800 dark:text-white font-medium transition-colors">
                                Cancel
                            </button>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-sm transition-colors">
                                Confirm Conversion
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    @endforeach

    <!-- Create Company / Lead Modal -->
    @if(in_array(auth()->user()->role, ['sales', 'super_admin']))
    <div id="createLeadModal" class="fixed inset-0 bg-black/40 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-opacity p-4">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-4xl mx-auto overflow-hidden max-h-[90vh] flex flex-col">
            <div class="p-8 overflow-y-auto">
                <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Top Section: Logo & Company Name -->
                    <div class="flex items-start gap-4 mb-8">
                        <div class="relative">
                            <input type="file" name="company_logo" id="companyLogoInput" class="hidden" accept="image/*" onchange="previewLogo(event)">
                            <label for="companyLogoInput" class="w-16 h-16 rounded-full border border-dashed border-gray-300 dark:border-slate-600 flex items-center justify-center shrink-0 cursor-pointer hover:bg-gray-50 dark:bg-slate-700 overflow-hidden" id="logoPreviewContainer">
                                <i class="fa-regular fa-image text-gray-400 dark:text-slate-500 text-xl" id="logoIcon"></i>
                                <img id="logoImage" src="" class="w-full h-full object-cover hidden">
                            </label>
                        </div>
                        <div class="flex-grow">
                            <label class="block text-gray-800 dark:text-white font-semibold mb-2">Company Name <span class="text-orange-600 text-sm font-normal ml-1">· Required</span></label>
                            <input type="text" name="company_name" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md px-3 py-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all" required>
                        </div>
                    </div>

                    <!-- Middle Grid Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6 mb-8">
                        
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Emails -->
                            <div id="emailsContainer">
                                <label class="block text-gray-800 dark:text-white font-semibold mb-2">Email</label>
                                <div class="email-row flex items-center gap-2 mb-2">
                                    <input type="email" name="email[]" class="flex-grow border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md px-3 py-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                                    <select class="w-24 border border-gray-300 dark:border-slate-600 rounded-md px-2 py-2.5 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-300 outline-none">
                                        <option>Work</option>
                                        <option>Personal</option>
                                    </select>
                                    <button type="button" class="text-gray-400 dark:text-slate-500 hover:text-red-500 px-1 opacity-0 pointer-events-none w-6"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                                <div class="text-right mt-1"><button type="button" onclick="addEmailRow()" class="text-blue-600 hover:underline text-sm">+ Add another</button></div>
                            </div>

                            <!-- Phones -->
                            <div id="phonesContainer">
                                <label class="block text-gray-800 dark:text-white font-semibold mb-2">Phone</label>
                                <div class="phone-row flex items-center gap-2 mb-2">
                                    <input type="text" name="phone[]" class="flex-grow border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md px-3 py-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                                    <select class="w-24 border border-gray-300 dark:border-slate-600 rounded-md px-2 py-2.5 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-300 outline-none">
                                        <option>Work</option>
                                        <option>Mobile</option>
                                    </select>
                                    <button type="button" class="text-gray-400 dark:text-slate-500 hover:text-red-500 px-1 opacity-0 pointer-events-none w-6"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                                <div class="text-right mt-1"><button type="button" onclick="addPhoneRow()" class="text-blue-600 hover:underline text-sm">+ Add another</button></div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Background info -->
                            <div>
                                <label class="block text-gray-800 dark:text-white font-semibold mb-2">Background info</label>
                                <textarea name="background_info" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md px-3 py-2.5 min-h-[50px] focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none resize-y"></textarea>
                            </div>

                            <!-- Website -->
                            <div>
                                <label class="block text-gray-800 dark:text-white font-semibold mb-2">URL <span class="text-gray-400 dark:text-slate-500 text-sm font-normal ml-1">· Optional</span></label>
                                <div class="flex items-center gap-2">
                                    <input type="url" name="website" class="flex-grow border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md px-3 py-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none" placeholder="https://">
                                </div>
                            </div>

                            <!-- Source -->
                            <div>
                                <label class="block text-gray-800 dark:text-white font-semibold mb-2">Source</label>
                                <select name="source" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md px-3 py-2.5 bg-white dark:bg-slate-800 text-gray-800 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none appearance-none cursor-pointer">
                                    <option value="">Select a source</option>
                                    <option value="Direct Traffic">Direct Traffic</option>
                                    <option value="Organic Search">Organic Search</option>
                                    <option value="Referral">Referral</option>
                                    <option value="Social Media">Social Media</option>
                                    <option value="Cold Call">Cold Call</option>
                                    <option value="Ad Campaign">Ad Campaign</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Section: Attach an item -->
                    <div class="border-t border-b border-gray-100 dark:border-slate-700 py-6 mb-8">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                                <i class="fa-solid fa-plus text-sm"></i>
                            </div>
                            <h4 class="font-bold text-gray-800 dark:text-white">Attach an item</h4>
                        </div>
                        <div class="w-full border-2 border-dashed border-gray-300 dark:border-slate-600 rounded-lg p-6 bg-gray-50 dark:bg-slate-700 hover:bg-gray-100 dark:bg-slate-700 transition-colors cursor-pointer text-center relative" id="fileDropzone">
                            <input type="file" name="attached_file" id="attachedFileInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="showAttachedFileName(event)">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 dark:text-slate-500 mb-2"></i>
                            <p class="text-gray-600 dark:text-slate-400 font-medium" id="dropzoneText">Click or drag a file here to upload</p>
                            <p class="text-xs text-gray-400 dark:text-slate-500 mt-1">Contracts, briefs, or reference documents</p>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center gap-6">
                        <button type="submit" class="bg-[#246fa4] hover:bg-[#1e5d8a] text-white font-bold py-2.5 px-8 rounded-full transition-colors">
                            Create company
                        </button>
                        <button type="button" onclick="document.getElementById('createLeadModal').classList.add('hidden')" class="text-[#246fa4] hover:text-[#1e5d8a] font-medium transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Edit Company / Lead Modal -->
    <div id="editClientModal" class="fixed inset-0 bg-black/40 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-opacity p-4">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-3xl mx-auto overflow-hidden">
            <div class="flex justify-between items-center p-6 border-b">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Edit Lead / Client</h3>
                <button onclick="document.getElementById('editClientModal').classList.add('hidden')" class="text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:text-slate-400 transition-colors">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6">
                <form id="editClientForm" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-gray-800 dark:text-white font-semibold mb-2">Company Name <span class="text-red-500">*</span></label>
                            <input type="text" name="company_name" id="editCompanyName" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md px-3 py-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all" required>
                        </div>

                        <div>
                            <label class="block text-gray-800 dark:text-white font-semibold mb-2">Primary Email</label>
                            <input type="email" name="email" id="editEmail" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md px-3 py-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                        </div>

                        <div>
                            <label class="block text-gray-800 dark:text-white font-semibold mb-2">Primary Phone</label>
                            <input type="text" name="phone" id="editPhone" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md px-3 py-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                        </div>

                        <div>
                            <label class="block text-gray-800 dark:text-white font-semibold mb-2">URL</label>
                            <input type="url" name="website" id="editWebsite" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md px-3 py-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none" placeholder="https://">
                        </div>

                        <div>
                            <label class="block text-gray-800 dark:text-white font-semibold mb-2">Source</label>
                            <select name="source" id="editSource" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md px-3 py-2.5 bg-white dark:bg-slate-800 text-gray-800 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                                <option value="">Select a source</option>
                                <option value="Direct Traffic">Direct Traffic</option>
                                <option value="Organic Search">Organic Search</option>
                                <option value="Referral">Referral</option>
                                <option value="Social Media">Social Media</option>
                                <option value="Cold Call">Cold Call</option>
                                <option value="Ad Campaign">Ad Campaign</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-gray-800 dark:text-white font-semibold mb-2">Background info</label>
                            <textarea name="background_info" id="editBackgroundInfo" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md px-3 py-2.5 min-h-[80px] focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none resize-y"></textarea>
                        </div>
                        
                        @if(in_array(auth()->user()->role, ['super_admin', 'onboarding']))
                        <div>
                            <label class="block text-gray-800 dark:text-white font-semibold mb-2">Assign VA</label>
                            <select name="assigned_va_id" id="editAssignedVaId" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md px-3 py-2.5 bg-white dark:bg-slate-800 text-gray-800 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                                <option value="">Unassigned</option>
                                @foreach($vas as $va)
                                    <option value="{{ $va->id }}">{{ $va->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-800 dark:text-white font-semibold mb-2">Attach Document (Optional)</label>
                            <input type="file" name="attached_file" class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                            <p class="text-xs text-slate-500 mt-1">Upload new contract or document. Replaces existing.</p>
                        </div>
                        @endif
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <button type="button" onclick="document.getElementById('editClientModal').classList.add('hidden')" class="px-5 py-2.5 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 text-gray-800 dark:text-white font-medium rounded-lg transition-colors">Cancel</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg transition-colors shadow-sm">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function previewLogo(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('logoIcon').classList.add('hidden');
                document.getElementById('logoImage').classList.remove('hidden');
                document.getElementById('logoImage').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function showAttachedFileName(event) {
        const input = event.target;
        const textElement = document.getElementById('dropzoneText');
        if (input.files && input.files.length > 0) {
            textElement.innerHTML = `<span class="text-blue-600 font-bold"><i class="fa-solid fa-file-check mr-1"></i> ${input.files[0].name}</span>`;
        } else {
            textElement.textContent = "Click or drag a file here to upload";
        }
    }

    function addEmailRow() {
        const container = document.getElementById('emailsContainer');
        const rows = container.querySelectorAll('.email-row');
        const firstRow = rows[0];
        const newRow = firstRow.cloneNode(true);
        
        // Reset values
        newRow.querySelector('input').value = '';
        
        // Enable delete button on cloned row
        const btn = newRow.querySelector('button');
        btn.classList.remove('opacity-0', 'pointer-events-none');
        btn.onclick = function() {
            newRow.remove();
        };

        // Insert before the "Add another" button
        container.insertBefore(newRow, container.lastElementChild);
    }

    function addPhoneRow() {
        const container = document.getElementById('phonesContainer');
        const rows = container.querySelectorAll('.phone-row');
        const firstRow = rows[0];
        const newRow = firstRow.cloneNode(true);
        
        // Reset values
        newRow.querySelector('input').value = '';
        
        // Enable delete button on cloned row
        const btn = newRow.querySelector('button');
        btn.classList.remove('opacity-0', 'pointer-events-none');
        btn.onclick = function() {
            newRow.remove();
        };

        // Insert before the "Add another" button
        container.insertBefore(newRow, container.lastElementChild);
    }

    function openEditClientModal(id, companyName, email, phone, website, source, backgroundInfo, assignedVaId) {
        document.getElementById('editCompanyName').value = companyName || '';
        document.getElementById('editEmail').value = email || '';
        document.getElementById('editPhone').value = phone || '';
        document.getElementById('editWebsite').value = website || '';
        document.getElementById('editSource').value = source || '';
        document.getElementById('editBackgroundInfo').value = backgroundInfo || '';
        
        const vaSelect = document.getElementById('editAssignedVaId');
        if(vaSelect) {
            vaSelect.value = assignedVaId || '';
        }

        document.getElementById('editClientForm').action = `/clients/${id}`;
        document.getElementById('editClientModal').classList.remove('hidden');
    }
</script>
@endpush
