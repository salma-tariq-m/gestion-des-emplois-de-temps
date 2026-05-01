<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Groupe;
use App\Models\Filiere;
use App\Models\Formateur;

class GroupeSeeder extends Seeder
{
    public function run(): void
    {
        $groupesData = [
            // Développement Digital (Année 1)
            ['code' => 'DEV101', 'filiere_nom' => 'Développement Digital', 'niveau' => 1, 'option' => null],
            ['code' => 'DEV102', 'filiere_nom' => 'Développement Digital', 'niveau' => 1, 'option' => null],
            ['code' => 'DEV103', 'filiere_nom' => 'Développement Digital', 'niveau' => 1, 'option' => null],

            // Développement Digital (Année 2 - Full Stack)
            ['code' => 'WFS201', 'filiere_nom' => 'Développement Digital', 'niveau' => 2, 'option' => 'Web Full Stack'],
            ['code' => 'WFS202', 'filiere_nom' => 'Développement Digital', 'niveau' => 2, 'option' => 'Web Full Stack'],

            // Développement Digital (Année 2 - Mobile)
            ['code' => 'AM201', 'filiere_nom' => 'Développement Digital', 'niveau' => 2, 'option' => 'Applications Mobiles'],

            // Infrastructure Digitale
            ['code' => 'ID101', 'filiere_nom' => 'Infrastructure Digitale', 'niveau' => 1, 'option' => null],
            ['code' => 'CS201', 'filiere_nom' => 'Infrastructure Digitale', 'niveau' => 2, 'option' => 'Cybersécurité'],
        ];

        $formateurs = Formateur::all();

        foreach ($groupesData as $gd) {
            // Recheche de la filière correspondante
            $filiere = Filiere::where('nom', $gd['filiere_nom'])
                             ->where('niveau', $gd['niveau'])
                             ->where('option', $gd['option'])
                             ->first();
                             
            if ($filiere) {
                // Création du groupe
                $groupe = Groupe::firstOrCreate(
                    ['code' => $gd['code']],
                    [
                        'filiere_id' => $filiere->id,
                        'annee' => $gd['niveau']
                    ]
                );
                
                // Attacher 2 formateurs au hasard pour chaque groupe (Pivot table)
                if ($formateurs->isNotEmpty()) {
                    $randomFormateurs = $formateurs->random(min(2, $formateurs->count()))->pluck('id')->toArray();
                    $groupe->formateurs()->syncWithoutDetaching($randomFormateurs);
                }
            }
        }
    }
}