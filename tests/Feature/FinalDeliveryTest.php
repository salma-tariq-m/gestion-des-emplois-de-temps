<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Groupe;
use App\Models\Formateur;
use App\Models\Salle;
use App\Models\Seance;
use App\Models\Filiere;

class FinalDeliveryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Setup base data
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->formateurUser = User::factory()->create(['role' => 'formateur']);
        
        $this->filiere = Filiere::create(['nom' => 'Test Filiere', 'niveau' => 1]);
        $this->groupe = Groupe::create(['code' => 'TEST101', 'filiere_id' => $this->filiere->id, 'annee' => 1]);
        $this->salle = Salle::create(['code' => 'SC-TEST', 'type' => 'Cours', 'capacite' => 30]);
        $this->formateur = Formateur::create([
            'user_id' => $this->formateurUser->id,
            'matricule' => 'F0001',
            'nom' => 'Test',
            'prenom' => 'Dev',
            'email' => 'dev.test@ofppt.ma',
            'specialite' => 'Informatique'
        ]);
        
        // Setup conflicting Seance
        $this->seance = Seance::create([
            'groupe_id' => $this->groupe->id,
            'formateur_id' => $this->formateur->id,
            'salle_id' => $this->salle->id,
            'jour' => 'Lundi',
            'creneau' => 1
        ]);
    }

    public function test_creation_dun_groupe_par_admin()
    {
        $response = $this->actingAs($this->admin)->post(route('groupes.store'), [
            'code' => 'NOUVEAU101',
            'filiere_id' => $this->filiere->id,
            'annee' => 1,
            'formateurs' => []
        ]);

        $response->assertRedirect(route('groupes.index'));
        $this->assertDatabaseHas('groupes', ['code' => 'NOUVEAU101']);
    }

    public function test_planification_seance_sans_conflit()
    {
        $response = $this->actingAs($this->admin)->post(route('seances.store'), [
            'groupe_id' => $this->groupe->id,
            'formateur_id' => $this->formateur->id,
            'salle_id' => $this->salle->id,
            'jour' => 'Mardi', // Jour différent
            'creneau' => 1
        ]);

        $response->assertRedirect(route('seances.index'));
        $this->assertDatabaseHas('seances', ['jour' => 'Mardi']);
    }

    public function test_blocage_seance_conflit_groupe_formateur_et_salle()
    {
        $response = $this->actingAs($this->admin)->post(route('seances.store'), [
            'groupe_id' => $this->groupe->id,
            'formateur_id' => $this->formateur->id,
            'salle_id' => $this->salle->id,
            'jour' => 'Lundi', // Même jour et créneau !
            'creneau' => 1
        ]);

        // Doit retourner des erreurs de validation spécifiques au groupe, formateur et salle
        $response->assertSessionHasErrors(['groupe_id', 'formateur_id', 'salle_id']);
    }

    public function test_acces_public_stagiaire_sans_authentification()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Pôle Digital & IA - Plannings');
    }

    public function test_blocage_formateur_sur_page_admin()
    {
        $response = $this->actingAs($this->formateurUser)->get(route('admin.dashboard'));
        $response->assertStatus(403); // Middleware check.role:admin doit bloquer
    }

    public function test_suppression_en_cascade_formateur_et_utilisateur()
    {
        $userId = $this->formateur->user_id;

        // La suppression depuis le controller supprime aussi l'user programmatiquement
        $this->actingAs($this->admin)->delete(route('formateurs.destroy', $this->formateur->id));

        $this->assertDatabaseMissing('formateurs', ['id' => $this->formateur->id]);
        $this->assertDatabaseMissing('users', ['id' => $userId]);
    }
}
