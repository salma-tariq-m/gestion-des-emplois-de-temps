<x-app-layout>
    <x-slot name="header">Planning par salle</x-slot>

    <div class="flex flex-col sm:flex-row gap-3 mb-6">
        <form method="GET" class="flex items-center gap-3 flex-1">
            <select name="salle_id" class="field-select max-w-xs" onchange="this.form.submit()">
                <option value="">— Choisir une salle —</option>
                @foreach($salles as $s)
                    <option value="{{ $s->id }}" {{ $salle_id == $s->id ? 'selected' : '' }}>{{ $s->code }}</option>
                @endforeach
            </select>
        </form>

        @if($salle_id)
            <a href="{{ route('planning.export', ['type' => 'salle', 'id' => $salle_id]) }}"
               onclick="showLoader('Génération du PDF en cours…'); setTimeout(() => hideLoader(), 3000);"
               class="btn-secondary text-sm">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Exporter PDF
            </a>
        @endif
    </div>

    @if($salle_id)
        @include('components.planning-grid', ['seances' => $seances, 'simpleView' => true, 'targetType' => 'salle'])
    @else
        <div class="flex flex-col items-center justify-center py-20 bg-white rounded-xl border border-dashed border-slate-200 text-slate-400">
            <svg class="w-10 h-10 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            <p class="text-sm font-medium">Sélectionnez une salle pour afficher son planning.</p>
        </div>
    @endif
</x-app-layout>
