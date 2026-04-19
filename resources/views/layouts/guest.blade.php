<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AskCampus') }} – {{ request()->routeIs('login') ? 'Connexion' : 'Inscription' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased min-h-screen bg-gradient-to-br from-indigo-950 via-indigo-900 to-purple-900 flex items-center justify-center p-4">
    <div class="w-full max-w-[420px]">
        <!-- Logo -->
        <div class="flex justify-center mb-8">
            <a href="{{ route('questions.index') }}" class="flex items-center gap-3 group px-4 py-2 rounded-xl hover:bg-white/5 transition-colors">
                <svg width="36" height="36" viewBox="0 0 30 30" fill="none" class="transform group-hover:scale-110 group-hover:-rotate-3 transition-all duration-300 drop-shadow-md">
                    <path d="M15 3L3 10l12 7 12-7-12-7z" fill="rgba(255,255,255,1)"/>
                    <path d="M3 10v7" stroke="rgba(255,255,255,.9)" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="3" cy="19" r="1.5" fill="rgba(255,255,255,.9)"/>
                    <path d="M7 13.5v5c0 2.5 3.8 4.5 8 4.5s8-2 8-4.5v-5"
                          fill="rgba(255,255,255,.2)" stroke="rgba(255,255,255,.9)"
                          stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <span class="text-3xl font-black tracking-tight text-white drop-shadow-md">AskCampus</span>
            </a>
        </div>

        <!-- Card -->
        <div class="bg-white/95 backdrop-blur-xl rounded-2xl p-8 sm:p-10 shadow-[0_24px_60px_rgba(0,0,0,0.4)] ring-1 ring-white/20">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
