<?php
namespace App\Http\Controllers;
use App\Models\Salle;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSalleRequest;

class SalleController extends Controller {
    public function index() {
        $salles = Salle::all();
        return view('admin.salles.index', compact('salles'));
    }
    public function create() {
        return view('admin.salles.create');
    }
    public function store(StoreSalleRequest $request) {
        Salle::create($request->validated());
        return redirect()->route('salles.index')->with('success', 'Salle créée.');
    }
    public function edit(Salle $salle) {
        return view('admin.salles.edit', compact('salle'));
    }
    public function update(StoreSalleRequest $request, Salle $salle) {
        $salle->update($request->validated());
        return redirect()->route('salles.index')->with('success', 'Salle modifiée.');
    }
    public function destroy(Salle $salle) {
        $salle->delete();
        return redirect()->route('salles.index')->with('success', 'Salle supprimée.');
    }
}