<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <div class="flex items-center justify-between mb-6">
                <nav class="flex items-center space-x-2 text-xs text-slate-500 font-medium">
                    <a href="{{ url('/') }}" class="hover:text-emerald-700 transition">Home</a>
                    <span class="text-slate-300">/</span>
                    <a href="{{ route('items.index') }}" class="hover:text-emerald-700 transition">Browse Items</a>
                    <span class="text-slate-300">/</span>
                    <span class="text-slate-800 font-bold truncate max-w-[200px] sm:max-w-xs">{{ $item->title }}</span>
                </nav>

                <a href="{{ route('items.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 hover:text-emerald-950 transition">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Back to Feed</span>
                </a>
            </div>

            <!-- Alerts -->
            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-600 p-4 rounded-r-xl text-emerald-800 text-sm font-medium flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-xl"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl text-red-800 text-sm font-medium flex items-center gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-red-600 text-xl"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Main Item Card -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200/90 overflow-hidden grid grid-cols-1 md:grid-cols-2 gap-8 p-6 md:p-8 mb-8">
                
                <!-- Left: Media / Photo -->
                <div class="flex flex-col justify-between">
                    <div class="relative rounded-2xl overflow-hidden bg-slate-100 border border-slate-200/80 shadow-xs">
                        @if($item->image_path)
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="w-full h-80 object-cover">
                        @else
                            <div class="w-full h-80 flex flex-col items-center justify-center text-slate-400 p-6 text-center">
                                <i class="fa-solid fa-image text-4xl mb-2 text-slate-300"></i>
                                <span class="text-xs font-medium">No Image Evidence Provided</span>
                            </div>
                        @endif

                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider shadow-sm {{ $item->status == 'lost' ? 'bg-red-600 text-white' : 'bg-emerald-600 text-white' }}">
                                @if($item->status == 'lost')
                                    <i class="fa-solid fa-triangle-exclamation text-[10px]"></i> Lost Property
                                @else
                                    <i class="fa-solid fa-circle-check text-[10px]"></i> Found Property
                                @endif
                            </span>
                        </div>

                        @if($item->is_resolved)
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center gap-1 bg-slate-900/90 text-emerald-300 px-3 py-1 rounded-full text-xs font-bold uppercase shadow-sm">
                                    <i class="fa-solid fa-lock text-[10px]"></i> Handed Over / Resolved
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Security Contact Notice -->
                    <div class="mt-4 p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200/70 text-xs text-emerald-900 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-shield-halved text-emerald-700 text-lg"></i>
                            <div>
                                <strong class="block">Security Desk Direct Line</strong>
                                <span class="text-[11px] text-emerald-700">Main Administration Block</span>
                            </div>
                        </div>
                        <a href="tel:+254582030161" class="font-bold text-emerald-800 hover:underline">
                            +254 58 2030161
                        </a>
                    </div>
                </div>

                <!-- Right: Information & Details -->
                <div class="flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between text-xs text-slate-400 mb-2">
                            <span class="bg-emerald-100 text-emerald-800 font-bold px-2.5 py-1 rounded-lg">
                                {{ $item->category }}
                            </span>
                            @if($item->status === 'found' && !(Auth::check() && (Auth::user()->isAdmin() || Auth::id() === $item->user_id)))
                                <span class="inline-flex items-center gap-1 font-semibold text-amber-800 bg-amber-50 border border-amber-200/80 px-2.5 py-0.5 rounded text-[11px]" title="Exact date hidden to verify claimant timeline">
                                    <i class="fa-solid fa-lock text-[10px] text-amber-600"></i> Date Protected (Verification Required)
                                </span>
                            @else
                                <span class="font-medium text-slate-500">
                                    {{ $item->status == 'lost' ? 'Lost on:' : 'Found on:' }} {{ $item->date_lost_found ? \Carbon\Carbon::parse($item->date_lost_found)->format('M d, Y') : $item->created_at->format('M d, Y') }}
                                </span>
                            @endif
                        </div>

                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-3 tracking-tight leading-snug">
                            {{ $item->title }}
                        </h1>

                        <div class="flex items-center text-sm font-semibold text-emerald-700 mb-5 bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <i class="fa-solid fa-location-dot mr-2 text-emerald-600"></i>
                            <span>Campus Location: {{ $item->location }}</span>
                        </div>

                        <div class="space-y-2 mb-6">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Detailed Description</h4>
                            <p class="text-sm text-slate-700 leading-relaxed bg-white">
                                {{ $item->description }}
                            </p>
                        </div>

                        @if(Auth::check() && (Auth::user()->isAdmin() || Auth::id() === $item->user_id))
                            @if($item->secret_identifier)
                                <div class="mb-5 p-3.5 rounded-2xl bg-purple-50 border border-purple-200/80 text-xs text-purple-950">
                                    <div class="flex items-center gap-1.5 font-bold text-purple-900 mb-1">
                                        <i class="fa-solid fa-key text-purple-600"></i>
                                        <span>Secret Verification Marker (Authorized Admin & Reporter Only):</span>
                                    </div>
                                    <span class="block font-mono bg-white p-2 rounded-lg border border-purple-100 text-purple-800">{{ $item->secret_identifier }}</span>
                                    <span class="text-[10px] text-purple-600 mt-1 block">Regular claimants cannot see this marker. Match it against proof submitted in claims desk.</span>
                                </div>
                            @endif
                        @endif
                    </div>

                    <div class="border-t border-slate-100 pt-4 text-xs text-slate-500 space-y-1">
                        <p>
                            Reported by: 
                            <strong class="text-slate-800">
                                @if($item->is_anonymous)
                                    Anonymous Campus Colleague
                                @else
                                    {{ $item->user ? $item->user->name : 'Campus Colleague' }}
                                @endif
                            </strong>
                        </p>
                        <p class="text-[11px] text-slate-400">
                            Logged on {{ $item->created_at->format('l, F j, Y \a\t g:i A') }}
                        </p>
                    </div>
                </div>

            </div>

            <!-- Claim Section -->
            @if($item->user_id !== Auth::id())
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/90 p-6 sm:p-8">
                    <div class="border-b border-slate-100 pb-5 mb-6">
                        <div class="inline-flex items-center gap-1.5 bg-amber-100 text-amber-900 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-2">
                            <i class="fa-solid fa-hand-holding-hand text-amber-700"></i> Ownership Claim
                        </div>
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Claim This Item</h2>
                        <p class="text-xs sm:text-sm text-slate-600 mt-1">
                            To ensure high campus security, you must provide your student credentials and concrete verification proof. Campus Security verifies claims before releasing property.
                        </p>
                    </div>

                    @if(request('from_match') == '1')
                        <div class="mb-6 bg-emerald-50 border-2 border-emerald-400 p-4 rounded-2xl flex items-start gap-3 shadow-xs">
                            <i class="fa-solid fa-wand-magic-sparkles text-emerald-600 text-xl mt-0.5 shrink-0"></i>
                            <div class="text-xs text-emerald-950">
                                <strong class="block text-sm font-bold text-emerald-900 mb-0.5">✨ Auto-Matched Item Claim Desk</strong>
                                <span class="leading-relaxed">
                                    This found listing matched your lost report credentials and timeline. Your student registration number and reported loss date have been pre-filled below. Please supply any additional ownership proof details to verify and arrange retrieval with Campus Security.
                                </span>
                            </div>
                        </div>
                    @endif

                    @if($item->status === 'found')
                        <div class="mb-6 bg-amber-50/70 border border-amber-200/80 rounded-2xl p-4 text-xs text-amber-900 flex items-start gap-3">
                            <i class="fa-solid fa-shield-halved text-amber-700 text-lg mt-0.5 shrink-0"></i>
                            <div>
                                <strong class="block font-bold">Anti-Fraud Timeline Verification Desk</strong>
                                <span class="leading-relaxed">
                                    To protect legitimate owners from false claims, the exact date this item was found is withheld. 
                                    You must state when you lost your property below. Our security intake system will cross-reference your timeline against when the item was surrendered.
                                </span>
                            </div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl">
                            <ul class="list-disc list-inside text-xs text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('claims.store', $item->id) }}" method="POST" class="space-y-5">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="student_registration_number" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                    Student Registration Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="student_registration_number" id="student_registration_number" value="{{ old('student_registration_number', request('reg_number', Auth::check() ? Auth::user()->reg_number : '')) }}" placeholder="e.g., IN13/00000/23" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" required>
                            </div>

                            <div>
                                <label for="phone_number" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', Auth::check() ? Auth::user()->phone : '') }}" placeholder="e.g., 0712345678" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" required>
                            </div>
                        </div>

                        <!-- Date Lost and Location Misplaced -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="claimed_loss_date" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                    Date You Lost/Misplaced This Item <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="claimed_loss_date" id="claimed_loss_date" max="{{ date('Y-m-d') }}" value="{{ old('claimed_loss_date', request('loss_date', '')) }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" required>
                                <p class="text-[11px] text-slate-400 mt-1">Specify approximately or exactly when you realized it was missing.</p>
                            </div>

                            <div>
                                <label for="claimed_location" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                    Where You Think You Lost It <span class="text-slate-400 font-normal">(Optional)</span>
                                </label>
                                <input type="text" name="claimed_location" id="claimed_location" value="{{ old('claimed_location') }}" placeholder="e.g. Near Library study desk, NTC room" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                        </div>

                        <div>
                            <label for="proof_details" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Proof of Ownership / Unique Markers <span class="text-red-500">*</span>
                            </label>
                            <textarea name="proof_details" id="proof_details" rows="4" placeholder="Detail any hidden scratches, wallpaper pictures, serial numbers, password patterns, or answer the secret verification marker..." class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" required>{{ old('proof_details') }}</textarea>
                            <p class="text-[11px] text-slate-400 mt-1">This confidential verification proof is only visible to campus security and the reporter to prevent bogus claims.</p>
                        </div>


                        <div class="pt-2 flex flex-col sm:flex-row gap-3">
                            <button type="submit" class="bg-emerald-700 hover:bg-emerald-600 text-white font-bold py-3.5 px-6 rounded-xl transition text-xs shadow-md flex items-center justify-center gap-2">
                                <i class="fa-solid fa-paper-plane"></i>
                                <span>Submit Verification Claim</span>
                            </button>
                            <a href="{{ route('items.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-3.5 px-5 rounded-xl transition text-xs flex items-center justify-center">
                                Back to Items
                            </a>
                        </div>
                    </form>
                </div>
            @else
                <div class="bg-emerald-50/70 border border-emerald-200 rounded-3xl p-6 text-center text-emerald-900">
                    <i class="fa-solid fa-circle-info text-2xl text-emerald-600 mb-2"></i>
                    <h3 class="text-base font-bold text-slate-800">You Reported This Item</h3>
                    <p class="text-xs text-slate-600 mt-1 max-w-lg mx-auto">
                        This listing was posted from your account. You can track community claims submitted for this item directly from your account dashboard.
                    </p>
                    <div class="mt-4 flex justify-center gap-3">
                        <a href="{{ route('dashboard') }}" class="bg-emerald-800 hover:bg-emerald-700 text-white font-bold px-4 py-2 rounded-xl text-xs transition">
                            Go to Dashboard
                        </a>
                        <a href="{{ route('items.index') }}" class="bg-white hover:bg-slate-50 text-slate-700 font-bold px-4 py-2 rounded-xl text-xs border border-slate-200 transition">
                            Browse Other Items
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>