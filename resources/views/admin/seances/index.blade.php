<x-app-layout>
    <x-slot name="header">Emploi du temps global</x-slot>
    <x-slot name="headerActions">
        <a href="{{ route('seances.create') }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Planifier une séance
        </a>
    </x-slot>

    <div class="table-wrapper overflow-x-auto">
        <table class="min-w-full">
            <thead class="table-head">
                <tr>
                    <th>Groupe</th>
                    <th>Formateur</th>
                    <th>Salle</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Créneau</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="table-body">
                @forelse($seances as $s)
                    <tr>
                        <td class="font-semibold text-slate-900">{{ $s->groupe->code }}</td>
                        <td class="text-slate-600">{{ $s->formateur->nomComplet }}</td>
                        <td><span class="badge bg-slate-100 text-slate-600">{{ $s->salle->code }}</span></td>
                        <td class="text-center text-slate-500">
                            {{ \Carbon\Carbon::parse($s->date)->translatedFormat('d M Y') }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-indigo-50 text-indigo-700">{{ $s->horaire }}</span>
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('seances.edit', $s) }}" class="btn-secondary px-3 py-1 text-xs">Modifier</a>
                                <form action="{{ route('seances.destroy', $s) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="btn-danger px-3 py-1 text-xs"
                                            onclick="return confirm('Retirer cette séance ?')">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            Aucune séance n'est actuellement planifiée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
