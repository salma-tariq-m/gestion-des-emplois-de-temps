<x-guest-layout>

    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-amber-100 rounded-xl mb-4">
            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <h1 class="text-xl font-bold text-slate-900">Sécurité du compte</h1>
        <p class="text-sm text-slate-500 mt-1">Veuillez définir un nouveau mot de passe pour continuer.</p>
    </div>

    @if(session('status') === 'password-updated')
        <div class="mb-5 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm font-medium">
            Mot de passe mis à jour avec succès.
        </div>
    @endif

    <form method="POST" action="{{ route('password.change.update') }}" class="space-y-5">
        @csrf

        <div>
            <label for="current_password" class="field-label">Mot de passe actuel <span class="text-red-500">*</span></label>
            <input id="current_password" type="password" name="current_password" class="field-input"
                   placeholder="••••••••" required>
            <x-input-error :messages="$errors->get('current_password')" />
        </div>

        <div>
            <label for="password" class="field-label">Nouveau mot de passe <span class="text-red-500">*</span></label>
            <input id="password" type="password" name="password" class="field-input"
                   placeholder="••••••••" required>
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div>
            <label for="password_confirmation" class="field-label">Confirmer le nouveau mot de passe <span class="text-red-500">*</span></label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="field-input"
                   placeholder="••••••••" required>
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <button type="submit" class="btn-primary w-full mt-2">Valider le changement</button>
    </form>
</x-guest-layout>
