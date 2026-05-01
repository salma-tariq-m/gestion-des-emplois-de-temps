@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-2 py-4"> {{-- Taille 5xl bach yji m'groupé f-l-wast --}}
    
    {{-- Header sghir o professionnel --}}
    <div class="flex justify-between items-end mb-4 border-b border-slate-900 pb-2">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 border border-slate-300 flex items-center justify-center text-[8px] text-center font-bold text-slate-400 leading-tight">
                LOGO<br>CMC
            </div>
            <div>
                <h1 class="text-sm font-black text-slate-900 uppercase leading-none">مدن المهن والكفاءات</h1>
                <p class="text-[9px] font-bold text-slate-500 uppercase">Cité des Métiers et des Compétences</p>
                <div class="mt-1 inline-block bg-slate-900 text-white px-2 py-0.5 text-[10px] font-bold">
                    Groupe: {{ $groupe->code ?? 'DEV101' }}
                </div>
            </div>
        </div>

        <div class="text-right leading-tight">
            <p class="text-[9px] font-bold text-slate-800 uppercase">OFPPT - La Voie de l'Avenir</p>
            <p class="text-[8px] font-bold text-slate-400 uppercase mt-0.5 tracking-tighter">Année de Formation: 2025 / 2026</p>
        </div>
    </div>

    {{-- Tableau Compact (Horizontal comme le PDF) --}}
    <div class="bg-white border border-slate-900 overflow-hidden shadow-sm">
        <table class="w-full border-collapse table-fixed"> {{-- Table-fixed bach ybqaw les colonnes mqadin --}}
            <thead>
                <tr class="bg-slate-100 border-b border-slate-900">
                    <th class="w-20 px-1 py-2 text-center border-r border-slate-900 text-[9px] font-black uppercase text-slate-700">
                        Jour / Horaire
                    </th>
                    @php
                        $horaires = [
                            '1' => '08:30 | 11:00',
                            '2' => '11:00 | 13:30',
                            '3' => '13:30 | 16:00',
                            '4' => '16:00 | 18:30'
                        ];
                    @endphp
                    @foreach($horaires as $num => $time)
                    <th class="px-1 py-1 text-center border-r border-slate-300 last:border-r-0">
                        <span class="text-[8px] text-slate-400 block font-bold uppercase leading-none">Séance {{ $num }}</span>
                        <span class="text-[10px] font-black text-slate-800 tracking-tighter">{{ $time }}</span>
                    </th>
                    @endforeach
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-300">
                @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $jour)
                <tr class="h-14"> {{-- Hauteur sghira bach t’éviter scroll --}}
                    <td class="bg-slate-50 border-r border-slate-900 px-1 py-1 text-center">
                        <span class="text-[10px] font-black text-slate-800 uppercase">{{ $jour }}</span>
                        @if(isset($dateDebutSemaine))
                            <span class="block text-[8px] font-bold text-blue-600">
                                {{ $dateDebutSemaine->copy()->addDays(array_search($jour, ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']))->format('d/m') }}
                            </span>
                        @endif
                    </td>

                    @foreach([1, 2, 3, 4] as $creneau)
                    <td class="p-1 border-r border-slate-200 last:border-r-0 relative group">
                        @if(isset($planningData[$jour][$creneau]))
                            @php $seance = $planningData[$jour][$creneau]; @endphp
                            <div class="h-full w-full bg-blue-50/50 border-l-2 border-blue-600 p-1 flex flex-col justify-center leading-tight">
                                <div class="text-[9px] font-black text-blue-900 uppercase truncate">
                                    {{ $seance->titre }}
                                </div>
                                <div class="mt-0.5 flex flex-wrap gap-x-2">
                                    <span class="text-[8px] font-bold text-slate-600 whitespace-nowrap">
                                        <span class="text-slate-400">F:</span> {{ $seance->formateur->user->name ?? $seance->formateur->nomComplet }}
                                    </span>
                                    <span class="text-[8px] font-extrabold text-blue-700 bg-blue-100 px-1 rounded uppercase whitespace-nowrap">
                                        S: {{ $seance->salle->code ?? 'SM03' }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center justify-center opacity-5">
                                <span class="text-[7px] font-bold uppercase tracking-widest text-slate-300">Libre</span>
                            </div>
                        @endif
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Footer sghir --}}
    <div class="mt-4 flex justify-between items-center text-[9px] font-bold text-slate-400 uppercase tracking-widest">
        <span>© CMC - Système de Gestion v2.1</span>
        <div class="flex gap-2">
            <button class="bg-slate-800 text-white px-3 py-1 rounded text-[8px] hover:bg-slate-700 transition">Imprimer PDF</button>
        </div>
    </div>
</div>

<style>
    body { background-color: #f1f5f9; }
    /* Force compact view */
    td, th { overflow: hidden; text-overflow: ellipsis; }
</style>
@endsection