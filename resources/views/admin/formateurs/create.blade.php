<x-app-layout>
    <x-slot name="header">Nouveau formateur</x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="panel">
            <div class="panel-header">
                <h2 class="section-title">Informations du formateur</h2>
            </div>

            <form action="{{ route('formateurs.store') }}" method="POST" class="panel-body space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="matricule" class="field-label">Matricule institutionnel <span class="text-red-500">*</span></label>
                        <input type="text" name="matricule" id="matricule" value="{{ old('matricule') }}"
                               class="field-input" placeholder="ex: F-10928" required>
                        @error('matricule')<p class="text-xs text-red-600 mt-2">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="specialite" class="field-label">Domaine d'expertise <span class="text-red-500">*</span></label>
                        <input type="text" name="specialite" id="specialite" value="{{ old('specialite') }}"
                               class="field-input" placeholder="ex: Intelligence Artificielle & Data" required>
                        @error('specialite')<p class="text-xs text-red-600 mt-2">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-slate-200">
                    <div>
                        <label for="prenom" class="field-label">Prénom <span class="text-red-500">*</span></label>
                        <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}"
                               class="field-input" placeholder="Prénom du formateur" required>
                        @error('prenom')<p class="text-xs text-red-600 mt-2">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="nom" class="field-label">Nom de famille <span class="text-red-500">*</span></label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom') }}"
                               class="field-input" placeholder="Nom du formateur" required>
                        @error('nom')<p class="text-xs text-red-600 mt-2">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-slate-200">
                    <div>
                        <label for="email" class="field-label">Adresse email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               class="field-input" placeholder="nom.prenom@institution.ma" required>
                        @error('email')<p class="text-xs text-red-600 mt-2">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="telephone" class="field-label">Numéro de téléphone</label>
                        <input type="text" name="telephone" id="telephone" value="{{ old('telephone') }}"
                               class="field-input" placeholder="06 XX XX XX XX">
                        @error('telephone')<p class="text-xs text-red-600 mt-2">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-200">
                    <a href="{{ route('formateurs.index') }}" class="btn-secondary">
                        Annuler
                    </a>
                    <button type="submit" class="btn-primary" onclick="showLoader('Création du compte en cours…')">
                        Enregistrer le formateur
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

