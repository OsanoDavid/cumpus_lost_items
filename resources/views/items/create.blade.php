<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb / Back Link -->
            <div class="mb-6 flex items-center justify-between">
                <a href="{{ Auth::check() ? route('items.index') : url('/') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-emerald-800 hover:text-emerald-950 transition">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>{{ Auth::check() ? 'Back to Campus Feed' : 'Back to Home' }}</span>
                </a>
                <span class="text-xs text-slate-400 font-medium">Official Kisii University Property Desk</span>
            </div>

            @php
                $initialStatus = old('status', request('status', 'lost'));
            @endphp

            <!-- Main Form Card -->
            <div class="bg-white p-6 sm:p-10 rounded-3xl shadow-sm border border-slate-200/90">
                
                <div class="border-b border-slate-100 pb-6 mb-6">
                    <div class="inline-flex items-center gap-2 bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-2" id="badgeIndicator">
                        <i class="fa-solid fa-file-pen text-emerald-600"></i>
                        <span id="badgeText">{{ $initialStatus === 'lost' ? 'Report Lost Property' : 'Report Found Property' }}</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight" id="formHeading">
                        {{ $initialStatus === 'lost' ? 'Report a Lost Campus Item' : 'Report a Found Campus Item' }}
                    </h1>
                    <p class="text-slate-600 text-xs sm:text-sm mt-1.5 leading-relaxed" id="formSubtitle">
                        @if($initialStatus === 'lost')
                            Fill in your lost item details below. Once submitted, our system instantly scans all campus found records from your loss date to today and checks for matching credentials (such as School ID / Reg numbers).
                        @else
                            Provide details and location for the found item. If it is a Student ID or card, enter the ID number so the rightful owner is matched instantly.
                        @endif
                    </p>
                </div>

                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl">
                        <div class="flex items-center gap-2 text-red-800 font-bold text-sm mb-1">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span>Please review the following errors:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Report Form -->
                <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="reportItemForm">
                    @csrf

                    <!-- Status Selection: Lost or Found -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Select Report Type <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <label id="labelStatusLost" class="relative flex items-center justify-between p-4 rounded-2xl border-2 cursor-pointer transition {{ $initialStatus === 'lost' ? 'border-red-500 bg-red-50/50' : 'border-slate-200 hover:border-slate-300 bg-white' }}">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="status" value="lost" id="statusLost" class="text-red-600 focus:ring-red-500 w-4 h-4" {{ $initialStatus === 'lost' ? 'checked' : '' }} required onchange="updateFormMode('lost')">
                                    <div>
                                        <span class="block font-bold text-sm text-red-700">I Lost an Item</span>
                                        <span class="text-[11px] text-slate-500">I am searching for my lost property</span>
                                    </div>
                                </div>
                                <span class="text-red-500 text-lg"><i class="fa-solid fa-triangle-exclamation"></i></span>
                            </label>

                            <label id="labelStatusFound" class="relative flex items-center justify-between p-4 rounded-2xl border-2 cursor-pointer transition {{ $initialStatus === 'found' ? 'border-emerald-600 bg-emerald-50/50' : 'border-slate-200 hover:border-slate-300 bg-white' }}">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="status" value="found" id="statusFound" class="text-emerald-600 focus:ring-emerald-500 w-4 h-4" {{ $initialStatus === 'found' ? 'checked' : '' }} required onchange="updateFormMode('found')">
                                    <div>
                                        <span class="block font-bold text-sm text-emerald-800">I Found an Item</span>
                                        <span class="text-[11px] text-slate-500">I picked up an item to surrender/return</span>
                                    </div>
                                </div>
                                <span class="text-emerald-600 text-lg"><i class="fa-solid fa-circle-check"></i></span>
                            </label>
                        </div>
                    </div>

                    <!-- 1. Item Name / Title -->
                    <div>
                        <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Item Name / Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="e.g., Student ID Card, HP Pavilion 15 Laptop, Room Keys" class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" required>
                    </div>

                    <!-- 2. Category & Location -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select name="category" id="category" class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white" required onchange="handleCategoryChange(this.value)">
                                <option value="">Select Category</option>
                                <option value="Student ID / Documents" {{ old('category') == 'Student ID / Documents' ? 'selected' : '' }}>Student ID / Documents</option>
                                <option value="Electronics" {{ old('category') == 'Electronics' ? 'selected' : '' }}>Electronics (Laptops, Phones, Flash Disks)</option>
                                <option value="Books / Notes" {{ old('category') == 'Books / Notes' ? 'selected' : '' }}>Books / Notes</option>
                                <option value="Clothing / Bags" {{ old('category') == 'Clothing / Bags' ? 'selected' : '' }}>Clothing / Bags / Wallets</option>
                                <option value="Keys" {{ old('category') == 'Keys' ? 'selected' : '' }}>Keys (Room / Hostel / Padlock)</option>
                                <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other Personal Items</option>
                            </select>
                        </div>

                        <!-- Campus Location -->
                        <div>
                            <label for="location" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5" id="labelLocation">
                                {{ $initialStatus === 'lost' ? 'Location Lost' : 'Location Found' }} <span class="text-red-500">*</span>
                            </label>
                            <select name="location" id="location" class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white" required>
                                <option value="">Select Campus Hotspot</option>
                                <option value="Main Library" {{ old('location') == 'Main Library' ? 'selected' : '' }}>Main Library & Study Halls</option>
                                <option value="New Tuition Complex (NTC)" {{ old('location') == 'New Tuition Complex (NTC)' ? 'selected' : '' }}>New Tuition Complex (NTC)</option>
                                <option value="Graduation Square" {{ old('location') == 'Graduation Square' ? 'selected' : '' }}>Graduation Square</option>
                                <option value="Administration Block" {{ old('location') == 'Administration Block' ? 'selected' : '' }}>Administration Block / Cash Office</option>
                                <option value="Science Complex" {{ old('location') == 'Science Complex' ? 'selected' : '' }}>Science Complex & Labs</option>
                                <option value="University Mess / Cafeteria" {{ old('location') == 'University Mess / Cafeteria' ? 'selected' : '' }}>University Mess / Cafeteria</option>
                                <option value="Hostels Area" {{ old('location') == 'Hostels Area' ? 'selected' : '' }}>Hostels Area & Walkways</option>
                                <option value="Sports Pavilion / Grounds" {{ old('location') == 'Sports Pavilion / Grounds' ? 'selected' : '' }}>Sports Pavilion / Grounds</option>
                                <option value="Other Campus Grounds" {{ old('location') == 'Other Campus Grounds' ? 'selected' : '' }}>Other Campus Grounds</option>
                            </select>
                        </div>
                    </div>

                    <!-- 3. Date Lost / Found -->
                    <div>
                        <label for="date_lost_found" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5" id="labelDate">
                            {{ $initialStatus === 'lost' ? 'Date Lost' : 'Date Found' }} <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="date_lost_found" id="date_lost_found" max="{{ date('Y-m-d') }}" value="{{ old('date_lost_found', date('Y-m-d')) }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" required>
                        <p class="text-[11px] text-slate-500 mt-1" id="dateHelperText">
                            {{ $initialStatus === 'lost' ? 'The system will search all found items logged from this date forward up to today.' : 'Specify the date you picked up this item on campus.' }}
                        </p>
                    </div>

                    <!-- 4. Detailed Description -->
                    <div>
                        <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Detailed Description <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" id="description" rows="3" placeholder="Provide distinct characteristics: color, brand, stickers, condition, engravings, and where you last had it..." class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" required>{{ old('description') }}</textarea>
                    </div>

                    <!-- 5. Credentials & Secret Info / Number (For instant matching of Student IDs, serial numbers, etc.) -->
                    <div class="bg-amber-50/70 border border-amber-200/90 p-5 rounded-2xl space-y-2">
                        <div class="flex items-center justify-between">
                            <label for="secret_identifier" class="block text-xs font-bold uppercase tracking-wider text-amber-900" id="labelSecretNumber">
                                <i class="fa-solid fa-id-card text-amber-600 mr-1.5"></i>
                                <span id="secretNumberTitle">School ID / Registration / Secret Number</span>
                            </label>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-amber-200/80 text-amber-900 uppercase tracking-wide">
                                Smart Matching
                            </span>
                        </div>
                        <p class="text-xs text-amber-800 leading-relaxed" id="secretNumberHelper">
                            <strong>For Student IDs:</strong> Enter your student Reg No (e.g. <span class="font-mono font-bold text-amber-950">IN13/00000/23</span>). Our system will automatically cross-reference this against all found IDs so it appears immediately on your dashboard! For laptops/phones, enter serial number or a secret detail.
                        </p>
                        <input type="text" name="secret_identifier" id="secret_identifier" 
                            value="{{ old('secret_identifier', Auth::check() ? Auth::user()->reg_number : '') }}" 
                            placeholder="e.g., IN13/00000/23 or Serial/Marker Number" 
                            class="w-full border border-amber-300 rounded-xl px-4 py-2.5 text-sm font-mono focus:ring-2 focus:ring-amber-500 focus:border-amber-500 bg-white">
                    </div>

                    <!-- 6. Evidence Photo (OPTIONAL) -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="image" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                Upload Photo / Evidence
                            </label>
                            <span class="text-[11px] font-semibold text-slate-500 bg-slate-200/70 px-2 py-0.5 rounded-full">
                                Optional — Leave empty if you have no photo
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-500 mb-2">
                            An image is completely optional since you may not have a photo. You can submit without uploading anything.
                        </p>
                        <input type="file" name="image" id="image" accept="image/png, image/jpeg, image/jpg, image/webp" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-100 file:text-emerald-800 hover:file:bg-emerald-200 cursor-pointer">
                    </div>

                    <!-- 7. Reporter Contact Details (Phone Number) -->
                    <div class="bg-emerald-50/70 border-2 border-emerald-300/80 rounded-2xl p-5 space-y-4">
                        <div class="flex items-center gap-2.5 text-emerald-950 font-bold text-sm">
                            <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-xs">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <span class="block">Reporter Contact Number</span>
                                <span class="text-[11px] text-emerald-800 font-normal">
                                    Your 10-digit phone number is required so Campus Security or the finder can reach you for retrieval.
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                            <div>
                                <label for="contact_phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                    Contact Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="contact_phone" id="contact_phone" 
                                    value="{{ old('contact_phone', Auth::check() ? Auth::user()->phone : '') }}" 
                                    placeholder="e.g. 0712345678" 
                                    maxlength="10" 
                                    class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-mono focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white" required>
                                <p class="text-[11px] text-slate-500 mt-1">Must be 10 numeric digits (e.g., 0712345678).</p>
                                @error('contact_phone')
                                    <p class="text-xs text-red-600 font-bold mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="contact_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                    Reporter Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="contact_name" id="contact_name" 
                                    value="{{ old('contact_name', Auth::check() ? Auth::user()->name : '') }}" 
                                    placeholder="e.g. Jane Doe" 
                                    class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white" required>
                                <p class="text-[11px] text-slate-500 mt-1">Name on file for campus property record.</p>
                                @error('contact_name')
                                    <p class="text-xs text-red-600 font-bold mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Anonymous Posting Option -->
                    <div class="flex items-start space-x-3 pt-1">
                        <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1" {{ old('is_anonymous') ? 'checked' : '' }} class="mt-0.5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                        <label for="is_anonymous" class="text-xs text-slate-600 cursor-pointer">
                            <strong class="text-slate-800">Conceal my name on public feed:</strong> Hide your name from the public list (Campus Security will still have your phone number for retrieval).
                        </label>
                    </div>

                    <!-- Form Action Buttons -->
                    <div class="pt-4 flex flex-col sm:flex-row gap-3">
                        <a href="{{ Auth::check() ? route('items.index') : url('/') }}" class="w-full sm:w-1/3 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3.5 px-4 rounded-xl transition text-xs flex items-center justify-center gap-2">
                            <i class="fa-solid fa-xmark"></i> Cancel
                        </a>
                        <button type="submit" id="submitBtn" class="w-full sm:w-2/3 bg-emerald-700 hover:bg-emerald-600 text-white font-bold py-3.5 px-6 rounded-xl transition shadow-md hover:shadow-lg text-xs flex items-center justify-center gap-2">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span id="submitBtnText">{{ $initialStatus === 'lost' ? 'Submit Lost Item & Scan Matches' : 'Submit Found Item Report' }}</span>
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>

    <!-- Client-side script for dynamic UX -->
    <script>
        function updateFormMode(mode) {
            const labelLost = document.getElementById('labelStatusLost');
            const labelFound = document.getElementById('labelStatusFound');
            const heading = document.getElementById('formHeading');
            const subtitle = document.getElementById('formSubtitle');
            const badgeText = document.getElementById('badgeText');
            const labelLocation = document.getElementById('labelLocation');
            const labelDate = document.getElementById('labelDate');
            const dateHelper = document.getElementById('dateHelperText');
            const submitBtnText = document.getElementById('submitBtnText');

            if (mode === 'lost') {
                labelLost.className = "relative flex items-center justify-between p-4 rounded-2xl border-2 cursor-pointer transition border-red-500 bg-red-50/50";
                labelFound.className = "relative flex items-center justify-between p-4 rounded-2xl border-2 cursor-pointer transition border-slate-200 hover:border-slate-300 bg-white";
                badgeText.textContent = "Report Lost Property";
                heading.textContent = "Report a Lost Campus Item";
                subtitle.textContent = "Fill in your lost item details below. Once submitted, our system instantly scans all campus found records from your loss date to today and checks for matching credentials (such as School ID / Reg numbers).";
                labelLocation.innerHTML = 'Location Lost <span class="text-red-500">*</span>';
                labelDate.innerHTML = 'Date Lost <span class="text-red-500">*</span>';
                dateHelper.textContent = "The system will search all found items logged from this date forward up to today.";
                submitBtnText.textContent = "Submit Lost Item & Scan Matches";
            } else {
                labelFound.className = "relative flex items-center justify-between p-4 rounded-2xl border-2 cursor-pointer transition border-emerald-600 bg-emerald-50/50";
                labelLost.className = "relative flex items-center justify-between p-4 rounded-2xl border-2 cursor-pointer transition border-slate-200 hover:border-slate-300 bg-white";
                badgeText.textContent = "Report Found Property";
                heading.textContent = "Report a Found Campus Item";
                subtitle.textContent = "Provide details and location for the found item. If it is a Student ID or card, enter the ID number so the rightful owner is matched instantly.";
                labelLocation.innerHTML = 'Location Found <span class="text-red-500">*</span>';
                labelDate.innerHTML = 'Date Found <span class="text-red-500">*</span>';
                dateHelper.textContent = "Specify the date you picked up this item on campus.";
                submitBtnText.textContent = "Submit Found Item Report";
            }
        }

        function handleCategoryChange(cat) {
            const titleInput = document.getElementById('title');
            const secretInput = document.getElementById('secret_identifier');
            const secretTitle = document.getElementById('secretNumberTitle');
            const secretHelper = document.getElementById('secretNumberHelper');

            if (cat === 'Student ID / Documents') {
                if (!titleInput.value) {
                    titleInput.value = 'Student ID Card';
                }
                secretTitle.textContent = "School ID / Student Registration Number";
                secretHelper.innerHTML = '<strong>Student ID Match:</strong> Enter the student registration number (e.g. <span class="font-mono font-bold text-amber-950">IN13/00000/23</span>). The system will search for this exact number among all surrendered IDs!';
                secretInput.placeholder = "e.g., IN13/00000/23";
            } else if (cat === 'Electronics') {
                secretTitle.textContent = "Device Serial Number / IMEI / Secret Marker";
                secretHelper.innerHTML = '<strong>Device Verification:</strong> Enter the laptop or phone serial number, IMEI, or a secret wallpaper/sticker marker for verification.';
                secretInput.placeholder = "e.g., Serial number or model code";
            } else {
                secretTitle.textContent = "Secret Identifier / Verification Marker";
                secretHelper.innerHTML = '<strong>Secret Marker:</strong> Enter any private markings (keychain color, engraving, pocket content) to verify ownership.';
                secretInput.placeholder = "e.g., Keyring color or unique engraving";
            }
        }
    </script>
</x-app-layout>