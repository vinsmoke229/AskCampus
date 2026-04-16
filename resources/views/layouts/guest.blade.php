<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AskCampus') }} – {{ request()->routeIs('login') ? 'Connexion' : 'Inscription' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body {
            margin: 0; padding: 0;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4c1d95 100%);
            display: flex; align-items: center; justify-content: center;
        }
        .auth-wrap {
            width: 100%; max-width: 420px;
            padding: 20px;
        }
        /* Logo */
        .auth-logo {
            display: flex; align-items: center; justify-content: center;
            gap: 10px; margin-bottom: 28px; text-decoration: none;
        }
        .auth-logo-text {
            font-size: 24px; font-weight: 900; letter-spacing: -.5px;
            color: #fff;
        }
        /* Card */
        .auth-card {
            background: rgba(255,255,255,.97);
            border-radius: 18px;
            padding: 32px 32px 28px;
            box-shadow: 0 24px 60px rgba(0,0,0,.3), 0 0 0 1px rgba(255,255,255,.1);
        }
        .auth-card h2 {
            font-size: 22px; font-weight: 800; color: #111827;
            margin: 0 0 4px; text-align: center;
        }
        .auth-card .auth-sub {
            font-size: 13px; color: #9ca3af; text-align: center; margin: 0 0 24px;
        }
        /* Form fields */
        .field { margin-bottom: 16px; }
        .field label {
            display: block; font-size: 13px; font-weight: 600;
            color: #374151; margin-bottom: 6px;
        }
        .field input {
            display: block; width: 100%; padding: 10px 14px;
            font-size: 14px; color: #111827;
            border: 1.5px solid #e5e7eb; border-radius: 10px;
            background: #f9fafb; outline: none; font-family: inherit;
            transition: border-color .15s, box-shadow .15s, background .15s;
        }
        .field input:focus {
            border-color: #5046e5; background: #fff;
            box-shadow: 0 0 0 3px rgba(80,70,229,.15);
        }
        .field-error { font-size: 12px; color: #dc2626; margin-top: 5px; font-weight: 600; }
        /* Submit */
        .btn-submit {
            display: block; width: 100%;
            padding: 12px; font-size: 15px; font-weight: 700;
            color: #fff; border: none; border-radius: 10px; cursor: pointer;
            background: linear-gradient(135deg, #5046e5 0%, #7c3aed 100%);
            box-shadow: 0 4px 14px rgba(80,70,229,.4);
            transition: opacity .15s;
            font-family: inherit;
        }
        .btn-submit:hover { opacity: .88; }
        /* Divider */
        .auth-divider {
            display: flex; align-items: center; gap: 10px;
            margin: 20px 0; font-size: 12px; color: #d1d5db;
        }
        .auth-divider::before, .auth-divider::after {
            content: ''; flex: 1; height: 1px; background: #e5e7eb;
        }
        /* Footer link */
        .auth-footer {
            text-align: center; font-size: 13px; color: #6b7280; margin-top: 18px;
        }
        .auth-footer a {
            color: #5046e5; font-weight: 700; text-decoration: none;
        }
        .auth-footer a:hover { color: #4338ca; text-decoration: underline; }
        /* Checkbox */
        .check-row { display: flex; align-items: center; gap: 8px; margin-bottom: 16px; }
        .check-row input[type=checkbox] { width: 16px; height: 16px; accent-color: #5046e5; cursor: pointer; }
        .check-row label { font-size: 13px; color: #6b7280; cursor: pointer; }
        /* Forgot */
        .forgot-link { font-size: 12px; color: #5046e5; text-decoration: none; float: right; margin-top: -2px; }
        .forgot-link:hover { text-decoration: underline; }
        /* Session status */
        .alert-info {
            background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px;
            padding: 10px 14px; font-size: 13px; color: #1d4ed8; margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <div class="auth-wrap">
        <!-- Logo -->
        <a href="{{ route('questions.index') }}" class="auth-logo">
            <svg width="32" height="32" viewBox="0 0 30 30" fill="none">
                <path d="M15 3L3 10l12 7 12-7-12-7z" fill="rgba(255,255,255,.9)"/>
                <path d="M3 10v7" stroke="rgba(255,255,255,.7)" stroke-width="2" stroke-linecap="round"/>
                <circle cx="3" cy="19" r="1.5" fill="rgba(255,255,255,.6)"/>
                <path d="M7 13.5v5c0 2.5 3.8 4.5 8 4.5s8-2 8-4.5v-5"
                      fill="rgba(255,255,255,.2)" stroke="rgba(255,255,255,.7)"
                      stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            <span class="auth-logo-text">AskCampus</span>
        </a>

        <!-- Card -->
        <div class="auth-card">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
