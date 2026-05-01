<x-app-layout>
    <div class="bg-slate-50 min-h-screen">
        {{-- Header Minimaliste --}}
        <div class="bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded bg-[#1e293b] flex items-center justify-center text-white font-bold text-sm shadow-sm">
                        AD
                    </div>
                    <div>
                        <h1 class="text-sm font-bold text-slate-800 leading-none">Administration Dashboard</h1>
                        <p class="text-[11px] text-slate-500 mt-1 uppercase tracking-wider font-semibold">
                            Session: {{ Auth::user()->name }}
                        </p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <a href="{{ route('planning.groupe') }}" class="text-xs font-bold text-blue-600 bg-blue-50 px-4 py-2 rounded border border-blue-100 hover:bg-blue-100 transition-all">
                        Planning Global
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-6">
            
            @php
                $kpis = [
                    ['label' => 'Groupes Actifs', 'value' => $stats['total_groupes'], 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['label' => 'Formateurs', 'value' => $stats['total_formateurs'], 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                    ['label' => 'Salles DIA', 'value' => $stats['total_salles'], 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                    ['label' => 'Séances Hebdo', 'value' => $stats['seances_semaine'], 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ];
            @endphp

            {{-- Grille des KPIs - Design Compact & Pro --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                @foreach($kpis as $kpi)
                    <div class="bg-white border border-slate-200 rounded p-4 flex items-center gap-4 hover:border-blue-300 transition-colors shadow-sm">
                        <div class="shrink-0 w-10 h-10 rounded bg-slate-50 flex items-center justify-center text-slate-600 border border-slate-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $kpi['icon'] }}"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-slate-500 uppercase tracking-tight">{{ $kpi['label'] }}</p>
                            <p class="text-xl font-black text-slate-800 leading-none mt-1">{{ $kpi['value'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Actions Rapides --}}
            <div class="mb-4 flex items-center gap-2">
                <div class="w-1.5 h-4 bg-[#1e293b] rounded-full"></div>
                <h2 class="text-sm font-bold text-slate-700 uppercase tracking-tight">Gestion Rapide</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                @php
                    $quickActions = [
                        ['route' => 'seances.create', 'label' => 'Programmer une séance', 'icon' => 'M12 4v16m8-8H4', 'color' => 'blue'],
                        ['route' => 'groupes.create', 'label' => 'Créer un groupe', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857', 'color' => 'slate'],
                        ['route' => 'formateurs.create', 'label' => 'Ajouter un formateur', 'icon' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3', 'color' => 'slate'],
                        ['route' => 'salles.create', 'label' => 'Nouvelle salle', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16', 'color' => 'slate'],
                    ];
                @endphp

                @foreach($quickActions as $action)
                    <a href="{{ route($action['route']) }}" class="group bg-white border border-slate-200 p-4 rounded hover:bg-[#1e293b] transition-all duration-200 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="p-2 rounded bg-slate-50 group-hover:bg-slate-700 transition-colors">
                                <svg class="w-5 h-5 text-slate-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $action['icon'] }}"/>
                                </svg>
                            </div>
                            <svg class="w-4 h-4 text-slate-300 group-hover:text-blue-400 opacity-0 group-hover:opacity-100 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                        <p class="mt-4 text-xs font-bold text-slate-700 group-hover:text-white transition-colors uppercase tracking-wide">
                            {{ $action['label'] }}
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>