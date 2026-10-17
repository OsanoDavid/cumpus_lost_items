<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-purple-700 uppercase tracking-wider mb-1">
                    <i class="fa-solid fa-crown text-purple-600"></i> Super User Authority Desk
                </div>
                <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight leading-tight">
                    Create Campus Administrator Account
                </h2>
            </div>
            
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.administrators.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-left"></i> Back to Administrators
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-7">

            <!-- Security Badge Info -->
            <div class="bg-gradient-to-r from-purple-900 to-indigo-900 text-white rounded-3xl p-6 sm:p-7 shadow-xs border border-purple-800 flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center shrink-0 text-xl text-purple-200">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-lg text-white">Delegating Administrative Authority</h3>
                    <p class="text-xs sm:text-sm text-purple-200 mt-1 leading-relaxed">
                        Campus Lost & Found Administrators will receive permissions to view all reported student items, approve and verify ownership claims, mark property as resolved, and manage student security inquiries.
                    </p>
                </div>
            </div>

            <!-- Creation Form Card -->
            <div class="bg-white rounded-3xl shadow-xs border border-slate-200/90 overflow-hidden p-6 sm:p-10">
                <form method="POST" action="{{ route('admin.administrators.store') }}" class="space-y-6">
                    @csrf

                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Administrator Full Name <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-user text-xs"></i>
                            </span>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                                placeholder="e.g. Inspector John Doe"
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-600/20 transition @error('name') border-red-500 @enderror">
                        </div>
                        @error('name')
                            <p class="text-red-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email & Phone Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Institutional or Official Email <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-envelope text-xs"></i>
                                </span>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                    placeholder="admin@kisiiuniversity.ac.ke"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-600/20 transition @error('email') border-red-500 @enderror">
                            </div>
                            @error('email')
                                <p class="text-red-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Official Phone / Hotline
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-phone text-xs"></i>
                                </span>
                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                    placeholder="+254 700 000000"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-600/20 transition @error('phone') border-red-500 @enderror">
                            </div>
                            @error('phone')
                                <p class="text-red-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Select Administrative Clearance Role <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Campus Lost & Found Admin -->
                            <label class="relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition has-checked:border-indigo-600 has-checked:bg-indigo-50/50 border-slate-200 hover:border-slate-300">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs">
                                            <i class="fa-solid fa-shield-halved"></i>
                                        </div>
                                        <span class="font-bold text-xs text-slate-900">Campus Administrator</span>
                                    </div>
                                    <input type="radio" name="role" value="admin" class="text-indigo-600 focus:ring-indigo-500" {{ old('role', 'admin') === 'admin' ? 'checked' : '' }}>
                                </div>
                                <p class="text-[11px] text-slate-500 leading-relaxed">
                                    Can review claims, verify ownership proof, resolve items, delete invalid listings, and audit students.
                                </p>
                            </label>

                            <!-- Super Admin -->
                            <label class="relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition has-checked:border-purple-600 has-checked:bg-purple-50/50 border-slate-200 hover:border-slate-300">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center text-xs">
                                            <i class="fa-solid fa-crown"></i>
                                        </div>
                                        <span class="font-bold text-xs text-slate-900">Super Administrator</span>
                                    </div>
                                    <input type="radio" name="role" value="super_admin" class="text-purple-600 focus:ring-purple-500" {{ old('role') === 'super_admin' ? 'checked' : '' }}>
                                </div>
                                <p class="text-[11px] text-slate-500 leading-relaxed">
                                    Full system governance. Can create other administrators, delegate credentials, promote users, and demote staff.
                                </p>
                            </label>
                        </div>
                        @error('role')
                            <p class="text-red-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password and Confirmation -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Initial Account Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-lock text-xs"></i>
                                </span>
                                <input type="password" id="password" name="password" required
                                    placeholder="Minimum 8 characters"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-600/20 transition @error('password') border-red-500 @enderror">
                            </div>
                            @error('password')
                                <p class="text-red-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Confirm Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-lock-open text-xs"></i>
                                </span>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    placeholder="Re-type password"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-600/20 transition">
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('admin.administrators.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 transition">
                            Cancel
                        </a>
                        <button type="submit" class="bg-purple-700 hover:bg-purple-600 text-white font-extrabold text-xs px-6 py-3 rounded-xl shadow-xs transition flex items-center gap-2">
                            <i class="fa-solid fa-check"></i> Provision Administrator Account
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>
