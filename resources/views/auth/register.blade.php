<x-guest-layout>
    {{-- Section title --}}
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900">Créer un compte</h2>
        <p class="text-sm text-gray-500 mt-1">Inscrivez-vous pour gérer les emplois du temps.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div class="space-y-2">
            <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-widest">Nom Complet</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="block w-full px-3 py-2.5 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm font-medium"
                   placeholder="ex: Jean Dupont">
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-widest">Adresse Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="block w-full px-3 py-2.5 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm font-medium"
                   placeholder="votre@ofppt.ma">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-widest">Mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="block w-full px-3 py-2.5 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm font-medium"
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2">
            <label for="password_confirmation" class="block text-xs font-bold text-gray-700 uppercase tracking-widest">Confirmer le mot de passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="block w-full px-3 py-2.5 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm font-medium"
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-2 space-y-4">
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs uppercase tracking-widest rounded shadow-sm transition-all active:scale-[0.98]">
                <span>Créer mon compte</span>
            </button>

            <p class="text-center">
                <a class="text-xs font-bold text-gray-500 hover:text-blue-700 transition-colors uppercase tracking-tight" href="{{ route('login') }}">
                    Déjà inscrit ? Se connecter
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
