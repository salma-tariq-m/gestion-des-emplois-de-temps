<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Creation Utilisateur Admin
        User::firstOrCreate(
            ['email' => 'admin@ocmc.ma'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('cmc2026'),
                'role' => 'admin',
                'must_change_password' => false,
            ]
        );
    }
}
