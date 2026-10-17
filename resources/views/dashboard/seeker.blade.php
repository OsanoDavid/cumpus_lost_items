<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-amber-700 uppercase tracking-wider mb-1">
                    <i class="fa-solid fa-magnifying-glass"></i> Seeker Workspace
                </div>
                <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight leading-tight">
                    Seeker Hub — Search & Recover Missing Belongings
                </h2>
            </div>
            
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('items.create') }}?status=lost" class="bg-amber-500 hover:bg-amber-400 text-emerald-950 px-4 py-2 rounded-xl text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                    <i class="fa-solid fa-triangle-exclamation"></i> Report Lost Item
                </a>
                <a href="{{ route('items.index') }}" class="bg-emerald-800 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                    <i class="fa-solid fa-boxes-stacked"></i> Browse All Feed
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
                <a href="{{ route('dashboard.seeker') }}" class="px-4 py-2.5 rounded-xl bg-amber-500 text-emerald-950 shadow-xs flex items-center gap-2">
                    <i class="fa-solid fa-magnifying-glass text-emerald-950"></i>
                    <span>Seeker Workspace</span>
                </a>
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl text-slate-600 hover:bg-indigo-50 hover:text-indigo-800 transition flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-indigo-500"></i>
                    <span>Admin Operations</span>
                </a>
            </div>

            <!-- Header Welcome Card -->
            <div class="bg-slate-900 text-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <span class="bg-amber-500/20 text-amber-300 border border-amber-500/30 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                        Active Property Search
                    </span>
                    <h3 class="text-2xl font-bold text-white">We're here to help you locate your missing items, {{ Auth::user()->name }}!</h3>
                    <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                        Registered searching interest: <span class="text-amber-300 font-semibold">{{ Auth::user()->what_searching ?? 'General Campus Items' }}</span>. Check recent found reports or publish your lost report so anyone who picks it up can contact you.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('items.index', ['status' => 'found']) }}" class="bg-emerald-700 hover:bg-emerald-600 text-white font-bold px-5 py-3 rounded-xl text-xs transition shadow-md flex items-center justify-center gap-2">
                        <i class="fa-solid fa-search"></i> Search Found Items
                    </a>
                </div>
            </div>

            <!-- Administrator Messages & Claim Status Notices -->
            @php
                $recentNotices = Auth::user()->receivedMessages()->take(3)->get();
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
                                        <i class="fa-solid fa-person-walking mr-1"></i> Please visit the Campus Security Administrator at Main Administration Block with your Student ID card to appeal or clarify.
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
                                    Read Message ➔
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif

            <!-- Quick Item Search Checker (For New & Existing Users) -->
            <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-200/90" x-data="{ query: '{{ request('quick_search', '') }}', searched: {{ request('quick_search') ? 'true' : 'false' }} }">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-slate-100 mb-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-700 uppercase tracking-wider mb-0.5">
                            <i class="fa-solid fa-radar text-amber-500"></i> Instant Intake Scanner
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Check If Your Item Has Been Handed In</h3>
                        <p class="text-xs text-slate-500">Enter your item name, registration number, or student ID number to check current campus intake</p>
                    </div>
                </div>

                <form method="GET" action="{{ route('dashboard.seeker') }}" class="flex flex-col sm:flex-row gap-2.5">
                    <div class="relative flex-1">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
                        <input type="text" name="quick_search" value="{{ request('quick_search') }}"
                               placeholder="e.g. Kisii University Student ID, HP Laptop, Dell Charger, National ID..."
                               class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none bg-slate-50/50">
                    </div>
                    <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-emerald-950 font-bold px-5 py-2.5 rounded-xl text-xs transition shadow-xs flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-magnifying-glass"></i> Check Now
                    </button>
                    @if(request('quick_search'))
                        <a href="{{ route('dashboard.seeker') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold px-4 py-2.5 rounded-xl text-xs transition flex items-center justify-center">
                            Clear
                        </a>
                    @endif
                </form>

                @if(request('quick_search'))
                    @php
                        $searchTerm = trim(request('quick_search'));
                        $quickResults = \App\Models\Item::where('status', 'found')
                            ->where('is_resolved', 0)
                            ->where(function($q) use ($searchTerm) {
                                $q->where('title', 'like', "%{$searchTerm}%")
                                  ->orWhere('description', 'like', "%{$searchTerm}%")
                                  ->orWhere('secret_identifier', 'like', "%{$searchTerm}%")
                                  ->orWhere('category', 'like', "%{$searchTerm}%");
                            })->get();
                    @endphp

                    <div class="mt-4 pt-4 border-t border-slate-100">
                        @if($quickResults->count() > 0)
                            <div class="bg-emerald-50 border border-emerald-300 rounded-2xl p-4 mb-3">
                                <div class="flex items-center gap-2 font-bold text-xs text-emerald-900 mb-1">
                                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                                    <span>Great News! We found {{ $quickResults->count() }} item(s) matching "{{ $searchTerm }}"</span>
                                </div>
                                <p class="text-[11px] text-emerald-800">Review the items below. If one belongs to you, submit your ownership claim immediately.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($quickResults as $foundItem)
                                    <div class="border border-emerald-200 rounded-xl p-3 bg-white flex items-center justify-between">
                                        <div>
                                            <h5 class="font-bold text-xs text-slate-900">{{ $foundItem->title }}</h5>
                                            <p class="text-[11px] text-slate-500">📍 {{ $foundItem->location }} • Found on {{ $foundItem->date_lost_found ? \Carbon\Carbon::parse($foundItem->date_lost_found)->format('M d, Y') : $foundItem->created_at->format('M d, Y') }}</p>
                                        </div>
                                        <a href="{{ route('items.show', $foundItem->id) }}" class="bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs px-3 py-1.5 rounded-lg transition shrink-0">
                                            Claim ➔
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            {{-- Explicit "NO MATCH FOUND" state as requested --}}
                            <div class="bg-amber-50/80 border-2 border-dashed border-amber-300 rounded-2xl p-5 text-center">
                                <div class="w-12 h-12 bg-amber-100 text-amber-700 rounded-full flex items-center justify-center text-xl mx-auto mb-2.5">
                                    <i class="fa-solid fa-search"></i>
                                </div>
                                <h4 class="font-extrabold text-sm text-slate-800 mb-1">No Match Found for "{{ $searchTerm }}"</h4>
                                <p class="text-xs text-slate-600 max-w-lg mx-auto leading-relaxed mb-3">
                                    We searched all found items currently held at Campus Security. Your item has not been handed in yet.
                                </p>
                                <div class="inline-flex items-center gap-2 bg-white px-4 py-2 rounded-xl border border-amber-200 text-xs font-semibold text-amber-900 shadow-2xs">
                                    <i class="fa-solid fa-bell text-amber-600"></i>
                                    <span>Tip: Report it as a Lost Item so you are notified the minute it is turned in!</span>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('items.create') }}?status=lost" class="inline-flex items-center gap-1.5 bg-amber-500 hover:bg-amber-400 text-emerald-950 font-bold px-4 py-2 rounded-xl text-xs transition shadow-xs">
                                        <i class="fa-solid fa-plus"></i> Report "{{ $searchTerm }}" as Lost Now
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            @php
                $myLostMatches = Auth::user()->getActiveLostItemMatches();
                $myLostReports = Auth::user()->items()->where('status', 'lost')->where('is_resolved', 0)->get();
            @endphp

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
            @elseif($myLostReports->count() > 0)
                {{-- User has reported lost items, but NO matches found yet --}}
                <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-200/90">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-sm font-bold">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-slate-900">Active Intake Monitoring — No Match Found Yet</h4>
                            <p class="text-xs text-slate-500">We are actively scanning all items found from your loss dates up to today.</p>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 text-xs text-slate-600 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                            <span>Monitoring <strong>{{ $myLostReports->count() }}</strong> active report(s). You will receive an immediate in-app notification when a matching item is turned in.</span>
                        </div>
                        <a href="{{ route('notifications.inbox') }}" class="text-emerald-700 font-bold hover:underline shrink-0 text-xs">
                            View Notification Desk ➔
                        </a>
                    </div>
                </div>
            @endif

            <!-- Two Column Layout: Lost Reports & My Claims -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- My Lost Item Reports -->
                <div class="bg-white rounded-3xl shadow-xs border border-slate-200/90 p-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Your Lost Item Reports</h3>
                            <p class="text-xs text-slate-500">Items you registered as missing on campus</p>
                        </div>
                        <a href="{{ route('items.create') }}?status=lost" class="text-xs bg-amber-500 hover:bg-amber-400 text-emerald-950 font-bold px-3 py-1.5 rounded-lg transition">
                            + Report Lost
                        </a>
                    </div>

                    @php
                        $myLostItems = Auth::user()->items()->where('status', 'lost')->latest()->get();
                    @endphp

                    @if($myLostItems->count() > 0)
                        <div class="space-y-3">
                            @foreach($myLostItems as $lost)
                                <div class="border border-slate-200/80 rounded-2xl p-4 flex items-center justify-between hover:bg-slate-50 transition">
                                    <div class="pr-2">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Lost</span>
                                            <span class="text-xs font-bold text-slate-900">{{ $lost->title }}</span>
                                        </div>
                                        <div class="text-[11px] text-slate-500">
                                            📍 {{ $lost->location }} • Logged on {{ $lost->created_at->format('M d, Y') }}
                                        </div>
                                    </div>
                                    <a href="{{ route('items.show', $lost->id) }}" class="text-xs font-bold text-emerald-700 hover:underline shrink-0">
                                        View Details ➔
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-10 text-center text-slate-400">
                            <i class="fa-solid fa-folder-open text-3xl mb-2 text-slate-300"></i>
                            <p class="text-xs">No active lost reports created yet.</p>
                            <a href="{{ route('items.create') }}?status=lost" class="inline-block mt-2 text-xs font-bold text-amber-700 hover:underline">
                                Report a Missing Item
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Claims You Submitted -->
                <div class="bg-white rounded-3xl shadow-xs border border-slate-200/90 p-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Your Submitted Claims</h3>
                            <p class="text-xs text-slate-500">Verification claims you made on listed property</p>
                        </div>
                        <a href="{{ route('items.index') }}" class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-3 py-1.5 rounded-lg transition">
                            Browse All
                        </a>
                    </div>

                    @php
                        $myClaims = Auth::user()->claims()->with('item')->latest()->get();
                    @endphp

                    @if($myClaims->count() > 0)
                        <div class="space-y-3">
                            @foreach($myClaims as $claim)
                                <div class="border {{ $claim->claim_status == 'rejected' ? 'border-red-200 bg-red-50/30' : ($claim->claim_status == 'approved' ? 'border-emerald-200 bg-emerald-50/20' : 'border-slate-200/80') }} rounded-2xl p-4 flex flex-col justify-between hover:bg-slate-50 transition">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <div class="flex items-center gap-2">
                                            <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded {{ $claim->claim_status == 'approved' ? 'bg-emerald-100 text-emerald-800' : ($claim->claim_status == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                                                {{ $claim->claim_status }}
                                            </span>
                                            <span class="text-xs font-bold text-slate-900">{{ $claim->item ? $claim->item->title : 'Item ID #' . $claim->item_id }}</span>
                                        </div>
                                        @if($claim->item)
                                            <a href="{{ route('items.show', $claim->item->id) }}" class="text-xs font-bold text-emerald-700 hover:underline shrink-0">
                                                Check Item ➔
                                            </a>
                                        @endif
                                    </div>

                                    <div class="text-[11px] text-slate-500">
                                        Student Reg: {{ $claim->student_registration_number }} • Submitted: {{ $claim->created_at->format('M d, Y') }}
                                    </div>

                                    @if($claim->claim_status == 'rejected' && $claim->admin_notes)
                                        <div class="mt-2 bg-red-100/80 border border-red-200 rounded-xl p-2.5 text-[11px] text-red-900">
                                            <div class="font-bold flex items-center gap-1 text-red-800">
                                                <i class="fa-solid fa-triangle-exclamation text-[10px]"></i> Administrator Notice:
                                            </div>
                                            <p class="mt-0.5">{{ $claim->admin_notes }}</p>
                                            <p class="text-[10px] text-red-700 mt-1 font-semibold">
                                                ➔ Visit Security Desk at Main Admin Block to verify.
                                            </p>
                                        </div>
                                    @elseif($claim->claim_status == 'approved')
                                        <div class="mt-2 bg-emerald-100/80 border border-emerald-200 rounded-xl p-2.5 text-[11px] text-emerald-900">
                                            <strong class="font-bold">✅ Approved:</strong> Please visit Security Desk with your Student ID to collect.
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-10 text-center text-slate-400">
                            <i class="fa-solid fa-file-shield text-3xl mb-2 text-slate-300"></i>
                            <p class="text-xs">You have not submitted claims for any items yet.</p>
                            <a href="{{ route('items.index') }}" class="inline-block mt-2 text-xs font-bold text-emerald-700 hover:underline">
                                Browse Items to Claim
                            </a>
                        </div>
                    @endif
                </div>

            </div>

            <!-- Campus Security Notice -->
            <div class="bg-emerald-50 border border-emerald-200 rounded-3xl p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-emerald-950">Lost an ID card or academic certificates?</h4>
                        <p class="text-xs text-emerald-800">Visit the Main Administration Block Ground Floor or call Security Hotline at +254 58 2030161.</p>
                    </div>
                </div>
                <a href="tel:+254582030161" class="bg-emerald-800 hover:bg-emerald-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition shrink-0 flex items-center gap-1.5">
                    <i class="fa-solid fa-phone"></i> Call Security Desk
                </a>
            </div>

        </div>
    </div>
</x-app-layout>