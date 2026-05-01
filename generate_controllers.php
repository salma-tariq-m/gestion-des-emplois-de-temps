<?php
$basePath = __DIR__ . '/app/Http/Controllers/';

$files = [
    'AdminController.php' => <<<'PHP'
<?php
namespace App\Http\Controllers;
use App\Models\Seance;
use App\Models\Salle;
use App\Models\Formateur;
use Illuminate\Http\Request;

class AdminController extends Controller {
    public function dashboard() {
        $stats = [
            'total_seances' => Seance::count(),
            'total_salles' => Salle::count(),
            'total_formateurs' => Formateur::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }
}
PHP,

    'GroupeController.php' => <<<'PHP'
<?php
namespace App\Http\Controllers;
use App\Models\Groupe;
use App\Models\Filiere;
use App\Models\Formateur;
use Illuminate\Http\Request;

class GroupeController extends Controller {
    public function index() {
        $groupes = Groupe::with('filiere')->get();
        return view('admin.groupes.index', compact('groupes'));
    }
    public function create() {
        $filieres = Filiere::all();
        $formateurs = Formateur::all();
        return view('admin.groupes.create', compact('filieres', 'formateurs'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'code' => 'required|unique:groupes',
            'filiere_id' => 'required|exists:filieres,id',
            'annee' => 'required|in:1,2',
            'formateurs' => 'array'
        ]);
        $groupe = Groupe::create($data);
        if($request->has('formateurs')) {
            $groupe->formateurs()->sync($request->formateurs);
        }
        return redirect()->route('groupes.index')->with('success', 'Groupe créé.');
    }
    // ... basic edit/update/delete implementations
    public function edit(Groupe $groupe) {
        $filieres = Filiere::all();
        $formateurs = Formateur::all();
        return view('admin.groupes.edit', compact('groupe', 'filieres', 'formateurs'));
    }
    public function update(Request $request, Groupe $groupe) {
        $data = $request->validate([
            'code' => 'required|unique:groupes,code,'.$groupe->id,
            'filiere_id' => 'required|exists:filieres,id',
            'annee' => 'required|in:1,2',
            'formateurs' => 'array'
        ]);
        $groupe->update($data);
        $groupe->formateurs()->sync($request->formateurs ?? []);
        return redirect()->route('groupes.index')->with('success', 'Groupe modifié.');
    }
    public function destroy(Groupe $groupe) {
        $groupe->delete();
        return redirect()->route('groupes.index');
    }
}
PHP,

    'FormateurController.php' => <<<'PHP'
<?php
namespace App\Http\Controllers;
use App\Models\Formateur;
use Illuminate\Http\Request;

class FormateurController extends Controller {
    public function index() {
        $formateurs = Formateur::all();
        return view('admin.formateurs.index', compact('formateurs'));
    }
    public function create() {
        return view('admin.formateurs.create');
    }
    public function store(Request $request) {
        Formateur::create($request->validate([
            'matricule' => 'required|unique:formateurs',
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:formateurs',
            'telephone' => 'nullable',
            'specialite' => 'required'
        ]));
        return redirect()->route('formateurs.index')->with('success', 'Créé.');
    }
    public function edit(Formateur $formateur) {
        return view('admin.formateurs.edit', compact('formateur'));
    }
    public function update(Request $request, Formateur $formateur) {
        $formateur->update($request->validate([
            'matricule' => 'required|unique:formateurs,matricule,'.$formateur->id,
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:formateurs,email,'.$formateur->id,
            'telephone' => 'nullable',
            'specialite' => 'required'
        ]));
        return redirect()->route('formateurs.index')->with('success', 'Modifié.');
    }
    public function destroy(Formateur $formateur) {
        $formateur->delete();
        return redirect()->route('formateurs.index');
    }
}
PHP,

    'SalleController.php' => <<<'PHP'
<?php
namespace App\Http\Controllers;
use App\Models\Salle;
use Illuminate\Http\Request;

class SalleController extends Controller {
    public function index() {
        $salles = Salle::all();
        return view('admin.salles.index', compact('salles'));
    }
    public function create() {
        return view('admin.salles.create');
    }
    public function store(Request $request) {
        Salle::create($request->validate([
            'code' => 'required|unique:salles',
            'type' => 'nullable',
            'capacite' => 'nullable|integer'
        ]));
        return redirect()->route('salles.index');
    }
    public function edit(Salle $salle) {
        return view('admin.salles.edit', compact('salle'));
    }
    public function update(Request $request, Salle $salle) {
        $salle->update($request->validate([
            'code' => 'required|unique:salles,code,'.$salle->id,
            'type' => 'nullable',
            'capacite' => 'nullable|integer'
        ]));
        return redirect()->route('salles.index');
    }
    public function destroy(Salle $salle) {
        $salle->delete();
        return redirect()->route('salles.index');
    }
}
PHP,

    'SeanceController.php' => <<<'PHP'
<?php
namespace App\Http\Controllers;
use App\Models\Seance;
use App\Models\Groupe;
use App\Models\Formateur;
use App\Models\Salle;
use App\Http\Requests\StoreSeanceRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SeanceController extends Controller {
    public function index() {
        $seances = Seance::with(['groupe', 'formateur', 'salle'])->get();
        return view('admin.seances.index', compact('seances'));
    }
    public function create() {
        $groupes = Groupe::all();
        $formateurs = Formateur::all();
        $salles = Salle::all();
        return view('admin.seances.create', compact('groupes', 'formateurs', 'salles'));
    }
    public function store(StoreSeanceRequest $request) {
        Seance::create($request->validated());
        return redirect()->route('seances.index')->with('success', 'Séance planifiée.');
    }
    public function edit(Seance $seance) {
        $groupes = Groupe::all();
        $formateurs = Formateur::all();
        $salles = Salle::all();
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
            $seances = Seance::where('groupe_id', $groupe_id)->with(['formateur', 'salle'])->get();
        }
        return view('admin.plannings.groupe', compact('groupes', 'seances', 'groupe_id'));
    }

    public function planningFormateur(Request $request) {
        $formateur_id = $request->get('formateur_id');
        $formateurs = Formateur::all();
        $seances = collect();
        if ($formateur_id) {
            $seances = Seance::where('formateur_id', $formateur_id)->with(['groupe', 'salle'])->get();
        }
        return view('admin.plannings.formateur', compact('formateurs', 'seances', 'formateur_id'));
    }

    public function planningSalle(Request $request) {
        $salle_id = $request->get('salle_id');
        $salles = Salle::all();
        $seances = collect();
        if ($salle_id) {
            $seances = Seance::where('salle_id', $salle_id)->with(['groupe', 'formateur'])->get();
        }
        return view('admin.plannings.salle', compact('salles', 'seances', 'salle_id'));
    }

    public function exportPdf(Request $request) {
        $type = $request->get('type');
        $id = $request->get('id');
        $seances = collect();
        $title = "Emploi du temps";

        if ($type == 'groupe') {
            $seances = Seance::where('groupe_id', $id)->with(['formateur', 'salle'])->get();
            $title .= " - Groupe " . Groupe::find($id)->code;
        } elseif ($type == 'formateur') {
            $seances = Seance::where('formateur_id', $id)->with(['groupe', 'salle'])->get();
            $title .= " - Formateur " . Formateur::find($id)->nomComplet;
        } elseif ($type == 'salle') {
            $seances = Seance::where('salle_id', $id)->with(['groupe', 'formateur'])->get();
            $title .= " - Salle " . Salle::find($id)->code;
        }

        $pdf = Pdf::loadView('pdf.planning', compact('seances', 'title', 'type'));
        return $pdf->download('planning.pdf');
    }
}
PHP,

    'PublicController.php' => <<<'PHP'
<?php
namespace App\Http\Controllers;
use App\Models\Filiere;
use App\Models\Groupe;
use App\Models\Seance;
use Illuminate\Http\Request;

class PublicController extends Controller {
    public function index() {
        $filieres = Filiere::all();
        $groupes = [];
        return view('public.index', compact('filieres', 'groupes'));
    }

    public function search(Request $request) {
        $filiere_id = $request->get('filiere_id');
        $groupe_id = $request->get('groupe_id');
        $filieres = Filiere::all();
        $groupes = $filiere_id ? Groupe::where('filiere_id', $filiere_id)->get() : [];
        $seances = $groupe_id ? Seance::where('groupe_id', $groupe_id)->with(['formateur', 'salle'])->get() : collect();
        
        return view('public.index', compact('filieres', 'groupes', 'seances', 'filiere_id', 'groupe_id'));
    }
}
PHP,

    'FormateurEspaceController.php' => <<<'PHP'
<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Seance;
use Illuminate\Support\Facades\Auth;

class FormateurEspaceController extends Controller {
    public function dashboard() {
        $user = Auth::user();
        $formateur = $user->formateur;
        $seances = collect();
        if ($formateur) {
            $seances = Seance::where('formateur_id', $formateur->id)->with(['groupe', 'salle'])->get();
        }
        return view('formateur.dashboard', compact('seances', 'formateur'));
    }
}
PHP
];

foreach($files as $name => $content) {
    file_put_contents($basePath . $name, $content);
}
echo "Controllers generated.\n";
