<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-purple-700 uppercase tracking-wider mb-1">
                    <i class="fa-solid fa-crown text-purple-600"></i> Super User Administration Desk
                </div>
                <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight leading-tight">
                    Manage Campus Administrators & Access Control
                </h2>
            </div>
            
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.administrators.create') }}" class="bg-purple-700 hover:bg-purple-600 text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                    <i class="fa-solid fa-user-plus"></i> Create New Administrator
                </a>
                <a href="{{ route('admin.dashboard') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-left"></i> Admin Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-7">
            
            <!-- Dashboard Switcher Tabs -->
            <div class="bg-white p-2 rounded-2xl shadow-xs border border-slate-200/90 flex flex-wrap gap-2 text-xs font-bold">
                <a href="{{ route('dashboard') }}" class="px-4 py-2.5 rounded-xl text-slate-600 hover:bg-emerald-50 hover:text-emerald-800 transition flex items-center gap-2">
                    <i class="fa-solid fa-gauge-high text-emerald-600"></i>
                    <span>General Overview</span>
                </a>
                <a href="{{ route('dashboard.finder') }}" class="px-4 py-2.5 rounded-xl text-slate-600 hover:bg-emerald-50 hover:text-emerald-800 transition flex items-center gap-2">
                    <i class="fa-solid fa-box-open text-emerald-600"></i>
                    <span>Finder Workspace</span>
                </a>
                <a href="{{ route('dashboard.seeker') }}" class="px-4 py-2.5 rounded-xl text-slate-600 hover:bg-amber-50 hover:text-amber-800 transition flex items-center gap-2">
                    <i class="fa-solid fa-magnifying-glass text-amber-500"></i>
                    <span>Seeker Workspace</span>
                </a>
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl text-slate-600 hover:bg-indigo-50 hover:text-indigo-800 transition flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-indigo-500"></i>
                    <span>Admin Operations</span>
                </a>
                <a href="{{ route('admin.administrators.index') }}" class="px-4 py-2.5 rounded-xl bg-purple-900 text-white shadow-xs flex items-center gap-2">
                    <i class="fa-solid fa-crown text-purple-300"></i>
                    <span>Super Admin: Team & Roles</span>
                </a>
            </div>

            <!-- Flash Notifications -->
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-600 p-4 rounded-r-xl text-emerald-800 text-sm font-medium flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-xl"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-600 p-4 rounded-r-xl text-red-800 text-sm font-medium flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-red-600 text-xl"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Super Admin Authority Banner -->
            <div class="bg-gradient-to-r from-slate-950 via-purple-950 to-slate-900 text-white rounded-3xl p-6 sm:p-8 shadow-sm border border-purple-900/50 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 bg-purple-800/60 border border-purple-700/60 text-purple-200 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">
                        <i class="fa-solid fa-crown text-purple-300"></i> Highest Security Clearance
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-white">Administrator Delegation & Governance</h3>
                    <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                        As a Super User, you have authority to appoint new Campus Lost and Found Administrators, assign supervisory roles, promote existing students or staff, and revoke administrator privileges when needed.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.administrators.create') }}" class="bg-purple-600 hover:bg-purple-500 text-white font-bold text-xs px-5 py-3 rounded-xl shadow transition flex items-center gap-2">
                        <i class="fa-solid fa-user-shield"></i> + Add Administrator
                    </a>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/90">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Super Administrators</span>
                            <span class="text-2xl font-extrabold text-purple-700">{{ \App\Models\User::where('is_super_admin', true)->count() }}</span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-crown"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/90">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Campus Administrators</span>
                            <span class="text-2xl font-extrabold text-indigo-700">{{ \App\Models\User::where('is_admin', true)->where('is_super_admin', false)->count() }}</span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/90">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Registered Campus Users</span>
                            <span class="text-2xl font-extrabold text-slate-900">{{ \App\Models\User::count() }}</span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Administrators Table Card -->
            <div class="bg-white rounded-3xl shadow-xs border border-slate-200/90 overflow-hidden p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-100 mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-id-badge text-purple-600"></i> Active Administrator Roster
                        </h3>
                        <p class="text-xs text-slate-500">Personnel holding administrative rights over Kisii University property logs</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <form method="GET" action="{{ route('admin.administrators.index') }}" class="flex items-center gap-2">
                            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search admins..." 
                                   class="text-xs rounded-xl border-slate-200 px-3 py-1.5 focus:border-purple-600 focus:ring-purple-600">
                            <button type="submit" class="bg-slate-800 text-white text-xs px-3 py-1.5 rounded-xl hover:bg-slate-700 font-semibold transition">
                                Filter
                            </button>
                            @if($search)
                                <a href="{{ route('admin.administrators.index') }}" class="text-xs text-slate-500 hover:text-slate-800">Clear</a>
                            @endif
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-y border-slate-100">
                            <tr>
                                <th class="py-3 px-4">Administrator Name</th>
                                <th class="py-3 px-4">Contact Email</th>
                                <th class="py-3 px-4">Phone</th>
                                <th class="py-3 px-4">Assigned Role</th>
                                <th class="py-3 px-4">Joined Date</th>
                                <th class="py-3 px-4 text-right">Super User Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($admins as $admin)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="py-3.5 px-4 font-bold text-slate-900">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-lg {{ $admin->is_super_admin ? 'bg-purple-100 text-purple-800' : 'bg-indigo-100 text-indigo-800' }} flex items-center justify-center font-bold text-xs">
                                                {{ strtoupper(substr($admin->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <span>{{ $admin->name }}</span>
                                                @if($admin->id === auth()->id())
                                                    <span class="ml-1.5 px-1.5 py-0.5 rounded text-[10px] font-bold bg-purple-100 text-purple-800 border border-purple-200">You</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600 font-mono">{{ $admin->email }}</td>
                                    <td class="py-3.5 px-4 text-slate-600">{{ $admin->phone ?? '—' }}</td>
                                    <td class="py-3.5 px-4">
                                        @if($admin->is_super_admin)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-purple-100 text-purple-800 border border-purple-200">
                                                <i class="fa-solid fa-crown text-[10px]"></i> Super Administrator
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-indigo-100 text-indigo-800 border border-indigo-200">
                                                <i class="fa-solid fa-shield-halved text-[10px]"></i> Campus Administrator
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-500">{{ $admin->created_at->format('M d, Y') }}</td>
                                    <td class="py-3.5 px-4 text-right">
                                        @if($admin->id !== auth()->id())
                                            <div class="flex items-center justify-end gap-2">
                                                @if(!$admin->is_super_admin)
                                                    <!-- Elevate to Super Admin -->
                                                    <form action="{{ route('admin.administrators.promote', $admin->id) }}" method="POST" class="inline" onsubmit="return confirm('Promote {{ $admin->name }} to Super Administrator?');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="role" value="super_admin">
                                                        <button type="submit" class="px-2.5 py-1 rounded-lg bg-purple-50 hover:bg-purple-100 text-purple-700 font-bold transition flex items-center gap-1" title="Promote to Super Admin">
                                                            <i class="fa-solid fa-crown text-[10px]"></i> Elevate
                                                        </button>
                                                    </form>
                                                @else
                                                    <!-- Lower to Campus Admin -->
                                                    <form action="{{ route('admin.administrators.promote', $admin->id) }}" method="POST" class="inline" onsubmit="return confirm('Change {{ $admin->name }} role to Campus Administrator?');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="role" value="admin">
                                                        <button type="submit" class="px-2.5 py-1 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold transition flex items-center gap-1" title="Set to Regular Admin">
                                                            <i class="fa-solid fa-shield-halved text-[10px]"></i> Set Admin
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- Demote to regular user -->
                                                <form action="{{ route('admin.administrators.demote', $admin->id) }}" method="POST" class="inline" onsubmit="return confirm('Revoke administrator privileges for {{ $admin->name }}? They will become a regular user.');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="px-2.5 py-1 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-800 font-bold transition flex items-center gap-1" title="Revoke Admin Access">
                                                        <i class="fa-solid fa-user-minus text-[10px]"></i> Revoke
                                                    </button>
                                                </form>

                                                <!-- Delete account -->
                                                <form action="{{ route('admin.administrators.destroy', $admin->id) }}" method="POST" class="inline" onsubmit="return confirm('Permanently delete this administrator account?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-700 transition" title="Delete Account">
                                                        <i class="fa-solid fa-trash text-xs"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-slate-400 italic font-medium">Logged-in session</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-slate-400">
                                        No administrators found matching criteria.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $admins->links() }}
                </div>
            </div>

            <!-- Promote Existing Users Card -->
            <div class="bg-white rounded-3xl shadow-xs border border-slate-200/90 overflow-hidden p-6 sm:p-8">
                <div class="pb-5 border-b border-slate-100 mb-6">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-user-gear text-indigo-600"></i> Appoint Administrators from Registered Campus Users
                    </h3>
                    <p class="text-xs text-slate-500">Quickly elevate existing students or staff accounts to Campus Administrator status</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-y border-slate-100">
                            <tr>
                                <th class="py-3 px-4">User Name</th>
                                <th class="py-3 px-4">Email</th>
                                <th class="py-3 px-4">Reg Number</th>
                                <th class="py-3 px-4">Current Purpose</th>
                                <th class="py-3 px-4 text-right">Appoint as Admin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($candidates as $candidate)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="py-3.5 px-4 font-bold text-slate-900">{{ $candidate->name }}</td>
                                    <td class="py-3.5 px-4 text-slate-600 font-mono">{{ $candidate->email }}</td>
                                    <td class="py-3.5 px-4 font-mono text-slate-700">{{ $candidate->reg_number ?? 'N/A' }}</td>
                                    <td class="py-3.5 px-4">
                                        <span class="px-2 py-0.5 rounded text-[10px] bg-slate-100 text-slate-700">
                                            {{ $candidate->reason_for_registering ?? 'Student User' }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <form action="{{ route('admin.administrators.promote', $candidate->id) }}" method="POST" class="inline" onsubmit="return confirm('Promote {{ $candidate->name }} to Campus Administrator?');">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="role" value="admin">
                                                <button type="submit" class="bg-indigo-700 hover:bg-indigo-600 text-white font-bold text-xs px-3 py-1.5 rounded-lg transition shadow-xs flex items-center gap-1.5">
                                                    <i class="fa-solid fa-shield-halved text-[10px]"></i> Make Admin
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.administrators.promote', $candidate->id) }}" method="POST" class="inline" onsubmit="return confirm('Elevate {{ $candidate->name }} to Super Administrator?');">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="role" value="super_admin">
                                                <button type="submit" class="bg-purple-700 hover:bg-purple-600 text-white font-bold text-xs px-3 py-1.5 rounded-lg transition shadow-xs flex items-center gap-1.5">
                                                    <i class="fa-solid fa-crown text-[10px]"></i> Make Super Admin
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-400">
                                        No registered candidate users available.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $candidates->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
