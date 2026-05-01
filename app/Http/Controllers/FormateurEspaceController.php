<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Seance;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

use App\Models\Filiere;
use App\Models\Groupe;

class FormateurEspaceController extends Controller {
    public function dashboard(Request $request) {
        $user = Auth::user();
        $formateur = $user->formateur;

        $filiere_id = $request->get('filiere_id');
        $groupe_id = $request->get('groupe_id');
        
        $filieres = Filiere::all();
        $groupes = $filiere_id ? Groupe::where('filiere_id', $filiere_id)->get() : collect();

        $seances = collect();
        
        if ($groupe_id) {
            // Consultation d'un planning de groupe spécifique (statique)
            $seances = Seance::where('groupe_id', $groupe_id)
                ->with(['formateur', 'salle', 'groupe'])
                ->get();
            $target_type = 'groupe';
        } elseif ($formateur) {
            // Par défaut, son propre planning personnel (statique)
            $seances = Seance::where('formateur_id', $formateur->id)
                ->with(['groupe', 'salle'])
                ->get();
            $target_type = 'personnel';
        }

        return view('formateur.dashboard', compact(
            'seances', 'formateur', 
            'filieres', 'groupes', 'filiere_id', 'groupe_id', 'target_type'
        ));
    }

    public function exportPdf(Request $request) {
        $user = Auth::user();
        $formateur = $user->formateur;

        if (!$formateur) {
            return redirect()->route('formateur.dashboard')
                ->with('error', 'Aucun profil formateur associé à votre compte.');
        }

        $seances = Seance::where('formateur_id', $formateur->id)
            ->with(['groupe', 'salle'])
            ->get();

        $title = "Emploi du temps - Formateur " . $formateur->nomComplet;
        $type = 'formateur';

        $pdf = Pdf::loadView('pdf.planning', compact('seances', 'title', 'type'));

        return $pdf->download("emploi_du_temps_".$formateur->nomComplet.".pdf");
    }
}