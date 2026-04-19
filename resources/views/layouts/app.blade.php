<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AskCampus') }} – Entraide étudiante</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-size: 13px;
            color: #232629;
            background-color: #f5f5fd;
            line-height: 1.5;
        }
        [x-cloak] { display: none !important; }
        a { text-decoration: none; }

        /* ── Navbar ─────────────────────── */
        #site-header {
            position: sticky; top: 0; z-index: 100;
            height: 52px;
            background: #fff;
            border-bottom: 3px solid #5046e5;
            display: flex; align-items: center;
            box-shadow: 0 1px 6px rgba(80,70,229,.12);
        }
        .header-inner {
            width: 100%; margin: 0;
            padding: 0 12px;
            display: flex; align-items: center; gap: 6px;
        }

        /* Logo */
        .site-logo {
            display: flex; align-items: center; gap: 8px;
            padding: 0 6px; height: 52px;
            text-decoration: none; flex-shrink: 0;
        }
        .logo-icon { display: flex; align-items: center; justify-content: center; }
        .logo-text {
            font-size: 18px; font-weight: 800; letter-spacing: -.5px;
            background: linear-gradient(135deg, #5046e5 0%, #8b5cf6 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        /* Search */
        .header-search { flex: 1; max-width: 600px; margin: 0 auto; }
        .search-wrap { position: relative; }
        .search-wrap input {
            display: block; width: 100%;
            padding: 8px 10px 8px 34px;
            font-size: 13px;
            border: 1px solid #d1d5db; border-radius: 8px;
            background: #f9fafb; color: #232629; outline: none;
            transition: border-color .15s, box-shadow .15s, background .15s;
        }
        .search-wrap input:focus {
            background: #fff;
            border-color: #5046e5;
            box-shadow: 0 0 0 3px rgba(80,70,229,.15);
        }
        .search-wrap input::placeholder { color: #9ca3af; }
        .search-icon {
            position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
            width: 15px; height: 15px; color: #9ca3af; pointer-events: none;
        }

        /* Auth buttons */
        .header-actions { display: flex; align-items: center; gap: 6px; margin-left: auto; }
        .btn-login {
            padding: 7px 14px; font-size: 13px; font-weight: 500;
            color: #5046e5; border: 1.5px solid #5046e5; border-radius: 8px;
            background: transparent; cursor: pointer;
            transition: background .15s;
        }
        .btn-login:hover { background: #eef2ff; }
        .btn-signup {
            padding: 7px 14px; font-size: 13px; font-weight: 600;
            color: #fff; border: none; border-radius: 8px;
            background: linear-gradient(135deg, #5046e5 0%, #7c3aed 100%);
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(80,70,229,.35);
            transition: opacity .15s;
        }
        .btn-signup:hover { opacity: .88; }

        /* ── Page Layout ─────────────────── */
        #page-wrap {
            width: 100%; margin: 0;
            display: flex; min-height: calc(100vh - 52px);
        }

        /* ── Left Sidebar ────────────────── */
        #sidebar-left {
            width: 170px; flex-shrink: 0;
            border-right: 1px solid #e5e7eb;
            background: #fff;
        }
        #sidebar-left nav { position: sticky; top: 52px; padding: 12px 0; }

        .nav-item {
            display: flex; align-items: center; gap: 8px;
            padding: 9px 10px 9px 14px;
            font-size: 13px; color: #6b7280;
            border-right: 3px solid transparent;
            cursor: pointer; transition: color .12s, background .12s;
        }
        .nav-item:hover { color: #1f2937; background: #f5f5fd; }
        .nav-item.active {
            font-weight: 700; color: #1f2937;
            background: #eef2ff;
            border-right-color: #5046e5;
        }
        .nav-item svg { width: 17px; height: 17px; flex-shrink: 0; }
        .nav-section-title {
            padding: 14px 14px 4px;
            font-size: 10.5px; font-weight: 700;
            text-transform: uppercase; letter-spacing: .06em;
            color: #9ca3af;
        }
        .nav-divider { height: 1px; background: #f3f4f6; margin: 6px 0; }

        /* ── Main ────────────────────────── */
        #page-main { flex: 1; min-width: 0; display: flex; }
        #content-center {
            flex: 1; min-width: 0;
            padding: 24px; background: #fff;
            border-right: 1px solid #e5e7eb;
        }

        /* ── Right Sidebar ───────────────── */
        #sidebar-right {
            width: 290px; flex-shrink: 0;
            padding: 20px 14px; background: #f5f5fd;
        }

        /* Widgets */
        .widget {
            background: #fff; border: 1px solid #e5e7eb;
            border-radius: 10px; margin-bottom: 14px; overflow: hidden;
        }
        .widget-head {
            padding: 10px 14px;
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: .05em;
            color: #6b7280; background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            display: flex; align-items: center; gap: 7px;
        }
        .widget-head svg { width:14px;height:14px; }
        .widget-body { padding: 12px 14px; }

        .widget-blog { background: #fefce8; border-color: #fde68a; border-radius: 10px; }
        .widget-blog .widget-head { background: #fef9c3; border-color: #fde68a; color: #92400e; }
        .widget-blog .widget-body a {
            display: flex; align-items: flex-start; gap: 6px;
            font-size: 13px; color: #1d4ed8; padding: 4px 0; line-height: 1.4;
        }
        .widget-blog .widget-body a:hover { color: #1e40af; }

        .stat-row { display:flex;justify-content:space-between;align-items:center;padding:4px 0; }
        .stat-row dt { font-size:13px;color:#6b7280; }
        .stat-row dd { font-size:13px;font-weight:700;color:#111827; }
        .tag-row { display:flex;justify-content:space-between;align-items:center;padding:3px 0; }
        .tag-pill {
            display:inline-flex;align-items:center;padding:3px 8px;
            font-size:12px;color:#5046e5;background:#eef2ff;
            border-radius:6px;text-decoration:none;
            transition:background .12s;
        }
        .tag-pill:hover { background:#e0e7ff; }
        .tag-count { font-size:12px;color:#9ca3af; }

        /* Flash */
        .flash-ok {
            margin-bottom:16px;padding:10px 14px;
            background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;
            font-size:13px;color:#15803d;
        }
        .flash-err {
            margin-bottom:16px;padding:10px 14px;
            background:#fef2f2;border:1px solid #fecaca;border-radius:8px;
            font-size:13px;color:#b91c1c;
        }
    </style>
</head>

<body>
<!-- ══════════════ TOP NAVBAR ══════════════ -->
<header id="site-header">
    <div class="header-inner">

        <!-- Logo -->
        <a href="{{ auth()->check() ? route('dashboard') : route('questions.index') }}" class="site-logo">
            <span class="logo-icon">
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none">
                    <path d="M15 3L3 10l12 7 12-7-12-7z" fill="#5046e5"/>
                    <path d="M3 10v7" stroke="#5046e5" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="3" cy="19" r="1.5" fill="#7c3aed"/>
                    <path d="M7 13.5v5c0 2.5 3.8 4.5 8 4.5s8-2 8-4.5v-5" fill="#5046e5" fill-opacity=".25" stroke="#5046e5" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </span>
            <span class="logo-text">AskCampus</span>
        </a>

        <!-- Search -->
        <div class="header-search">
            <form action="{{ route('questions.index') }}" method="GET">
                <div class="search-wrap">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Rechercher des questions…" autocomplete="off">
                </div>
            </form>
        </div>

        <!-- Auth -->
        <div class="header-actions">
            @auth
                {{-- Icône notifications --}}
                <a href="{{ route('notifications.index') }}"
                   style="position:relative;display:flex;align-items:center;justify-content:center;
                          width:36px;height:36px;border-radius:8px;border:1.5px solid #e5e7eb;
                          color:#6b7280;transition:border-color .15s;"
                   onmouseover="this.style.borderColor='#5046e5';this.style.color='#5046e5'"
                   onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#6b7280'">
                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @php $unreadCount = auth()->user()->unreadNotifications()->count(); @endphp
                    @if($unreadCount > 0)
                        <span style="position:absolute;top:-4px;right:-4px;
                                     min-width:16px;height:16px;padding:0 4px;
                                     background:#d93025;color:#fff;border-radius:8px;
                                     font-size:10px;font-weight:700;
                                     display:flex;align-items:center;justify-content:center;
                                     border:2px solid #fff;">
                            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                        </span>
                    @endif
                </a>

                <div style="position:relative;" x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                            style="display:flex;align-items:center;gap:7px;padding:6px 10px;
                                   background:transparent;border:1.5px solid #e5e7eb;border-radius:8px;
                                   cursor:pointer;transition:border-color .15s;"
                            onmouseover="this.style.borderColor='#5046e5'" onmouseout="this.style.borderColor='#e5e7eb'">
                        @php
                            $colors = ['#5046e5','#7c3aed','#059669','#dc2626','#d97706','#0891b2'];
                            $ci = abs(crc32(auth()->user()->name)) % count($colors);
                        @endphp
                        <div style="width:26px;height:26px;border-radius:7px;background:{{ $colors[$ci] }};
                                    display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <span style="color:#fff;font-weight:700;font-size:11px;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        </div>
                        <span style="font-size:13px;font-weight:600;color:#1f2937;">{{ auth()->user()->name }}</span>
                        <span style="font-size:11px;font-weight:700;color:#5046e5;
                                     background:#eef2ff;padding:2px 6px;border-radius:5px;">
                            {{ number_format(auth()->user()->reputation ?? 0) }}
                        </span>
                        @if(auth()->user()->isModerator())
                            <span style="font-size:10px;font-weight:700;color:#fff;
                                         background:#dc2626;padding:2px 5px;border-radius:4px;letter-spacing:.03em;">
                                MOD
                            </span>
                        @endif
                    </button>

                    <div x-show="open" @click.away="open = false" x-cloak
                         style="position:absolute;right:0;top:calc(100% + 6px);width:210px;
                                background:#fff;border:1px solid #e5e7eb;border-radius:10px;
                                box-shadow:0 8px 24px rgba(0,0,0,.12);z-index:200;overflow:hidden;">
                        <div style="padding:6px 0;">
                            <a href="{{ route('profile.show') }}"
                               style="display:flex;align-items:center;gap:8px;padding:9px 16px;
                                      font-size:13px;color:#1f2937;"
                               onmouseover="this.style.background='#f5f5fd'" onmouseout="this.style.background='transparent'">
                                <svg style="width:15px;height:15px;color:#6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Mon profil
                            </a>
                            <a href="{{ route('profile.edit') }}"
                               style="display:flex;align-items:center;gap:8px;padding:9px 16px;
                                      font-size:13px;color:#1f2937;"
                               onmouseover="this.style.background='#f5f5fd'" onmouseout="this.style.background='transparent'">
                                <svg style="width:15px;height:15px;color:#6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Paramètres
                            </a>
                            <div style="height:1px;background:#f3f4f6;margin:4px 0;"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        style="display:flex;align-items:center;gap:8px;width:100%;
                                               padding:9px 16px;font-size:13px;color:#dc2626;
                                               background:transparent;border:none;cursor:pointer;text-align:left;"
                                        onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='transparent'">
                                    <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-login">Connexion</a>
                <a href="{{ route('register') }}" class="btn-signup">S'inscrire</a>
            @endauth
        </div>
    </div>
</header>

<!-- ══════════════ PAGE WRAP ══════════════ -->
<div id="page-wrap">

    <!-- Left Sidebar -->
    <aside id="sidebar-left">
        <nav>
            @auth
                <a href="{{ route('dashboard') }}"
                   class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Accueil
                </a>
            @else
                <a href="{{ route('questions.index') }}"
                   class="nav-item {{ request()->routeIs('questions.index') && !request()->has('tag') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Accueil
                </a>
            @endauth
            <a href="{{ route('questions.index') }}"
               class="nav-item {{ request()->routeIs('questions.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Questions
            </a>
            <a href="{{ route('tags.index') }}" class="nav-item {{ request()->routeIs('tags.index') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Tags
            </a>
            <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Utilisateurs
            </a>

            @auth
                <div class="nav-divider" style="margin-top:10px;"></div>
                <div class="nav-section-title">Personnel</div>
                <a href="{{ route('profile.show') }}"
                   class="nav-item {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Mon profil
                </a>
                @if(auth()->user()->isModerator())
                    <a href="{{ route('dashboard') }}" class="nav-item"
                       style="color:#dc2626;">
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Modération
                    </a>
                @endif
            @endauth
        </nav>
    </aside>

    <!-- Main -->
    <main id="page-main">
        <div id="content-center">
            @if(session('success'))
                <div class="flash-ok">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="flash-err">{{ session('error') }}</div>
            @endif
            {{ $slot }}
        </div>

        <!-- Right Sidebar -->
        <aside id="sidebar-right">
            <div style="position:sticky;top:calc(52px + 20px);">

                <!-- Blog -->
                <div class="widget widget-blog">
                    <div class="widget-head">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#92400e;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        Blog de la communauté
                    </div>
                    <div class="widget-body">
                        <a href="#">
                            <svg style="width:11px;height:11px;flex-shrink:0;margin-top:3px;color:#6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            Comment bien poser une question
                        </a>
                        <a href="#">
                            <svg style="width:11px;height:11px;flex-shrink:0;margin-top:3px;color:#6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            Système de réputation expliqué
                        </a>
                        <a href="#">
                            <svg style="width:11px;height:11px;flex-shrink:0;margin-top:3px;color:#6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            Guide du modérateur
                        </a>
                    </div>
                </div>

                <!-- Stats -->
                <div class="widget">
                    <div class="widget-head">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Statistiques
                    </div>
                    <div class="widget-body">
                        <dl>
                            <div class="stat-row">
                                <dt>Questions</dt>
                                <dd>{{ number_format(\App\Models\Question::count()) }}</dd>
                            </div>
                            <div class="stat-row">
                                <dt>Réponses</dt>
                                <dd>{{ number_format(\App\Models\Answer::count()) }}</dd>
                            </div>
                            <div class="stat-row">
                                <dt>Utilisateurs</dt>
                                <dd>{{ number_format(\App\Models\User::count()) }}</dd>
                            </div>
                            <div class="stat-row">
                                <dt>Résolues</dt>
                                <dd style="color:#059669;">{{ number_format(\App\Models\Question::where('is_solved',true)->count()) }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Tags -->
                <div class="widget">
                    <div class="widget-head">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Tags populaires
                    </div>
                    <div class="widget-body">
                        @foreach(\App\Models\Tag::withCount('questions')->orderByDesc('questions_count')->take(8)->get() as $tag)
                            <div class="tag-row">
                                <a href="{{ route('questions.index', ['tag' => $tag->slug]) }}" class="tag-pill">
                                    {{ $tag->name }}
                                </a>
                                <span class="tag-count">{{ $tag->questions_count }} q.</span>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </aside>
    </main>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
