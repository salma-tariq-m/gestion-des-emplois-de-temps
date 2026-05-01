<form method="post" action="{{ route('password.update') }}" class="space-y-6">
    @csrf @method('put')

    <div class="space-y-2">
        <label for="current_password" class="field-label">Mot de Passe Actuel</label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-slate-400 group-focus-within:text-accent-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <input id="current_password" name="current_password" type="password" class="field-input pl-11"
                   autocomplete="current-password" placeholder="••••••••">
        </div>
        @error('current_password', 'updatePassword')<p class="text-xs text-red-600 font-bold mt-2">{{ $message }}</p>@enderror
    </div>

    <div class="space-y-2">
        <label for="password" class="field-label">Nouveau Mot de Passe <span class="text-accent-500">*</span></label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-slate-400 group-focus-within:text-accent-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
            </div>
            <input id="password" name="password" type="password" class="field-input pl-11"
                   autocomplete="new-password" placeholder="••••••••">
        </div>
        @error('password', 'updatePassword')<p class="text-xs text-red-600 font-bold mt-2">{{ $message }}</p>@enderror
    </div>

    <div class="space-y-2">
        <label for="password_confirmation" class="field-label">Confirmation du Nouveau Mot de Passe <span class="text-accent-500">*</span></label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-slate-400 group-focus-within:text-accent-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <input id="password_confirmation" name="password_confirmation" type="password" class="field-input pl-11"
                   autocomplete="new-password" placeholder="••••••••">
        </div>
        @error('password_confirmation', 'updatePassword')<p class="text-xs text-red-600 font-bold mt-2">{{ $message }}</p>@enderror
    </div>

    <div class="flex items-center gap-6 pt-4">
        <button type="submit" class="btn-primary px-8">
            Sécuriser le Compte
        </button>
        
        @if(session('status') === 'password-updated')
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 class="flex items-center gap-2 text-emerald-600 font-black text-[11px] uppercase tracking-widest">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                Mot de Passe Mis à Jour
            </div>
        @endif
    </div>
</form>

