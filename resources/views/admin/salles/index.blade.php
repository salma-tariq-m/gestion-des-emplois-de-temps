<x-app-layout>
    <x-slot name="header">Gestion des salles</x-slot>
    <x-slot name="headerActions">
        <a href="{{ route('salles.create') }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Ajouter une salle
        </a>
    </x-slot>

    <div class="table-wrapper">
        <table class="min-w-full">
            <thead class="table-head">
                <tr>
                    <th>Code</th>
                    <th class="text-center">Capacité</th>
                    <th>Type</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="table-body">
                @forelse($salles as $s)
                    <tr>
                        <td class="font-semibold text-slate-900">{{ $s->code }}</td>
                        <td class="text-center text-slate-600 text-sm">{{ $s->capacite }} places</td>
                        <td>
                            @if(strtolower($s->type) === 'informatique')
                                <span class="badge bg-indigo-50 text-indigo-700">Informatique</span>
                            @else
                                <span class="badge bg-slate-100 text-slate-600">{{ ucfirst($s->type) }}</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('salles.edit', $s) }}" class="btn-secondary px-3 py-1 text-xs">Modifier</a>
                                <form action="{{ route('salles.destroy', $s) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="btn-danger px-3 py-1 text-xs"
                                            onclick="return confirm('Supprimer cette salle ?')">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                            Aucune salle n'a été trouvée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
