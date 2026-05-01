<x-guest-layout>

    <div class="mb-8">
        <h2 class="text-xl font-bold text-slate-900">Nouveau mot de passe</h2>
        <p class="text-sm text-slate-500 mt-1">Choisissez un mot de passe sécurisé pour votre compte.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="field-label">Adresse email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                   class="field-input" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <label for="password" class="field-label">Nouveau mot de passe <span class="text-red-500">*</span></label>
            <input id="password" type="password" name="password" class="field-input"
                   placeholder="••••••••" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div>
            <label for="password_confirmation" class="field-label">Confirmer le mot de passe <span class="text-red-500">*</span></label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="field-input"
                   placeholder="••••••••" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <button type="submit" class="btn-primary w-full">Réinitialiser le mot de passe</button>
    </form>
</x-guest-layout>
