<?php

namespace Tests\Feature;

use App\Models\Formateur;
use App\Models\Groupe;
use App\Models\Salle;
use App\Models\Seance;
use App\Models\User;
use App\Models\Filiere;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeanceConflictTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $filiere;
    protected $groupe;
    protected $formateur;
    protected $salle;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        $this->filiere = Filiere::create(['nom' => 'Test Filiere', 'niveau' => 1]);
        $this->groupe = Groupe::create(['code' => 'G1', 'filiere_id' => $this->filiere->id, 'annee' => 1]);
        $this->formateur = Formateur::create([
            'matricule' => 'F1',
            'nom' => 'Nom',
            'prenom' => 'Prenom',
            'email' => 'f1@test.com',
            'specialite' => 'Spec'
        ]);
        $this->salle = Salle::create(['code' => 'S1']);
    }

    public function test_can_create_seance_without_conflict()
    {
        $response = $this->actingAs($this->admin)->post(route('seances.store'), [
            'groupe_id' => $this->groupe->id,
            'formateur_id' => $this->formateur->id,
            'salle_id' => $this->salle->id,
            'date' => '2026-04-20',
            'creneau' => 1
        ]);

        $response->assertRedirect(route('seances.index'));
        $this->assertDatabaseHas('seances', ['creneau' => 1, 'date' => '2026-04-20 00:00:00']);
    }

    public function test_cannot_create_seance_with_formateur_conflict()
    {
        // Créer une première séance
        Seance::create([
            'groupe_id' => $this->groupe->id,
            'formateur_id' => $this->formateur->id,
            'salle_id' => $this->salle->id,
            'date' => '2026-04-20',
            'creneau' => 1
        ]);

        // Essayer d'en créer une autre avec le même formateur
        $groupe2 = Groupe::create(['code' => 'G2', 'filiere_id' => $this->filiere->id, 'annee' => 1]);
        $salle2 = Salle::create(['code' => 'S2']);

        $response = $this->actingAs($this->admin)->post(route('seances.store'), [
            'groupe_id' => $groupe2->id,
            'formateur_id' => $this->formateur->id,
            'salle_id' => $salle2->id,
            'date' => '2026-04-20',
            'creneau' => 1
        ]);

        $response->assertSessionHasErrors('formateur_id');
    }

    public function test_cannot_create_seance_with_salle_conflict()
    {
        // Créer une première séance
        Seance::create([
            'groupe_id' => $this->groupe->id,
            'formateur_id' => $this->formateur->id,
            'salle_id' => $this->salle->id,
            'date' => '2026-04-20',
            'creneau' => 1
        ]);

        // Essayer d'en créer une autre avec la même salle
        $formateur2 = Formateur::create([
            'matricule' => 'F2',
            'nom' => 'N2',
            'prenom' => 'P2',
            'email' => 'f2@test.com',
            'specialite' => 'S2'
        ]);
        $groupe2 = Groupe::create(['code' => 'G2', 'filiere_id' => $this->filiere->id, 'annee' => 1]);

        $response = $this->actingAs($this->admin)->post(route('seances.store'), [
            'groupe_id' => $groupe2->id,
            'formateur_id' => $formateur2->id,
            'salle_id' => $this->salle->id,
            'date' => '2026-04-20',
            'creneau' => 1
        ]);

        $response->assertSessionHasErrors('salle_id');
    }
}

