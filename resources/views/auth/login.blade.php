<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-slate-50 px-4">
        
        <div class="w-full max-w-md">
            
            <!-- Logo -->
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-slate-900 text-white mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h1 class="text-xl font-semibold text-slate-800">Bienvenue</h1>
            </div>

            <!-- Card -->
            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                
                {{-- Status --}}
                @if(session('status'))
                    <div class="mb-4 p-2 rounded-lg bg-emerald-50 text-emerald-700 text-xs border border-emerald-100">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Errors --}}
                @if($errors->any())
                    <div class="mb-4 p-2 rounded-lg bg-rose-50 text-rose-700 text-xs border border-rose-100">
                        Identifiants incorrects. Veuillez réessayer.
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-medium text-slate-600 mb-1">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               class="w-full  bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm"
                               placeholder="nom@exemple.com" required autofocus>
                    </div>

                    {{-- Password --}}
                    <div>
                        <input id="password" type="password" name="password"
                               class="w-full  bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm"
                               required>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full py-2.5 rounded-lg text-sm font-semibold text-white bg-slate-900 hover:bg-black transition">
                        Se connecter
                    </button>

                </form>
            </div>
        </div>
    </div>
</x-guest-layout>