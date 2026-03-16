@extends('layouts.dashboard')

@section('title', 'Employee Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Employee Management</h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Register and manage system users.</p>
    </div>
    <button onclick="document.getElementById('addEmployeeModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-sm flex items-center gap-2 transition-colors">
        <i class="fa-solid fa-user-plus"></i> Register Employee
    </button>
</div>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif



    <!-- Add Employee Modal -->
    <div id="addEmployeeModal" class="fixed inset-0 bg-black/40 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-opacity p-4">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-4xl mx-auto overflow-hidden">
            <div class="flex justify-between items-center p-6 border-b">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Register New Employee</h3>
                <button onclick="document.getElementById('addEmployeeModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:text-slate-400 transition-colors">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Full Name</label>
                            <input type="text" name="name" class="w-full border dark:border-slate-600 rounded dark:bg-slate-700 dark:text-white px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Email Address</label>
                            <input type="email" name="email" class="w-full border dark:border-slate-600 rounded dark:bg-slate-700 dark:text-white px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Temporary Password</label>
                            <input type="password" name="password" class="w-full border dark:border-slate-600 rounded dark:bg-slate-700 dark:text-white px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Department / Role</label>
                            <select name="role" class="w-full border dark:border-slate-600 rounded dark:bg-slate-700 dark:text-white px-3 py-2" required>
                                <option value="sales">Sales</option>
                                <option value="onboarding">Onboarding</option>
                                <option value="va">VA</option>
                                <option value="accounts">Accounts</option>
                                <option value="hr">HR</option>
                                <option value="super_admin">Super Admin</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Region (Optional)</label>
                            <select name="region" class="w-full border dark:border-slate-600 rounded dark:bg-slate-700 dark:text-white px-3 py-2">
                                <option value="">Global / N/A</option>
                                <option value="USA">USA</option>
                                <option value="Pakistan">Pakistan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Base Salary (Optional)</label>
                            <div class="flex items-center">
                                <span class="bg-gray-100 dark:bg-slate-700 border border-r-0 border-gray-300 dark:border-slate-600 px-3 py-2 rounded-l text-gray-600 dark:text-slate-400">Rs</span>
                                <input type="number" step="1" name="salary" class="w-full border dark:border-slate-600 rounded dark:bg-slate-700 dark:text-white-r px-3 py-2 outline-none focus:border-blue-500" placeholder="55000">
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <button type="button" onclick="document.getElementById('addEmployeeModal').classList.add('hidden')" class="px-5 py-2.5 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 text-gray-800 dark:text-white font-medium rounded-lg transition-colors">Cancel</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg transition-colors shadow-sm">
                            Register Employee
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-slate-700 text-gray-700 dark:text-slate-300 border-b">
                    <th class="py-3 px-6 cursor-pointer">ID</th>
                    <th class="py-3 px-6 cursor-pointer">Name</th>
                    <th class="py-3 px-6 cursor-pointer">Email</th>
                    <th class="py-3 px-6 cursor-pointer">Department/Role</th>
                    <th class="py-3 px-6 cursor-pointer">Region</th>
                    <th class="py-3 px-6 cursor-pointer">Base Salary</th>
                    <th class="py-3 px-6 cursor-pointer">Status</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-b hover:bg-gray-50 dark:bg-slate-700">
                    <td class="py-3 px-6">{{ $user->id }}</td>
                    <td class="py-3 px-6 font-bold">{{ $user->name }}</td>
                    <td class="py-3 px-6 text-gray-500 dark:text-slate-400">{{ $user->email }}</td>
                    <td class="py-3 px-6 text-blue-600">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</td>
                    <td class="py-3 px-6">{{ $user->region ?? 'N/A' }}</td>
                    <td class="py-3 px-6 text-green-600 font-bold">{{ $user->salary ? 'Rs ' . number_format($user->salary, 0) : 'N/A' }}</td>
                    <td class="py-3 px-6 text-center">
                        <span class="w-3 h-3 rounded-full inline-block mr-1 
                            @if($user->status == 'online') bg-green-500 @elseif($user->status == 'fired') bg-red-600 @else bg-gray-400 @endif"></span>
                        <span class="text-sm">{{ ucfirst($user->status) }}</span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex items-center justify-center gap-3">
                            <button onclick="openViewEmployeeModal({{ $user->id }})" class="text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:text-slate-300 transition-colors" title="View details">
                                <i class="fa-solid fa-eye text-lg"></i>
                            </button>
                            <button onclick="openEditEmployeeModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ $user->role }}', '{{ $user->region }}', '{{ $user->salary }}', {{ $user->total_leaves ?? 30 }}, {{ $user->used_leaves ?? 0 }}, '{{ $user->status }}')" class="text-blue-500 hover:text-blue-700 transition-colors" title="Edit">
                                <i class="fa-solid fa-pen-to-square text-lg"></i>
                            </button>
                            @if($user->status !== 'fired')
                            <button onclick="openFireEmployeeModal({{ $user->id }}, '{{ addslashes($user->name) }}')" class="text-red-500 hover:text-red-700 transition-colors" title="Fire">
                                <i class="fa-solid fa-user-slash text-lg"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- View Employee Modal -->
    <div id="viewEmployeeModal" class="fixed inset-0 bg-black/40 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-opacity p-4">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-2xl mx-auto overflow-hidden">
            <div class="flex justify-between items-center p-6 border-b">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white" id="viewEmployeeName">Employee Details</h3>
                <button onclick="document.getElementById('viewEmployeeModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:text-slate-400 transition-colors">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-3 gap-6 mb-6">
                    <div class="bg-gray-50 dark:bg-slate-700 p-4 rounded-lg border">
                        <h4 class="text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-1">Role / Dept</h4>
                        <p class="text-base font-semibold text-gray-800 dark:text-white break-words" id="viewEmployeeRole"></p>
                    </div>
                    <div class="bg-gray-50 dark:bg-slate-700 p-4 rounded-lg border">
                        <h4 class="text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-1">Region</h4>
                        <p class="text-base font-semibold text-gray-800 dark:text-white" id="viewEmployeeRegion"></p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">Employed Since</h4>
                        <p class="text-base font-semibold text-blue-900" id="viewEmployedSince"></p>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-bold text-slate-800 dark:text-white mb-3 border-b pb-2"><i class="fa-solid fa-chart-line text-blue-500 mr-2"></i>Current Month Performance</h4>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-check-double text-lg"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-500 dark:text-slate-400 font-bold uppercase tracking-wider">Completed</p>
                                <p class="text-xl font-bold text-slate-800 dark:text-white" id="viewEmployeeTasks">-</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-bolt text-lg"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-500 dark:text-slate-400 font-bold uppercase tracking-wider">Efficiency</p>
                                <p class="text-xl font-bold text-slate-800 dark:text-white"><span id="viewEmployeeEfficiency">-</span> <span class="text-sm text-gray-500 dark:text-slate-400 font-normal">T/h</span></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-user-clock text-lg"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-red-500 font-bold uppercase tracking-wider">Days Absent</p>
                                <p class="text-xl font-bold text-red-600" id="viewDaysAbsent">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold text-slate-800 dark:text-white mb-3 border-b pb-2"><i class="fa-solid fa-calendar-alt text-orange-500 mr-2"></i>Leave Management</h4>
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div class="bg-gray-50 dark:bg-slate-700 p-3 rounded-lg border border-gray-200 dark:border-slate-700">
                            <p class="text-xs text-gray-500 dark:text-slate-400 font-bold uppercase mb-1">Total Leaves</p>
                            <p class="text-2xl font-bold text-slate-800 dark:text-white" id="viewTotalLeaves">-</p>
                        </div>
                        <div class="bg-orange-50 p-3 rounded-lg border border-orange-200">
                            <p class="text-xs text-orange-600 font-bold uppercase mb-1">Used Leaves</p>
                            <p class="text-2xl font-bold text-orange-600" id="viewUsedLeaves">-</p>
                        </div>
                        <div class="bg-green-50 p-3 rounded-lg border border-green-200">
                            <p class="text-xs text-green-700 font-bold uppercase mb-1">Remaining</p>
                            <p class="text-2xl font-bold text-green-700" id="viewRemainingLeaves">-</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-slate-700 px-6 py-4 border-t flex justify-end">
                <button onclick="document.getElementById('viewEmployeeModal').classList.add('hidden')" class="px-5 py-2 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 hover:bg-gray-50 dark:bg-slate-700 text-gray-700 dark:text-slate-300 font-medium rounded-lg transition-colors shadow-sm">Close</button>
            </div>
        </div>
    </div>

    <!-- Edit Employee Modal -->
    <div id="editEmployeeModal" class="fixed inset-0 bg-black/40 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-opacity p-4">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-4xl mx-auto overflow-hidden">
            <div class="flex justify-between items-center p-6 border-b">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Edit Employee</h3>
                <button onclick="document.getElementById('editEmployeeModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:text-slate-400 transition-colors">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6">
                <form id="editEmployeeForm" method="POST">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Full Name</label>
                            <input type="text" name="name" id="editName" class="w-full border dark:border-slate-600 rounded dark:bg-slate-700 dark:text-white px-3 py-2 outline-none focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Email Address</label>
                            <input type="email" name="email" id="editEmail" class="w-full border dark:border-slate-600 rounded dark:bg-slate-700 dark:text-white px-3 py-2 outline-none focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Department / Role</label>
                            <select name="role" id="editRole" class="w-full border dark:border-slate-600 rounded dark:bg-slate-700 dark:text-white px-3 py-2 outline-none focus:border-blue-500" required>
                                <option value="sales">Sales</option>
                                <option value="onboarding">Onboarding</option>
                                <option value="va">VA</option>
                                <option value="accounts">Accounts</option>
                                <option value="hr">HR</option>
                                <option value="super_admin">Super Admin</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Region</label>
                            <select name="region" id="editRegion" class="w-full border dark:border-slate-600 rounded dark:bg-slate-700 dark:text-white px-3 py-2 outline-none focus:border-blue-500">
                                <option value="">Global / N/A</option>
                                <option value="USA">USA</option>
                                <option value="Pakistan">Pakistan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Base Salary</label>
                            <div class="flex items-center">
                                <span class="bg-gray-100 dark:bg-slate-700 border border-r-0 border-gray-300 dark:border-slate-600 px-3 py-2 rounded-l text-gray-600 dark:text-slate-400">Rs</span>
                                <input type="number" step="1" name="salary" id="editSalary" class="w-full border dark:border-slate-600 rounded dark:bg-slate-700 dark:text-white-r px-3 py-2 outline-none focus:border-blue-500" placeholder="0">
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Current Status</label>
                            <select name="status" id="editStatus" class="w-full border dark:border-slate-600 rounded dark:bg-slate-700 dark:text-white px-3 py-2 outline-none focus:border-blue-500" required>
                                <option value="offline">Offline (Active)</option>
                                <option value="online">Online (Active)</option>
                                <option value="fired">Fired (Inactive)</option>
                                <option value="delete" class="text-red-500 font-bold">Delete Record (Permanent)</option>
                            </select>
                        </div>
                    </div>

                    <h4 class="font-bold text-gray-800 dark:text-white mb-3 border-b pb-2">Leave Management</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Total Leaves Allowed (Yearly)</label>
                            <input type="number" name="total_leaves" id="editTotalLeaves" class="w-full border dark:border-slate-600 rounded dark:bg-slate-700 dark:text-white px-3 py-2 outline-none focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-slate-300 font-bold mb-2">Used Leaves</label>
                            <input type="number" name="used_leaves" id="editUsedLeaves" class="w-full border dark:border-slate-600 rounded dark:bg-slate-700 dark:text-white px-3 py-2 outline-none focus:border-blue-500" required>
                        </div>
                    </div>
                    
                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <button type="button" onclick="document.getElementById('editEmployeeModal').classList.add('hidden')" class="px-5 py-2.5 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 text-gray-800 dark:text-white font-medium rounded-lg transition-colors">Cancel</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg transition-colors shadow-sm">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Fire Employee Modal -->
    <div id="fireEmployeeModal" class="fixed inset-0 bg-black/40 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-opacity p-4">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-lg mx-auto overflow-hidden">
            <div class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-user-slash text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">Fire Employee</h3>
                        <p class="text-sm text-gray-500 dark:text-slate-400" id="fireEmployeeName"></p>
                    </div>
                </div>
                
                <div class="bg-orange-50 border border-orange-200 text-orange-800 px-4 py-3 rounded mb-6 text-sm">
                    <i class="fa-solid fa-triangle-exclamation mr-2"></i> This will immediately revoke their access and send an automatic termination email to their inbox.
                </div>

                <form id="fireEmployeeForm" method="POST">
                    @csrf
                    <div>
                        <label class="block text-gray-800 dark:text-white font-bold mb-2">Reason for Firing <span class="text-red-500">*</span></label>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mb-2">This reason will be included in the email sent to the employee.</p>
                        <textarea name="reason" class="w-full border border-gray-300 dark:border-slate-600 rounded-md px-3 py-2 min-h-[100px] outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 resize-y" placeholder="e.g., We are sorry, but due to repeated policy violations, we are unable to continue..." required></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-6 mt-2 border-t border-gray-100">
                        <button type="button" onclick="document.getElementById('fireEmployeeModal').classList.add('hidden')" class="px-5 py-2.5 text-gray-600 dark:text-slate-400 hover:bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 font-medium rounded-lg transition-colors">Cancel</button>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-lg transition-colors shadow-sm">
                            Confirm Firing
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openEditEmployeeModal(id, name, email, role, region, salary, totalLeaves, usedLeaves, status) {
        document.getElementById('editName').value = name;
        document.getElementById('editEmail').value = email;
        document.getElementById('editRole').value = role;
        document.getElementById('editRegion').value = region || '';
        document.getElementById('editSalary').value = salary || '';
        document.getElementById('editTotalLeaves').value = totalLeaves;
        document.getElementById('editUsedLeaves').value = usedLeaves;
        document.getElementById('editStatus').value = status;

        document.getElementById('editEmployeeForm').action = `/users/${id}`;
        document.getElementById('editEmployeeModal').classList.remove('hidden');
    }

    function openFireEmployeeModal(id, name) {
        document.getElementById('fireEmployeeName').textContent = name;
        document.getElementById('fireEmployeeForm').action = `/users/${id}/fire`;
        document.getElementById('fireEmployeeModal').classList.remove('hidden');
    }

    function openViewEmployeeModal(id) {
        // Fetch data
        fetch(`/users/${id}`, {
            headers: { 'Accept': 'application/json'}
        })
        .then(res => res.json())
        .then(data => {
            const user = data.user;
            const metrics = data.metrics;

            document.getElementById('viewEmployeeName').textContent = user.name + ' - Details';
            document.getElementById('viewEmployeeRole').textContent = user.role.replace('_', ' ').toUpperCase();
            document.getElementById('viewEmployeeRegion').textContent = user.region || 'Global / N/A';
            document.getElementById('viewEmployedSince').textContent = metrics.employed_since;

            document.getElementById('viewEmployeeTasks').textContent = metrics.tasks_completed;
            document.getElementById('viewEmployeeEfficiency').textContent = metrics.efficiency;
            document.getElementById('viewDaysAbsent').textContent = metrics.days_absent;

            document.getElementById('viewTotalLeaves').textContent = metrics.leaves_total;
            document.getElementById('viewUsedLeaves').textContent = metrics.leaves_used;
            document.getElementById('viewRemainingLeaves').textContent = metrics.leaves_remaining;

            document.getElementById('viewEmployeeModal').classList.remove('hidden');
        })
        .catch(err => {
            console.error('Error fetching employee details:', err);
            alert('Could not load employee details.');
        });
    }
</script>
@endpush
