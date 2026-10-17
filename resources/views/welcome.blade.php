<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kisii University - Official Lost & Found Portal</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/kisii-logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/kisii-logo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .hero-pattern {
            background-color: #064e3b;
            background-image: radial-gradient(rgba(16, 185, 129, 0.15) 1px, transparent 1px), radial-gradient(rgba(16, 185, 129, 0.15) 1px, #064e3b 1px);
            background-size: 40px 40px;
            background-position: 0 0, 20px 20px;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen selection:bg-emerald-500 selection:text-white">

    <!-- Global Page Transition Loader -->
    @include('layouts.page-loader')

    <!-- Unified Official Navigation Bar -->
    @include('layouts.navigation')

    <!-- Flash Notification for Guest Posts / Redirects -->
    @if(session('success'))
        <div class="bg-emerald-700 text-white text-sm font-semibold py-3.5 px-5 flex items-center justify-center gap-3 shadow-sm">
            <i class="fa-solid fa-circle-check text-emerald-200 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-600 text-white text-sm font-semibold py-3.5 px-5 flex items-center justify-center gap-3 shadow-sm">
            <i class="fa-solid fa-circle-exclamation text-red-200 text-base"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Hero Section with Kisii University Campus Background -->
    <div class="relative bg-slate-900 text-white py-20 lg:py-28 px-4 overflow-hidden border-b border-emerald-800/80">
        <!-- Campus Background Photo -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/hero-bg.png') }}" alt="Kisii University Campus Academic Block" class="w-full h-full object-cover object-center">
            <!-- LINE 61: 5% subtle overlay. Change 'bg-black/5' to whatever percentage you want (e.g. bg-black/0, bg-black/10, bg-emerald-950/5) -->
            <div class="absolute inset-0 bg-black/20"></div>
        </div>

        <!-- Decorative Glow Orbs -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-4xl mx-auto space-y-7 text-center relative z-10">
            <!-- Badge with Logo -->
            <div class="inline-flex items-center gap-2.5 bg-emerald-900/80 backdrop-blur-md text-emerald-200 border border-emerald-500/40 text-xs font-semibold px-4 py-1.5 rounded-full uppercase tracking-widest shadow-md">
                <img src="{{ asset('images/kisii-logo.png') }}" alt="Kisii University" class="w-4 h-4 object-contain inline-block">
                <span>Kisii University Property Recovery Desk</span>
            </div>

            <!-- Main Heading -->
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight drop-shadow-[0_3px_10px_rgba(0,0,0,0.85)]">
                Find What You Lost on <span class="text-amber-300 drop-shadow-[0_2px_8px_rgba(0,0,0,0.85)]">Campus</span>
            </h1>

            <p class="text-white text-base sm:text-lg max-w-2xl mx-auto font-medium leading-relaxed drop-shadow-[0_2px_6px_rgba(0,0,0,0.85)]">
                Official property recovery portal for Kisii University students, faculty, and campus staff. Report lost items, register found property, and securely claim belongings.
            </p>
            
            <!-- Unified Search Bar Form (Disabled until text entered; requires login to browse) -->
            <form id="searchForm" action="{{ Auth::check() ? route('items.index') : route('login') }}" method="GET" class="max-w-2xl mx-auto bg-white p-2 sm:p-2.5 rounded-2xl shadow-2xl flex flex-col sm:flex-row gap-2 border border-emerald-100">
                @guest
                    <input type="hidden" name="message" value="Please log in or register to search and browse campus items.">
                @endguest
                <div class="flex-1 flex items-center px-3.5 py-1.5 text-gray-800">
                    <i class="fa-solid fa-magnifying-glass text-emerald-700 text-base mr-3"></i>
                    <input type="text" id="searchInput" name="search" placeholder="Search items (e.g., HP Laptop, Student ID, Keys)..." class="w-full text-slate-800 placeholder-slate-400 border-0 focus:ring-0 focus:outline-none text-sm bg-transparent font-medium" autocomplete="off">
                </div>
                <button type="submit" id="searchBtn" class="bg-amber-500 text-emerald-950 font-bold px-7 py-3 rounded-xl transition duration-150 shadow-md flex items-center justify-center gap-2 text-sm opacity-50 cursor-not-allowed" disabled>
                    <i class="fa-solid fa-search"></i>
                    <span>Search Items</span>
                </button>
            </form>

            @guest
                <p class="text-[11px] text-emerald-200/80 -mt-3">
                    <i class="fa-solid fa-lock text-emerald-400 mr-1"></i> An account is required to browse and search items. <a href="{{ route('login') }}" class="underline font-bold text-white hover:text-amber-300">Sign in</a> or <a href="{{ route('register') }}" class="underline font-bold text-white hover:text-amber-300">Register</a>.
                </p>
            @endguest

            <!-- Quick Action Direct Routing Buttons -->
            <div class="flex flex-wrap justify-center items-center gap-3.5 pt-1">
                <a href="{{ route('items.create') }}?status=found" class="group bg-emerald-800/80 hover:bg-emerald-700 backdrop-blur-md border border-emerald-600/40 text-white font-semibold px-5 py-3 rounded-xl transition duration-200 text-sm flex items-center gap-2.5 shadow-md hover:shadow-lg hover:-translate-y-0.5" title="No account required to report">
                    <span class="w-7 h-7 rounded-lg bg-emerald-500/30 flex items-center justify-center text-emerald-300 group-hover:scale-110 transition">
                        <i class="fa-solid fa-circle-plus"></i>
                    </span>
                    <span>Report Found Item <span class="text-[10px] bg-emerald-700/60 text-emerald-200 px-1.5 py-0.5 rounded ml-1 font-normal">Public</span></span>
                </a>

                <a href="{{ route('items.create') }}?status=lost" class="group bg-emerald-800/80 hover:bg-emerald-700 backdrop-blur-md border border-emerald-600/40 text-white font-semibold px-5 py-3 rounded-xl transition duration-200 text-sm flex items-center gap-2.5 shadow-md hover:shadow-lg hover:-translate-y-0.5" title="No account required to report">
                    <span class="w-7 h-7 rounded-lg bg-amber-500/30 flex items-center justify-center text-amber-300 group-hover:scale-110 transition">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </span>
                    <span>Report Lost Item <span class="text-[10px] bg-emerald-700/60 text-emerald-200 px-1.5 py-0.5 rounded ml-1 font-normal">Public</span></span>
                </a>

                @auth
                    <a href="{{ route('items.index') }}" class="group bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white font-semibold px-5 py-3 rounded-xl transition duration-200 text-sm flex items-center gap-2.5 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                        <i class="fa-solid fa-list-ul text-emerald-300"></i>
                        <span>Browse My Filtered Feed</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="group bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white font-semibold px-5 py-3 rounded-xl transition duration-200 text-sm flex items-center gap-2.5 shadow-md hover:shadow-lg hover:-translate-y-0.5" title="Sign in required to browse">
                        <i class="fa-solid fa-lock text-amber-300"></i>
                        <span>Browse Items (Login Required)</span>
                    </a>
                @endauth
            </div>

            <!-- Quick Stats Strip -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 max-w-3xl mx-auto pt-8 border-t border-emerald-800/50 text-left">
                <div class="bg-emerald-900/60 backdrop-blur-sm p-3.5 rounded-xl border border-emerald-700/50">
                    <div class="text-xs text-emerald-300 font-medium">Coverage</div>
                    <div class="text-lg font-bold text-white">All Campus Blocks</div>
                </div>
                <div class="bg-emerald-900/60 backdrop-blur-sm p-3.5 rounded-xl border border-emerald-700/50">
                    <div class="text-xs text-emerald-300 font-medium">Verification</div>
                    <div class="text-lg font-bold text-white">Student Reg No.</div>
                </div>
                <div class="bg-emerald-900/60 backdrop-blur-sm p-3.5 rounded-xl border border-emerald-700/50">
                    <div class="text-xs text-emerald-300 font-medium">Direct Hotline</div>
                    <div class="text-lg font-bold text-white">+254 58 2030161</div>
                </div>
                <div class="bg-emerald-900/60 backdrop-blur-sm p-3.5 rounded-xl border border-emerald-700/50">
                    <div class="text-xs text-emerald-300 font-medium">Admin Office</div>
                    <div class="text-lg font-bold text-white">Main Admin Block</div>
                </div>
            </div>

        </div>
    </div>

    <!-- Quick Navigation Hub Strip -->
    <div class="bg-white border-b border-slate-200/90 py-5 px-4 shadow-xs">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                <i class="fa-solid fa-compass text-emerald-600"></i> Quick Portals:
            </div>
            <div class="flex flex-wrap items-center gap-2 sm:gap-3 text-xs font-semibold">
                @auth
                    <a href="{{ route('items.index') }}" class="px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 transition border border-slate-200">
                        <i class="fa-solid fa-box text-emerald-600 mr-1"></i> All Items Feed
                    </a>
                    <a href="{{ route('dashboard') }}" class="px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 transition border border-slate-200">
                        <i class="fa-solid fa-gauge-high text-amber-600 mr-1"></i> General Dashboard
                    </a>
                    <a href="{{ route('dashboard.finder') }}" class="px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 transition border border-slate-200">
                        <i class="fa-solid fa-box-open text-emerald-600 mr-1"></i> Finder Hub
                    </a>
                    <a href="{{ route('dashboard.seeker') }}" class="px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 transition border border-slate-200">
                        <i class="fa-solid fa-magnifying-glass text-teal-600 mr-1"></i> Seeker Hub
                    </a>
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-indigo-50 text-slate-700 hover:text-indigo-700 transition border border-slate-200">
                            <i class="fa-solid fa-shield-halved text-indigo-600 mr-1"></i> Admin Desk
                        </a>
                    @endif
                @else
                    <a href="{{ route('items.create') }}?status=found" class="px-3.5 py-1.5 rounded-lg bg-emerald-100 hover:bg-emerald-200 text-emerald-800 transition border border-emerald-200">
                        <i class="fa-solid fa-circle-plus text-emerald-600 mr-1"></i> Report Found Item
                    </a>
                    <a href="{{ route('items.create') }}?status=lost" class="px-3.5 py-1.5 rounded-lg bg-amber-100 hover:bg-amber-200 text-amber-800 transition border border-amber-200">
                        <i class="fa-solid fa-triangle-exclamation text-amber-600 mr-1"></i> Report Lost Item
                    </a>
                    <a href="{{ route('login') }}" class="px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200">
                        <i class="fa-solid fa-lock text-slate-400 mr-1"></i> Sign In to Browse
                    </a>
                    <a href="{{ route('register') }}" class="px-3.5 py-1.5 rounded-lg bg-emerald-800 hover:bg-emerald-700 text-white transition">
                        <i class="fa-solid fa-user-plus mr-1"></i> Register Free
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Features / Highlights Section -->
    <div id="services" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                System Architecture & Integrity
            </span>
            <h2 class="text-3xl font-extrabold text-slate-900 mt-3 tracking-tight">Platform Features & Safeguards</h2>
            <p class="text-slate-600 text-sm mt-2">Designed to maintain transparency, security, and reliable property retrieval across all university faculties.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="bg-white p-7 rounded-2xl shadow-sm hover:shadow-md transition duration-200 border border-slate-200/80 flex flex-col justify-between group">
                <div>
                    <div class="w-13 h-13 w-12 h-12 bg-emerald-100 text-emerald-700 rounded-2xl flex items-center justify-center font-bold text-xl mb-5 group-hover:scale-105 transition duration-200 shadow-xs">
                        <i class="fa-solid fa-id-card-clip"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Campus Registration & Verification</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        To ensure campus safety and prevent theft, viewing sensitive contact info and posting official item claims requires your Kisii University student registration number.
                    </p>
                </div>
                <div class="pt-6 border-t border-slate-100 mt-6">
                    <a href="{{ route('register') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1.5">
                        <span>Register with Student ID</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white p-7 rounded-2xl shadow-sm hover:shadow-md transition duration-200 border border-slate-200/80 flex flex-col justify-between group">
                <div>
                    <div class="w-12 h-12 bg-amber-100 text-amber-700 rounded-2xl flex items-center justify-center font-bold text-xl mb-5 group-hover:scale-105 transition duration-200 shadow-xs">
                        <i class="fa-solid fa-camera"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Photographic Proof & Secret Markers</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Upload photos of found items along with secret verification markers (e.g., hidden scratches or lock screen details) known exclusively to the rightful owner.
                    </p>
                </div>
                <div class="pt-6 border-t border-slate-100 mt-6">
                    <a href="{{ route('items.create') }}?status=found" class="text-xs font-bold text-amber-700 hover:text-amber-800 flex items-center gap-1.5">
                        <span>Post Found Item Evidence</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white p-7 rounded-2xl shadow-sm hover:shadow-md transition duration-200 border border-slate-200/80 flex flex-col justify-between group">
                <div>
                    <div class="w-12 h-12 bg-teal-100 text-teal-700 rounded-2xl flex items-center justify-center font-bold text-xl mb-5 group-hover:scale-105 transition duration-200 shadow-xs">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Campus Security Oversight</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        High-value assets such as electronics and official documents are cataloged and monitored in coordination with the Main Administration Security Desk.
                    </p>
                </div>
                <div class="pt-6 border-t border-slate-100 mt-6">
                    <a href="#security" class="text-xs font-bold text-teal-700 hover:text-teal-800 flex items-center gap-1.5">
                        <span>Contact Security Desk</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Kisii University Campus Retrieval Points & Landmark Gallery -->
    <div class="py-16 bg-white border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">
                        <img src="{{ asset('images/kisii-logo.png') }}" alt="Kisii Logo" class="w-4 h-4 object-contain">
                        <span>Kisii University Campus Network</span>
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Main Campus Locations & Retrieval Hubs</h2>
                    <p class="text-sm text-slate-600 mt-1 max-w-2xl">
                        Lost items can be claimed or surrendered across key official faculty and administrative hubs on campus.
                    </p>
                </div>
                <div class="text-xs font-semibold text-emerald-800 bg-emerald-50 px-3.5 py-2 rounded-xl border border-emerald-200/70 inline-flex items-center gap-2 w-fit">
                    <i class="fa-solid fa-camera text-emerald-600"></i>
                    <span>Official Campus Views</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Landmark 1: Academic Block 11 (Hero Featured) -->
                <div class="group bg-slate-50 rounded-2xl overflow-hidden border border-slate-200/80 hover:shadow-xl transition-all duration-300 flex flex-col">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ asset('images/campus/kisii-academic-block-11.jpg') }}" alt="Kisii University Academic Block" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-3 left-3 bg-emerald-800/90 text-white text-[10px] font-bold px-2.5 py-1 rounded-full backdrop-blur-xs">
                            <i class="fa-solid fa-star text-amber-400 mr-1"></i> Featured Block
                        </span>
                    </div>
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Academic Block A & Halls</h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">Lecture halls, classrooms & departmental inquiry desks.</p>
                        </div>
                        <div class="pt-3 border-t border-slate-200/60 mt-3 text-[11px] text-emerald-700 font-semibold flex items-center justify-between">
                            <span>Ground Floor Desk</span>
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                    </div>
                </div>

                <!-- Landmark 2: Chancellor's Pavilion -->
                <div class="group bg-slate-50 rounded-2xl overflow-hidden border border-slate-200/80 hover:shadow-xl transition-all duration-300 flex flex-col">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ asset('images/campus/kisii-chancellors-pavilion.jpg') }}" alt="Chancellor's Pavilion Kisii University" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-3 left-3 bg-blue-900/90 text-white text-[10px] font-bold px-2.5 py-1 rounded-full backdrop-blur-xs">
                            Events & Sports
                        </span>
                    </div>
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Chancellor's Pavilion</h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">Assembly arena, graduations, student convocations & sporting pavilion.</p>
                        </div>
                        <div class="pt-3 border-t border-slate-200/60 mt-3 text-[11px] text-blue-700 font-semibold flex items-center justify-between">
                            <span>Pavilion Help Post</span>
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                    </div>
                </div>

                <!-- Landmark 3: Academic Complex -->
                <div class="group bg-slate-50 rounded-2xl overflow-hidden border border-slate-200/80 hover:shadow-xl transition-all duration-300 flex flex-col">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ asset('images/campus/kisii-academic-complex.jpg') }}" alt="Academic Complex Kisii University" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-3 left-3 bg-amber-900/90 text-white text-[10px] font-bold px-2.5 py-1 rounded-full backdrop-blur-xs">
                            Main Complex
                        </span>
                    </div>
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Science & Academic Complex</h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">Laboratories, ICT centers, computer labs and faculty offices.</p>
                        </div>
                        <div class="pt-3 border-t border-slate-200/60 mt-3 text-[11px] text-amber-700 font-semibold flex items-center justify-between">
                            <span>Lab Reception Desk</span>
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                    </div>
                </div>

                <!-- Landmark 4: Campus Lawns & Grounds -->
                <div class="group bg-slate-50 rounded-2xl overflow-hidden border border-slate-200/80 hover:shadow-xl transition-all duration-300 flex flex-col">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ asset('images/campus/kisii-campus-lawn.jpg') }}" alt="Campus Lawns and Gardens Kisii University" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-3 left-3 bg-teal-900/90 text-white text-[10px] font-bold px-2.5 py-1 rounded-full backdrop-blur-xs">
                            Campus Grounds
                        </span>
                    </div>
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Main Campus Lawns & Quad</h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">Student common areas, outdoor study walks and perimeter pathways.</p>
                        </div>
                        <div class="pt-3 border-t border-slate-200/60 mt-3 text-[11px] text-teal-700 font-semibold flex items-center justify-between">
                            <span>Patrol Security Desk</span>
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Campus Security Direct Reporting Section -->
    <div id="security" class="bg-gradient-to-r from-emerald-50 via-teal-50 to-emerald-50 border-y border-emerald-200/70 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row items-center justify-between gap-10">
            <div class="space-y-4 max-w-2xl">
                <span class="bg-emerald-200 text-emerald-900 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                    Official Security Hotline
                </span>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Want to Hand Over Property Directly to Campus Security?</h2>
                <p class="text-slate-600 text-sm leading-relaxed">
                    If you have found high-value items such as laptops, smartphones, official national IDs, academic certificates, or wallets, you can deliver them directly to the main campus security desk or contact campus security personnel immediately.
                </p>
                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="tel:+254582030161" class="bg-emerald-700 hover:bg-emerald-600 text-white font-bold px-5 py-2.5 rounded-xl text-xs transition flex items-center gap-2 shadow-sm">
                        <i class="fa-solid fa-phone-volume"></i>
                        <span>Call +254 58 2030161 Now</span>
                    </a>
                    <a href="{{ route('items.create') }}?status=found" class="bg-white hover:bg-slate-50 text-emerald-800 font-bold px-5 py-2.5 rounded-xl text-xs border border-emerald-300 transition flex items-center gap-2 shadow-xs">
                        <i class="fa-solid fa-file-pen"></i>
                        <span>Register Property Online First</span>
                    </a>
                </div>
            </div>

            <!-- Security Office Card -->
            <div class="bg-white p-6 rounded-2xl shadow-md border border-emerald-200/80 w-full lg:w-auto space-y-4 min-w-[320px]">
                <div class="flex items-center space-x-3.5 pb-4 border-b border-slate-100">
                    <div class="w-11 h-11 bg-emerald-100 text-emerald-700 rounded-xl flex items-center justify-center text-lg">
                        <i class="fa-solid fa-phone-volume"></i>
                    </div>
                    <div>
                        <span class="block text-[11px] text-slate-400 uppercase font-bold tracking-wider">Security Hotline</span>
                        <a href="tel:+254582030161" class="font-extrabold text-emerald-800 hover:text-emerald-600 transition text-base tracking-wide block">+254 58 2030161</a>
                        <span class="text-[10px] text-emerald-600 font-semibold">24/7 Campus Coverage</span>
                    </div>
                </div>

                <div class="flex items-center space-x-3.5">
                    <div class="w-11 h-11 bg-teal-100 text-teal-700 rounded-xl flex items-center justify-center text-lg">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <span class="block text-[11px] text-slate-400 uppercase font-bold tracking-wider">Physical Office</span>
                        <span class="font-bold text-slate-900 text-sm">Main Administration Block</span>
                        <span class="text-[10px] text-slate-500 block">Ground Floor, Security Retrieval Desk</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Unified Official Global Footer -->
    @include('layouts.footer')

    <!-- Search Input Validation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchBtn = document.getElementById('searchBtn');
            const searchForm = document.getElementById('searchForm');

            if (searchInput && searchBtn) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.trim();
                    if (query.length > 0) {
                        searchBtn.removeAttribute('disabled');
                        searchBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        searchBtn.classList.add('hover:bg-amber-400', 'cursor-pointer');
                    } else {
                        searchBtn.setAttribute('disabled', 'true');
                        searchBtn.classList.add('opacity-50', 'cursor-not-allowed');
                        searchBtn.classList.remove('hover:bg-amber-400', 'cursor-pointer');
                    }
                });

                if (searchForm) {
                    searchForm.addEventListener('submit', function(e) {
                        if (searchInput.value.trim().length === 0) {
                            e.preventDefault();
                            alert('Please type what you are searching for (e.g. Laptop, ID) before submitting.');
                            return false;
                        }
                    });
                }
            }
        });
    </script>

</body>
</html>