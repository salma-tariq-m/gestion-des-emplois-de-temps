<x-app-layout>
    <x-slot name="header">Planning par groupe</x-slot>

    {{-- Sélecteur + navigation semaine --}}
    <div class="flex flex-col sm:flex-row gap-3 mb-6">
        <form method="GET" class="flex items-center gap-3 flex-1">
            <select name="groupe_id" class="field-select max-w-xs" onchange="this.form.submit()">
                <option value="">— Choisir un groupe —</option>
                @foreach($groupes as $g)
                    <option value="{{ $g->id }}" {{ $groupe_id == $g->id ? 'selected' : '' }}>{{ $g->code }}</option>
                @endforeach
            </select>
        </form>

        @if($groupe_id)
            <a href="{{ route('planning.export', ['type' => 'groupe', 'id' => $groupe_id]) }}"
               onclick="showLoader('Génération du PDF en cours…'); setTimeout(() => hideLoader(), 3000);"
               class="btn-secondary text-sm">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Exporter PDF
            </a>
        @endif
    </div>

    @if($groupe_id)
        @include('components.planning-grid', ['seances' => $seances, 'simpleView' => true, 'targetType' => 'groupe'])
    @else
        <div class="flex flex-col items-center justify-center py-20 bg-white rounded-xl border border-dashed border-slate-200 text-slate-400">
            <svg class="w-10 h-10 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <p class="text-sm font-medium">Sélectionnez un groupe pour afficher son planning.</p>
        </div>
    @endif
</x-app-layout>
