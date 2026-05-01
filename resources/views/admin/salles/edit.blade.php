<x-app-layout>
    <x-slot name="header">Modifier la salle</x-slot>
    <x-slot name="breadcrumb">
        <span class="breadcrumb-sep">/</span>
        <a href="{{ route('salles.index') }}" class="breadcrumb-item">Salles</a>
        <span class="breadcrumb-sep">/</span>
        <span class="text-sm text-slate-700 font-medium">{{ $salle->code }}</span>
    </x-slot>

    <div class="max-w-xl">
        <div class="card">
            <div class="card-header">
                <h2 class="text-sm font-semibold text-slate-700">Mise à jour des informations</h2>
            </div>
            <form action="{{ route('salles.update', $salle) }}" method="POST" class="p-6 space-y-5">
                @csrf @method('PUT')

                <div>
                    <label for="code" class="field-label">Code de la salle <span class="text-red-500">*</span></label>
                    <input type="text" name="code" id="code" value="{{ old('code', $salle->code) }}"
                           class="field-input" required>
                    @error('code')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label for="capacite" class="field-label">Capacité (places)</label>
                        <input type="number" name="capacite" id="capacite" value="{{ old('capacite', $salle->capacite) }}"
                               class="field-input" min="1">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                    <a href="{{ route('salles.index') }}" class="btn-secondary">Annuler</a>
                    <button type="submit" class="btn-primary">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
