<x-guest-layout>
    <div class="mb-5 text-center">
        <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight">Create Student Account</h2>
        <p class="text-xs text-gray-500 mt-1">Join the official Kisii University Lost &amp; Found Portal.</p>
    </div>

    <!-- Explicit Validation Failure Banner -->
    @if ($errors->any())
        <div class="mb-5 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-xs">
            <div class="flex items-center gap-2 text-red-800 font-bold text-sm mb-1">
                <i class="fa-solid fa-triangle-exclamation text-base"></i>
                <span>We cannot complete your registration due to the following details:</span>
            </div>
            <ul class="list-disc list-inside text-xs text-red-700 space-y-1 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-5" id="registrationForm">
        @csrf

        <!-- PART 1: Academic & Personal Information -->
        <div id="part1" class="bg-slate-50/70 p-4 sm:p-6 rounded-2xl border border-slate-200/90 space-y-4 transition-all duration-300">
            <div class="flex flex-wrap justify-between items-center border-b border-slate-200 pb-3 gap-2">
                <h3 class="text-xs font-bold text-emerald-800 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fa-solid fa-user-graduate text-emerald-600"></i> Part 1: Academic &amp; Personal Info
                </h3>
                <span class="text-[11px] bg-emerald-100 text-emerald-800 px-2.5 py-0.5 rounded-full font-bold">Step 1 of 2</span>
            </div>

            <!-- Full Name -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Full Name
                    </label>
                    <span id="status-name" class="inline-flex items-center gap-1 text-[11px] font-semibold text-rose-500 transition-all duration-200">
                        <span class="font-bold">*</span> Required
                    </span>
                </div>
                <div class="relative">
                    <i class="fa-solid fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        placeholder="e.g. John Doe"
                        class="block w-full pl-10 pr-10 py-3 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-slate-800 placeholder-slate-400 transition shadow-xs @error('name') border-red-400 @enderror">
                    <i id="tick-name" class="fa-solid fa-circle-check text-emerald-600 text-sm absolute right-3.5 top-1/2 -translate-y-1/2 hidden transition"></i>
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-1 font-semibold text-red-600 text-xs" />
            </div>

            <!-- Email Address -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Email Address
                    </label>
                    <span id="status-email" class="inline-flex items-center gap-1 text-[11px] font-semibold text-rose-500 transition-all duration-200">
                        <span class="font-bold">*</span> Required
                    </span>
                </div>
                <div class="relative">
                    <i class="fa-solid fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                        placeholder="student@kisiiuniversity.ac.ke"
                        class="block w-full pl-10 pr-10 py-3 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-slate-800 placeholder-slate-400 transition shadow-xs @error('email') border-red-400 @enderror">
                    <i id="tick-email" class="fa-solid fa-circle-check text-emerald-600 text-sm absolute right-3.5 top-1/2 -translate-y-1/2 hidden transition"></i>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1 font-semibold text-red-600 text-xs" />
            </div>

            <!-- Phone Number (Max 10 digits) -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Phone Number
                    </label>
                    <span id="status-phone" class="inline-flex items-center gap-1 text-[11px] font-semibold text-rose-500 transition-all duration-200">
                        <span class="font-bold">*</span> 0/10 digits
                    </span>
                </div>
                <div class="relative">
                    <i class="fa-solid fa-phone absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" placeholder="0712345678" maxlength="10" required
                        class="block w-full pl-10 pr-10 py-3 bg-white border border-slate-300 rounded-xl text-sm font-mono focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-slate-800 placeholder-slate-400 transition shadow-xs @error('phone') border-red-400 @enderror">
                    <i id="tick-phone" class="fa-solid fa-circle-check text-emerald-600 text-sm absolute right-3.5 top-1/2 -translate-y-1/2 hidden transition"></i>
                </div>
                <p id="phoneError" class="text-xs text-red-600 font-semibold mt-1 hidden">
                    <i class="fa-solid fa-circle-exclamation mr-1"></i> Phone number must be exactly 10 digits.
                </p>
                <x-input-error :messages="$errors->get('phone')" class="mt-1 font-semibold text-red-600 text-xs" />
            </div>

            <!-- Registration Number with Dynamic Green Tick -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="reg_number" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Student Reg. Number
                    </label>
                    <span id="status-reg_number" class="inline-flex items-center gap-1 text-[11px] font-semibold text-rose-500 transition-all duration-200">
                        <span class="font-bold">*</span> e.g. IN13/00000/23
                    </span>
                </div>
                <div class="relative">
                    <i class="fa-solid fa-id-card absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input id="reg_number" type="text" name="reg_number" value="{{ old('reg_number') }}" placeholder="e.g. IN13/00000/23" pattern="[A-Za-z0-9]{1,5}/\d{1,5}/\d{1,2}" title="Max 5 chars / max 5 digits / max 2 digits (e.g. IN13/00000/23)" required
                        class="block w-full pl-10 pr-10 py-3 bg-white border border-slate-300 rounded-xl text-sm font-mono uppercase focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-slate-800 placeholder-slate-400 transition shadow-xs @error('reg_number') border-red-400 @enderror">
                    <i id="tick-reg_number" class="fa-solid fa-circle-check text-emerald-600 text-sm absolute right-3.5 top-1/2 -translate-y-1/2 hidden transition"></i>
                </div>
                <p id="regHint" class="text-[11px] text-slate-500 mt-1">Format: Faculty code / Admission No / Year (e.g., IN13/00000/23)</p>
                <p id="regError" class="text-xs text-red-600 font-semibold mt-1 hidden">
                    <i class="fa-solid fa-circle-exclamation mr-1"></i> Registration number format is invalid. Use e.g. IN13/00000/23.
                </p>
                <x-input-error :messages="$errors->get('reg_number')" class="mt-1 font-semibold text-red-600 text-xs" />
            </div>

            <!-- Course of Study -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="course" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Course of Study
                    </label>
                    <span id="status-course" class="inline-flex items-center gap-1 text-[11px] font-semibold text-rose-500 transition-all duration-200">
                        <span class="font-bold">*</span> Required
                    </span>
                </div>
                <div class="relative">
                    <i class="fa-solid fa-book-open absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input id="course" type="text" name="course" value="{{ old('course') }}" placeholder="e.g., BSc. Computer Science" required
                        class="block w-full pl-10 pr-10 py-3 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-slate-800 placeholder-slate-400 transition shadow-xs @error('course') border-red-400 @enderror">
                    <i id="tick-course" class="fa-solid fa-circle-check text-emerald-600 text-sm absolute right-3.5 top-1/2 -translate-y-1/2 hidden transition"></i>
                </div>
                <x-input-error :messages="$errors->get('course')" class="mt-1 font-semibold text-red-600 text-xs" />
            </div>

            <!-- Year of Study & School / Faculty (Stacked on mobile, 2 cols on tablet/desktop) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Year of Study -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="year_of_study" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Year of Study
                        </label>
                        <span id="status-year_of_study" class="inline-flex items-center gap-1 text-[11px] font-semibold text-rose-500 transition-all duration-200">
                            <span class="font-bold">*</span> Select
                        </span>
                    </div>
                    <div class="relative">
                        <i class="fa-solid fa-calendar-days absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <select id="year_of_study" name="year_of_study" required
                            class="block w-full pl-10 pr-8 py-3 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-slate-800 transition shadow-xs @error('year_of_study') border-red-400 @enderror">
                            <option value="">Select Year of Study (Max Year 6)</option>
                            <option value="Year 1" {{ old('year_of_study') == 'Year 1' ? 'selected' : '' }}>Year 1</option>
                            <option value="Year 2" {{ old('year_of_study') == 'Year 2' ? 'selected' : '' }}>Year 2</option>
                            <option value="Year 3" {{ old('year_of_study') == 'Year 3' ? 'selected' : '' }}>Year 3</option>
                            <option value="Year 4" {{ old('year_of_study') == 'Year 4' ? 'selected' : '' }}>Year 4</option>
                            <option value="Year 5" {{ old('year_of_study') == 'Year 5' ? 'selected' : '' }}>Year 5</option>
                            <option value="Year 6" {{ old('year_of_study') == 'Year 6' ? 'selected' : '' }}>Year 6</option>
                        </select>
                    </div>
                    <x-input-error :messages="$errors->get('year_of_study')" class="mt-1 font-semibold text-red-600 text-xs" />
                </div>

                <!-- School (Exact 8 Kisii University Schools in full with acronym in brackets) -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="school" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            School / Faculty
                        </label>
                        <span id="status-school" class="inline-flex items-center gap-1 text-[11px] font-semibold text-rose-500 transition-all duration-200">
                            <span class="font-bold">*</span> Select
                        </span>
                    </div>
                    <div class="relative">
                        <i class="fa-solid fa-building-columns absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <select id="school" name="school" required
                            class="block w-full pl-10 pr-8 py-3 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-slate-800 transition shadow-xs @error('school') border-red-400 @enderror">
                            <option value="">Select Faculty / School</option>
                            <option value="School of Information Sciences & Technology (SIST)" {{ old('school') == 'School of Information Sciences & Technology (SIST)' ? 'selected' : '' }}>School of Information Sciences &amp; Technology (SIST)</option>
                            <option value="School of Arts and Social Sciences (SASS)" {{ old('school') == 'School of Arts and Social Sciences (SASS)' ? 'selected' : '' }}>School of Arts and Social Sciences (SASS)</option>
                            <option value="School of Business and Economics (SOBE)" {{ old('school') == 'School of Business and Economics (SOBE)' ? 'selected' : '' }}>School of Business and Economics (SOBE)</option>
                            <option value="School of Education and Human Resource Development (SEDHURED)" {{ old('school') == 'School of Education and Human Resource Development (SEDHURED)' ? 'selected' : '' }}>School of Education and Human Resource Development (SEDHURED)</option>
                            <option value="School of Health Sciences (SHS)" {{ old('school') == 'School of Health Sciences (SHS)' ? 'selected' : '' }}>School of Health Sciences (SHS)</option>
                            <option value="School of Law (SLAW)" {{ old('school') == 'School of Law (SLAW)' ? 'selected' : '' }}>School of Law (SLAW)</option>
                            <option value="School of Pure and Applied Sciences (SPAS)" {{ old('school') == 'School of Pure and Applied Sciences (SPAS)' ? 'selected' : '' }}>School of Pure and Applied Sciences (SPAS)</option>
                            <option value="School of Agriculture and Natural Resources Management (SANRM)" {{ old('school') == 'School of Agriculture and Natural Resources Management (SANRM)' ? 'selected' : '' }}>School of Agriculture and Natural Resources Management (SANRM)</option>
                        </select>
                    </div>
                    <x-input-error :messages="$errors->get('school')" class="mt-1 font-semibold text-red-600 text-xs" />
                </div>
            </div>

            <!-- Password with Eye Toggle -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Password
                    </label>
                    <span id="status-password" class="inline-flex items-center gap-1 text-[11px] font-semibold text-rose-500 transition-all duration-200">
                        <span class="font-bold">*</span> Min 8 chars
                    </span>
                </div>
                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        placeholder="••••••••"
                        class="block w-full pl-10 pr-11 py-3 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-slate-800 placeholder-slate-400 transition shadow-xs @error('password') border-red-400 @enderror">
                    <button type="button" onclick="togglePassword('password', 'eyeIcon1')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition" aria-label="Toggle password visibility">
                        <i class="fa-solid fa-eye text-xs" id="eyeIcon1"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 font-semibold text-red-600 text-xs" />
            </div>

            <!-- Confirm Password with Eye Toggle -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Confirm Password
                    </label>
                    <span id="status-password_confirmation" class="inline-flex items-center gap-1 text-[11px] font-semibold text-rose-500 transition-all duration-200">
                        <span class="font-bold">*</span> Re-type password
                    </span>
                </div>
                <div class="relative">
                    <i class="fa-solid fa-shield-halved absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        placeholder="••••••••"
                        class="block w-full pl-10 pr-11 py-3 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-slate-800 placeholder-slate-400 transition shadow-xs @error('password_confirmation') border-red-400 @enderror">
                    <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition" aria-label="Toggle confirm password visibility">
                        <i class="fa-solid fa-eye text-xs" id="eyeIcon2"></i>
                    </button>
                </div>
                <p id="passwordMismatchError" class="text-xs text-red-600 font-semibold mt-1 hidden">
                    <i class="fa-solid fa-circle-exclamation mr-1"></i> Passwords do not match.
                </p>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 font-semibold text-red-600 text-xs" />
            </div>

            <!-- Next Step Action Button with Spinner Animation -->
            <div class="flex justify-end pt-3">
                <button type="button" id="nextBtn" onclick="goToPart2()" class="w-full sm:w-auto bg-emerald-800 hover:bg-emerald-700 text-white font-bold py-3 px-7 rounded-xl text-sm transition shadow-md flex items-center justify-center gap-2">
                    <span id="nextBtnText">Next: Purpose &amp; Search Intent</span>
                    <i id="nextBtnIcon" class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </div>
        </div>

        <!-- PART 2: Other Information & Search Intent -->
        <div id="part2" class="bg-slate-50/70 p-4 sm:p-6 rounded-2xl border border-slate-200/90 space-y-4 hidden transition-all duration-300">
            <div class="flex flex-wrap justify-between items-center border-b border-slate-200 pb-3 gap-2">
                <h3 class="text-xs font-bold text-emerald-800 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fa-solid fa-sliders text-emerald-600"></i> Part 2: Search Intent &amp; Category Filter
                </h3>
                <span class="text-[11px] bg-emerald-100 text-emerald-800 px-2.5 py-0.5 rounded-full font-bold">Step 2 of 2</span>
            </div>

            <!-- Why Registering Dropdown -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="reason_for_registering" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Why are you registering?
                    </label>
                    <span id="status-reason_for_registering" class="inline-flex items-center gap-1 text-[11px] font-semibold text-rose-500 transition-all duration-200">
                        <span class="font-bold">*</span> Select
                    </span>
                </div>
                <div class="relative">
                    <i class="fa-solid fa-bullseye absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <select id="reason_for_registering" name="reason_for_registering" onchange="handleReasonChange()" required
                        class="block w-full pl-10 pr-8 py-3 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-slate-800 transition shadow-xs @error('reason_for_registering') border-red-400 @enderror">
                        <option value="">Select Purpose</option>
                        <option value="Finding a lost item / searching" {{ old('reason_for_registering', 'Finding a lost item / searching') == 'Finding a lost item / searching' ? 'selected' : '' }}>Finding a lost item / searching</option>
                        <option value="Posting a lost item" {{ old('reason_for_registering') == 'Posting a lost item' ? 'selected' : '' }}>Posting a found/lost item</option>
                    </select>
                </div>
                <x-input-error :messages="$errors->get('reason_for_registering')" class="mt-1 font-semibold text-red-600 text-xs" />
            </div>

            <!-- Conditional Field: What you are searching for -->
            <div id="searchingContainer">
                <div class="flex items-center justify-between mb-1.5">
                    <label for="what_searching" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Search Category
                    </label>
                    <span id="status-what_searching" class="inline-flex items-center gap-1 text-[11px] font-semibold text-rose-500 transition-all duration-200">
                        <span class="font-bold">*</span> Select
                    </span>
                </div>
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <select id="what_searching" name="what_searching"
                        class="block w-full pl-10 pr-8 py-3 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-slate-800 transition shadow-xs @error('what_searching') border-red-400 @enderror">
                        <option value="">-- Choose Category to Search --</option>
                        <option value="Laptop / Electronics" {{ old('what_searching') == 'Laptop / Electronics' ? 'selected' : '' }}>💻 Laptop / Electronics / Charger (Laptops only, no IDs)</option>
                        <option value="Student ID Card" {{ old('what_searching') == 'Student ID Card' ? 'selected' : '' }}>🪪 Student ID Card / Documents</option>
                        <option value="Textbooks / Notes" {{ old('what_searching') == 'Textbooks / Notes' ? 'selected' : '' }}>📚 Textbooks / Notebooks</option>
                        <option value="Keys" {{ old('what_searching') == 'Keys' ? 'selected' : '' }}>🔑 Keys (Room / Padlock)</option>
                        <option value="Wallet / Purse" {{ old('what_searching') == 'Wallet / Purse' ? 'selected' : '' }}>🎒 Wallet / Purse / Bag</option>
                    </select>
                </div>
                <p class="text-[11px] text-emerald-700 mt-1.5 font-medium flex items-center gap-1">
                    <i class="fa-solid fa-circle-info"></i> Rule: Your dashboard feed and search results will exclusively provide items in this category.
                </p>
                <x-input-error :messages="$errors->get('what_searching')" class="mt-1 font-semibold text-red-600 text-xs" />
            </div>

            <!-- Conditional Field: What you have lost -->
            <div id="lostContainer" class="hidden">
                <label for="what_lost" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Describe the item you lost or want to post
                </label>
                <textarea id="what_lost" name="what_lost" rows="3"
                    class="block w-full p-3.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-slate-800 placeholder-slate-400 transition shadow-xs @error('what_lost') border-red-400 @enderror"
                    placeholder="Provide details of the item (e.g. HP Laptop or ID)...">{{ old('what_lost') }}</textarea>
                <x-input-error :messages="$errors->get('what_lost')" class="mt-1 font-semibold text-red-600 text-xs" />
            </div>

            <!-- Bottom Navigation Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-between pt-4 border-t border-slate-200 gap-3">
                <button type="button" onclick="goToPart1()" class="w-full sm:w-auto bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold py-3 px-5 rounded-xl text-sm transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    <span>Back to Part 1</span>
                </button>

                <button type="submit" id="submitBtn" class="w-full sm:w-auto bg-emerald-800 hover:bg-emerald-700 text-white font-bold py-3 px-7 rounded-xl text-sm transition shadow-md flex items-center justify-center gap-2">
                    <span id="submitBtnText">Complete Registration</span>
                    <i id="submitBtnIcon" class="fa-solid fa-user-check text-xs"></i>
                </button>
            </div>
        </div>
    </form>

    <div class="mt-6 pt-5 border-t border-slate-100 text-center">
        <span class="text-xs text-slate-500">Already registered? </span>
        <a class="text-xs font-bold text-emerald-800 hover:text-emerald-700 hover:underline transition" href="{{ route('login') }}">
            Sign In to Portal &rarr;
        </a>
    </div>

    <!-- Live Dynamic Validation Scripts with Green Ticks and Step Spinners -->
    <script>
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone');
        const phoneError = document.getElementById('phoneError');
        const regInput = document.getElementById('reg_number');
        const regError = document.getElementById('regError');
        const courseInput = document.getElementById('course');
        const yearSelect = document.getElementById('year_of_study');
        const schoolSelect = document.getElementById('school');
        const passInput = document.getElementById('password');
        const passConfirmInput = document.getElementById('password_confirmation');
        const passMismatchError = document.getElementById('passwordMismatchError');
        const reasonSelect = document.getElementById('reason_for_registering');
        const searchingSelect = document.getElementById('what_searching');

        // Helper to update status pill and input styling
        function updateStatus(fieldKey, isValid, validText, emptyText, invalidText = null) {
            const statusEl = document.getElementById(`status-${fieldKey}`);
            const tickEl = document.getElementById(`tick-${fieldKey}`);
            const inputEl = document.getElementById(fieldKey);

            if (!statusEl) return;

            const val = inputEl ? inputEl.value.trim() : '';

            if (isValid) {
                // Change to GREEN with a tick!
                statusEl.innerHTML = `<i class="fa-solid fa-circle-check text-emerald-600 text-xs"></i> <span class="font-bold text-emerald-700">${validText}</span>`;
                statusEl.className = 'inline-flex items-center gap-1 text-[10px] sm:text-[11px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-300 px-2 py-0.5 rounded-full transition-all duration-300 shadow-xs';
                
                if (inputEl) {
                    inputEl.classList.remove('border-slate-300', 'border-red-400', 'border-amber-400');
                    inputEl.classList.add('border-emerald-500', 'bg-emerald-50/15');
                }
                if (tickEl) {
                    tickEl.classList.remove('hidden');
                }
            } else if (val.length === 0) {
                // Default / Empty state with asterisk
                statusEl.innerHTML = `<span class="font-bold text-rose-500">*</span> ${emptyText}`;
                statusEl.className = 'inline-flex items-center gap-1 text-[11px] font-semibold text-rose-500 transition-all duration-200';
                
                if (inputEl) {
                    inputEl.classList.remove('border-emerald-500', 'bg-emerald-50/15', 'border-red-400', 'border-amber-400');
                    inputEl.classList.add('border-slate-300');
                }
                if (tickEl) {
                    tickEl.classList.add('hidden');
                }
            } else {
                // Invalid or in progress state
                statusEl.innerHTML = `<i class="fa-solid fa-circle-exclamation text-amber-500 text-[10px]"></i> <span class="font-semibold text-amber-700">${invalidText || 'Incomplete'}</span>`;
                statusEl.className = 'inline-flex items-center gap-1 text-[10px] sm:text-[11px] font-semibold text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full transition-all duration-200';
                
                if (inputEl) {
                    inputEl.classList.remove('border-emerald-500', 'bg-emerald-50/15', 'border-slate-300');
                    inputEl.classList.add('border-amber-400');
                }
                if (tickEl) {
                    tickEl.classList.add('hidden');
                }
            }
        }

        // 1. Full Name
        function validateName() {
            const valid = nameInput.value.trim().length >= 3;
            updateStatus('name', valid, 'Name Verified', 'Required', 'Min 3 letters');
        }
        nameInput.addEventListener('input', validateName);

        // 2. Email Address
        function validateEmail() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const valid = emailRegex.test(emailInput.value.trim());
            updateStatus('email', valid, 'Email Valid', 'Required', 'Invalid email');
        }
        emailInput.addEventListener('input', validateEmail);

        // 3. Phone Number (Max 10 digits)
        function validatePhone() {
            phoneInput.value = phoneInput.value.replace(/\D/g, '');
            if (phoneInput.value.length > 10) {
                phoneInput.value = phoneInput.value.slice(0, 10);
            }
            const len = phoneInput.value.length;
            const valid = len === 10;
            
            if (valid) {
                phoneError.classList.add('hidden');
                updateStatus('phone', true, '10 Digits Verified', '0/10 digits');
            } else if (len > 0) {
                updateStatus('phone', false, '', '', `${len}/10 digits`);
                phoneError.classList.remove('hidden');
            } else {
                phoneError.classList.add('hidden');
                updateStatus('phone', false, '', '0/10 digits');
            }
        }
        phoneInput.addEventListener('input', validatePhone);

        // 4. Registration Number (IN13/00000/23)
        function validateRegNumber() {
            const regPattern = /^[A-Za-z0-9]{1,5}\/\d{1,5}\/\d{1,2}$/;
            const val = regInput.value.trim();
            const valid = regPattern.test(val);

            if (valid) {
                regError.classList.add('hidden');
                updateStatus('reg_number', true, 'Valid Reg No.', 'e.g. IN13/00000/23');
            } else if (val.length > 0) {
                updateStatus('reg_number', false, '', '', 'Check format');
            } else {
                regError.classList.add('hidden');
                updateStatus('reg_number', false, '', 'e.g. IN13/00000/23');
            }
        }
        regInput.addEventListener('input', validateRegNumber);
        regInput.addEventListener('blur', function() {
            const regPattern = /^[A-Za-z0-9]{1,5}\/\d{1,5}\/\d{1,2}$/;
            const val = this.value.trim();
            if (val.length > 0 && !regPattern.test(val)) {
                regError.classList.remove('hidden');
            } else {
                regError.classList.add('hidden');
            }
        });

        // 5. Course of Study
        function validateCourse() {
            const valid = courseInput.value.trim().length >= 3;
            updateStatus('course', valid, 'Course Verified', 'Required', 'Too short');
        }
        courseInput.addEventListener('input', validateCourse);

        // 6. Year of Study
        function validateYear() {
            const valid = yearSelect.value !== '';
            updateStatus('year_of_study', valid, 'Year Selected', 'Select');
        }
        yearSelect.addEventListener('change', validateYear);

        // 7. School / Faculty
        function validateSchool() {
            const valid = schoolSelect.value !== '';
            updateStatus('school', valid, 'School Selected', 'Select');
        }
        schoolSelect.addEventListener('change', validateSchool);

        // 8. Password & Confirm Password
        function validatePasswords() {
            const passVal = passInput.value;
            const confirmVal = passConfirmInput.value;

            // Password field
            const passValid = passVal.length >= 8;
            updateStatus('password', passValid, '8+ Chars Secure', 'Min 8 chars', `${passVal.length}/8 chars`);

            // Confirm password
            if (confirmVal.length > 0) {
                const match = (confirmVal === passVal && passValid);
                if (match) {
                    passMismatchError.classList.add('hidden');
                    updateStatus('password_confirmation', true, 'Passwords Match', 'Re-type password');
                } else {
                    passMismatchError.classList.remove('hidden');
                    updateStatus('password_confirmation', false, '', '', 'Mismatch');
                }
            } else {
                passMismatchError.classList.add('hidden');
                updateStatus('password_confirmation', false, '', 'Re-type password');
            }
        }
        passInput.addEventListener('input', validatePasswords);
        passConfirmInput.addEventListener('input', validatePasswords);

        // Part 2 validation helpers
        function validatePart2Fields() {
            const reasonValid = reasonSelect.value !== '';
            updateStatus('reason_for_registering', reasonValid, 'Purpose Set', 'Select');

            const searchingValid = searchingSelect.value !== '';
            updateStatus('what_searching', searchingValid, 'Category Locked', 'Select');
        }
        reasonSelect.addEventListener('change', () => {
            handleReasonChange();
            validatePart2Fields();
        });
        searchingSelect.addEventListener('change', validatePart2Fields);

        // Toggle password visibility
        function togglePassword(fieldId, iconId) {
            const passwordInput = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Multi-Step Navigation with Spinning Animation
        function goToPart2() {
            const name = nameInput.value.trim();
            const email = emailInput.value.trim();
            const phone = phoneInput.value.trim();
            const reg = regInput.value.trim();
            const course = courseInput.value.trim();
            const year = yearSelect.value;
            const school = schoolSelect.value;
            const pass = passInput.value;
            const passConfirm = passConfirmInput.value;

            if(!name || !email || !phone || !reg || !course || !year || !school || !pass || !passConfirm) {
                alert('Please complete all required fields in Part 1 before continuing.');
                return;
            }

            if(phone.length !== 10) {
                alert('Phone number must be exactly 10 digits (e.g. 0712345678).');
                phoneInput.focus();
                return;
            }

            const regPattern = /^[A-Za-z0-9]{1,5}\/\d{1,5}\/\d{1,2}$/;
            if (!regPattern.test(reg)) {
                alert('Wrong registration number format. Please use format like IN13/00000/23.');
                regInput.focus();
                return;
            }

            if(pass.length < 8) {
                alert('Password must be at least 8 characters long.');
                passInput.focus();
                return;
            }

            if(pass !== passConfirm) {
                alert('Passwords do not match. Please ensure both passwords match.');
                passConfirmInput.focus();
                return;
            }

            // Show spinning animation on the button to indicate moving to next step
            const nextBtn = document.getElementById('nextBtn');
            const nextBtnText = document.getElementById('nextBtnText');
            const nextBtnIcon = document.getElementById('nextBtnIcon');

            nextBtn.disabled = true;
            nextBtnText.textContent = 'Verifying Part 1 & Loading...';
            nextBtnIcon.className = 'fa-solid fa-circle-notch fa-spin text-xs';

            setTimeout(() => {
                document.getElementById('part1').classList.add('hidden');
                const part2 = document.getElementById('part2');
                part2.classList.remove('hidden');
                
                // Reset button state
                nextBtn.disabled = false;
                nextBtnText.textContent = 'Next: Purpose & Search Intent';
                nextBtnIcon.className = 'fa-solid fa-arrow-right text-xs';

                validatePart2Fields();
                window.scrollTo({ top: 120, behavior: 'smooth' });
            }, 300);
        }

        function goToPart1() {
            document.getElementById('part2').classList.add('hidden');
            document.getElementById('part1').classList.remove('hidden');
            window.scrollTo({ top: 120, behavior: 'smooth' });
        }

        function handleReasonChange() {
            const val = reasonSelect.value;
            const searchingCont = document.getElementById('searchingContainer');
            const lostCont = document.getElementById('lostContainer');

            if (val === 'Finding a lost item / searching') {
                searchingCont.classList.remove('hidden');
                lostCont.classList.add('hidden');
            } else if (val === 'Posting a lost item') {
                lostCont.classList.remove('hidden');
                searchingCont.classList.add('hidden');
            } else {
                searchingCont.classList.add('hidden');
                lostCont.classList.add('hidden');
            }
        }

        // On submit show loading spinner on Complete Registration button
        const form = document.getElementById('registrationForm');
        form.addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const submitBtnText = document.getElementById('submitBtnText');
            const submitBtnIcon = document.getElementById('submitBtnIcon');

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtnText.textContent = 'Creating Your Account...';
                submitBtnIcon.className = 'fa-solid fa-circle-notch fa-spin text-xs';
            }
        });

        // Initialize state on page load
        document.addEventListener('DOMContentLoaded', function() {
            validateName();
            validateEmail();
            validatePhone();
            validateRegNumber();
            validateCourse();
            validateYear();
            validateSchool();
            validatePasswords();
            handleReasonChange();
        });
    </script>
</x-guest-layout>