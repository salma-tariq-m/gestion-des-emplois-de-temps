<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Plannings DIA') }} — Connexion</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">
    <x-institutional-topbar />

    <div class="min-h-screen flex flex-col items-center justify-center p-6">

        {{-- Main Container --}}
        <div class="w-full max-w-md">
            <div class="bg-white rounded-lg shadow-premium border border-slate-200 p-8">
                {{ $slot }}
            </div>

            {{-- Simple Footer --}}
            <p class="mt-8 text-center text-xs text-slate-400 font-medium tracking-wide uppercase">
                &copy; {{ date('Y') }} OFPPT &bull; Pôle Digital & IA
            </p>
        </div>
    </div>
</body>
</html>
