<?php
$basePath = __DIR__ . '/resources/views/';

// Define directories to create
$dirs = [
    'admin', 'admin/groupes', 'admin/formateurs', 'admin/salles', 'admin/seances', 'admin/plannings', 'public', 'formateur', 'pdf'
];

foreach ($dirs as $dir) {
    if (!is_dir($basePath . $dir)) {
        mkdir($basePath . $dir, 0777, true);
    }
}

$views = [
    'admin/dashboard.blade.php' => <<<'HTML'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tableau de bord Administrateur</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm">Total Séances</h3>
                    <p class="text-3xl font-bold">{{ $stats['total_seances'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm">Total Salles</h3>
                    <p class="text-3xl font-bold">{{ $stats['total_salles'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm">Total Formateurs</h3>
                    <p class="text-3xl font-bold">{{ $stats['total_formateurs'] }}</p>
                </div>
            </div>
            
            <div class="mt-8 bg-white p-6 shadow-sm sm:rounded-lg space-y-4">
                <h3 class="text-lg font-bold">Actions Rapides</h3>
                <div class="flex gap-4">
                    <a href="{{ route('seances.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Planifier une séance</a>
                    <a href="{{ route('planning.groupe') }}" class="px-4 py-2 bg-gray-600 text-white rounded">Voir les plannings</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
HTML,

    'admin/groupes/index.blade.php' => <<<'HTML'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestion des Groupes</h2>
    </x-slot>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-4 text-right">
            <a href="{{ route('groupes.create') }}" class="px-4 py-2 bg-green-500 text-white rounded">Nouveau Groupe</a>
        </div>
        <table class="w-full bg-white shadow-sm rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr><th>Code</th><th>Filière</th><th>Année</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @foreach($groupes as $g)
                <tr class="border-b text-center">
                    <td class="p-3">{{ $g->code }}</td>
                    <td class="p-3">{{ $g->filiere->nomComplet }}</td>
                    <td class="p-3">{{ $g->annee }}</td>
                    <td class="p-3">
                        <form action="{{ route('groupes.destroy', $g) }}" method="POST" class="inline">
                            @csrf @method('DELETE') <button class="text-red-600">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
HTML,

    'admin/groupes/create.blade.php' => <<<'HTML'
<x-app-layout>
    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('groupes.store') }}" method="POST" class="bg-white p-6 shadow-sm rounded-lg">
            @csrf
            <div class="mb-4">
                <label>Code (ex: DEV101)</label>
                <input required type="text" name="code" class="w-full border-gray-300 rounded shadow-sm">
            </div>
            <div class="mb-4">
                <label>Filière</label>
                <select name="filiere_id" class="w-full border-gray-300 rounded shadow-sm">
                    @foreach($filieres as $f)
                        <option value="{{ $f->id }}">{{ $f->nomComplet }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label>Année</label>
                <select name="annee" class="w-full border-gray-300 rounded shadow-sm">
                    <option value="1">1ère Année</option>
                    <option value="2">2ème Année</option>
                </select>
            </div>
            <div class="mb-4">
                <label>Formateurs rattachés</label>
                <select name="formateurs[]" multiple class="w-full border-gray-300 rounded shadow-sm" style="height:100px;">
                    @foreach($formateurs as $form)
                        <option value="{{ $form->id }}">{{ $form->nomComplet }}</option>
                    @endforeach
                </select>
            </div>
            <button class="px-4 py-2 bg-blue-600 text-white rounded">Enregistrer</button>
        </form>
    </div>
</x-app-layout>
HTML,

    'admin/seances/index.blade.php' => <<<'HTML'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Séances Planifiées</h2>
    </x-slot>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-4 text-right">
            <a href="{{ route('seances.create') }}" class="px-4 py-2 bg-green-500 text-white rounded">Planifier</a>
        </div>
        @if(session('success')) <div class="mb-4 text-green-600">{{ session('success') }}</div> @endif
        <table class="w-full bg-white shadow-sm rounded-lg overflow-hidden text-sm">
            <thead class="bg-gray-100">
                <tr><th>Groupe</th><th>Formateur</th><th>Salle</th><th>Jour</th><th>Créneau</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @foreach($seances as $s)
                <tr class="border-b text-center">
                    <td class="p-2">{{ $s->groupe->code }}</td>
                    <td class="p-2">{{ $s->formateur->nomComplet }}</td>
                    <td class="p-2">{{ $s->salle->code }}</td>
                    <td class="p-2 font-bold">{{ $s->jour }}</td>
                    <td class="p-2 whitespace-nowrap">{{ $s->horaire }}</td>
                    <td class="p-2">
                        <form action="{{ route('seances.destroy', $s) }}" method="POST" class="inline">
                            @csrf @method('DELETE') <button class="text-red-600 text-xs text-white bg-red-100 px-2 rounded">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
HTML,

    'admin/seances/create.blade.php' => <<<'HTML'
<x-app-layout>
    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-bold text-2xl mb-4">Planifier une séance</h2>
        @if($errors->any())
            <div class="bg-red-100 text-red-600 p-4 rounded mb-4">
                <ul>@foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach</ul>
            </div>
        @endif
        <form action="{{ route('seances.store') }}" method="POST" class="bg-white p-6 shadow-sm rounded-lg">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label>Groupe</label>
                    <select name="groupe_id" class="w-full border-gray-300 rounded shadow-sm">
                        @foreach($groupes as $g) <option value="{{ $g->id }}">{{ $g->code }}</option> @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label>Formateur</label>
                    <select name="formateur_id" class="w-full border-gray-300 rounded shadow-sm">
                        @foreach($formateurs as $f) <option value="{{ $f->id }}">{{ $f->nomComplet }}</option> @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label>Salle</label>
                    <select name="salle_id" class="w-full border-gray-300 rounded shadow-sm">
                        @foreach($salles as $s) <option value="{{ $s->id }}">{{ $s->code }}</option> @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label>Jour</label>
                    <select name="jour" class="w-full border-gray-300 rounded shadow-sm">
                        @foreach(['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'] as $j)
                            <option value="{{ $j }}">{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4 col-span-2">
                    <label>Créneau Horaire</label>
                    <select name="creneau" class="w-full border-gray-300 rounded shadow-sm">
                        <option value="1">Créneau 1 : 08h30 - 11h00</option>
                        <option value="2">Créneau 2 : 11h00 - 13h30</option>
                        <option value="3">Créneau 3 : 13h30 - 16h00</option>
                        <option value="4">Créneau 4 : 16h00 - 18h30</option>
                    </select>
                </div>
            </div>
            <button class="px-4 py-2 bg-blue-600 text-white rounded w-full">Enregistrer la séance</button>
        </form>
    </div>
</x-app-layout>
HTML,

    'admin/plannings/groupe.blade.php' => <<<'HTML'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Planning par Groupe</h2>
    </x-slot>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form method="GET" class="mb-6 bg-white p-4 rounded shadow-sm flex gap-4">
            <select name="groupe_id" class="border-gray-300 rounded" onchange="this.form.submit()">
                <option value="">-- Choisir un groupe --</option>
                @foreach($groupes as $g)
                    <option value="{{ $g->id }}" {{ $groupe_id == $g->id ? 'selected' : '' }}>{{ $g->code }}</option>
                @endforeach
            </select>
            @if($groupe_id)
            <a href="{{ route('planning.export', ['type'=>'groupe', 'id'=>$groupe_id]) }}" class="px-4 py-2 bg-red-500 text-white rounded">Exporter PDF</a>
            @endif
        </form>

        @if($groupe_id)
            @include('components.planning-grid', ['seances' => $seances])
        @else
            <p class="text-gray-500 text-center">Veuillez sélectionner un groupe.</p>
        @endif
    </div>
</x-app-layout>
HTML,

    'components/planning-grid.blade.php' => <<<'HTML'
@php
    $jours = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
    $creneaux = [
        1 => '08h30 - 11h00',
        2 => '11h00 - 13h30',
        3 => '13h30 - 16h00',
        4 => '16h00 - 18h30',
    ];
@endphp
<div class="overflow-x-auto bg-white rounded shadow-sm">
    <table class="w-full border-collapse border border-gray-200">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="border border-gray-300 p-3">Heure / Jour</th>
                @foreach($jours as $j) <th class="border border-gray-300 p-3">{{ $j }}</th> @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($creneaux as $c => $time)
            <tr>
                <td class="border border-gray-300 font-bold p-3 text-center bg-gray-100">{{ $time }}</td>
                @foreach($jours as $j)
                    @php $seance = $seances->where('jour', $j)->where('creneau', $c)->first(); @endphp
                    <td class="border border-gray-300 p-3 text-center text-sm {{ $seance ? 'bg-green-50' : 'bg-gray-50' }}">
                        @if($seance)
                            <div class="font-bold text-gray-800">{{ $seance->groupe->code ?? '' }}</div>
                            <div class="text-blue-600">{{ $seance->formateur->nomComplet ?? '' }}</div>
                            <div class="text-red-500 text-xs">{{ $seance->salle->code ?? '' }}</div>
                        @else
                            <span class="text-gray-400 italic">Aucune séance</span>
                        @endif
                    </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
HTML,

    'pdf/planning.blade.php' => <<<'HTML'
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { w-full; border-collapse: collapse; margin-top: 20px; width: 100%; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>{{ $title }}</h2>
    <table>
        <thead>
            <tr>
                <th>Heure / Jour</th>
                <th>Lundi</th><th>Mardi</th><th>Mercredi</th><th>Jeudi</th><th>Vendredi</th><th>Samedi</th>
            </tr>
        </thead>
        <tbody>
            @php $creneaux = [1 => '08h30-11h00', 2 => '11h00-13h30', 3 => '13h30-16h00', 4 => '16h00-18h30']; $jours = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi']; @endphp
            @foreach($creneaux as $c => $time)
            <tr>
                <td style="font-weight:bold;">{{ $time }}</td>
                @foreach($jours as $j)
                    @php $seance = $seances->where('jour', $j)->where('creneau', $c)->first(); @endphp
                    <td>
                        @if($seance)
                            <b>{{ $seance->groupe->code ?? '' }}</b><br>
                            {{ $seance->formateur->nomComplet ?? '' }}<br>
                            Salle: {{ $seance->salle->code ?? '' }}
                        @endif
                    </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
HTML,

    'public/index.blade.php' => <<<'HTML'
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consultation Emploi du Temps</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <nav class="bg-white p-4 shadow mb-6 flex justify-between">
        <h1 class="font-bold text-xl text-blue-800">Pôle Digital & IA - Plannings</h1>
        <div class="flex gap-4">
            @auth
                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-black">Aller au Tableau de bord</a>
            @else
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-black">Connexion Formateur/Admin</a>
            @endauth
        </div>
    </nav>
    <div class="flex-grow max-w-7xl mx-auto px-4 w-full">
        <div class="bg-white p-6 shadow-sm rounded mb-8 text-center">
            <h2 class="text-2xl font-bold mb-4">Rechercher un Emploi du Temps</h2>
            <form method="GET" action="{{ route('public.search') }}" class="flex justify-center gap-4">
                <select name="filiere_id" onchange="this.form.submit()" class="border-gray-300 rounded shadow-sm w-64">
                    <option value="">Sélectionner une filière</option>
                    @foreach($filieres as $f)
                        <option value="{{ $f->id }}" {{ isset($filiere_id) && $filiere_id == $f->id ? 'selected' : '' }}>{{ $f->nomComplet }}</option>
                    @endforeach
                </select>
                <select name="groupe_id" class="border-gray-300 rounded shadow-sm w-64">
                    <option value="">Sélectionner un groupe</option>
                    @foreach($groupes as $g)
                        <option value="{{ $g->id }}" {{ isset($groupe_id) && $groupe_id == $g->id ? 'selected' : '' }}>{{ $g->code }}</option>
                    @endforeach
                </select>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Afficher</button>
            </form>
        </div>

        @if(isset($groupe_id) && $groupe_id)
            <div class="mb-4 text-center text-lg font-bold">Emploi du temps du groupe</div>
            @include('components.planning-grid', ['seances' => $seances])
        @elseif(isset($filiere_id))
            <p class="text-center mt-4">Veuillez sélectionner un groupe puis cliquer sur Afficher.</p>
        @else
            <div class="text-center text-xl text-gray-500 mt-10">Commencez par choisir votre filière.</div>
        @endif
    </div>
</body>
</html>
HTML,

    'formateur/dashboard.blade.php' => <<<'HTML'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mon Espace Formateur</h2>
    </x-slot>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
            <h3 class="text-xl font-bold mb-2">Bienvenue {{ Auth::user()->name }}</h3>
            <p class="text-sm text-gray-600">Matricule : {{ $formateur->matricule ?? 'N/A' }} | Spécialité : {{ $formateur->specialite ?? 'N/A' }}</p>
        </div>
        
        <h3 class="font-bold text-lg mb-4">Mon emploi du temps personnel</h3>
        @include('components.planning-grid', ['seances' => $seances])
    </div>
</x-app-layout>
HTML
];

foreach($views as $name => $content) {
    file_put_contents($basePath . $name, $content);
}
echo "Views generated.\n";
