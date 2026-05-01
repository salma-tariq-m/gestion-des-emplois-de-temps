<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use App\Models\Formateur;
use App\Models\Salle;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DashboardController extends Controller
{
    /**
     * Show the dashboard with planning selection forms.
     */
    use AuthorizesRequests;
    public function index()
    {
        $filieres = Filiere::with('groupes')->get();
        $formateurs = Formateur::with('user')->get();
        $salles = Salle::all();
        $user = auth()->user();

        return view('dashboard', [
            'filieres' => $filieres,
            'formateurs' => $formateurs,
            'salles' => $salles,
            'user' => $user,
        ]);
    }

    /**
     * Handle groupe selection and redirect to planning.
     */
    public function selectGroupe(Request $request)
    {
        $validated = $request->validate([
            'groupe_id' => 'required|exists:groupes,id',
        ], [
            'groupe_id.required' => 'Veuillez sélectionner un groupe.',
            'groupe_id.exists' => 'Le groupe sélectionné n\'existe pas.',
        ]);

        return redirect()->route('planning.groupe.show', ['groupe' => $validated['groupe_id']]);
    }

    /**
     * Handle formateur selection and redirect to planning.
     */
    public function selectFormateur(Request $request)
    {
        $validated = $request->validate([
            'formateur_id' => 'required|exists:formateurs,id',
        ], [
            'formateur_id.required' => 'Veuillez sélectionner un formateur.',
            'formateur_id.exists' => 'Le formateur sélectionné n\'existe pas.',
        ]);

        return redirect()->route('planning.formateur.show', ['formateur' => $validated['formateur_id']]);
    }

    /**
     * Handle salle selection and redirect to planning (Admin only).
     */
    public function selectSalle(Request $request)
    {
        if (!auth()->user() || auth()->user()->role !== 'admin') {
            abort(403, 'Accès non autorisé. Veuillez vous connecter en tant qu\'administrateur.');
        }

    $validated = $request->validate([
        'salle_id' => 'required|exists:salles,id',
    ]);

    return redirect()->route('planning.salle.show', ['salle' => $validated['salle_id']]);
}
}
