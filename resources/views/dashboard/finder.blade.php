<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-emerald-700 uppercase tracking-wider mb-1">
                    <i class="fa-solid fa-box-open"></i> Finder Workspace
                </div>
                <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight leading-tight">
                    Finder Hub — Surrender & Track Found Campus Property
                </h2>
            </div>
            
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('items.create') }}?status=found" class="bg-emerald-700 hover:bg-emerald-600 text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-plus"></i> Post Found Item
                </a>
                <a href="{{ route('dashboard') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                    <i class="fa-solid fa-gauge-high"></i> General Hub
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
                <a href="{{ route('dashboard.finder') }}" class="px-4 py-2.5 rounded-xl bg-emerald-800 text-white shadow-xs flex items-center gap-2">
                    <i class="fa-solid fa-box-open text-emerald-300"></i>
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
            </div>

            <!-- Header Welcome Card -->
            <div class="bg-emerald-900 text-white rounded-3xl p-6 sm:p-8 shadow-sm border border-emerald-800 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <span class="bg-emerald-800 text-emerald-200 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                        Good Samaritan Desk
                    </span>
                    <h3 class="text-2xl font-bold text-white">Thank you for helping campus colleagues, {{ Auth::user()->name }}!</h3>
                    <p class="text-xs sm:text-sm text-emerald-100 max-w-2xl leading-relaxed">
                        Whenever you discover forgotten belongings around lecture halls, cafeterias, or hostels, post them here with photo evidence and secret markers so rightful owners can verify them.
                    </p>
                </div>
                <div>
                    <a href="{{ route('items.create') }}?status=found" class="bg-amber-500 hover:bg-amber-400 text-emerald-950 font-bold px-6 py-3 rounded-xl text-xs transition shadow-md flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Post a Found Item Now
                    </a>
                </div>
            </div>

            <!-- Campus Security Surrender Advisory Banner -->
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-lg shrink-0">
                        <i class="fa-solid fa-hand-holding-hand"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-amber-950">Campus Security Surrender Recommendation</h4>
                        <p class="text-xs text-amber-800">Found valuable electronics or official IDs? Hand them directly to Main Administration Block Security Desk.</p>
                    </div>
                </div>
                <a href="tel:+254582030161" class="bg-amber-600 hover:bg-amber-500 text-white text-xs font-bold px-4 py-2 rounded-xl transition shrink-0 flex items-center gap-1.5">
                    <i class="fa-solid fa-phone"></i> Call Hotline: +254 58 2030161
                </a>
            </div>

            <!-- Items Found by this User -->
            <div class="bg-white rounded-3xl shadow-xs border border-slate-200/90 p-6 sm:p-8">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Found Items You Have Reported</h3>
                        <p class="text-xs text-slate-500">Track items you picked up and monitor ownership claims</p>
                    </div>
                    <a href="{{ route('items.create') }}?status=found" class="text-xs bg-emerald-700 hover:bg-emerald-600 text-white font-bold px-3.5 py-2 rounded-xl transition">
                        + New Found Item
                    </a>
                </div>

                @php
                    $foundItems = Auth::user()->items()->where('status', 'found')->latest()->get();
                @endphp

                @if($foundItems->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach($foundItems as $item)
                            <div class="border border-slate-200/90 rounded-2xl p-4 flex flex-col justify-between hover:shadow-sm transition">
                                <div>
                                    <div class="flex items-center justify-between text-xs mb-2">
                                        <span class="bg-emerald-100 text-emerald-800 font-bold px-2 py-0.5 rounded text-[10px] uppercase">
                                            Found Property
                                        </span>
                                        <span class="text-slate-400 text-[11px]">{{ $item->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <h4 class="font-bold text-slate-900 text-sm mb-1">{{ $item->title }}</h4>
                                    <p class="text-xs text-emerald-700 font-semibold mb-2">📍 {{ $item->location }}</p>
                                    <p class="text-xs text-slate-500 line-clamp-2 mb-4">{{ $item->description }}</p>
                                </div>
                                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                                    <span class="text-[11px] font-semibold {{ $item->is_resolved ? 'text-emerald-600' : 'text-amber-600' }}">
                                        {{ $item->is_resolved ? '✓ Resolved' : '● Active / Unclaimed' }}
                                    </span>
                                    <a href="{{ route('items.show', $item->id) }}" class="text-xs font-bold text-emerald-800 hover:underline">
                                        View Item Details ➔
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-12 text-center text-slate-400">
                        <i class="fa-solid fa-box-open text-4xl mb-3 text-slate-300"></i>
                        <h4 class="text-base font-bold text-slate-700 mb-1">No found items registered yet</h4>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto mb-4">Have you picked up a lost student card, notebook, or phone on campus? List it so the student can find it.</p>
                        <a href="{{ route('items.create') }}?status=found" class="inline-block bg-emerald-700 hover:bg-emerald-600 text-white font-bold px-5 py-2.5 rounded-xl text-xs transition">
                            Report a Found Item
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>