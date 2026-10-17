<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-emerald-800 uppercase tracking-wider mb-1">
                    <img src="{{ asset('images/kisii-logo.png') }}" alt="Kisii University" class="w-5 h-5 object-contain inline-block"> Kisii University Portal
                </div>
                <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight leading-tight">
                    Campus Lost & Found Hub — General Dashboard
                </h2>
            </div>
            
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('items.create') }}?status=found" class="bg-emerald-700 hover:bg-emerald-600 text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-plus"></i> Report Found
                </a>
                <a href="{{ route('items.create') }}?status=lost" class="bg-amber-500 hover:bg-amber-400 text-emerald-950 px-4 py-2 rounded-xl text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                    <i class="fa-solid fa-triangle-exclamation"></i> Report Lost
                </a>
                <a href="{{ route('items.index') }}" class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                    <i class="fa-solid fa-magnifying-glass"></i> Browse All
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-7">
            
            <!-- Dashboard Switcher Tabs -->
            <div class="bg-white p-2 rounded-2xl shadow-xs border border-slate-200/90 flex flex-wrap gap-2 text-xs font-bold">
                <a href="{{ route('dashboard') }}" class="px-4 py-2.5 rounded-xl bg-emerald-800 text-white shadow-xs flex items-center gap-2">
                    <i class="fa-solid fa-gauge-high text-emerald-300"></i>
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

            <!-- Welcome Profile Banner -->
            <div class="bg-gradient-to-r from-emerald-900 to-teal-900 text-white rounded-3xl p-6 sm:p-8 shadow-md border border-emerald-800/80 relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-emerald-700/20 rounded-full blur-2xl"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-1.5 bg-emerald-800/80 text-emerald-200 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">
                            <i class="fa-solid fa-user-graduate"></i> Verified Student / Member
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-white">
                            Welcome back, {{ Auth::user()->name }}!
                        </h3>
                        <p class="text-xs sm:text-sm text-emerald-100 max-w-2xl leading-relaxed">
                            School of <strong>{{ Auth::user()->school ?? 'Kisii University Main Campus' }}</strong> 
                            • Course: <strong>{{ Auth::user()->course ?? 'General Studies' }}</strong>
                            • Reg No: <strong class="text-emerald-200">{{ Auth::user()->reg_number ?? 'Verified' }}</strong>
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('profile.edit') }}" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white px-4 py-2.5 rounded-xl text-xs font-semibold transition text-center flex items-center justify-center gap-2">
                            <i class="fa-solid fa-user-pen"></i> Edit Profile
                        </a>
                        @if(Auth::user()->reason_for_registering === 'Posting a lost item')
                            <a href="{{ route('dashboard.finder') }}" class="bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition shadow-xs text-center flex items-center justify-center gap-2">
                                <i class="fa-solid fa-box-open"></i> Open Finder Hub ➔
                            </a>
                        @else
                            <a href="{{ route('dashboard.seeker') }}" class="bg-amber-500 hover:bg-amber-400 text-emerald-950 px-4 py-2.5 rounded-xl text-xs font-bold transition shadow-xs text-center flex items-center justify-center gap-2">
                                <i class="fa-solid fa-magnifying-glass"></i> Open Seeker Hub ➔
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Search Scope Advisory -->
            @php
                $user = Auth::user();
                $isAdmin = (bool) $user->is_admin;
                $searchIntent = $user->what_searching ?: $user->what_lost;

                if ($isAdmin) {
                    $totalItems = \App\Models\Item::count();
                    $lostItems = \App\Models\Item::where('status', 'lost')->count();
                    $foundItems = \App\Models\Item::where('status', 'found')->count();
                    $matchingCampusItems = \App\Models\Item::latest()->take(6)->get();
                } else {
                    $scopedQuery = \App\Models\Item::forSearchIntent($searchIntent);
                    $totalItems = (clone $scopedQuery)->count();
                    $lostItems = (clone $scopedQuery)->where('status', 'lost')->count();
                    $foundItems = (clone $scopedQuery)->where('status', 'found')->count();
                    $matchingCampusItems = (clone $scopedQuery)->latest()->take(6)->get();
                }
                $userItemsCount = $user->items()->count();
                $userClaimsCount = $user->claims()->count();
                $myLostMatches = $user->getActiveLostItemMatches();
            @endphp

            @if(!$isAdmin)
                <div class="bg-emerald-50 border-l-4 border-emerald-600 p-4 rounded-r-2xl shadow-xs flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-xs font-bold">
                            <i class="fa-solid fa-bullseye"></i>
                        </div>
                        <div>
                            <span class="block font-bold text-emerald-950 text-xs uppercase tracking-wider">Search Scope Active: {{ $searchIntent ?? 'General Property' }}</span>
                            <span class="text-xs text-emerald-800">Your dashboard and search filters are personalized to exclusively provide items in this category (e.g. Laptops only, not IDs). Only the Administrator can view all items across campus.</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-indigo-50 border-l-4 border-indigo-600 p-4 rounded-r-2xl shadow-xs flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-xs font-bold">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <span class="block font-bold text-indigo-950 text-xs uppercase tracking-wider">Administrator View</span>
                            <span class="text-xs text-indigo-800">Showing campus-wide statistics across all item categories. Full unrestricted directory clearance.</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Administrator Notices & Status Alerts Banner -->
            @php
                $recentNotices = Auth::user()->receivedMessages()->take(2)->get();
                $deniedClaims = Auth::user()->claims()->where('claim_status', 'rejected')->with('item')->get();
            @endphp

            @if($deniedClaims->count() > 0 || $recentNotices->count() > 0)
                <div class="space-y-3">
                    @foreach($deniedClaims as $denied)
                        <div class="bg-red-50 border-2 border-red-300 rounded-2xl p-4 sm:p-5 text-red-900 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-red-200 text-red-700 flex items-center justify-center text-lg shrink-0 mt-0.5">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="bg-red-200 text-red-900 text-[10px] font-black uppercase px-2 py-0.5 rounded">Claim Denied</span>
                                        <h4 class="font-bold text-sm text-red-950">Claim for "{{ $denied->item ? $denied->item->title : 'Item #' . $denied->item_id }}" was Denied</h4>
                                    </div>
                                    <p class="text-xs text-red-800 mt-1 leading-relaxed">
                                        <strong>Notice from Administrator:</strong> {{ $denied->admin_notes ?? 'Ownership credentials could not be verified.' }}
                                    </p>
                                    <p class="text-[11px] text-red-700 font-medium mt-1">
                                        <i class="fa-solid fa-person-walking mr-1"></i> Visit the Campus Security Desk at Main Administration Block with your Student ID to clarify.
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('notifications.inbox') }}" class="bg-red-700 hover:bg-red-800 text-white font-bold text-xs px-4 py-2 rounded-xl transition shrink-0 text-center">
                                View Full Notice ➔
                            </a>
                        </div>
                    @endforeach

                    @foreach($recentNotices as $notice)
                        @if(!str_contains($notice->subject, 'Denied'))
                            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 text-blue-900 shadow-xs flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-base shrink-0">
                                        <i class="fa-solid fa-envelope"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-xs text-blue-950">{{ $notice->subject }}</h5>
                                        <p class="text-[11px] text-blue-800 line-clamp-1">{{ $notice->body }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('notifications.inbox') }}" class="text-xs font-bold text-blue-700 hover:underline shrink-0">
                                    Read Notice ➔
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif

            <!-- Smart Matched Found Items Section -->
            @if($myLostMatches->count() > 0)
                <div class="bg-gradient-to-r from-emerald-950 via-teal-950 to-slate-900 border-2 border-emerald-500 rounded-3xl p-6 sm:p-8 text-white shadow-xl space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-emerald-800/80 pb-5">
                        <div class="space-y-1">
                            <div class="inline-flex items-center gap-2 bg-amber-400 text-emerald-950 text-xs font-black px-3.5 py-1 rounded-full uppercase tracking-wider shadow-sm">
                                <i class="fa-solid fa-bolt text-amber-900"></i> {{ $myLostMatches->count() }} Smart Match(es) Found on Campus!
                            </div>
                            <h3 class="text-xl sm:text-2xl font-black text-white tracking-tight">Potential Found Matches for Your Lost Belongings</h3>
                            <p class="text-xs sm:text-sm text-emerald-200 max-w-2xl leading-relaxed">
                                Our automated intake engine cross-referenced all items found from your loss date to today. Matches found with corresponding category or registration credentials appear below.
                            </p>
                        </div>
                        <span class="text-xs font-bold text-emerald-200 bg-white/10 px-3.5 py-2 rounded-xl border border-white/15 shrink-0 flex items-center gap-2">
                            <i class="fa-solid fa-shield-check text-emerald-400 text-sm"></i> Direct Claim Enabled
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach($myLostMatches as $matchedItem)
                            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-5 flex flex-col justify-between hover:bg-white/15 transition shadow-sm">
                                <div>
                                    <div class="flex items-center justify-between gap-2 mb-2.5">
                                        <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-full {{ $matchedItem->match_type === 'exact_id' ? 'bg-amber-400 text-amber-950' : 'bg-emerald-400 text-emerald-950' }}">
                                            <i class="fa-solid {{ $matchedItem->match_type === 'exact_id' ? 'fa-id-card' : 'fa-calendar-check' }} mr-1"></i>
                                            {{ $matchedItem->match_type === 'exact_id' ? 'Exact ID / Reg Match' : 'Timeline & Category Match' }}
                                        </span>
                                        <span class="text-[11px] text-emerald-200 font-semibold truncate max-w-[120px]">
                                            📍 {{ $matchedItem->location }}
                                        </span>
                                    </div>

                                    <h4 class="font-extrabold text-base text-white line-clamp-1 mb-1">{{ $matchedItem->title }}</h4>
                                    <p class="text-xs text-slate-300 line-clamp-2 mb-3 leading-relaxed">{{ $matchedItem->description }}</p>

                                    <div class="bg-slate-900/60 rounded-xl p-3 border border-emerald-500/30 text-[11px] text-emerald-300 mb-3 space-y-1">
                                        <div class="font-bold text-white flex items-center gap-1.5 text-xs">
                                            <i class="fa-solid fa-circle-check text-emerald-400"></i>
                                            <span>Matching Intel:</span>
                                        </div>
                                        <div class="text-[11px] text-emerald-100 font-medium leading-snug">
                                            {{ $matchedItem->match_reason }}
                                        </div>
                                        @if($matchedItem->matched_lost_item)
                                            <div class="text-[10px] text-slate-400 pt-1 border-t border-white/10">
                                                Corresponds to lost report: <strong class="text-amber-300">"{{ $matchedItem->matched_lost_item->title }}"</strong>
                                                ({{ \Carbon\Carbon::parse($matchedItem->matched_lost_item->date_lost_found)->format('M d, Y') }})
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="pt-3 border-t border-white/15 flex items-center justify-between gap-2">
                                    <div class="text-[11px] text-slate-300">
                                        Found on {{ $matchedItem->date_lost_found ? \Carbon\Carbon::parse($matchedItem->date_lost_found)->format('M d, Y') : $matchedItem->created_at->format('M d, Y') }}
                                    </div>
                                    <a href="{{ route('items.show', $matchedItem->id) }}?from_match=1&loss_date={{ $matchedItem->matched_lost_item ? $matchedItem->matched_lost_item->date_lost_found : '' }}&reg_number={{ urlencode($matchedItem->matched_lost_item->secret_identifier ?? Auth::user()->reg_number ?? '') }}" 
                                       class="bg-amber-400 hover:bg-amber-300 text-emerald-950 font-black text-xs px-4 py-2.5 rounded-xl transition shadow-md flex items-center gap-1.5">
                                        <i class="fa-solid fa-hand-holding-hand"></i>
                                        <span>Claim Item ➔</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Stats Counters Strip -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/90">
                    <div class="flex items-center justify-between text-slate-400 mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                            {{ $isAdmin ? 'All Campus Listings' : 'Items In Your Category' }}
                        </span>
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-slate-900">{{ $totalItems }}</div>
                    <a href="{{ route('items.index') }}" class="text-[11px] font-bold text-emerald-700 hover:underline mt-1 inline-block">
                        {{ $isAdmin ? 'Browse all items ➔' : 'View matching items ➔' }}
                    </a>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/90">
                    <div class="flex items-center justify-between text-slate-400 mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                            {{ $isAdmin ? 'Found on Grounds' : 'Found In Your Scope' }}
                        </span>
                        <div class="w-8 h-8 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-teal-700">{{ $foundItems }}</div>
                    <a href="{{ route('items.index', ['status' => 'found']) }}" class="text-[11px] font-bold text-teal-700 hover:underline mt-1 inline-block">View found items ➔</a>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/90">
                    <div class="flex items-center justify-between text-slate-400 mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                            {{ $isAdmin ? 'Reported Lost' : 'Lost In Your Scope' }}
                        </span>
                        <div class="w-8 h-8 rounded-lg bg-red-100 text-red-700 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-red-600">{{ $lostItems }}</div>
                    <a href="{{ route('items.index', ['status' => 'lost']) }}" class="text-[11px] font-bold text-red-600 hover:underline mt-1 inline-block">View lost reports ➔</a>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/90">
                    <div class="flex items-center justify-between text-slate-400 mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">My Reports & Claims</span>
                        <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-clipboard-user"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-slate-900">{{ $userItemsCount }} <span class="text-xs font-normal text-slate-400">items / {{ $userClaimsCount }} claims</span></div>
                    <span class="text-[11px] text-slate-400 mt-1 inline-block">Managed on this account</span>
                </div>
            </div>

            <!-- Categories Grid -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-slate-900">Campus Property Categories</h3>
                    <a href="{{ route('items.index') }}" class="text-xs font-bold text-emerald-800 hover:underline">View All Category Directory</a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('items.index', ['category' => 'Student ID / Documents']) }}" class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/90 hover:border-emerald-500 hover:shadow-md transition duration-200 group">
                        <div class="text-2xl mb-2">🪪</div>
                        <h4 class="font-bold text-sm text-slate-900 group-hover:text-emerald-700 transition">Student IDs & Docs</h4>
                        <p class="text-xs text-slate-500 mt-1 mb-3">Campus identity cards, library cards & IDs.</p>
                        <span class="text-xs font-semibold bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-lg">Browse IDs ➔</span>
                    </a>

                    <a href="{{ route('items.index', ['category' => 'Electronics']) }}" class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/90 hover:border-emerald-500 hover:shadow-md transition duration-200 group">
                        <div class="text-2xl mb-2">💻</div>
                        <h4 class="font-bold text-sm text-slate-900 group-hover:text-emerald-700 transition">Electronics & Gadgets</h4>
                        <p class="text-xs text-slate-500 mt-1 mb-3">Laptops, smartphones, chargers & flash drives.</p>
                        <span class="text-xs font-semibold bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-lg">Browse Electronics ➔</span>
                    </a>

                    <a href="{{ route('items.index', ['category' => 'Books / Notes']) }}" class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/90 hover:border-emerald-500 hover:shadow-md transition duration-200 group">
                        <div class="text-2xl mb-2">📚</div>
                        <h4 class="font-bold text-sm text-slate-900 group-hover:text-emerald-700 transition">Books & Academic Notes</h4>
                        <p class="text-xs text-slate-500 mt-1 mb-3">Textbooks, lab manuals, assignment notebooks.</p>
                        <span class="text-xs font-semibold bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-lg">Browse Books ➔</span>
                    </a>

                    <a href="{{ route('items.index', ['category' => 'Clothing / Bags']) }}" class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/90 hover:border-emerald-500 hover:shadow-md transition duration-200 group">
                        <div class="text-2xl mb-2">🎒</div>
                        <h4 class="font-bold text-sm text-slate-900 group-hover:text-emerald-700 transition">Bags, Wallets & Keys</h4>
                        <p class="text-xs text-slate-500 mt-1 mb-3">Backpacks, room keys, purses & jackets.</p>
                        <span class="text-xs font-semibold bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-lg">Browse Personal ➔</span>
                    </a>
                </div>
            </div>

            <!-- Two Column: My Reported Items & My Submitted Claims -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- My Reported Items -->
                <div class="bg-white rounded-2xl shadow-xs border border-slate-200/90 p-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Items You Reported</h4>
                            <p class="text-[11px] text-slate-500">Listings created from your account</p>
                        </div>
                        <a href="{{ route('items.create') }}" class="text-xs bg-emerald-700 hover:bg-emerald-600 text-white font-bold px-3 py-1.5 rounded-lg transition">
                            + Post Item
                        </a>
                    </div>

                    @php
                        $myItems = Auth::user()->items()->latest()->take(5)->get();
                    @endphp

                    @if($myItems->count() > 0)
                        <div class="divide-y divide-slate-100">
                            @foreach($myItems as $myItem)
                                <div class="py-3 flex items-center justify-between">
                                    <div class="pr-2">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $myItem->status == 'lost' ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' }}">
                                                {{ $myItem->status }}
                                            </span>
                                            <span class="text-xs font-bold text-slate-800">{{ $myItem->title }}</span>
                                        </div>
                                        <div class="text-[11px] text-slate-500">
                                            📍 {{ $myItem->location }} • {{ $myItem->created_at->format('M d, Y') }}
                                        </div>
                                    </div>
                                    <a href="{{ route('items.show', $myItem->id) }}" class="text-xs font-bold text-emerald-700 hover:underline whitespace-nowrap">
                                        View ➔
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-8 text-center text-slate-400">
                            <i class="fa-solid fa-inbox text-3xl mb-2 text-slate-300"></i>
                            <p class="text-xs">You have not reported any lost or found items yet.</p>
                            <a href="{{ route('items.create') }}" class="inline-block mt-3 text-xs font-bold text-emerald-700 hover:underline">
                                Report an Item Now
                            </a>
                        </div>
                    @endif
                </div>

                <!-- My Claims -->
                <div class="bg-white rounded-2xl shadow-xs border border-slate-200/90 p-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Your Claims & Inquiries</h4>
                            <p class="text-[11px] text-slate-500">Claims submitted to verify your ownership</p>
                        </div>
                        <a href="{{ route('items.index') }}" class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-3 py-1.5 rounded-lg transition">
                            Browse Items
                        </a>
                    </div>

                    @php
                        $myClaims = Auth::user()->claims()->with('item')->latest()->take(5)->get();
                    @endphp

                    @if($myClaims->count() > 0)
                        <div class="divide-y divide-slate-100">
                            @foreach($myClaims as $claim)
                                <div class="py-3 flex items-center justify-between">
                                    <div class="pr-2">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-amber-100 text-amber-800">
                                                {{ $claim->claim_status }}
                                            </span>
                                            <span class="text-xs font-bold text-slate-800">{{ $claim->item ? $claim->item->title : 'Item' }}</span>
                                        </div>
                                        <div class="text-[11px] text-slate-500">
                                            Submitted on {{ $claim->created_at->format('M d, Y') }}
                                        </div>
                                    </div>
                                    @if($claim->item)
                                        <a href="{{ route('items.show', $claim->item->id) }}" class="text-xs font-bold text-emerald-700 hover:underline whitespace-nowrap">
                                            Item Details ➔
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-8 text-center text-slate-400">
                            <i class="fa-solid fa-shield-cat text-3xl mb-2 text-slate-300"></i>
                            <p class="text-xs">You have not submitted any item claims yet.</p>
                            <a href="{{ route('items.index') }}" class="inline-block mt-3 text-xs font-bold text-amber-700 hover:underline">
                                Search Lost & Found Feed
                            </a>
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>
</x-app-layout>