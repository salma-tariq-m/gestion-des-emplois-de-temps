<x-app-layout>
    <div class="bg-slate-50 min-h-screen">
        {{-- Header Minimaliste --}}
        <div class="bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded bg-blue-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <h1 class="text-sm font-bold text-slate-800 leading-none">Pr. {{ Auth::user()->name }}</h1>
                        <p class="text-[11px] text-slate-500 mt-1 uppercase tracking-wider font-semibold">
                            {{ $formateur->specialite ?? 'Formateur' }} | ID: {{ $formateur->matricule ?? 'N/A' }}
                        </p>
                    </div>
                </div>
                
                <div class="flex items-center gap-2">
                    <a href="{{ route('profile.edit') }}" class="text-xs font-medium text-slate-600 hover:text-blue-600 px-3 py-1.5 rounded border border-slate-200 transition-all">
                        Paramètres
                    </a>
                    <a href="{{ $target_type === 'personnel' ? route('formateur.planning.export') : route('public.planning.export', ['groupe_id' => $groupe_id]) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-1.5 rounded shadow-sm flex items-center gap-2 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        PDF
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-6">
            
            {{-- Barre de filtres Ultra-Compacte --}}
            <div class="bg-[#1e293b] rounded-lg shadow-sm mb-6 p-3">
                <form action="{{ route('formateur.dashboard') }}" method="GET" class="flex flex-wrap md:flex-nowrap items-center gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            </span>
                            <select name="filiere_id" id="filiere_id" class="w-full bg-slate-800 border-none text-slate-200 text-xs rounded pl-9 focus:ring-1 focus:ring-blue-500">
                                <option value="">Toutes les filières</option>
                                @foreach($filieres as $f)
                                    <option value="{{ $f->id }}" {{ $filiere_id == $f->id ? 'selected' : '' }}>{{ $f->nomComplet }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex-1 min-w-[200px]">
                        <select name="groupe_id" id="groupe_id" class="w-full bg-slate-800 border-none text-slate-200 text-xs rounded focus:ring-1 focus:ring-blue-500 disabled:opacity-50" {{ !$filiere_id ? 'disabled' : '' }}>
                            <option value="">Sélectionner Groupe</option>
                            @foreach($groupes as $g)
                                <option value="{{ $g->id }}" {{ $groupe_id == $g->id ? 'selected' : '' }}>{{ $g->code }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold px-6 py-2 rounded transition-colors">
                            Filtrer
                        </button>
                        @if($groupe_id)
                            <a href="{{ route('formateur.dashboard') }}" class="text-slate-400 hover:text-white transition-colors" title="Réinitialiser">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Titre Planning --}}
            <div class="mb-4 flex items-center gap-2">
                <div class="w-1.5 h-4 bg-blue-600 rounded-full"></div>
                <h2 class="text-sm font-bold text-slate-700 uppercase tracking-tight">
                    @if($target_type === 'groupe')
                        Planning Groupe: <span class="text-blue-600">{{ $groupes->where('id', $groupe_id)->first()->code ?? '' }}</span>
                    @else
                        Mon emploi du temps personnel
                    @endif
                </h2>
            </div>

            {{-- Grille principale --}}
            <div class="bg-white border border-slate-200 rounded shadow-sm overflow-hidden">
                @include('components.planning-grid', [
                    'seances' => $seances, 
                    'simpleView' => true,
                    'targetType' => $target_type
                ])
            </div>
        </div>
    </div>

    <script>
        document.getElementById('filiere_id').addEventListener('change', function() {
            const filiereId = this.value;
            const groupeSelect = document.getElementById('groupe_id');
            if (filiereId) {
                groupeSelect.disabled = false;
                fetch(`/api/groupes/${filiereId}`)
                    .then(response => response.json())
                    .then(data => {
                        groupeSelect.innerHTML = '<option value="">Sélectionner Groupe</option>';
                        data.forEach(groupe => {
                            const option = document.createElement('option');
                            option.value = groupe.id;
                            option.textContent = groupe.code;
                            groupeSelect.appendChild(option);
                        });
                    });
            } else {
                groupeSelect.innerHTML = '<option value="">Sélectionner Groupe</option>';
                groupeSelect.disabled = true;
            }
        });
    </script>
</x-app-layout>