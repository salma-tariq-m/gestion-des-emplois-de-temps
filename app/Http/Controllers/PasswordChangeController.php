<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordChangeController extends Controller
{
    public function showChangeForm()
    {
        return view('auth.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        $user = $request->user();
        $targetRoute = $user->role === 'admin' ? 'admin.dashboard' : 'formateur.dashboard';

        return redirect()->intended(route($targetRoute))
            ->with('success', 'Votre mot de passe a été mis à jour avec succès.');
    }
}
