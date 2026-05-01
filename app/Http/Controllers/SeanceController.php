<?php
namespace App\Http\Controllers;
use App\Models\Seance;
use App\Models\Groupe;
use App\Models\Formateur;
use App\Models\Salle;
use App\Http\Requests\StoreSeanceRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class SeanceController extends Controller {
    public function index() {
        $seances = Seance::with(['groupe', 'formateur', 'salle'])->latest()->get();
        return view('admin.seances.index', compact('seances'));
    }
    public function create() {
        $groupes = \App\Models\Groupe::all();
        $formateurs = \App\Models\Formateur::all();
        $salles = \App\Models\Salle::all();
        return view('admin.seances.create', compact('groupes', 'formateurs', 'salles'));
    }
    public function store(StoreSeanceRequest $request) {
        Seance::create($request->validated());
        return redirect()->route('seances.index')->with('success', 'Séance planifiée.');
    }
    public function edit(\App\Models\Seance $seance) {
        $groupes = \App\Models\Groupe::all();
        $formateurs = \App\Models\Formateur::all();
        $salles = \App\Models\Salle::all();
        return view('admin.seances.edit', compact('seance', 'groupes', 'formateurs', 'salles'));
    }
    public function update(StoreSeanceRequest $request, Seance $seance) {
        $seance->update($request->validated());
        return redirect()->route('seances.index')->with('success', 'Séance modifiée.');
    }
    public function destroy(Seance $seance) {
        $seance->delete();
        return redirect()->route('seances.index');
    }

    public function planningGroupe(Request $request) {
        $groupe_id = $request->get('groupe_id');
        $groupes = Groupe::all();
        $seances = collect();
        if ($groupe_id) {
            $seances = Seance::where('groupe_id', $groupe_id)
                ->with(['formateur', 'salle'])
                ->get();
        }
        return view('admin.plannings.groupe', compact('groupes', 'seances', 'groupe_id'));
    }

    public function planningFormateur(Request $request) {
        $formateur_id = $request->get('formateur_id');
        $formateurs = Formateur::all();
        $seances = collect();
        if ($formateur_id) {
            $seances = Seance::where('formateur_id', $formateur_id)
                ->with(['groupe', 'salle'])
                ->get();
        }
        return view('admin.plannings.formateur', compact('formateurs', 'seances', 'formateur_id'));
    }

    public function planningSalle(Request $request) {
        $salle_id = $request->get('salle_id');
        $salles = Salle::all();
        $seances = collect();
        if ($salle_id) {
            $seances = Seance::where('salle_id', $salle_id)
                ->with(['groupe', 'formateur'])
                ->get();
        }
        return view('admin.plannings.salle', compact('salles', 'seances', 'salle_id'));
    }

    public function exportPdf(Request $request) {
        $type = $request->get('type');
        $id = $request->get('id');
        $seances = collect();

        if ($type === 'groupe') {
            $target = Groupe::findOrFail($id);
            $seances = Seance::where('groupe_id', $id)->with(['formateur', 'salle'])->get();
            $title = "Planning Groupe: " . $target->code;
        } elseif ($type === 'formateur') {
            $target = Formateur::findOrFail($id);
            $seances = Seance::where('formateur_id', $id)->with(['groupe', 'salle'])->get();
            $title = "Planning Formateur: " . $target->nomComplet;
        } elseif ($type === 'salle') {
            $target = Salle::findOrFail($id);
            $seances = Seance::where('salle_id', $id)->with(['groupe', 'formateur'])->get();
            $title = "Planning Salle: " . $target->code;
        }

        $pdf = Pdf::loadView('pdf.planning', compact('seances', 'title', 'type'));
        return $pdf->download('planning.pdf');
    }

    public function exportCsv(Request $request) {
        $type = $request->get('type');
        $id = $request->get('id');
        $seances = collect();
        $filename = "planning.csv";

        if ($type == 'groupe') {
            $seances = Seance::where('groupe_id', $id)->with(['formateur', 'salle'])->get();
            $filename = "planning_groupe_" . Groupe::find($id)->code . ".csv";
        } elseif ($type == 'formateur') {
            $seances = Seance::where('formateur_id', $id)->with(['groupe', 'salle'])->get();
            $filename = "planning_formateur_" . Formateur::find($id)->nomComplet . ".csv";
        } elseif ($type == 'salle') {
            $seances = Seance::where('salle_id', $id)->with(['groupe', 'formateur'])->get();
            $filename = "planning_salle_" . Salle::find($id)->code . ".csv";
        }

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Jour', 'Creneau', 'Horaire', 'Groupe', 'Formateur', 'Salle'];

        $callback = function() use ($seances, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($seances as $seance) {
                fputcsv($file, [
                    $seance->jour,
                    $seance->creneau,
                    $seance->horaire,
                    $seance->groupe->code,
                    $seance->formateur->nomComplet,
                    $seance->salle->code,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}