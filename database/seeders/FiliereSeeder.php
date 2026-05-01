<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Filiere;

class FiliereSeeder extends Seeder
{
    public function run(): void
    {
        $filieresData = [
            // 1ère année
            ['nom' => 'Digital Design', 'niveau' => 1, 'option' => null],
            ['nom' => 'Développement Digital', 'niveau' => 1, 'option' => null],
            ['nom' => 'Intelligence Artificielle', 'niveau' => 1, 'option' => null],
            ['nom' => 'Infrastructure Digitale', 'niveau' => 1, 'option' => null],
            // 2ème année
            ['nom' => 'Digital Design', 'niveau' => 2, 'option' => 'UI Designer'],
            ['nom' => 'Digital Design', 'niveau' => 2, 'option' => 'UX Designer'],
            ['nom' => 'Développement Digital', 'niveau' => 2, 'option' => 'Applications Mobiles'],
            ['nom' => 'Développement Digital', 'niveau' => 2, 'option' => 'Web Full Stack'],
            ['nom' => 'Intelligence Artificielle', 'niveau' => 2, 'option' => 'Assistant Data Analyst'],
            ['nom' => 'Intelligence Artificielle', 'niveau' => 2, 'option' => 'Développeur Chatbots'],
            ['nom' => 'Infrastructure Digitale', 'niveau' => 2, 'option' => 'Cyber sécurité'],
            ['nom' => 'Infrastructure Digitale', 'niveau' => 2, 'option' => 'Systèmes et Réseaux'],
        ];

        foreach ($filieresData as $data) {
            Filiere::firstOrCreate(
                ['nom' => $data['nom'], 'niveau' => $data['niveau'], 'option' => $data['option']],
                $data
            );
        }
    }
}
