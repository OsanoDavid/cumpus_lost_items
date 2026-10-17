<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-indigo-700 uppercase tracking-wider mb-1">
                    <i class="fa-solid fa-shield-halved"></i> Campus Security & Administration Desk
                </div>
                <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight leading-tight">
                    Admin Operations Portal — Kisii University
                </h2>
            </div>
            
            <div class="flex flex-wrap items-center gap-2">
                @if(Auth::user()->isSuperAdmin())
                    <a href="{{ route('admin.administrators.create') }}" class="bg-purple-700 hover:bg-purple-600 text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-user-shield"></i> + Add Administrator
                    </a>
                @endif
                <a href="{{ route('items.create') }}" class="bg-emerald-700 hover:bg-emerald-600 text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-plus"></i> Post Property
                </a>
                <a href="{{ route('items.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                    <i class="fa-solid fa-list-ul"></i> Public Feed
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
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-indigo-900 text-white shadow-xs flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-indigo-300"></i>
                    <span>Admin Operations</span>
                </a>
                @if(Auth::user()->isSuperAdmin())
                    <a href="{{ route('admin.administrators.index') }}" class="px-4 py-2.5 rounded-xl text-purple-700 bg-purple-50 hover:bg-purple-100 transition flex items-center gap-2">
                        <i class="fa-solid fa-crown text-purple-600"></i>
                        <span>Manage Administrators</span>
                    </a>
                @endif
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

            <!-- Super Admin Authority Quick Banner (Visible to Super Admin only) -->
            @if(Auth::user()->isSuperAdmin())
                <div class="bg-gradient-to-r from-purple-950 via-indigo-950 to-slate-900 text-white rounded-3xl p-6 sm:p-7 shadow-sm border border-purple-800/60 flex flex-col md:flex-row md:items-center justify-between gap-5">
                    <div class="flex items-start sm:items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-purple-600/30 border border-purple-500/40 flex items-center justify-center text-xl text-purple-300 shrink-0">
                            <i class="fa-solid fa-crown"></i>
                        </div>
                        <div>
                            <div class="inline-flex items-center gap-1.5 text-[10px] uppercase font-extrabold tracking-wider text-purple-300 mb-0.5">
                                <i class="fa-solid fa-lock"></i> Super User Governance Active
                            </div>
                            <h4 class="font-extrabold text-lg text-white">Campus Administrators Delegation Desk</h4>
                            <p class="text-xs text-purple-200 max-w-2xl mt-0.5">
                                You hold Super Administrator privileges. You can provision new Campus Administrators, promote existing campus members, or revoke access rights.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('admin.administrators.index') }}" class="bg-white hover:bg-purple-50 text-purple-950 font-bold text-xs px-4 py-2.5 rounded-xl transition shadow-xs flex items-center gap-1.5">
                            <i class="fa-solid fa-users-gear text-purple-700"></i> Manage Admins
                        </a>
                        <a href="{{ route('admin.administrators.create') }}" class="bg-purple-600 hover:bg-purple-500 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition shadow-xs flex items-center gap-1.5">
                            <i class="fa-solid fa-user-plus"></i> + Add Admin
                        </a>
                    </div>
                </div>
            @endif



            <!-- Admin Overview Banner -->
            <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 bg-indigo-800/60 border border-indigo-700/60 text-indigo-200 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">
                        <i class="fa-solid fa-lock"></i> Authorized Campus Administration
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-white">Campus Security & Property Desk</h3>
                    <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                        Control center for managing campus-wide property reports, reviewing student ownership claims, resolving returned assets, and auditing user registrations.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <span class="block text-xs text-slate-400">Security Hotline</span>
                        <a href="tel:+254582030161" class="text-base font-bold text-emerald-400 hover:underline">+254 58 2030161</a>
                    </div>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/90">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Total Items</span>
                    <span class="text-2xl font-extrabold text-slate-900">{{ $items->total() }}</span>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/90">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Submitted Claims</span>
                    <span class="text-2xl font-extrabold text-amber-600">{{ $claims->total() }}</span>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-xs border border-red-200 bg-red-50/30">
                    <span class="text-xs font-bold uppercase tracking-wider text-red-600 block mb-1 flex items-center gap-1">
                        <i class="fa-solid fa-triangle-exclamation"></i> Red Claims
                    </span>
                    <span class="text-2xl font-extrabold text-red-700">{{ \App\Models\Claim::where('is_suspicious', true)->count() }}</span>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/90">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Resolved Property</span>
                    <span class="text-2xl font-extrabold text-emerald-600">{{ \App\Models\Item::where('is_resolved', 1)->count() }}</span>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/90">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Registered Users</span>
                    <span class="text-2xl font-extrabold text-indigo-600">{{ $users->total() }}</span>
                </div>
            </div>


            <!-- Items Management Table Card -->
            <div class="bg-white rounded-3xl shadow-xs border border-slate-200/90 overflow-hidden p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-100 mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Campus Property Catalog</h3>
                        <p class="text-xs text-slate-500">Manage reported items, mark as resolved when claimed, or remove obsolete records</p>
                    </div>
                    <a href="{{ route('items.create') }}" class="text-xs bg-emerald-700 hover:bg-emerald-600 text-white font-bold px-3.5 py-2 rounded-xl transition">
                        + Post Item
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-y border-slate-100">
                            <tr>
                                <th class="py-3 px-4">Item Title</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4">Category</th>
                                <th class="py-3 px-4">Location</th>
                                <th class="py-3 px-4">Resolution</th>
                                <th class="py-3 px-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($items as $item)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="py-3.5 px-4 font-bold text-slate-900">
                                        <a href="{{ route('items.show', $item->id) }}" class="hover:text-emerald-700">
                                            {{ $item->title }}
                                        </a>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $item->status == 'lost' ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600">{{ $item->category }}</td>
                                    <td class="py-3.5 px-4 text-slate-600">📍 {{ $item->location }}</td>
                                    <td class="py-3.5 px-4">
                                        @if($item->is_resolved)
                                            <span class="text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded text-[10px]">
                                                ✓ Resolved
                                            </span>
                                        @else
                                            <span class="text-amber-700 font-bold bg-amber-50 px-2 py-0.5 rounded text-[10px]">
                                                ● Active
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('items.show', $item->id) }}" class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition" title="View Details">
                                                <i class="fa-solid fa-eye text-xs"></i>
                                            </a>
                                            @if(!$item->is_resolved)
                                                <form action="{{ route('admin.items.resolve', $item->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="p-1.5 rounded-lg bg-emerald-100 hover:bg-emerald-200 text-emerald-800 transition" title="Mark Resolved">
                                                        <i class="fa-solid fa-check text-xs"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 rounded-lg bg-red-100 hover:bg-red-200 text-red-700 transition" title="Delete Item">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-slate-400">
                                        No items recorded on platform yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $items->links() }}
                </div>
            </div>

            <!-- Claims Review Desk with Automated Anti-Fraud ("Red Claim") Engine -->
            <div class="bg-white rounded-3xl shadow-xs border border-slate-200/90 overflow-hidden p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-100 mb-6">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-red-100 text-red-800">
                                <i class="fa-solid fa-shield-halved text-[9px]"></i> Automated Fraud Sentinel Active
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Student Ownership Claims Verification Desk</h3>
                        <p class="text-xs text-slate-500">Examine proof of ownership and automated timeline anomaly flags before releasing property</p>
                    </div>
                    @if(\App\Models\Claim::where('is_suspicious', true)->where('claim_status', 'pending')->count() > 0)
                        <div class="bg-red-50 border border-red-200 px-3.5 py-2 rounded-xl text-red-800 text-xs font-bold flex items-center gap-2">
                            <i class="fa-solid fa-triangle-exclamation text-red-600 text-sm"></i>
                            <span>{{ \App\Models\Claim::where('is_suspicious', true)->where('claim_status', 'pending')->count() }} Red Claim(s) Awaiting Review</span>
                        </div>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-y border-slate-100">
                            <tr>
                                <th class="py-3 px-4">Item & Intake Date</th>
                                <th class="py-3 px-4">Claimant Information</th>
                                <th class="py-3 px-4">Timeline & Anti-Fraud Audit</th>
                                <th class="py-3 px-4">Proof vs Secret Marker</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 text-right">Administrative Decision</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($claims as $claim)
                                <tr class="hover:bg-slate-50/70 transition {{ $claim->is_suspicious ? 'bg-red-50/40' : '' }}">
                                    <!-- Item & Intake Date -->
                                    <td class="py-3.5 px-4 font-bold text-slate-900 align-top">
                                        @if($claim->item)
                                            <a href="{{ route('items.show', $claim->item->id) }}" class="hover:text-emerald-700 block leading-tight">
                                                {{ $claim->item->title }}
                                            </a>
                                            <span class="text-[10px] text-slate-500 font-normal block mt-1">
                                                📅 {{ $claim->item->status == 'found' ? 'Found on' : 'Lost on' }}: 
                                                <strong class="text-slate-700">{{ $claim->item->date_lost_found ? \Carbon\Carbon::parse($claim->item->date_lost_found)->format('M d, Y') : $claim->item->created_at->format('M d, Y') }}</strong>
                                            </span>
                                            <span class="text-[10px] text-slate-400 font-normal block">
                                                📍 {{ $claim->item->location }}
                                            </span>
                                        @else
                                            <span class="text-slate-400">Item deleted</span>
                                        @endif
                                    </td>

                                    <!-- Claimant Information -->
                                    <td class="py-3.5 px-4 align-top">
                                        <div class="font-bold text-slate-800">{{ $claim->user ? $claim->user->name : 'Claimant' }}</div>
                                        <div class="font-mono text-indigo-700 font-semibold text-[11px] mt-0.5">
                                            {{ $claim->student_registration_number }}
                                        </div>
                                        <div class="mt-0.5">
                                            <a href="tel:{{ $claim->phone_number }}" class="hover:underline text-slate-600 font-mono text-[11px]">
                                                📞 {{ $claim->phone_number }}
                                            </a>
                                        </div>
                                    </td>

                                    <!-- Timeline & Anti-Fraud Audit (Red Claim detection) -->
                                    <td class="py-3.5 px-4 max-w-xs align-top">
                                        <div class="text-[11px] mb-1">
                                            <span class="text-slate-500">Claimant says lost:</span>
                                            <strong class="{{ $claim->is_suspicious ? 'text-red-700' : 'text-slate-800' }}">
                                                {{ $claim->claimed_loss_date ? \Carbon\Carbon::parse($claim->claimed_loss_date)->format('M d, Y') : 'Date unspecified' }}
                                            </strong>
                                        </div>

                                        @if($claim->is_suspicious)
                                            <!-- RED CLAIM ALERT (Visible to Administrator only) -->
                                            <div class="p-2.5 rounded-xl bg-red-100/90 border border-red-300 text-red-900 shadow-xs">
                                                <div class="flex items-center gap-1.5 font-extrabold text-[11px] text-red-800 uppercase tracking-tight">
                                                    <i class="fa-solid fa-triangle-exclamation text-red-600"></i>
                                                    <span>🚩 RED CLAIM / FRAUD ALERT</span>
                                                </div>
                                                <div class="text-[10px] text-red-900 mt-1 whitespace-pre-line leading-relaxed font-medium">
                                                    {{ $claim->flag_reason }}
                                                </div>
                                            </div>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-800 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-md">
                                                <i class="fa-solid fa-check text-[9px] text-emerald-600"></i> Timeline Consistent
                                            </span>
                                        @endif

                                        @if($claim->claimed_location)
                                            <div class="text-[10px] text-slate-500 mt-1.5">
                                                <span>Suspected spot: <em>{{ $claim->claimed_location }}</em></span>
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Proof vs Secret Marker -->
                                    <td class="py-3.5 px-4 max-w-xs align-top">
                                        <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-200/80 text-[11px] text-slate-700 leading-relaxed max-h-24 overflow-y-auto">
                                            <strong class="text-slate-900 block mb-0.5 text-[10px] uppercase font-bold text-slate-500">Claimant's Proof:</strong>
                                            {{ $claim->proof_details }}
                                        </div>

                                        @if($claim->item && $claim->item->secret_identifier)
                                            <div class="mt-1.5 p-2 rounded-xl bg-purple-50 border border-purple-200 text-[10px] text-purple-900">
                                                <strong class="text-purple-800 font-bold block">🔑 Secret Marker on File:</strong>
                                                <span class="font-mono text-purple-950">{{ $claim->item->secret_identifier }}</span>
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Status -->
                                    <td class="py-3.5 px-4 align-top">
                                        @if($claim->claim_status == 'approved')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-emerald-100 text-emerald-800 border border-emerald-200 inline-flex items-center gap-1">
                                                <i class="fa-solid fa-circle-check text-[9px]"></i> Approved
                                            </span>
                                        @elseif($claim->claim_status == 'rejected')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-red-100 text-red-800 border border-red-200 inline-flex items-center gap-1">
                                                <i class="fa-solid fa-circle-xmark text-[9px]"></i> Rejected
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-amber-100 text-amber-800 border border-amber-200 inline-flex items-center gap-1">
                                                <i class="fa-solid fa-clock text-[9px]"></i> Pending Review
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Administrative Actions -->
                                    <td class="py-3.5 px-4 text-right align-top">
                                        <div class="flex flex-col items-end gap-1.5"
                                             x-data="{ rejectOpen: false, msgOpen: false }">

                                            @if($claim->claim_status == 'pending')
                                                <!-- Approve button -->
                                                <form action="{{ route('admin.claims.approve', $claim->id) }}" method="POST" class="inline w-full"
                                                      onsubmit="return confirm('Approve this claim and release property to {{ $claim->user ? addslashes($claim->user->name) : 'claimant' }}?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="w-full px-2.5 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-[11px] transition shadow-2xs flex items-center justify-center gap-1">
                                                        <i class="fa-solid fa-check text-[9px]"></i> Approve & Release
                                                    </button>
                                                </form>

                                                <!-- Reject with reason modal trigger -->
                                                <button @click="rejectOpen = true"
                                                        class="w-full px-2.5 py-1 rounded-lg bg-red-600 hover:bg-red-500 text-white font-bold text-[11px] transition shadow-2xs flex items-center justify-center gap-1">
                                                    <i class="fa-solid fa-xmark text-[9px]"></i> Reject Claim
                                                </button>

                                                <!-- Reject Modal -->
                                                <div x-show="rejectOpen" x-cloak
                                                     class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                                                    <div @click.outside="rejectOpen = false"
                                                         class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 border border-red-100">
                                                        <div class="flex items-center gap-3 mb-4">
                                                            <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center">
                                                                <i class="fa-solid fa-circle-xmark text-red-600 text-lg"></i>
                                                            </div>
                                                            <div>
                                                                <h3 class="font-bold text-slate-900 text-sm">Reject Ownership Claim</h3>
                                                                <p class="text-[11px] text-slate-500">For: <strong>{{ $claim->item ? $claim->item->title : 'Item' }}</strong></p>
                                                            </div>
                                                        </div>
                                                        <form action="{{ route('admin.claims.reject', $claim->id) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="mb-4">
                                                                <label class="block text-xs font-bold text-slate-700 mb-1">Rejection Reason <span class="text-red-500">*</span></label>
                                                                <textarea name="admin_notes" rows="4"
                                                                          placeholder="Explain why the claim is denied, e.g. 'Provided registration number does not match our records. Please visit Security Desk with your student ID card.'"
                                                                          required
                                                                          class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 focus:ring-2 focus:ring-red-300 focus:border-red-400 outline-none resize-none bg-red-50/30"></textarea>
                                                            </div>
                                                            <p class="text-[11px] text-slate-500 mb-4 bg-amber-50 border border-amber-200 rounded-lg px-3 py-2">
                                                                <i class="fa-solid fa-circle-info text-amber-500 mr-1"></i>
                                                                The student <strong>{{ $claim->user ? $claim->user->name : '' }}</strong> will receive an in-app notification with this reason.
                                                            </p>
                                                            <div class="flex gap-2">
                                                                <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold text-xs py-2.5 rounded-xl transition">
                                                                    Confirm Rejection & Notify Student
                                                                </button>
                                                                <button type="button" @click="rejectOpen = false"
                                                                        class="px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-2.5 rounded-xl transition">
                                                                    Cancel
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Send Message button (always visible) -->
                                            @if($claim->user_id)
                                                <button @click="msgOpen = true"
                                                        class="w-full px-2.5 py-1 rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-bold text-[11px] transition flex items-center justify-center gap-1">
                                                    <i class="fa-solid fa-paper-plane text-[9px]"></i> Message Student
                                                </button>

                                                <!-- Send Message Modal -->
                                                <div x-show="msgOpen" x-cloak
                                                     class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                                                    <div @click.outside="msgOpen = false"
                                                         class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 border border-blue-100">
                                                        <div class="flex items-center gap-3 mb-4">
                                                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                                                                <i class="fa-solid fa-envelope text-blue-600 text-lg"></i>
                                                            </div>
                                                            <div>
                                                                <h3 class="font-bold text-slate-900 text-sm">Send Message to Student</h3>
                                                                <p class="text-[11px] text-slate-500">To: <strong>{{ $claim->user->name }}</strong> ({{ $claim->student_registration_number }})</p>
                                                            </div>
                                                        </div>
                                                        <form action="{{ route('admin.messages.send') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="to_user_id" value="{{ $claim->user_id }}">
                                                            <input type="hidden" name="claim_id" value="{{ $claim->id }}">
                                                            <div class="mb-3">
                                                                <label class="block text-xs font-bold text-slate-700 mb-1">Subject</label>
                                                                <input type="text" name="subject"
                                                                       value="Message from Campus Security Administration"
                                                                       class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:ring-2 focus:ring-blue-300 outline-none bg-slate-50">
                                                            </div>
                                                            <div class="mb-4">
                                                                <label class="block text-xs font-bold text-slate-700 mb-1">Message <span class="text-red-500">*</span></label>
                                                                <textarea name="body" rows="4" required
                                                                          placeholder="e.g. 'Please come to the Security Desk in the Administration Block with your Student ID card to proceed with your claim...'"
                                                                          class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 focus:ring-2 focus:ring-blue-300 focus:border-blue-400 outline-none resize-none bg-blue-50/20"></textarea>
                                                            </div>
                                                            <div class="flex gap-2">
                                                                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-2.5 rounded-xl transition">
                                                                    <i class="fa-solid fa-paper-plane mr-1 text-[10px]"></i> Send Message
                                                                </button>
                                                                <button type="button" @click="msgOpen = false"
                                                                        class="px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-2.5 rounded-xl transition">
                                                                    Cancel
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($claim->item)
                                                <a href="{{ route('items.show', $claim->item->id) }}" class="text-[11px] font-bold text-slate-600 hover:text-emerald-700 hover:underline">
                                                    Inspect Item ➔
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-slate-400">
                                        <i class="fa-solid fa-inbox text-3xl mb-2 text-slate-300 block"></i>
                                        No claims pending review.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $claims->links() }}
                </div>
            </div>


            <!-- Registered Users Directory -->
            <div class="bg-white rounded-3xl shadow-xs border border-slate-200/90 overflow-hidden p-6 sm:p-8">
                <div class="pb-5 border-b border-slate-100 mb-6">
                    <h3 class="text-lg font-bold text-slate-900">Registered Campus Accounts Directory</h3>
                    <p class="text-xs text-slate-500">Audit registered students and faculty on the system</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-y border-slate-100">
                            <tr>
                                <th class="py-3 px-4">Name</th>
                                <th class="py-3 px-4">Email</th>
                                <th class="py-3 px-4">Registration No.</th>
                                <th class="py-3 px-4">Role Clearance</th>
                                <th class="py-3 px-4">School & Course</th>
                                <th class="py-3 px-4">Registered Purpose</th>
                                @if(Auth::user()->isSuperAdmin())
                                    <th class="py-3 px-4 text-right">Super User Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($users as $user)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="py-3.5 px-4 font-bold text-slate-900">
                                        <div class="flex items-center gap-2">
                                            <span>{{ $user->name }}</span>
                                            @if($user->id === auth()->id())
                                                <span class="text-[9px] px-1 py-0.2 bg-purple-100 text-purple-800 rounded font-bold">You</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600">{{ $user->email }}</td>
                                    <td class="py-3.5 px-4 font-mono font-semibold text-slate-700">{{ $user->reg_number ?? 'N/A' }}</td>
                                    <td class="py-3.5 px-4">
                                        @if($user->is_super_admin)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-purple-100 text-purple-800">
                                                <i class="fa-solid fa-crown text-[9px]"></i> Super Admin
                                            </span>
                                        @elseif($user->is_admin)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-100 text-indigo-800">
                                                <i class="fa-solid fa-shield-halved text-[9px]"></i> Administrator
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600">
                                                Standard User
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600">{{ $user->school ?? 'Kisii University' }} • {{ $user->course ?? 'N/A' }}</td>
                                    <td class="py-3.5 px-4">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-700">
                                            {{ $user->reason_for_registering ?? 'Student' }}
                                        </span>
                                    </td>
                                    @if(Auth::user()->isSuperAdmin())
                                        <td class="py-3.5 px-4 text-right">
                                            @if(!$user->is_admin && !$user->is_super_admin)
                                                <form action="{{ route('admin.administrators.promote', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Promote {{ $user->name }} to Campus Administrator?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="role" value="admin">
                                                    <button type="submit" class="text-[11px] font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 px-2.5 py-1 rounded-lg transition">
                                                        <i class="fa-solid fa-plus text-[9px]"></i> Make Admin
                                                    </button>
                                                </form>
                                            @elseif($user->id !== auth()->id())
                                                <a href="{{ route('admin.administrators.index') }}" class="text-[11px] font-bold text-purple-700 hover:underline">
                                                    Manage ➔
                                                </a>
                                            @else
                                                <span class="text-[10px] text-slate-400">Current</span>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ Auth::user()->isSuperAdmin() ? '7' : '6' }}" class="py-8 text-center text-slate-400">
                                        No users registered.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
