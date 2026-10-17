<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Page Header Strip -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <div>
                    <div class="inline-flex items-center gap-2 bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-2">
                        <i class="fa-solid fa-list-check text-emerald-600"></i> Kisii University Directory
                    </div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Campus Lost & Found Feed</h1>
                    <p class="text-slate-600 text-sm mt-1">Real-time catalog of items reported lost or found across all Kisii University faculties and grounds.</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('items.create') }}?status=found" class="bg-emerald-700 hover:bg-emerald-600 text-white font-bold px-4 py-2.5 rounded-xl text-xs transition duration-150 flex items-center gap-2 shadow-sm">
                        <i class="fa-solid fa-circle-plus"></i>
                        <span>Report Found Item</span>
                    </a>
                    <a href="{{ route('items.create') }}?status=lost" class="bg-amber-500 hover:bg-amber-400 text-emerald-950 font-bold px-4 py-2.5 rounded-xl text-xs transition duration-150 flex items-center gap-2 shadow-sm">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>Report Lost Item</span>
                    </a>
                </div>
            </div>

            <!-- Access Level Notice (Admin vs Regular User Search Scope) -->
            @if($isAdmin)
                <div class="mb-6 bg-indigo-50 border-l-4 border-indigo-600 p-4 rounded-r-2xl flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-bold">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <span class="block font-bold text-indigo-950 text-xs uppercase tracking-wider">Administrator Full Catalog View</span>
                            <span class="text-xs text-indigo-800">You are logged in as Administrator. You have full clearance to view, filter, and audit all items reported across Kisii University.</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="bg-indigo-700 hover:bg-indigo-600 text-white text-xs font-bold px-3.5 py-1.5 rounded-lg transition shrink-0 hidden sm:inline-block">
                        Admin Desk ➔
                    </a>
                </div>
            @else
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-600 p-4 rounded-r-2xl flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold">
                            <i class="fa-solid fa-filter"></i>
                        </div>
                        <div>
                            <span class="block font-bold text-emerald-950 text-xs uppercase tracking-wider">Targeted Search Feed</span>
                            <span class="text-xs text-emerald-800">
                                Showing items matching your registered search interest: <strong class="text-emerald-900 underline">{{ $searchIntent ?? 'General Search Scope' }}</strong>.
                                <span class="text-slate-500 ml-1">(Notice: Viewing all campus items across every category is reserved for Campus Security & Administrators).</span>
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Search and Filter Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/90 p-5 mb-8">
                <form id="filterForm" method="GET" action="{{ route('items.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3.5">
                    
                    <!-- Search Input -->
                    <div class="relative md:col-span-1">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" id="feedSearchInput" name="search" value="{{ request('search') }}" placeholder="Search by title, room, detail..." class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50/50">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <select name="status" class="w-full py-2.5 px-3.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50/50">
                            <option value="">All Statuses (Lost & Found)</option>
                            <option value="lost" {{ request('status') == 'lost' ? 'selected' : '' }}>🚨 Lost Items Only</option>
                            <option value="found" {{ request('status') == 'found' ? 'selected' : '' }}>✅ Found Items Only</option>
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <select name="category" class="w-full py-2.5 px-3.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50/50">
                            <option value="">All Categories</option>
                            <option value="Electronics" {{ request('category') == 'Electronics' ? 'selected' : '' }}>Electronics (Laptops, Phones)</option>
                            <option value="Student ID / Documents" {{ request('category') == 'Student ID / Documents' ? 'selected' : '' }}>Student ID / Documents</option>
                            <option value="Books / Notes" {{ request('category') == 'Books / Notes' ? 'selected' : '' }}>Books / Notes</option>
                            <option value="Clothing / Bags" {{ request('category') == 'Clothing / Bags' ? 'selected' : '' }}>Clothing / Bags / Wallets</option>
                            <option value="Keys" {{ request('category') == 'Keys' ? 'selected' : '' }}>Keys</option>
                            <option value="Other" {{ request('category') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-2">
                        <button type="submit" id="feedFilterBtn" class="flex-1 bg-emerald-800 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition duration-150 shadow-sm flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-filter"></i> Apply Filter
                        </button>
                        <a href="{{ route('items.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-2.5 px-3.5 rounded-xl text-xs transition duration-150 flex items-center justify-center">
                            Reset
                        </a>
                    </div>
                </form>

                <!-- Quick Filter Tags -->
                <div class="flex flex-wrap items-center gap-2 pt-4 mt-3 border-t border-slate-100 text-xs">
                    <span class="text-slate-400 font-medium">Quick Tags:</span>
                    <a href="{{ route('items.index') }}" class="px-2.5 py-1 rounded-lg {{ !request('status') && !request('category') ? 'bg-emerald-100 text-emerald-800 font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">Scope Default</a>
                    <a href="{{ route('items.index', ['status' => 'lost']) }}" class="px-2.5 py-1 rounded-lg {{ request('status') == 'lost' ? 'bg-red-100 text-red-800 font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">Lost</a>
                    <a href="{{ route('items.index', ['status' => 'found']) }}" class="px-2.5 py-1 rounded-lg {{ request('status') == 'found' ? 'bg-emerald-100 text-emerald-800 font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">Found</a>
                    @if($isAdmin || str_contains(strtolower($searchIntent ?? ''), 'laptop') || str_contains(strtolower($searchIntent ?? ''), 'electronic'))
                        <a href="{{ route('items.index', ['category' => 'Electronics']) }}" class="px-2.5 py-1 rounded-lg {{ request('category') == 'Electronics' ? 'bg-emerald-100 text-emerald-800 font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">Electronics</a>
                    @endif
                    @if($isAdmin || str_contains(strtolower($searchIntent ?? ''), 'id') || str_contains(strtolower($searchIntent ?? ''), 'card'))
                        <a href="{{ route('items.index', ['category' => 'Student ID / Documents']) }}" class="px-2.5 py-1 rounded-lg {{ request('category') == 'Student ID / Documents' ? 'bg-emerald-100 text-emerald-800 font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">Student IDs</a>
                    @endif
                </div>
            </div>

            <!-- Notification Messages -->
            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-600 p-4 rounded-r-xl text-emerald-800 text-sm font-medium flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Results Count -->
            <div class="flex justify-between items-center mb-5 text-xs text-slate-500 font-medium">
                <span>Showing <strong>{{ $items->total() }}</strong> matching reports</span>
                @if(request('search') || request('status') || request('category'))
                    <span class="text-emerald-700">Filters Active • <a href="{{ route('items.index') }}" class="underline font-bold">Clear all</a></span>
                @endif
            </div>

            <!-- Items Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($items as $item)
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md border border-slate-200/90 overflow-hidden flex flex-col justify-between transition duration-200 group">
                        <div>
                            <!-- Item Image -->
                            <div class="relative h-48 w-full bg-slate-100 overflow-hidden">
                                @if($item->image_path)
                                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 text-xs p-4 text-center">
                                        <i class="fa-solid fa-image text-3xl mb-1.5 text-slate-300"></i>
                                        <span>No Evidence Photo Uploaded</span>
                                    </div>
                                @endif

                                <!-- Status Badge Pill -->
                                <div class="absolute top-3 left-3">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider shadow-sm {{ $item->status == 'lost' ? 'bg-red-600 text-white' : 'bg-emerald-600 text-white' }}">
                                        @if($item->status == 'lost')
                                            <i class="fa-solid fa-triangle-exclamation text-[10px]"></i> Lost
                                        @else
                                            <i class="fa-solid fa-circle-check text-[10px]"></i> Found
                                        @endif
                                    </span>
                                </div>

                                <!-- Resolved Badge if any -->
                                @if($item->is_resolved)
                                    <div class="absolute top-3 right-3">
                                        <span class="inline-flex items-center gap-1 bg-slate-900/90 backdrop-blur-sm text-emerald-300 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase shadow-sm">
                                            <i class="fa-solid fa-lock text-[9px]"></i> Resolved
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Card Body -->
                            <div class="p-5">
                                <div class="flex items-center justify-between text-xs text-slate-400 mb-2">
                                    <span class="font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-md">
                                        {{ $item->category }}
                                    </span>
                                    <span>
                                        @if($item->status === 'found' && !$isAdmin)
                                            <span class="text-amber-850 bg-amber-50 text-amber-800 border border-amber-200/60 px-2 py-0.5 rounded text-[10px] font-semibold" title="Protected for fraud prevention">
                                                <i class="fa-solid fa-lock text-[9px] text-amber-600 mr-1"></i> Date Protected
                                            </span>
                                        @else
                                            <i class="fa-regular fa-calendar-days mr-1"></i>
                                            {{ $item->date_lost_found ? \Carbon\Carbon::parse($item->date_lost_found)->format('M d, Y') : $item->created_at->format('M d, Y') }}
                                        @endif
                                    </span>

                                </div>

                                <h3 class="text-base font-bold text-slate-900 group-hover:text-emerald-800 transition leading-snug line-clamp-1 mb-1.5">
                                    {{ $item->title }}
                                </h3>

                                <div class="flex items-center text-xs text-slate-500 font-medium mb-3">
                                    <i class="fa-solid fa-location-dot text-emerald-600 mr-1.5"></i>
                                    <span class="truncate">{{ $item->location }}</span>
                                </div>

                                <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed mb-4">
                                    {{ $item->description }}
                                </p>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="px-5 pb-5 pt-0">
                            <a href="{{ route('items.show', $item->id) }}" class="w-full bg-slate-900 hover:bg-emerald-800 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition duration-150 flex items-center justify-center gap-2 shadow-xs group-hover:bg-emerald-700">
                                <span>View Details & Claim</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 px-4 bg-white rounded-2xl border border-slate-200/90 text-center shadow-xs">
                        <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center text-2xl mx-auto mb-4">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-1">No items found matching your search interest</h3>
                        <p class="text-slate-500 text-sm max-w-md mx-auto mb-6">
                            @if(!$isAdmin && $searchIntent)
                                Your account is currently scoped to search for <strong>{{ $searchIntent }}</strong>. If you are searching for another category, you can update your search intent or post a report.
                            @else
                                Try adjusting your search keywords or post a new report.
                            @endif
                        </p>
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('items.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-2 rounded-xl text-xs transition">
                                Reset Filters
                            </a>
                            <a href="{{ route('items.create') }}" class="bg-emerald-700 hover:bg-emerald-600 text-white font-bold px-4 py-2 rounded-xl text-xs transition">
                                Post New Item
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                {{ $items->links() }}
            </div>

        </div>
    </div>
</x-app-layout>