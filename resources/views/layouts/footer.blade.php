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
                    <span class="text-xs text-gray-300 block mb-2.5 font-semibold tracking-wide">Connect With Us:</span>
                    <div class="flex items-center space-x-3">
                        <!-- Facebook -->
                        <a href="https://facebook.com/KisiiUniversityOfficial" target="_blank" rel="noopener noreferrer" aria-label="Kisii University Facebook"
                           class="w-10 h-10 rounded-xl bg-slate-800/90 border border-slate-700/80 hover:border-blue-500 text-blue-400 hover:text-white hover:bg-[#1877F2] flex items-center justify-center shadow-md hover:shadow-blue-500/30 hover:-translate-y-1 transition-all duration-200 group" title="Follow on Facebook">
                            <svg class="w-4 h-4 fill-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>

                        <!-- X / Twitter (Fixes missing icon) -->
                        <a href="https://twitter.com/KisiiUniversity" target="_blank" rel="noopener noreferrer" aria-label="Kisii University on X"
                           class="w-10 h-10 rounded-xl bg-slate-800/90 border border-slate-700/80 hover:border-slate-400 text-slate-200 hover:text-white hover:bg-black flex items-center justify-center shadow-md hover:shadow-slate-600/30 hover:-translate-y-1 transition-all duration-200 group" title="Follow on X (Twitter)">
                            <svg class="w-4 h-4 fill-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>

                        <!-- Instagram -->
                        <a href="https://instagram.com/KisiiUniversity" target="_blank" rel="noopener noreferrer" aria-label="Kisii University Instagram"
                           class="w-10 h-10 rounded-xl bg-slate-800/90 border border-slate-700/80 hover:border-pink-500 text-pink-400 hover:text-white hover:bg-gradient-to-tr hover:from-[#f09433] hover:via-[#dc2743] hover:to-[#bc1888] flex items-center justify-center shadow-md hover:shadow-pink-500/30 hover:-translate-y-1 transition-all duration-200 group" title="Follow on Instagram">
                            <svg class="w-4 h-4 fill-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>

                        <!-- LinkedIn -->
                        <a href="https://linkedin.com/school/kisii-university" target="_blank" rel="noopener noreferrer" aria-label="Kisii University LinkedIn"
                           class="w-10 h-10 rounded-xl bg-slate-800/90 border border-slate-700/80 hover:border-blue-400 text-blue-400 hover:text-white hover:bg-[#0A66C2] flex items-center justify-center shadow-md hover:shadow-blue-500/30 hover:-translate-y-1 transition-all duration-200 group" title="Connect on LinkedIn">
                            <svg class="w-4 h-4 fill-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
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
