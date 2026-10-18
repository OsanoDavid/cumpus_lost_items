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

        <!-- Google Fonts: Inter / Figtree -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- FontAwesome Icons CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Tailwind CSS CDN Fallback & Vite Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            }
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-800 antialiased flex flex-col selection:bg-emerald-500 selection:text-white">
        <!-- Global Page Transition Loader -->
        @include('layouts.page-loader')

        <!-- Site Navigation -->
        @include('layouts.navigation')

        <!-- Page Heading if defined -->
        @isset($header)
            <header class="bg-white border-b border-slate-200/80 shadow-xs">
                <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Global Unified Footer with All Direct Routes -->
        @include('layouts.footer')

        <!-- Accessibility Widget -->
        @include('layouts.accessibility')
    </body>
</html>
