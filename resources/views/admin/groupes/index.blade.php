<x-app-layout>
    <x-slot name="header">Gestion des groupes</x-slot>
    <x-slot name="headerActions">
        <a href="{{ route('groupes.create') }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nouveau groupe
        </a>
    </x-slot>

    <div class="table-wrapper">
        <table class="min-w-full">
            <thead class="table-head">
                <tr>
                    <th>Code</th>
                    <th>Filière / Programme</th>
                    <th class="text-center">Année</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="table-body">
                @forelse($groupes as $g)
                    <tr>
                        <td class="font-semibold text-slate-900">{{ $g->code }}</td>
                        <td class="text-slate-600">{{ $g->filiere->nomComplet ?? '—' }}</td>
                        <td class="text-center">
                            <span class="badge bg-indigo-50 text-indigo-700">Année {{ $g->annee }}</span>
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('groupes.edit', $g) }}" class="btn-secondary px-3 py-1 text-xs">Modifier</a>
                                <form action="{{ route('groupes.destroy', $g) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="btn-danger px-3 py-1 text-xs"
                                            onclick="return confirm('Supprimer ce groupe ?')">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                            Aucun groupe n'a été trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
