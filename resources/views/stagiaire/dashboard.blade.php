<x-app-layout>
    <x-slot name="header">Mon Emploi du Temps</x-slot>

    {{-- Bannière stagiaire --}}
    <div class="card mb-6 overflow-hidden">
        <div class="h-1 bg-gradient-to-r from-[#0F172A] to-emerald-500"></div>
        <div class="p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-bold text-lg uppercase shadow-md shrink-0">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-lg font-bold text-slate-900">{{ Auth::user()->name }}</h2>
                @if($stagiaire && $stagiaire->groupe)
                <div class="flex flex-wrap gap-x-4 gap-y-1 mt-1">
                    <span class="text-xs text-slate-500">
                        Groupe : <strong class="text-slate-700">{{ $stagiaire->groupe->code }}</strong>
                    </span>
                    <span class="text-xs text-slate-500">
                        Filière : <strong class="text-slate-700">
                            {{ $stagiaire->groupe->filiere->nomComplet ?? '—' }}
                        </strong>
                    </span>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Grille EDT --}}
    @if($seances->isNotEmpty())
        @include('components.planning-grid', [
            'seances'     => $seances,
            'simpleView'  => true,
            'targetType'  => 'groupe'
        ])
    @else
        <div class="card p-16 text-center">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-900">Aucune séance planifiée</h3>
            <p class="text-slate-500 mt-1">Aucun cours n'a été trouvé pour votre groupe.</p>
        </div>
    @endif

</x-app-layout>