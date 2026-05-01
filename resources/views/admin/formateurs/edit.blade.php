<x-app-layout>
    <x-slot name="header">Modifier le formateur</x-slot>
    <x-slot name="breadcrumb">
        <span class="breadcrumb-sep">/</span>
        <a href="{{ route('formateurs.index') }}" class="breadcrumb-item">Formateurs</a>
        <span class="breadcrumb-sep">/</span>
        <span class="text-sm text-slate-700 font-medium">{{ $formateur->nomComplet }}</span>
    </x-slot>

    <div class="max-w-2xl">
        <div class="card">
            <div class="card-header">
                <h2 class="text-sm font-semibold text-slate-700">Mise à jour du dossier</h2>
            </div>
            <form action="{{ route('formateurs.update', $formateur) }}" method="POST" class="p-6 space-y-5">
                @csrf @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="matricule" class="field-label">Matricule <span class="text-red-500">*</span></label>
                        <input type="text" name="matricule" id="matricule" value="{{ old('matricule', $formateur->matricule) }}"
                               class="field-input" required>
                        @error('matricule')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="specialite" class="field-label">Spécialité <span class="text-red-500">*</span></label>
                        <input type="text" name="specialite" id="specialite" value="{{ old('specialite', $formateur->specialite) }}"
                               class="field-input" required>
                        @error('specialite')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="prenom" class="field-label">Prénom <span class="text-red-500">*</span></label>
                        <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $formateur->prenom) }}"
                               class="field-input" required>
                    </div>
                    <div>
                        <label for="nom" class="field-label">Nom <span class="text-red-500">*</span></label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom', $formateur->nom) }}"
                               class="field-input" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="email" class="field-label">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $formateur->email) }}"
                               class="field-input" required>
                        @error('email')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="telephone" class="field-label">Téléphone</label>
                        <input type="text" name="telephone" id="telephone" value="{{ old('telephone', $formateur->telephone) }}"
                               class="field-input">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                    <a href="{{ route('formateurs.index') }}" class="btn-secondary">Annuler</a>
                    <button type="submit" class="btn-primary">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
