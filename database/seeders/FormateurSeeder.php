<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Formateur;

class FormateurSeeder extends Seeder
{
    public function run(): void
    {
        $formateursInfo = [ 
            ['nom' => 'Fretit',   'prenom' => 'Imane',  'spec' => 'Développement web'],
            ['nom' => 'Guelsa',   'prenom' => 'Mouna',  'spec' => 'Base de données'],
            ['nom' => 'Alami',    'prenom' => 'Sami',   'spec' => 'UI/UX'],
            ['nom' => 'Berrada',  'prenom' => 'Yasmine','spec' => 'Cybersécurité'],
            ['nom' => 'Mansouri', 'prenom' => 'Ahmed',  'spec' => 'IA & Data'],
            ['nom' => 'Tazi',     'prenom' => 'Houda',  'spec' => 'Développement Mobile'],
            ['nom' => 'Zaki',     'prenom' => 'Anas',   'spec' => 'Réseaux'],
            ['nom' => 'Idrissi',  'prenom' => 'Laila',  'spec' => 'Algorithmique'],
        ];

        foreach ($formateursInfo as $index => $info) {
            // Création de l'email automatique
            $email = strtolower($info['prenom'].'.'.$info['nom'].'@ofppt.ma');

            // Création ou récupération de l'utilisateur
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $info['prenom'] . ' ' . $info['nom'],
                    'password' => Hash::make($info['prenom'].'-'.$info['nom']), // Password par défaut
                    'role' => 'formateur',
                    'must_change_password' => true,
                ]
            );

            // Création ou récupération du formateur lié
            Formateur::firstOrCreate(
                ['matricule' => 'F'.str_pad($index + 1, 4, '0', STR_PAD_LEFT)],
                [
                    'user_id' => $user->id,
                    'nom' => $info['nom'],
                    'prenom' => $info['prenom'],
                    'email' => $email,
                    'telephone' => '06'.str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT), // Numéro aléatoire
                    'specialite' => $info['spec'],
                ]
            );
        }
    }
}