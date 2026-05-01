<x-app-layout>
    <x-slot name="header">Ajouter une Nouvelle Salle</x-slot>
  

    <div class="max-w-xl mx-auto">
        <div class="card overflow-hidden">
            <div class="bg-slate-50/50 px-8 py-6 border-b border-slate-100 flex items-center gap-4">
                <div class="w-10 h-10 bg-primary-800 rounded-xl flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-black text-primary-900 uppercase tracking-widest">Espace de Formation</h2>
                </div>
            </div>

            <form action="{{ route('salles.store') }}" method="POST" class="p-8 space-y-8">
                @csrf

                <div class="space-y-6">
                    {{-- Code --}}
                    <div class="space-y-2">
                        <label for="code" class="field-label">Identifiant / Code Salle <span class="text-accent-500">*</span></label>
                        <input type="text" name="code" id="code" value="{{ old('code') }}"
                               class="field-input" placeholder="ex: Salle 104, Labo Digital" required>
                        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-tight mt-2">Nom unique affiché sur les emplois du temps</p>
                        @error('code')<p class="text-xs text-red-600 font-bold mt-2">{{ $message }}</p>@enderror
                    </div>

                    {{-- Capacité --}}
                    <div class="space-y-2">
                        <label for="capacite" class="field-label">Capacité d'Accueil (Stagiaires)</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-accent-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <input type="number" name="capacite" id="capacite" value="{{ old('capacite') }}"
                                   class="field-input pl-11" placeholder="Nombre de places" min="1">
                        </div>
                        @error('capacite')<p class="text-xs text-red-600 font-bold mt-2">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-4 pt-8 border-t border-slate-100">
                    <a href="{{ route('salles.index') }}" class="btn-secondary">
                        Annuler
                    </a>
                    <button type="submit" class="btn-primary" onclick="showLoader('Enregistrement de l\'espace…')">
                        Confirmer la Création
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

