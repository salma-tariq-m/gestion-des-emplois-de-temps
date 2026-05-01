<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' — ' : '' }}{{ config('app.name', 'Plannings DIA') }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased bg-slate-50 text-slate-900 selection:bg-blue-100 selection:text-blue-900">

<div class="min-h-full flex flex-col">

    {{-- Navbar --}}
    @include('layouts.navigation')

    <main class="flex-grow py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb --}}
            @isset($breadcrumb)
                <nav class="flex items-center text-sm mb-6" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-slate-500">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">Tableau de bord</a>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            {{ $breadcrumb }}
                        </li>
                    </ol>
                </nav>
            @endisset

            {{-- Page Header --}}
            @isset($header)
                <div class="mb-8 border-b border-slate-200 pb-6 md:flex md:items-center md:justify-between">
                    <div class="min-w-0 flex-1">
                        <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl tracking-tight">{{ $header }}</h1>
                        @isset($headerSubtitle)
                            <p class="mt-1 text-sm text-slate-500">{{ $headerSubtitle }}</p>
                        @endisset
                    </div>
                    @isset($headerActions)
                        <div class="mt-4 flex md:ml-4 md:mt-0 items-center gap-3">
                            {{ $headerActions }}
                        </div>
                    @endisset
                </div>
            @endisset

            {{-- Main Slot --}}
            <div class="pb-12">
                {{ $slot }}
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-slate-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-sm text-slate-500">
                    &copy; {{ date('Y') }} CMC Rabat
                </p>
            </div>
        </div>
    </footer>
</div>

{{-- Toast Notifications --}}
@if(session('success') || session('error') || session('warning'))
    <div x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, 5000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="fixed bottom-6 right-6 z-[200] max-w-sm w-full">
        <div class="bg-white rounded-lg shadow-xl border p-4 flex items-start gap-3
            @if(session('success')) border-emerald-100 @elseif(session('error')) border-red-100 @else border-amber-100 @endif">
            
            <div class="shrink-0 @if(session('success')) text-emerald-500 @elseif(session('error')) text-red-500 @else text-amber-500 @endif">
                @if(session('success'))
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                @elseif(session('error'))
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                @else
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @endif
            </div>

            <div class="flex-1">
                <p class="text-sm font-semibold text-slate-900">
                    {{ session('success') ?? session('error') ?? session('warning') }}
                </p>
            </div>

            <button @click="show = false" class="text-slate-400 hover:text-slate-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
@endif

{{-- Loader --}}
<div id="global-loader" class="hidden fixed inset-0 z-[300] bg-slate-900/10 backdrop-blur-[1px] flex items-center justify-center">
    <div class="bg-white px-6 py-4 rounded-md shadow-lg flex items-center gap-3 border border-slate-200">
        <svg class="animate-spin h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <p id="loader-message" class="text-sm font-medium text-slate-700">Traitement en cours...</p>
    </div>
</div>

<script>
    window.showLoader = (msg) => {
        if (msg) document.getElementById('loader-message').textContent = msg;
        document.getElementById('global-loader').classList.remove('hidden');
    };
    window.hideLoader = () => document.getElementById('global-loader').classList.add('hidden');
</script>
</body>
</html>

