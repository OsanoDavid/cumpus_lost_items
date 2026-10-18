<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kisii University Lost & Found') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/kisii-logo.png') }}">
        <link rel="shortcut icon" href="{{ asset('images/kisii-logo.png') }}">

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- FontAwesome Icons CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Tailwind CDN & Vite Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Alpine.js for navigation dropdowns -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            body {
                font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            }
        </style>
    </head>
    <body class="min-h-screen bg-slate-900 text-slate-800 antialiased flex flex-col justify-between selection:bg-emerald-500 selection:text-white relative">
        <!-- Global Page Transition Loader -->
        @include('layouts.page-loader')

        <!-- Campus Wallpaper Background -->
        <div class="fixed inset-0 z-[-1] pointer-events-none">
            <img src="{{ asset('images/hero-bg.jpg') }}" alt="Kisii University Campus" class="w-full h-full object-cover opacity-15 filter contrast-110">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/90 via-emerald-950/80 to-slate-950/95"></div>
        </div>

        <!-- Site Navigation -->
        @include('layouts.navigation')

        <!-- Guest Content Center Area -->
        <main class="flex-grow flex flex-col justify-center items-center py-6 sm:py-12 px-3 sm:px-6 lg:px-8">
            <div class="w-full sm:max-w-xl">
                
                <!-- Logo & Brand Header -->
                <div class="text-center mb-6">
                    <a href="{{ url('/') }}" class="inline-flex flex-col items-center group">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white p-2 flex items-center justify-center shadow-xl border border-emerald-500/40 group-hover:scale-105 transition duration-200">
                            <img src="{{ asset('images/kisii-logo.png') }}" alt="Kisii University Logo" class="w-full h-full object-contain">
                        </div>
                        <span class="mt-2.5 sm:mt-3 text-xl sm:text-2xl font-extrabold text-white tracking-tight drop-shadow-sm">Kisii University</span>
                        <span class="text-[10px] sm:text-xs text-emerald-300 font-bold uppercase tracking-wider">Lost &amp; Found Portal</span>
                    </a>
                </div>

                <div class="bg-white py-6 sm:py-8 px-4 sm:px-8 shadow-2xl border border-slate-200/90 rounded-2xl sm:rounded-3xl">
                    {{ $slot }}
                </div>

                <!-- Assistance Note -->
                <div class="mt-6 text-center text-xs text-slate-400">
                    <span>Need security assistance? </span>
                    <a href="tel:+254582030161" class="text-emerald-400 font-bold hover:underline">+254 58 2030161</a>
                </div>

            </div>
        </main>

        <!-- Global Unified Footer with All Direct Routes -->
        @include('layouts.footer')

        <!-- Accessibility Widget -->
        @include('layouts.accessibility')
    </body>
</html>
