<x-guest-layout>
    <div class="mb-5 text-center">
        <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">Welcome Back</h2>
        <p class="text-xs text-gray-500 mt-1">Sign in to access your Kisii University Lost &amp; Found account.</p>
    </div>

    <!-- Session Status -->
    @if(session('status'))
        <div class="mb-4 bg-emerald-50 border-l-4 border-emerald-600 p-3 rounded-r-xl text-emerald-800 text-xs font-medium flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
            {{ session('status') }}
        </div>
    @endif

    <!-- Session Error Messages (e.g., from redirects with messages) -->
    @if(session('message'))
        <div class="mb-4 bg-amber-50 border-l-4 border-amber-500 p-3 rounded-r-xl text-amber-800 text-xs font-medium flex items-center gap-2">
            <i class="fa-solid fa-lock text-amber-600"></i>
            {{ session('message') }}
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="mb-5 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl">
            <div class="flex items-center gap-2 text-red-800 font-bold text-sm mb-1">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>Login failed. Please check your details:</span>
            </div>
            <ul class="list-disc list-inside text-xs text-red-700 space-y-1 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                Email Address <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <i class="fa-solid fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    placeholder="your.email@university.ac.ke"
                    class="block w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('email') border-red-400 @enderror">
            </div>
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                Password <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    placeholder="••••••••"
                    class="block w-full pl-10 pr-11 py-3 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('password') border-red-400 @enderror">
                <button type="button" onclick="togglePwdVisibility()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition">
                    <i class="fa-solid fa-eye text-xs" id="pwdToggleIcon"></i>
                </button>
            </div>
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between text-xs">
            <label for="remember_me" class="inline-flex items-center gap-2 text-slate-600 cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 w-3.5 h-3.5">
                <span>Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="font-semibold text-emerald-700 hover:text-emerald-900 hover:underline transition">
                    Forgot password?
                </a>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full bg-emerald-800 hover:bg-emerald-700 text-white font-bold py-3.5 px-6 rounded-xl transition shadow-sm hover:shadow-md text-sm flex items-center justify-center gap-2">
            <i class="fa-solid fa-right-to-bracket"></i>
            Sign In to Portal
        </button>

        <!-- Divider -->
        <div class="relative my-4">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-slate-200"></div>
            </div>
            <div class="relative flex justify-center text-xs">
                <span class="bg-white px-3 text-slate-400 font-medium">New to the portal?</span>
            </div>
        </div>

        <a href="{{ route('register') }}" class="w-full block text-center bg-amber-500 hover:bg-amber-400 text-emerald-950 font-bold py-3 px-6 rounded-xl transition text-sm">
            <i class="fa-solid fa-user-plus mr-1.5"></i> Create Student Account
        </a>
    </form>

    <!-- Public Options Reminder -->
    <div class="mt-5 bg-emerald-50 border border-emerald-200 rounded-2xl p-3.5 text-center">
        <p class="text-xs text-emerald-800 font-medium">
            <i class="fa-solid fa-circle-info text-emerald-600 mr-1"></i>
            You can <a href="{{ route('items.create') }}?status=found" class="underline font-bold">report found items</a> or
            <a href="{{ route('items.create') }}?status=lost" class="underline font-bold">report lost items</a>
            without creating an account.
        </p>
    </div>

    <script>
        function togglePwdVisibility() {
            const pwd = document.getElementById('password');
            const icon = document.getElementById('pwdToggleIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                pwd.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</x-guest-layout>
