<x-app-layout>
    <x-slot name="header">Modifier la séance</x-slot>
    <x-slot name="breadcrumb">
        <span class="breadcrumb-sep">/</span>
        <a href="{{ route('seances.index') }}" class="breadcrumb-item">Séances</a>
        <span class="breadcrumb-sep">/</span>
        <span class="text-sm text-slate-700 font-medium">Modification</span>
    </x-slot>

    <div class="max-w-2xl">
        <div class="card">
            <div class="card-header">
                <h2 class="text-sm font-semibold text-slate-700">Ajustement du créneau</h2>
            </div>
            <form action="{{ route('seances.update', $seance) }}" method="POST" class="p-6 space-y-5">
                @csrf @method('PUT')

                @if($errors->any())
                    <div class="flex items-start gap-3 p-4 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                        <svg class="w-4 h-4 mt-0.5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <p class="font-semibold mb-1">Conflit de planification détecté</p>
                            <ul class="list-disc list-inside space-y-0.5">
                                @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="groupe_id" class="field-label">Groupe stagiaire <span class="text-red-500">*</span></label>
                        <select name="groupe_id" id="groupe_id" class="field-select" required>
                            @foreach($groupes as $g)
                                <option value="{{ $g->id }}" {{ old('groupe_id', $seance->groupe_id) == $g->id ? 'selected' : '' }}>{{ $g->code }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="formateur_id" class="field-label">Formateur intervenant <span class="text-red-500">*</span></label>
                        <select name="formateur_id" id="formateur_id" class="field-select" required>
                            @foreach($formateurs as $f)
                                <option value="{{ $f->id }}" {{ old('formateur_id', $seance->formateur_id) == $f->id ? 'selected' : '' }}>{{ $f->nomComplet }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="salle_id" class="field-label">Salle de formation <span class="text-red-500">*</span></label>
                        <select name="salle_id" id="salle_id" class="field-select" required>
                            @foreach($salles as $s)
                                <option value="{{ $s->id }}" {{ old('salle_id', $seance->salle_id) == $s->id ? 'selected' : '' }}>{{ $s->code }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="date" class="field-label">Date de la séance <span class="text-red-500">*</span></label>
                        <input type="date" name="date" id="date"
                               value="{{ old('date', $seance->date ? \Carbon\Carbon::parse($seance->date)->format('Y-m-d') : '') }}"
                               class="field-input" required>
                    </div>
                </div>

                <div>
                    <label for="creneau" class="field-label">Créneau horaire <span class="text-red-500">*</span></label>
                    <select name="creneau" id="creneau" class="field-select" required>
                        <option value="1" {{ old('creneau', $seance->creneau) == 1 ? 'selected' : '' }}>Séance 1 — 08h30 à 11h00</option>
                        <option value="2" {{ old('creneau', $seance->creneau) == 2 ? 'selected' : '' }}>Séance 2 — 11h00 à 13h30</option>
                        <option value="3" {{ old('creneau', $seance->creneau) == 3 ? 'selected' : '' }}>Séance 3 — 13h30 à 16h00</option>
                        <option value="4" {{ old('creneau', $seance->creneau) == 4 ? 'selected' : '' }}>Séance 4 — 16h00 à 18h30</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                    <a href="{{ route('seances.index') }}" class="btn-secondary">Annuler</a>
                    <button type="submit" class="btn-primary">Mettre à jour la séance</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
