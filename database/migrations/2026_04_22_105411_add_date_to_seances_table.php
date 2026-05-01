<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Désactiver complètement les foreign keys
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('SET unique_checks=0');

        // Ajouter la colonne date
        if (!Schema::hasColumn('seances', 'date')) {
            Schema::table('seances', function (Blueprint $table) {
                $table->date('date')->after('salle_id')->nullable();
            });
        }

        // Supprimer les anciens index directement via SQL brut
        try { DB::statement('DROP INDEX unq_groupe_jour_creneau ON seances'); } catch (\Exception $e) {}
        try { DB::statement('DROP INDEX unq_formateur_jour_creneau ON seances'); } catch (\Exception $e) {}
        try { DB::statement('DROP INDEX unq_salle_jour_creneau ON seances'); } catch (\Exception $e) {}

        // Ajouter les nouveaux index
        try { DB::statement('CREATE UNIQUE INDEX unq_groupe_date_creneau ON seances (groupe_id, date, creneau)'); } catch (\Exception $e) {}
        try { DB::statement('CREATE UNIQUE INDEX unq_formateur_date_creneau ON seances (formateur_id, date, creneau)'); } catch (\Exception $e) {}
        try { DB::statement('CREATE UNIQUE INDEX unq_salle_date_creneau ON seances (salle_id, date, creneau)'); } catch (\Exception $e) {}

        // Réactiver
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        DB::statement('SET unique_checks=1');
    }

    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        try { DB::statement('DROP INDEX unq_groupe_date_creneau ON seances'); } catch (\Exception $e) {}
        try { DB::statement('DROP INDEX unq_formateur_date_creneau ON seances'); } catch (\Exception $e) {}
        try { DB::statement('DROP INDEX unq_salle_date_creneau ON seances'); } catch (\Exception $e) {}

        try { DB::statement('CREATE UNIQUE INDEX unq_groupe_jour_creneau ON seances (groupe_id, jour, creneau)'); } catch (\Exception $e) {}
        try { DB::statement('CREATE UNIQUE INDEX unq_formateur_jour_creneau ON seances (formateur_id, jour, creneau)'); } catch (\Exception $e) {}
        try { DB::statement('CREATE UNIQUE INDEX unq_salle_jour_creneau ON seances (salle_id, jour, creneau)'); } catch (\Exception $e) {}

        Schema::table('seances', function (Blueprint $table) {
            if (Schema::hasColumn('seances', 'date')) {
                $table->dropColumn('date');
            }
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};