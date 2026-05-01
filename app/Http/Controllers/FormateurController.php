<?php
namespace App\Http\Controllers;
use App\Models\Formateur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreFormateurRequest;

class FormateurController extends Controller {
    public function index() {
        $formateurs = Formateur::with('user')->get();
        return view('admin.formateurs.index', compact('formateurs'));
    }
    public function create() {
        return view('admin.formateurs.create');
    }
    public function store(StoreFormateurRequest $request) {
        $data = $request->validated();
        
        // 1. Générer mot de passe temporaire
        $tempPassword = Str::random(8);
        
        // 2. Créer le compte utilisateur
        $user = User::create([
            'name' => $data['prenom'] . ' ' . $data['nom'],
            'email' => $data['email'],
            'password' => Hash::make($tempPassword),
            'role' => 'formateur',
            'must_change_password' => true,
        ]);
        
        // 3. Créer le formateur lié à l'utilisateur
        $data['user_id'] = $user->id;
        Formateur::create($data);
        
        return redirect()->route('formateurs.index')
            ->with('success', 'Formateur créé avec succès.')
            ->with('credentials', [
                'email' => $data['email'],
                'password' => $tempPassword
            ]);
    }
    public function edit(Formateur $formateur) {
        return view('admin.formateurs.edit', compact('formateur'));
    }
    public function update(StoreFormateurRequest $request, Formateur $formateur) {
        $data = $request->validated();
        $formateur->update($data);
        
        // Mettre à jour l'utilisateur si nécessaire
        if ($formateur->user) {
            $formateur->user->update([
                'name' => $data['prenom'] . ' ' . $data['nom'],
                'email' => $data['email'],
            ]);
        }
        
        return redirect()->route('formateurs.index')->with('success', 'Formateur modifié.');
    }
    public function destroy(Formateur $formateur) {
        // La suppression du formateur supprime aussi l'utilisateur si on a mis onDelete('cascade') ou manuellement
        if ($formateur->user) {
            $formateur->user->delete();
        }
        $formateur->delete();
        return redirect()->route('formateurs.index')->with('success', 'Formateur supprimé.');
    }

    public function resetPassword(Formateur $formateur) {
        if (!$formateur->user) {
            return back()->with('error', 'Aucun compte utilisateur associé à ce formateur.');
        }

        $tempPassword = Str::random(8);
        $formateur->user->update([
            'password' => Hash::make($tempPassword),
            'must_change_password' => true,
        ]);

        return back()
            ->with('success', 'Mot de passe réinitialisé.')
            ->with('credentials', [
                'email' => $formateur->email,
                'password' => $tempPassword
            ]);
    }
}