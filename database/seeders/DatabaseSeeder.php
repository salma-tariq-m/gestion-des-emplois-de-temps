<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            FiliereSeeder::class,
            SalleSeeder::class,
            FormateurSeeder::class,
            GroupeSeeder::class,
            SeanceSeeder::class,
            StagiaireSeeder::class,
        ]);
    }
}
