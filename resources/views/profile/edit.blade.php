<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-emerald-700 uppercase tracking-wider mb-1">
                    <i class="fa-solid fa-user-gear"></i> Account Settings
                </div>
                <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight leading-tight">
                    {{ __('Student / Staff Profile Settings') }}
                </h2>
            </div>
            
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard') }}" class="bg-emerald-800 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-xs">
                    <i class="fa-solid fa-gauge-high"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
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
            </div>

            <!-- Profile Info Card -->
            <div class="p-6 sm:p-8 bg-white border border-slate-200/90 shadow-xs rounded-3xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Password Card -->
            <div class="p-6 sm:p-8 bg-white border border-slate-200/90 shadow-xs rounded-3xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Card -->
            <div class="p-6 sm:p-8 bg-white border border-slate-200/90 shadow-xs rounded-3xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
