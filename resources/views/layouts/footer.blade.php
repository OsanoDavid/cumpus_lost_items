<footer class="bg-gray-900 text-gray-300 pt-14 pb-8 border-t border-gray-800 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
            
            <!-- Column 1: University Identity -->
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-white p-1 rounded-xl flex items-center justify-center shadow-md border border-gray-700">
                        <img src="{{ asset('images/kisii-logo.png') }}" alt="Kisii University Logo" class="w-10 h-10 object-contain">
                    </div>
                    <div>
                        <span class="text-white font-bold text-base tracking-wide block leading-tight">Kisii University</span>
                        <span class="text-xs text-emerald-400 font-semibold uppercase tracking-wider">Lost & Found Portal</span>
                    </div>
                </div>
                <p class="text-xs text-gray-400 leading-relaxed">
                    Official campus property tracking and security retrieval system for students, faculty, and administrative staff across all campus blocks.
                </p>
                <div class="pt-2 text-xs space-y-2 text-gray-400">
                    <p class="flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-emerald-400"></i>
                        <span>Main Admin Block, Ground Floor</span>
                    </p>
                    <p class="flex items-center gap-2">
                        <i class="fa-solid fa-phone text-emerald-400"></i>
                        <a href="tel:+254582030161" class="hover:text-emerald-300 transition font-medium">+254 58 2030161 (Security Hotline)</a>
                    </p>
                </div>
            </div>

            <!-- Column 2: Items & Reporting (Direct Routes) -->
            <div>
                <h4 class="text-white font-semibold text-sm mb-4 tracking-wider uppercase flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Items & Reporting
                </h4>
                <ul class="space-y-2.5 text-xs text-gray-400">
                    <li>
                        <a href="{{ route('items.index') }}" class="hover:text-emerald-300 transition flex items-center gap-2">
                            <i class="fa-solid fa-arrow-right text-[10px] text-gray-500"></i> Browse All Campus Items
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('items.create') }}?status=found" class="hover:text-emerald-300 transition flex items-center gap-2">
                            <i class="fa-solid fa-arrow-right text-[10px] text-gray-500"></i> Report Found Property
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('items.create') }}?status=lost" class="hover:text-emerald-300 transition flex items-center gap-2">
                            <i class="fa-solid fa-arrow-right text-[10px] text-gray-500"></i> Report Lost Property
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('items.index', ['category' => 'Electronics']) }}" class="hover:text-emerald-300 transition flex items-center gap-2">
                            <i class="fa-solid fa-arrow-right text-[10px] text-gray-500"></i> Electronics (Laptops, Phones)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('items.index', ['category' => 'Student ID / Documents']) }}" class="hover:text-emerald-300 transition flex items-center gap-2">
                            <i class="fa-solid fa-arrow-right text-[10px] text-gray-500"></i> Student IDs & Documents
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Column 3: Dashboards & Portals (Direct Routes) -->
            <div>
                <h4 class="text-white font-semibold text-sm mb-4 tracking-wider uppercase flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    Campus Dashboards
                </h4>
                <ul class="space-y-2.5 text-xs text-gray-400">
                    <li>
                        <a href="{{ route('dashboard') }}" class="hover:text-amber-300 transition flex items-center gap-2">
                            <i class="fa-solid fa-gauge-high text-[10px] text-amber-500"></i> General User Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.finder') }}" class="hover:text-emerald-300 transition flex items-center gap-2">
                            <i class="fa-solid fa-box-open text-[10px] text-emerald-400"></i> Finder Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.seeker') }}" class="hover:text-amber-300 transition flex items-center gap-2">
                            <i class="fa-solid fa-magnifying-glass text-[10px] text-amber-400"></i> Seeker Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-300 transition flex items-center gap-2">
                            <i class="fa-solid fa-shield-halved text-[10px] text-blue-400"></i> Admin Operations Desk
                        </a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ route('profile.edit') }}" class="hover:text-white transition flex items-center gap-2">
                                <i class="fa-solid fa-user-gear text-[10px] text-gray-400"></i> My Account & Profile
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>

            <!-- Column 4: Security & Connect -->
            <div class="space-y-4">
                <h4 class="text-white font-semibold text-sm mb-4 tracking-wider uppercase flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Campus Security & Access
                </h4>
                
                <div class="space-y-2 text-xs">
                    @auth
                        <div class="bg-gray-800/80 p-3 rounded-xl border border-gray-700/60">
                            <p class="text-gray-300">Signed in as: <strong class="text-white">{{ Auth::user()->name }}</strong></p>
                            <p class="text-gray-400 text-[11px] truncate">{{ Auth::user()->email }}</p>
                            <form method="POST" action="{{ route('logout') }}" class="mt-2.5">
                                @csrf
                                <button type="submit" class="w-full bg-red-600/20 hover:bg-red-600/30 text-red-400 border border-red-500/30 text-xs py-1.5 px-3 rounded-lg transition font-medium text-center">
                                    <i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Log Out
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex gap-2">
                            <a href="{{ route('login') }}" class="flex-1 bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-semibold py-2 px-3 rounded-lg text-center transition">
                                User Login
                            </a>
                            <a href="{{ route('register') }}" class="flex-1 bg-gray-800 hover:bg-gray-700 text-white text-xs font-semibold py-2 px-3 rounded-lg text-center border border-gray-700 transition">
                                Register
                            </a>
                        </div>
                    @endauth
                </div>

                <div class="pt-2">
                    <span class="text-xs text-gray-400 block mb-2 font-medium">Connect With Us:</span>
                    <div class="flex space-x-3 text-sm text-gray-300">
                        <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-lg bg-gray-800 hover:bg-emerald-600 text-gray-300 hover:text-white flex items-center justify-center transition">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-lg bg-gray-800 hover:bg-emerald-600 text-gray-300 hover:text-white flex items-center justify-center transition">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-lg bg-gray-800 hover:bg-emerald-600 text-gray-300 hover:text-white flex items-center justify-center transition">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-lg bg-gray-800 hover:bg-emerald-600 text-gray-300 hover:text-white flex items-center justify-center transition">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                
                <p class="text-[11px] text-gray-500 pt-1">
                    Kisii, Kenya • P.O. Box 408-40200
                </p>
            </div>

        </div>

        <!-- Bottom Copyright -->
        <div class="pt-6 border-t border-gray-800/80 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500 gap-3">
            <p>&copy; {{ date('Y') }} Kisii University Lost & Found System. Official Property Recovery Desk.</p>
            <div class="flex items-center space-x-4 text-xs">
                <a href="{{ url('/#security') }}" class="hover:text-gray-300 transition">Campus Security Desk</a>
                <span>•</span>
                <a href="{{ url('/#services') }}" class="hover:text-gray-300 transition">Platform Safeguards</a>
                <span>•</span>
                <a href="{{ route('items.index') }}" class="hover:text-gray-300 transition">Browse Items</a>
            </div>
        </div>
    </div>
</footer>
