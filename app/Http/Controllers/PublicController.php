<?php
namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Groupe;
use App\Models\Seance;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PublicController extends Controller {
    public function index() {
        $filieres = Filiere::all();
        $groupes = collect();
        $seances = collect();
        $type = 'groupe';
        return view('public.index', compact('filieres', 'groupes', 'seances', 'type'));
    }

    public function search(Request $request) {
        // Public access is intentionally limited to trainee groups.
        $type = 'groupe';
        $filiere_id = $request->get('filiere_id');
        $groupe_id = $request->get('groupe_id');
        
        $filieres = Filiere::all();
        $groupes = $filiere_id ? Groupe::where('filiere_id', $filiere_id)->get() : collect();
        
        $seances = collect();
        
        if ($groupe_id) {
            $seances = Seance::where('groupe_id', $groupe_id)
                        ->with(['formateur', 'salle', 'groupe'])
                        ->get();
        }
        
        return view('public.index', compact(
            'filieres', 'groupes',
            'seances', 'type', 'filiere_id', 'groupe_id'
        ));
    }

    public function getGroupesByFiliere(Filiere $filiere)
    {
        return response()->json($filiere->groupes);
    }

    public function exportPdf(Request $request)
    {
        $groupeId = $request->get('groupe_id');
        if (!$groupeId) {
            return redirect()->route('public.index')
                ->with('error', 'Veuillez sélectionner un groupe avant l’export PDF.');
        }

        $groupe = Groupe::find($groupeId);
        if (!$groupe) {
            return redirect()->route('public.index')
                ->with('error', 'Groupe introuvable.');
        }

        $seances = Seance::where('groupe_id', $groupeId)
            ->with(['formateur', 'salle', 'groupe'])
            ->get();

        $title = "Emploi du temps - Groupe " . $groupe->code;
        $type = 'groupe';
        $pdf = Pdf::loadView('pdf.planning', compact('seances', 'title', 'type'));

        return $pdf->download("emploi_du_temps_groupe_" . $groupe->code . ".pdf");
    }
}