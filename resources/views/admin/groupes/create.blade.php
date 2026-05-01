<x-app-layout>
    <x-slot name="header">Créer un Nouveau Groupe</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="card overflow-hidden">
            <div class="bg-slate-50/50 px-8 py-6 border-b border-slate-100 flex items-center gap-4">
                <div class="w-10 h-10 bg-primary-800 rounded-xl flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-black text-primary-900 uppercase tracking-widest">Informations du Groupe</h2>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-tighter mt-0.5">Veuillez remplir tous les champs obligatoires</p>
                </div>
            </div>

            <form action="{{ route('groupes.store') }}" method="POST" class="p-8 space-y-8">
                @csrf

                {{-- Code --}}
                <div class="space-y-2">
                    <label for="code" class="field-label">Code Identification <span class="text-accent-500">*</span></label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}"
                           class="field-input @error('code') border-red-300 ring-4 ring-red-50 @enderror" 
                           placeholder="ex: DEVOWFS-202" required>
                    <p class="field-hint">Le code doit être unique et facilement identifiable (ex: Filière-Année-Numéro).</p>
                    @error('code')<p class="text-xs text-red-600 font-bold mt-2 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> {{ $message }}</p>@enderror
                </div>

                {{-- Filière --}}
                <div class="space-y-2">
                    <label for="filiere_id" class="field-label">Filière d'Appartenance <span class="text-accent-500">*</span></label>
                    <select name="filiere_id" id="filiere_id" 
                            class="field-select @error('filiere_id') border-red-300 ring-4 ring-red-50 @enderror" required>
                        <option value="">— Sélectionnez une filière —</option>
                        @foreach($filieres as $f)
                            <option value="{{ $f->id }}" {{ old('filiere_id') == $f->id ? 'selected' : '' }}>{{ $f->nomComplet }}</option>
                        @endforeach
                    </select>
                    @error('filiere_id')<p class="text-xs text-red-600 font-bold mt-2">{{ $message }}</p>@enderror
                </div>

                {{-- Année --}}
                <div class="space-y-2">
                    <label for="annee" class="field-label">Niveau de Formation <span class="text-accent-500">*</span></label>
                    <select name="annee" id="annee" class="field-select" required>
                        <option value="1" {{ old('annee') == 1 ? 'selected' : '' }}>1ère Année (Fondamentaux)</option>
                        <option value="2" {{ old('annee') == 2 ? 'selected' : '' }}>2ème Année (Spécialisation)</option>
                    </select>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-4 pt-8 border-t border-slate-100">
                    <a href="{{ route('groupes.index') }}" class="btn-secondary">
                        Annuler l'Opération
                    </a>
                    <button type="submit" class="btn-primary" onclick="showLoader('Initialisation du groupe en cours…')">
                        Finaliser et Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

