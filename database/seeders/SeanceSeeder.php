<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seance;
use App\Models\Groupe;
use App\Models\Formateur;
use App\Models\Salle;

class SeanceSeeder extends Seeder
{
    public function run(): void
    {
        $groupes = Groupe::all();
        $formateurs = Formateur::all();
        $salles = Salle::all();

        if ($groupes->count() > 2 && $formateurs->count() > 5 && $salles->count() > 7) {
            // DEV101 - Lundi Créneau 1 - Formateur Dev - Salle SM-01
            Seance::firstOrCreate(
                ['groupe_id' => $groupes[0]->id, 'jour' => 'Lundi', 'creneau' => 1],
                ['formateur_id' => $formateurs[0]->id, 'salle_id' => $salles[6]->id]
            );
            // DEV101 - Lundi Créneau 2 - Formateur BD - Salle SM-01
            Seance::firstOrCreate(
                ['groupe_id' => $groupes[0]->id, 'jour' => 'Lundi', 'creneau' => 2],
                ['formateur_id' => $formateurs[1]->id, 'salle_id' => $salles[6]->id]
            );
            // DEVOWFS201 - Lundi Créneau 1 - Formateur Mobile - Salle SM-02
            Seance::firstOrCreate(
                ['groupe_id' => $groupes[2]->id, 'jour' => 'Lundi', 'creneau' => 1],
                ['formateur_id' => $formateurs[5]->id, 'salle_id' => $salles[7]->id]
            );
        }
    }
}
