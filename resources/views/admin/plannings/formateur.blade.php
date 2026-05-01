<x-app-layout>
    <x-slot name="header">Planning par formateur</x-slot>

    <div class="flex flex-col sm:flex-row gap-3 mb-6">
        <form method="GET" class="flex items-center gap-3 flex-1">
            <select name="formateur_id" class="field-select max-w-xs" onchange="this.form.submit()">
                <option value="">— Choisir un formateur —</option>
                @foreach($formateurs as $f)
                    <option value="{{ $f->id }}" {{ $formateur_id == $f->id ? 'selected' : '' }}>{{ $f->nomComplet }}</option>
                @endforeach
            </select>
        </form>

        @if($formateur_id)
            <a href="{{ route('planning.export', ['type' => 'formateur', 'id' => $formateur_id]) }}"
               onclick="showLoader('Génération du PDF en cours…'); setTimeout(() => hideLoader(), 3000);"
               class="btn-secondary text-sm">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Exporter PDF
            </a>
        @endif
    </div>

    @if($formateur_id)
        @include('components.planning-grid', ['seances' => $seances, 'simpleView' => true, 'targetType' => 'formateur'])
    @else
        <div class="flex flex-col items-center justify-center py-20 bg-white rounded-xl border border-dashed border-slate-200 text-slate-400">
            <svg class="w-10 h-10 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <p class="text-sm font-medium">Sélectionnez un formateur pour afficher son planning.</p>
        </div>
    @endif
</x-app-layout>
