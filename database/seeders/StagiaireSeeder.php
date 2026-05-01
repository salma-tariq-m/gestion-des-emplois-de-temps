<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Stagiaire;
use App\Models\Groupe;

class StagiaireSeeder extends Seeder
{
    public function run(): void
    {
        $stagiairesData = [
            ['name' => 'Lmadani Lfqih', 'email' => 'lmadani@ofppt.ma'],
            ['name' => 'Laarbi boulmani', 'email' => 'laarbi@ofppt.ma'],
        ];

        $groupe = Groupe::first();

        foreach ($stagiairesData as $sd) {
            $user = User::firstOrCreate(
                ['email' => $sd['email']],
                [
                    'name' => $sd['name'],
                    'password' => Hash::make($sd['name']. "-cmc2023"),
                    'role' => 'stagiaire'
                ]
            );

            if ($groupe) {
                Stagiaire::firstOrCreate(
                    ['user_id' => $user->id],
                    ['groupe_id' => $groupe->id]
                );
            }
        }
    }
}
