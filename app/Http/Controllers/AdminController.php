<?php
namespace App\Http\Controllers;
use App\Models\Seance;
use App\Models\Salle;
use App\Models\Formateur;
use App\Models\Groupe;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller {
    public function dashboard() {
        $now = Carbon::now();
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();

        $stats = [
            'total_seances' => Seance::count(),
            'total_salles' => Salle::count(),
            'total_formateurs' => Formateur::count(),
            'total_groupes' => Groupe::count(),
            'seances_semaine' => Seance::whereBetween('date', [$startOfWeek->format('Y-m-d'), $endOfWeek->format('Y-m-d')])->count(),
        ];

        // Occupation des salles (données pour le graphique)
        $salleUsage = Salle::withCount(['seances' => function($q) use ($startOfWeek, $endOfWeek) {
            $q->whereBetween('date', [$startOfWeek->format('Y-m-d'), $endOfWeek->format('Y-m-d')]);
        }])->get();

        return view('admin.dashboard', compact('stats', 'salleUsage'));
    }
}