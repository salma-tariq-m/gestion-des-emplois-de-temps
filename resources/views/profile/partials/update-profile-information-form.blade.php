<form method="post" action="{{ route('profile.update') }}" class="space-y-6">
    @csrf @method('patch')

    <div class="space-y-2">
        <label for="name" class="field-label">Nom complet <span class="text-accent-500">*</span> 
            @if($user->role === 'formateur')
                <span class="text-slate-400 font-normal uppercase text-[10px] tracking-widest">(Verrouillé)</span>
            @endif
        </label>
        <div class="relative group">
            @if($user->role === 'formateur')
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
            @endif
            <input id="name" name="name" type="text" 
                   class="field-input {{ $user->role === 'formateur' ? 'pl-11 !bg-slate-50 !text-slate-500 cursor-not-allowed border-dashed' : '' }}"
                   value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                   {{ $user->role === 'formateur' ? 'readonly' : '' }}>
        </div>
        @error('name')<p class="text-xs text-red-600 font-bold mt-2">{{ $message }}</p>@enderror
    </div>

    @if($user->role === 'formateur' && $user->formateur)
        <div class="space-y-2">
            <label class="field-label">Matricule <span class="text-slate-400 font-normal uppercase text-[10px] tracking-widest">(Verrouillé)</span></label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <input type="text" class="field-input pl-11 !bg-slate-50 !text-slate-400 cursor-not-allowed border-dashed"
                       value="{{ $user->formateur->matricule }}" disabled>
            </div>
        </div>
        <div class="space-y-2">
            <label for="telephone" class="field-label">Téléphone de Contact</label>
            <input id="telephone" name="telephone" type="text" class="field-input"
                   value="{{ old('telephone', $user->formateur->telephone) }}" placeholder="06 XX XX XX XX">
            @error('telephone')<p class="text-xs text-red-600 font-bold mt-2">{{ $message }}</p>@enderror
        </div>
    @endif

    <div class="space-y-2">
        <label for="email" class="field-label">Adresse de Correspondance <span class="text-accent-500">*</span>
            @if($user->role === 'formateur')
                <span class="text-slate-400 font-normal uppercase text-[10px] tracking-widest">(Verrouillé)</span>
            @endif
        </label>
        <div class="relative group">
            @if($user->role === 'formateur')
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
            @endif
            <input id="email" name="email" type="email" 
                   class="field-input {{ $user->role === 'formateur' ? 'pl-11 !bg-slate-50 !text-slate-500 cursor-not-allowed border-dashed' : '' }}"
                   value="{{ old('email', $user->email) }}" required autocomplete="username"
                   {{ $user->role === 'formateur' ? 'readonly' : '' }}>
        </div>
        @error('email')<p class="text-xs text-red-600 font-bold mt-2">{{ $message }}</p>@enderror
    </div>

    <div class="flex items-center gap-6 pt-4">
        <button type="submit" class="btn-primary px-8">
            Enregistrer les Modifications
        </button>
        
        @if(session('status') === 'profile-updated')
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 class="flex items-center gap-2 text-emerald-600 font-black text-[11px] uppercase tracking-widest">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                Modifications Enregistrées
            </div>
        @endif
    </div>
</form>

