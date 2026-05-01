<x-guest-layout>

    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-[#0F172A] rounded-xl mb-4 shadow-lg">
            <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <h1 class="text-xl font-bold text-slate-900">Plannings DIA</h1>
    </div>

    <div class="mb-6">
        <h2 class="text-lg font-semibold text-slate-800">Réinitialiser le mot de passe</h2>
        <p class="text-sm text-slate-500 mt-1">Entrez votre email pour recevoir un lien de réinitialisation.</p>
    </div>

    @if(session('status'))
        <div class="mb-5 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm font-medium">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf
        <div>
            <label for="email" class="field-label">Adresse email <span class="text-red-500">*</span></label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="field-input" placeholder="votre@email.ma" required autofocus>
            <x-input-error :messages="$errors->get('email')" />
        </div>
        <button type="submit" class="btn-primary w-full">Envoyer le lien de réinitialisation</button>
        <div class="text-center">
            <a href="{{ route('login') }}" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">← Retour à la connexion</a>
        </div>
    </form>
</x-guest-layout>
