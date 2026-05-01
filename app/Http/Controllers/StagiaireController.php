<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seance;
use Illuminate\Support\Facades\Auth;

class StagiaireController extends Controller
{
    public function dashboard()
    {
        $user      = Auth::user();
        $stagiaire = $user->stagiaire;

        $seances = collect();
        $groupe  = null;

        if ($stagiaire && $stagiaire->groupe) {
            $groupe  = $stagiaire->groupe;
            $seances = Seance::where('groupe_id', $groupe->id)
                ->with(['formateur', 'salle', 'groupe'])
                ->get();
        }

        $target_type = 'groupe';

        return view('stagiaire.dashboard', compact(
            'stagiaire', 'seances', 'groupe', 'target_type'
        ));
    }
}