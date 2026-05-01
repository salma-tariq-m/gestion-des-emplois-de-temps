<p class="text-sm text-slate-600 mb-4">
    Une fois votre compte supprimé, toutes ses données seront définitivement effacées. Cette action est irréversible.
</p>

<x-danger-button
    x-data=""
    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
    Supprimer mon compte
</x-danger-button>

<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
        @csrf @method('delete')

        <h2 class="text-lg font-bold text-slate-900 mb-2">Confirmer la suppression</h2>
        <p class="text-sm text-slate-600 mb-5">
            Cette action est irréversible. Entrez votre mot de passe pour confirmer.
        </p>

        <div class="mb-5">
            <label for="del_password" class="field-label">Mot de passe</label>
            <input id="del_password" name="password" type="password" class="field-input" placeholder="••••••••">
            <x-input-error :messages="$errors->userDeletion->get('password')" />
        </div>

        <div class="flex justify-end gap-3">
            <x-secondary-button x-on:click="$dispatch('close')">Annuler</x-secondary-button>
            <x-danger-button>Supprimer définitivement</x-danger-button>
        </div>
    </form>
</x-modal>
