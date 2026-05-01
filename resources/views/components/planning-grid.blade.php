@php
    $start = isset($dateDebutSemaine) ? \Carbon\Carbon::parse($dateDebutSemaine) : \Carbon\Carbon::now()->startOfWeek();
    $joursNoms = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
    $joursDates = [];
    for ($i = 0; $i < 6; $i++) {
        $joursDates[$joursNoms[$i]] = $start->copy()->addDays($i);
    }
    $creneaux = [
        1 => ['label' => 'S1', 'horaire' => '08:30 – 11:00'],
        2 => ['label' => 'S2', 'horaire' => '11:00 – 13:30'],
        3 => ['label' => 'S3', 'horaire' => '13:30 – 16:00'],
        4 => ['label' => 'S4', 'horaire' => '16:00 – 18:30'],
    ];
@endphp

<div class="table-wrapper">
    <table class="w-full border-collapse" style="min-width: 980px;">
        <thead>
            <tr class="border-b border-slate-200">
                <th class="w-40 px-6 py-5 bg-blue-50/60 border-r border-slate-200 text-left">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Jour / Horaire</span>
                </th>
                @foreach($creneaux as $info)
                    <th class="px-4 py-5 text-center bg-blue-50/60 border-r border-slate-200 last:border-r-0">
                        @if(isset($simpleView) && $simpleView)
                            @php
                                $times = explode(' – ', $info['horaire']);
                            @endphp
                            <div class="flex justify-between text-[10px] font-bold text-slate-500">
                                <span>{{ $times[0] }}</span>
                                <span>{{ $times[1] }}</span>
                            </div>
                        @else
                            <p class="text-xs font-black text-slate-700 tracking-tight">{{ $info['label'] }}</p>
                            <p class="text-[11px] text-slate-500 font-bold mt-1">{{ $info['horaire'] }}</p>
                        @endif
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($joursNoms as $j)
                <tr class="border-b border-slate-100 last:border-b-0">
                    @php
                        $skipCols = 0;
                        $currentDate = isset($joursDates[$j]) ? $joursDates[$j]->format('Y-m-d') : null;
                    @endphp

                    <td class="px-6 py-5 bg-slate-50/40 border-r border-slate-200">
                        <p class="text-sm font-extrabold text-slate-800 uppercase tracking-wider">{{ $j }}</p>
                        @if(!isset($simpleView) || !$simpleView)
                            <p class="text-[11px] text-slate-500 font-bold mt-1">{{ $joursDates[$j]->format('d/m/Y') }}</p>
                        @endif
                    </td>

                    @foreach($creneaux as $c => $info)
                        @php
                            if ($skipCols > 0) { $skipCols--; continue; }

                            // Recherche de la séance pour ce jour et ce créneau
                            $seance = $seances->filter(function($s) use ($currentDate, $j, $c, $simpleView) {
                                if (isset($simpleView) && $simpleView) {
                                    return trim(strtolower($s->jour)) === trim(strtolower($j)) && (int)$s->creneau === (int)$c;
                                }
                                $sDate = ($s->date instanceof \Carbon\Carbon) ? $s->date->format('Y-m-d') : $s->date;
                                return $sDate === $currentDate && (int)$s->creneau === (int)$c;
                            })->first();
                            
                            $colspan = 1;

                            if ($seance) {
                                for ($nc = $c + 1; $nc <= 4; $nc++) {
                                    $ns = $seances->filter(function($s) use ($currentDate, $j, $nc, $seance, $simpleView) {
                                        if (isset($simpleView) && $simpleView) {
                                            return trim(strtolower($s->jour)) === trim(strtolower($j)) && (int)$s->creneau === (int)$nc;
                                        }
                                        $sDate = ($s->date instanceof \Carbon\Carbon) ? $s->date->format('Y-m-d') : $s->date;
                                        return $sDate === $currentDate && (int)$s->creneau === (int)$nc;
                                    })->first();

                                    if ($ns && $ns->groupe_id === $seance->groupe_id
                                             && $ns->formateur_id === $seance->formateur_id
                                             && $ns->salle_id === $seance->salle_id) {
                                        $colspan++;
                                    } else { break; }
                                }
                                if ($colspan > 1) $skipCols = $colspan - 1;
                            }
                        @endphp

                    <td @if($colspan > 1) colspan="{{ $colspan }}" @endif
                        class="p-1 border-r border-slate-100 last:border-r-0 align-middle transition-colors duration-200 hover:bg-slate-50/50"
                        style="height: 100px;">
                        @if($seance)
                            @if(isset($simpleView) && $simpleView)
                                <div class="flex flex-col items-center justify-center h-full bg-blue-600 rounded-md shadow-sm p-2 text-white text-center">
                                    <div class="text-xs font-black uppercase tracking-wider mb-1">
                                        @if(isset($targetType) && $targetType === 'groupe')
                                            {{ $seance->formateur->nomComplet ?? 'N/A' }}
                                        @else
                                            {{ $seance->groupe->code ?? 'N/A' }}
                                        @endif
                                    </div>
                                    <div class="text-[10px] font-bold opacity-90 uppercase">
                                        SALLE : {{ $seance->salle->code ?? '?' }}
                                    </div>
                                </div>
                            @else
                                <div class="planning-cell-filled group {{ $colspan > 1 ? 'bg-blue-50/50 border-blue-100' : '' }}">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="px-2 py-1 bg-blue-700 rounded-lg shadow-sm">
                                            <span class="text-[10px] font-black text-white tracking-widest uppercase">
                                                @if(isset($targetType) && $targetType === 'groupe')
                                                    {{ $seance->formateur->nomComplet ?? 'N/A' }}
                                                @else
                                                    {{ $seance->groupe->code ?? 'N/A' }}
                                                @endif
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-1 text-[10px] font-bold text-blue-700 bg-blue-50 px-2 py-1 rounded-md border border-blue-100">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                            {{ $seance->salle->code ?? '?' }}
                                        </div>
                                    </div>
                                    
                                    <div class="mt-auto space-y-1">
                                        <div class="flex items-center gap-2">
                                            <div class="w-1 h-4 bg-blue-200 rounded-full group-hover:bg-blue-500 transition-colors"></div>
                                            <p class="text-xs font-bold text-slate-800 leading-tight">
                                            @if(isset($targetType))
                                                @if($targetType === 'groupe')
                                                    {{-- Ne rien afficher ou autre info --}}
                                                @elseif($targetType === 'formateur')
                                                    {{-- Ne rien afficher --}}
                                                @else
                                                    {{ $seance->formateur->nomComplet ?? 'Formateur inconnu' }}
                                                @endif
                                            @else
                                                {{ $seance->formateur->nomComplet ?? 'Formateur inconnu' }}
                                            @endif
                                        </p>
                                        </div>
                                        @if($colspan > 1)
                                            <div class="flex items-center gap-1.5 mt-2">
                                                <span class="text-[9px] font-black text-blue-600 uppercase tracking-widest bg-white border border-blue-100 px-1.5 py-0.5 rounded shadow-sm">
                                                    Session Longue
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="planning-cell-empty">
                                <span class="opacity-20 text-xs">--</span>
                            </div>
                        @endif
                    </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

