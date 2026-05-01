<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Plannings DIA — Consultation Publique</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased bg-slate-50 text-slate-900 selection:bg-blue-100 flex flex-col">
    <x-institutional-topbar />

    {{-- Simple Navbar --}}
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('public.index') }}" class="font-semibold text-slate-900 tracking-tight">
                DIA Plannings
            </a>
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-500">Tableau de bord</a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">
                        Accès Staff
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full space-y-12">

        {{-- Search Section --}}
        <div class="card p-8 md:p-12">
            <div class="max-w-3xl mx-auto text-center mb-10">
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight mb-3">Consultez votre emploi du temps</h1>
                <p class="text-slate-600">Accédez aux plannings actualisés du pôle Digital & Intelligence Artificielle.</p>
            </div>

            <div class="max-w-2xl mx-auto mb-8 text-center">
                <span class="inline-flex items-center rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">
                    Accès public: planning des groupes stagiaires uniquement
                </span>
            </div>

            <form method="GET" action="{{ route('public.search') }}" class="max-w-2xl mx-auto space-y-6">
                <input type="hidden" name="type" value="groupe">
                
                <div class="space-y-4">
                    <div>
                        <label class="field-label">Filière</label>
                        <select id="filiere_select" name="filiere_id" class="field-select">
                            <option value="">— Sélectionnez une filière —</option>
                            @foreach($filieres as $f)
                                <option value="{{ $f->id }}" {{ ($filiere_id ?? '') == $f->id ? 'selected' : '' }}>{{ $f->nomComplet }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="field-label">Groupe</label>
                        <select id="groupe_select" name="groupe_id" class="field-select" {{ empty($groupes) ? 'disabled' : '' }}>
                            <option value="">— Sélectionnez un groupe —</option>
                            @foreach($groupes as $g)
                                <option value="{{ $g->id }}" {{ ($groupe_id ?? '') == $g->id ? 'selected' : '' }}>{{ $g->code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="btn-primary w-full py-3 text-base">
                        Afficher le planning
                    </button>
                </div>
            </form>
        </div>

        {{-- Results Area --}}
        @if(isset($seances) && $seances->isNotEmpty())
            <div class="space-y-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 uppercase tracking-tight">
                            Planning : 
                            <span class="text-blue-600">
                                {{ $groupes->where('id', $groupe_id)->first()->code ?? '' }}
                            </span>
                        </h2>
                    </div>
                    
                    <a href="{{ route('public.planning.export', ['groupe_id' => $groupe_id]) }}" 
                       class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-red-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Exporter en PDF
                    </a>
                </div>

                @include('components.planning-grid', [
                    'seances' => $seances,
                    'simpleView' => true,
                    'targetType' => 'groupe'
                ])
            </div>
        @elseif(isset($type))
            <div class="card p-16 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900">Aucune séance planifiée</h3>
                <p class="text-slate-500 mt-1">Aucun cours n'a été trouvé pour cette sélection cette semaine.</p>
            </div>
        @endif

    </main>

    <footer class="bg-white border-t border-slate-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-slate-900 rounded flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <p class="text-xs font-semibold text-slate-600 uppercase tracking-tight">Office de la Formation Professionnelle<br>et de la Promotion du Travail</p>
                </div>
                <p class="text-xs text-slate-400">
                    &copy; {{ date('Y') }} OFPPT &bull; Pôle Digital & Intelligence Artificielle
                </p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filiereSelect = document.getElementById('filiere_select');
            const groupeSelect  = document.getElementById('groupe_select');

            if (filiereSelect) {
                filiereSelect.addEventListener('change', function () {
                    const id = this.value;
                    if (!groupeSelect) return;

                    groupeSelect.innerHTML = '<option value="">Chargement...</option>';
                    groupeSelect.disabled = true;

                    if (id) {
                        fetch(`/api/groupes/${id}`)
                            .then(r => r.json())
                            .then(data => {
                                groupeSelect.innerHTML = '<option value="">— Sélectionnez un groupe —</option>';
                                data.forEach(g => {
                                    const o = document.createElement('option');
                                    o.value = g.id; o.textContent = g.code;
                                    groupeSelect.appendChild(o);
                                });
                                groupeSelect.disabled = false;
                            })
                            .catch(() => {
                                groupeSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                            });
                    } else {
                        groupeSelect.innerHTML = '<option value="">— Sélectionnez d\'abord une filière —</option>';
                        groupeSelect.disabled = true;
                    }
                });
            }
        });
    </script>
</body>
</html>

