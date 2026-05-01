<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Salle;

class SalleSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 6; $i++) {
            Salle::firstOrCreate(
                ['code' => 'SC-0' . $i],
                ['type' => 'Salle de cours', 'capacite' => 20]
            );
        }
        for ($i = 1; $i <= 10; $i++) {
            $code = $i < 10 ? 'SM-0' . $i : 'SM-10';
            Salle::firstOrCreate(
                ['code' => $code],
                ['type' => 'Salle Multimédia', 'capacite' => 20]
            );
        }
    }
}
