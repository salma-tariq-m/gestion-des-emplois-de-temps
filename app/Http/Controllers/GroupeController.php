<?php
namespace App\Http\Controllers;
use App\Models\Groupe;
use App\Models\Filiere;
use App\Models\Formateur;
use Illuminate\Http\Request;

use App\Http\Requests\StoreGroupeRequest;

class GroupeController extends Controller {
    public function index() {
        $groupes = Groupe::with('filiere')->get();
        return view('admin.groupes.index', compact('groupes'));
    }
    public function create() {
        $filieres = Filiere::all();
        return view('admin.groupes.create', compact('filieres'));
    }
    public function store(StoreGroupeRequest $request) {
        $data = $request->validated();
        $groupe = Groupe::create($data);
        return redirect()->route('groupes.index')->with('success', 'Groupe créé.');
    }
    public function edit(Groupe $groupe) {
        $filieres = Filiere::all();
        return view('admin.groupes.edit', compact('groupe', 'filieres'));
    }
    public function update(StoreGroupeRequest $request, Groupe $groupe) {
        $data = $request->validated();
        $groupe->update($data);
        return redirect()->route('groupes.index')->with('success', 'Groupe modifié.');
    }
    public function destroy(Groupe $groupe) {
        $groupe->delete();
        return redirect()->route('groupes.index')->with('success', 'Groupe supprimé.');
    }
}