<x-app-layout>
    <x-slot name="header">Modifier le groupe</x-slot>
    <x-slot name="breadcrumb">
        <span class="breadcrumb-sep">/</span>
        <a href="{{ route('groupes.index') }}" class="breadcrumb-item">Groupes</a>
        <span class="breadcrumb-sep">/</span>
        <span class="text-sm text-slate-700 font-medium">{{ $groupe->code }}</span>
    </x-slot>

    <div class="max-w-2xl">
        <div class="card">
            <div class="card-header">
                <h2 class="text-sm font-semibold text-slate-700">Mise à jour de la configuration</h2>
            </div>
            <form action="{{ route('groupes.update', $groupe) }}" method="POST" class="p-6 space-y-5">
                @csrf @method('PUT')

                <div>
                    <label for="code" class="field-label">Code du groupe <span class="text-red-500">*</span></label>
                    <input type="text" name="code" id="code" value="{{ old('code', $groupe->code) }}"
                           class="field-input" required>
                    @error('code')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="filiere_id" class="field-label">Filière <span class="text-red-500">*</span></label>
                        <select name="filiere_id" id="filiere_id" class="field-select" required>
                            <option value="">— Choisissez —</option>
                            @foreach($filieres as $f)
                                <option value="{{ $f->id }}" {{ old('filiere_id', $groupe->filiere_id) == $f->id ? 'selected' : '' }}>{{ $f->nomComplet }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="annee" class="field-label">Année de formation <span class="text-red-500">*</span></label>
                        <select name="annee" id="annee" class="field-select" required>
                            <option value="1" {{ old('annee', $groupe->annee) == 1 ? 'selected' : '' }}>1ère Année</option>
                            <option value="2" {{ old('annee', $groupe->annee) == 2 ? 'selected' : '' }}>2ème Année</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                    <a href="{{ route('groupes.index') }}" class="btn-secondary">Annuler</a>
                    <button type="submit" class="btn-primary">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
