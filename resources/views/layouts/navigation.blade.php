<nav x-data="{ open: false, dashOpen: false }" class="bg-emerald-900 text-white shadow-lg sticky top-0 z-50 border-b border-emerald-800/80">
    <!-- Top Announcement Line -->
    <div class="bg-emerald-950 text-emerald-200 text-xs py-1.5 px-4 hidden sm:block border-b border-emerald-900/50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <span class="flex items-center gap-1.5 font-medium">
                <i class="fa-solid fa-shield-halved text-emerald-400"></i>
                Official Kisii University Campus Security & Property Recovery Desk
            </span>
            <div class="flex items-center space-x-4 text-[11px] text-emerald-300">
                <a href="tel:+254582030161" class="hover:text-white transition flex items-center gap-1">
                    <i class="fa-solid fa-phone"></i> +254 58 2030161
                </a>
                <span>•</span>
                <span class="flex items-center gap-1">
                    <i class="fa-solid fa-location-dot"></i> Main Administration Block
                </span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            
            <!-- Brand / Logo -->
            <div class="flex items-center space-x-2.5 sm:space-x-3">
                <a href="{{ url('/') }}" class="flex items-center space-x-2.5 sm:space-x-3 group">
                    <div class="bg-white p-1 rounded-xl flex items-center justify-center shadow-md border border-emerald-600/50 group-hover:scale-105 transition duration-200 shrink-0">
                        <img src="{{ asset('images/kisii-logo.png') }}" alt="Kisii University Logo" class="w-8 h-8 sm:w-9 sm:h-9 object-contain">
                    </div>
                    <div>
                        <span class="text-base sm:text-lg font-extrabold tracking-wide block leading-tight text-white group-hover:text-emerald-200 transition">Kisii University</span>
                        <span class="text-[10px] sm:text-xs text-emerald-300 tracking-wider uppercase font-semibold">Lost &amp; Found Portal</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Nav Links -->
            <div class="hidden lg:flex items-center space-x-1 text-sm font-medium">
                <a href="{{ url('/') }}" class="px-3.5 py-2 rounded-lg transition {{ request()->is('/') ? 'bg-emerald-800/90 text-white font-semibold shadow-inner' : 'text-emerald-100 hover:bg-emerald-800/50 hover:text-white' }}">
                    <i class="fa-solid fa-house mr-1.5 text-xs text-emerald-400"></i> Home
                </a>

                <a href="{{ route('items.index') }}" class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('items.index') ? 'bg-emerald-800/90 text-white font-semibold shadow-inner' : 'text-emerald-100 hover:bg-emerald-800/50 hover:text-white' }}">
                    <i class="fa-solid fa-magnifying-glass mr-1.5 text-xs text-emerald-400"></i> Browse Items
                </a>

                <a href="{{ route('items.create') }}" class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('items.create') ? 'bg-emerald-800/90 text-white font-semibold shadow-inner' : 'text-emerald-100 hover:bg-emerald-800/50 hover:text-white' }}">
                    <i class="fa-solid fa-circle-plus mr-1.5 text-xs text-emerald-300"></i> Report Item
                </a>

                <!-- Dashboards Dropdown -->
                <div class="relative" x-data="{ dashDropdown: false }" @click.outside="dashDropdown = false">
                    <button @click="dashDropdown = !dashDropdown" type="button" class="px-3.5 py-2 rounded-lg transition flex items-center gap-1.5 {{ request()->routeIs('dashboard*') || request()->routeIs('admin.dashboard') ? 'bg-emerald-800/90 text-white font-semibold shadow-inner' : 'text-emerald-100 hover:bg-emerald-800/50 hover:text-white' }}">
                        <i class="fa-solid fa-layer-group text-xs text-amber-400"></i> Dashboards
                        <i class="fa-solid fa-chevron-down text-[10px] ml-0.5 transition-transform duration-200" :class="{ 'rotate-180': dashDropdown }"></i>
                    </button>

                    <div x-show="dashDropdown" 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute left-0 mt-2 w-56 rounded-xl shadow-2xl bg-white text-gray-800 border border-gray-100 py-2 z-50"
                         style="display: none;">
                        <div class="px-3 py-1.5 text-[10px] uppercase font-bold text-gray-400 tracking-wider">
                            Campus Dashboards
                        </div>
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs hover:bg-emerald-50 hover:text-emerald-900 transition {{ request()->routeIs('dashboard') ? 'font-bold text-emerald-700 bg-emerald-50' : 'text-gray-700' }}">
                            <div class="w-6 h-6 rounded-md bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs">
                                <i class="fa-solid fa-gauge-high"></i>
                            </div>
                            <div>
                                <span class="block font-semibold">General Dashboard</span>
                                <span class="text-[10px] text-gray-400">Main overview & stats</span>
                            </div>
                        </a>
                        <a href="{{ route('dashboard.finder') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs hover:bg-emerald-50 hover:text-emerald-900 transition {{ request()->routeIs('dashboard.finder') ? 'font-bold text-emerald-700 bg-emerald-50' : 'text-gray-700' }}">
                            <div class="w-6 h-6 rounded-md bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <div>
                                <span class="block font-semibold">Finder Hub</span>
                                <span class="text-[10px] text-gray-400">Post & track found items</span>
                            </div>
                        </a>
                        <a href="{{ route('dashboard.seeker') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs hover:bg-emerald-50 hover:text-emerald-900 transition {{ request()->routeIs('dashboard.seeker') ? 'font-bold text-amber-700 bg-amber-50' : 'text-gray-700' }}">
                            <div class="w-6 h-6 rounded-md bg-amber-100 text-amber-700 flex items-center justify-center text-xs">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <div>
                                <span class="block font-semibold">Seeker Hub</span>
                                <span class="text-[10px] text-gray-400">Claims & lost items</span>
                            </div>
                        </a>
                        @if(Auth::check() && Auth::user()->isAdmin())
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs hover:bg-emerald-50 hover:text-emerald-900 transition {{ request()->routeIs('admin.dashboard') ? 'font-bold text-indigo-700 bg-indigo-50' : 'text-gray-700' }}">
                                <div class="w-6 h-6 rounded-md bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>
                                <div>
                                    <span class="block font-semibold">Admin Operations</span>
                                    <span class="text-[10px] text-gray-400">Security & resolution desk</span>
                                </div>
                            </a>
                        @endif
                        @if(Auth::check() && Auth::user()->isSuperAdmin())
                            <a href="{{ route('admin.administrators.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs hover:bg-purple-50 hover:text-purple-900 transition {{ request()->routeIs('admin.administrators.*') ? 'font-bold text-purple-700 bg-purple-50' : 'text-gray-700' }}">
                                <div class="w-6 h-6 rounded-md bg-purple-100 text-purple-700 flex items-center justify-center text-xs">
                                    <i class="fa-solid fa-crown"></i>
                                </div>
                                <div>
                                    <span class="block font-semibold">Manage Admins</span>
                                    <span class="text-[10px] text-gray-400">Super user role delegation</span>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>

                <a href="{{ url('/#services') }}" class="px-3 py-2 rounded-lg text-emerald-100 hover:bg-emerald-800/50 hover:text-white transition">
                    Services
                </a>

                <a href="{{ url('/#security') }}" class="px-3 py-2 rounded-lg text-emerald-100 hover:bg-emerald-800/50 hover:text-white transition">
                    Campus Security
                </a>
            </div>

            <!-- Right Side Auth Actions -->
            <div class="hidden lg:flex items-center space-x-3">
                @auth
                    <!-- Notification Bell -->
                    @php $unreadCount = Auth::user()->unreadMessageCount(); @endphp
                    <a href="{{ route('notifications.inbox') }}"
                       class="relative flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-800/70 hover:bg-emerald-700 border border-emerald-700/60 text-emerald-100 hover:text-white transition group"
                       title="Notifications">
                        <i class="fa-solid fa-bell text-sm {{ $unreadCount > 0 ? 'animate-pulse text-amber-300' : '' }}"></i>
                        @if($unreadCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px] bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center shadow-md px-0.5">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Profile & User Menu -->
                    <div class="relative" x-data="{ userMenuOpen: false }" @click.outside="userMenuOpen = false">
                        <button @click="userMenuOpen = !userMenuOpen" type="button" class="flex items-center space-x-2.5 bg-emerald-800 hover:bg-emerald-700/80 px-3 py-2 rounded-xl text-xs font-semibold border border-emerald-700 transition">
                            <div class="w-7 h-7 rounded-lg {{ Auth::user()->isSuperAdmin() ? 'bg-purple-600' : (Auth::user()->isAdmin() ? 'bg-indigo-600' : 'bg-emerald-600') }} flex items-center justify-center text-white font-bold text-xs shadow-inner">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="text-left leading-tight hidden xl:block">
                                <span class="block font-bold text-white max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] {{ Auth::user()->isSuperAdmin() ? 'text-purple-300' : (Auth::user()->isAdmin() ? 'text-indigo-300' : 'text-emerald-300') }} uppercase tracking-wider font-bold">
                                    {{ Auth::user()->isSuperAdmin() ? 'Super Admin' : (Auth::user()->isAdmin() ? 'Admin' : (Auth::user()->reason_for_registering === 'Posting a lost item' ? 'Finder' : 'Student')) }}
                                </span>
                            </div>
                            <i class="fa-solid fa-chevron-down text-[10px] text-emerald-300 ml-1"></i>
                        </button>

                        <div x-show="userMenuOpen"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-64 rounded-xl shadow-2xl bg-white text-gray-800 border border-gray-100 py-2 z-50"
                             style="display: none;">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-xs font-bold text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                <div class="mt-1 flex items-center gap-1.5 flex-wrap">
                                    @if(Auth::user()->isSuperAdmin())
                                        <span class="bg-purple-100 text-purple-800 text-[10px] font-bold px-2 py-0.5 rounded flex items-center gap-1">
                                            <i class="fa-solid fa-crown text-[9px]"></i> Super Administrator
                                        </span>
                                    @elseif(Auth::user()->isAdmin())
                                        <span class="bg-indigo-100 text-indigo-800 text-[10px] font-bold px-2 py-0.5 rounded flex items-center gap-1">
                                            <i class="fa-solid fa-shield-halved text-[9px]"></i> Campus Administrator
                                        </span>
                                    @endif
                                    @if(Auth::user()->reg_number)
                                        <span class="bg-emerald-50 text-emerald-700 text-[10px] font-semibold px-2 py-0.5 rounded">
                                            {{ Auth::user()->reg_number }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="py-1">
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-900 transition">
                                    <i class="fa-solid fa-gauge text-gray-400 w-4"></i> General Dashboard
                                </a>
                                <a href="{{ route('dashboard.finder') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-900 transition">
                                    <i class="fa-solid fa-box-open text-gray-400 w-4"></i> Finder Dashboard
                                </a>
                                <a href="{{ route('dashboard.seeker') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-900 transition">
                                    <i class="fa-solid fa-magnifying-glass text-gray-400 w-4"></i> Seeker Dashboard
                                </a>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-900 transition">
                                    <i class="fa-solid fa-user-pen text-gray-400 w-4"></i> Profile Settings
                                </a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-indigo-700 hover:bg-indigo-50 font-semibold transition">
                                        <i class="fa-solid fa-shield-halved text-indigo-500 w-4"></i> Admin Operations Desk
                                    </a>
                                @endif
                                @if(Auth::user()->isSuperAdmin())
                                    <a href="{{ route('admin.administrators.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-purple-700 hover:bg-purple-50 font-semibold transition">
                                        <i class="fa-solid fa-crown text-purple-500 w-4"></i> Manage Administrators
                                    </a>
                                @endif
                            </div>


                            <div class="border-t border-gray-100 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition font-medium">
                                        <i class="fa-solid fa-arrow-right-from-bracket w-4"></i> Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-sm font-semibold text-emerald-100 hover:text-white hover:bg-emerald-800/60 transition">
                        Log In
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-amber-500 hover:bg-amber-400 text-emerald-950 px-4 py-2 rounded-lg text-sm font-bold shadow transition">
                            Register
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Hamburger Button for Mobile -->
            <div class="flex items-center lg:hidden">
                <button @click="open = !open" type="button" class="p-2 rounded-lg text-emerald-200 hover:text-white hover:bg-emerald-800 transition focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Drawer Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden lg:hidden bg-emerald-950 border-t border-emerald-800">
        <div class="px-4 pt-3 pb-4 space-y-1 text-sm">
            <a href="{{ url('/') }}" class="block px-3 py-2.5 rounded-lg text-emerald-100 hover:bg-emerald-800 hover:text-white font-medium {{ request()->is('/') ? 'bg-emerald-800 font-bold text-white' : '' }}">
                <i class="fa-solid fa-house mr-2 text-emerald-400"></i> Home
            </a>
            <a href="{{ route('items.index') }}" class="block px-3 py-2.5 rounded-lg text-emerald-100 hover:bg-emerald-800 hover:text-white font-medium {{ request()->routeIs('items.index') ? 'bg-emerald-800 font-bold text-white' : '' }}">
                <i class="fa-solid fa-magnifying-glass mr-2 text-emerald-400"></i> Browse Items
            </a>
            <a href="{{ route('items.create') }}" class="block px-3 py-2.5 rounded-lg text-emerald-100 hover:bg-emerald-800 hover:text-white font-medium {{ request()->routeIs('items.create') ? 'bg-emerald-800 font-bold text-white' : '' }}">
                <i class="fa-solid fa-circle-plus mr-2 text-emerald-300"></i> Report Lost or Found Item
            </a>
            
            <!-- Dashboard links for mobile -->
            <div class="pt-2 pb-1 border-t border-emerald-900">
                <span class="px-3 text-[11px] font-bold uppercase text-emerald-400 tracking-wider">Campus Dashboards</span>
            </div>
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-emerald-100 hover:bg-emerald-800 hover:text-white text-xs {{ request()->routeIs('dashboard') ? 'bg-emerald-800 font-bold text-white' : '' }}">
                <i class="fa-solid fa-gauge-high mr-2 text-emerald-400"></i> General Dashboard
            </a>
            <a href="{{ route('dashboard.finder') }}" class="block px-3 py-2 rounded-lg text-emerald-100 hover:bg-emerald-800 hover:text-white text-xs {{ request()->routeIs('dashboard.finder') ? 'bg-emerald-800 font-bold text-white' : '' }}">
                <i class="fa-solid fa-box-open mr-2 text-emerald-400"></i> Finder Dashboard
            </a>
            <a href="{{ route('dashboard.seeker') }}" class="block px-3 py-2 rounded-lg text-emerald-100 hover:bg-emerald-800 hover:text-white text-xs {{ request()->routeIs('dashboard.seeker') ? 'bg-emerald-800 font-bold text-white' : '' }}">
                <i class="fa-solid fa-magnifying-glass mr-2 text-amber-400"></i> Seeker Dashboard
            </a>
            @if(Auth::check() && Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-emerald-100 hover:bg-emerald-800 hover:text-white text-xs {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-800 font-bold text-white' : '' }}">
                    <i class="fa-solid fa-shield-halved mr-2 text-indigo-400"></i> Admin Operations Desk
                </a>
            @endif
            @if(Auth::check() && Auth::user()->isSuperAdmin())
                <a href="{{ route('admin.administrators.index') }}" class="block px-3 py-2 rounded-lg text-purple-200 hover:bg-purple-900 hover:text-white text-xs {{ request()->routeIs('admin.administrators.*') ? 'bg-purple-900 font-bold text-white' : '' }}">
                    <i class="fa-solid fa-crown mr-2 text-purple-400"></i> Manage Administrators
                </a>
            @endif


            <div class="pt-2 pb-1 border-t border-emerald-900">
                <span class="px-3 text-[11px] font-bold uppercase text-emerald-400 tracking-wider">Quick Info</span>
            </div>
            <a href="{{ url('/#services') }}" class="block px-3 py-2 rounded-lg text-emerald-200 hover:text-white text-xs">
                <i class="fa-solid fa-circle-info mr-2"></i> System Safeguards & Services
            </a>
            <a href="{{ url('/#security') }}" class="block px-3 py-2 rounded-lg text-emerald-200 hover:text-white text-xs">
                <i class="fa-solid fa-phone mr-2"></i> Campus Security Hotline
            </a>
        </div>

        <!-- Mobile User Area -->
        <div class="pt-3 pb-4 px-4 border-t border-emerald-900 bg-emerald-900/60">
            @auth
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-9 h-9 rounded-lg bg-emerald-700 flex items-center justify-center font-bold text-white">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-bold text-white text-sm">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-emerald-300">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-xs text-emerald-200 hover:bg-emerald-800 hover:text-white">
                        <i class="fa-solid fa-user-pen mr-2"></i> Profile Settings
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-xs text-red-300 hover:bg-red-900/50 hover:text-red-100 font-medium">
                            <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Sign Out
                        </button>
                    </form>
                </div>
            @else
                <div class="grid grid-cols-2 gap-2 pt-2">
                    <a href="{{ route('login') }}" class="text-center py-2 px-3 rounded-lg bg-emerald-800 text-white font-semibold text-xs hover:bg-emerald-700 transition">
                        Log In
                    </a>
                    <a href="{{ route('register') }}" class="text-center py-2 px-3 rounded-lg bg-amber-500 text-emerald-950 font-bold text-xs hover:bg-amber-400 transition">
                        Register
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>
