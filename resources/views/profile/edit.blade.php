<x-app-layout>
    <x-slot name="header">Mon Profil Utilisateur</x-slot>
    <x-slot name="headerSubtitle">Gérez vos informations personnelles et la sécurité de votre compte</x-slot>

    <div class="max-w-3xl mx-auto space-y-10">

        {{-- Header Profil --}}
        <div class="card p-8 flex flex-col sm:flex-row items-center gap-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary-50 rounded-full -mr-16 -mt-16"></div>
            <div class="w-24 h-24 rounded-3xl bg-primary-900 flex items-center justify-center text-white text-3xl font-black shadow-premium group">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="text-center sm:text-left space-y-1">
                <h2 class="text-2xl font-black text-primary-900 tracking-tight">{{ Auth::user()->name }}</h2>
                <p class="text-sm text-slate-500 font-medium">{{ Auth::user()->email }}</p>
                <div class="flex gap-2 mt-3">
                    <span class="px-3 py-1 bg-accent-50 text-accent-600 text-[10px] font-black uppercase tracking-widest rounded-full border border-accent-100">
                        {{ Auth::user()->role ?? 'Utilisateur' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Informations personnelles --}}
        <div class="card">
            <div class="card-header flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h2 class="text-sm font-black text-primary-900 uppercase tracking-widest">Informations du Compte</h2>
            </div>
            <div class="p-8">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Mot de passe --}}
        <div class="card">
            <div class="card-header flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h2 class="text-sm font-black text-primary-900 uppercase tracking-widest">Sécurité & Accès</h2>
            </div>
            <div class="p-8">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Zone dangereuse --}}
        <div class="card border-red-100/50">
            <div class="card-header flex items-center gap-3 bg-red-50/30">
                <div class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center border border-red-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <h2 class="text-sm font-black text-red-900 uppercase tracking-widest">Zone de Danger</h2>
            </div>
            <div class="p-8">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>

