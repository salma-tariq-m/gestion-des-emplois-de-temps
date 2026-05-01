<x-app-layout>
    <x-slot name="header">Gestion des formateurs</x-slot>
    <x-slot name="headerActions">
        <a href="{{ route('formateurs.create') }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Ajouter un formateur
        </a>
    </x-slot>

    @if(session('credentials'))
        <div class="mb-8 p-6 bg-amber-50 border border-amber-100 rounded-lg">
            <div class="flex items-start gap-4">
                <div class="shrink-0 w-10 h-10 bg-amber-100 text-amber-600 rounded-md flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-amber-900 uppercase tracking-tight">Identifiants générés</h4>
                    <p class="mt-1 text-sm text-amber-700">Veuillez transmettre ces accès au nouveau formateur :</p>
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-white p-3 rounded border border-amber-200">
                            <span class="block text-[10px] font-bold text-slate-400 uppercase">Email</span>
                            <span class="text-sm font-medium text-slate-900">{{ session('credentials')['email'] }}</span>
                        </div>
                        <div class="bg-white p-3 rounded border border-amber-200">
                            <span class="block text-[10px] font-bold text-slate-400 uppercase">Mot de passe temporaire</span>
                            <span class="text-sm font-mono font-bold text-indigo-600">{{ session('credentials')['password'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="table-wrapper">
        <table class="min-w-full">
            <thead class="table-head">
                <tr>
                    <th>Matricule</th>
                    <th>Nom & Prénom</th>
                    <th>Email</th>
                    <th>Spécialité</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="table-body">
                @forelse($formateurs as $f)
                    <tr>
                        <td class="font-mono text-xs font-semibold text-slate-500">{{ $f->matricule }}</td>
                        <td class="font-semibold text-slate-900">{{ $f->nomComplet }}</td>
                        <td class="text-slate-500 text-sm">{{ $f->email }}</td>
                        <td>
                            <span class="badge bg-slate-100 text-slate-600">{{ $f->specialite }}</span>
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('formateurs.edit', $f) }}" class="btn-secondary px-3 py-1 text-xs">Modifier</a>
                                <form action="{{ route('formateurs.destroy', $f) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="btn-danger px-3 py-1 text-xs"
                                            onclick="return confirm('Supprimer ce formateur ?')">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            Aucun formateur n'a été trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
