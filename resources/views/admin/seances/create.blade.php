<x-app-layout>
    <x-slot name="header">Planifier une Nouvelle Séance</x-slot>
    
    

    <div class="max-w-2xl mx-auto">
        <div class="card overflow-hidden">
            <div class="bg-slate-50/50 px-8 py-6 border-b border-slate-100 flex items-center gap-4">
                <div class="w-10 h-10 bg-primary-800 rounded-xl flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-black text-primary-900 uppercase tracking-widest">Configuration du Créneau</h2>
                </div>
            </div>

            <form action="{{ route('seances.store') }}" method="POST" class="p-8 space-y-8">
                @csrf

                @if($errors->any())
                    <div class="flex items-start gap-4 p-6 bg-red-50 border border-red-100 rounded-2xl animate-shake">
                        <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div class="space-y-1">
                            <p class="text-sm font-black text-red-900 uppercase tracking-widest">Erreur de Conflit</p>
                            <ul class="text-xs text-red-700 font-medium list-disc list-inside space-y-1 opacity-80">
                                @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- Groupe --}}
                <div class="space-y-2">
                    <label for="groupe_id" class="field-label">Groupe de Formation <span class="text-accent-500">*</span></label>
                    <select name="groupe_id" id="groupe_id" 
                            class="field-select @error('groupe_id') border-red-300 ring-4 ring-red-50 @enderror" required>
                        <option value="">— Sélectionnez un groupe —</option>
                        @foreach($groupes as $g)
                            <option value="{{ $g->id }}" {{ old('groupe_id') == $g->id ? 'selected' : '' }}>{{ $g->code }}</option>
                        @endforeach
                    </select>
                    @error('groupe_id')<p class="text-xs text-red-600 font-bold mt-2">{{ $message }}</p>@enderror
                </div>

                {{-- Formateur --}}
                <div class="space-y-2">
                    <label for="formateur_id" class="field-label">Formateur Responsable <span class="text-accent-500">*</span></label>
                    <select name="formateur_id" id="formateur_id" 
                            class="field-select @error('formateur_id') border-red-300 ring-4 ring-red-50 @enderror" required>
                        <option value="">— Sélectionnez un formateur —</option>
                        @foreach($formateurs as $f)
                            <option value="{{ $f->id }}" {{ old('formateur_id') == $f->id ? 'selected' : '' }}>{{ $f->nomComplet }}</option>
                        @endforeach
                    </select>
                    @error('formateur_id')<p class="text-xs text-red-600 font-bold mt-2">{{ $message }}</p>@enderror
                </div>

                {{-- Salle --}}
                <div class="space-y-2">
                    <label for="salle_id" class="field-label">Lieu d'Enseignement (Salle) <span class="text-accent-500">*</span></label>
                    <select name="salle_id" id="salle_id" 
                            class="field-select @error('salle_id') border-red-300 ring-4 ring-red-50 @enderror" required>
                        <option value="">— Sélectionnez une salle —</option>
                        @foreach($salles as $s)
                            <option value="{{ $s->id }}" {{ old('salle_id') == $s->id ? 'selected' : '' }}>{{ $s->code }}</option>
                        @endforeach
                    </select>
                    @error('salle_id')<p class="text-xs text-red-600 font-bold mt-2">{{ $message }}</p>@enderror
                </div>

                {{-- Date --}}
                <div class="space-y-2">
                    <label for="date" class="field-label">Date de Tenue <span class="text-accent-500">*</span></label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400 group-focus-within:text-accent-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}"
                               class="field-input pl-11" required>
                    </div>
                    @error('date')<p class="text-xs text-red-600 font-bold mt-2">{{ $message }}</p>@enderror
                </div>

                {{-- Créneau --}}
                <div class="space-y-2">
                    <label for="creneau" class="field-label">Bloc Horaire <span class="text-accent-500">*</span></label>
                    <select name="creneau" id="creneau" class="field-select" required>
                        <option value="">— Sélectionnez un créneau —</option>
                        <option value="1" {{ old('creneau') == 1 ? 'selected' : '' }}>S1 • 08:30 – 11:00</option>
                        <option value="2" {{ old('creneau') == 2 ? 'selected' : '' }}>S2 • 11:00 – 13:30</option>
                        <option value="3" {{ old('creneau') == 3 ? 'selected' : '' }}>S3 • 13:30 – 16:00</option>
                        <option value="4" {{ old('creneau') == 4 ? 'selected' : '' }}>S4 • 16:00 – 18:30</option>
                    </select>
                    @error('creneau')<p class="text-xs text-red-600 font-bold mt-2">{{ $message }}</p>@enderror
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-4 pt-8 border-t border-slate-100">
                    <a href="{{ route('seances.index') }}" class="btn-secondary">
                        Annuler
                    </a>
                    <button type="submit" class="btn-primary" onclick="showLoader('Vérification des conflits et inscription…')">
                        Confirmer l'Inscription
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

