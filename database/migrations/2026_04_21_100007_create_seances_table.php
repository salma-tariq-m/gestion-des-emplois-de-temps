<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('groupe_id')->constrained('groupes')->onDelete('cascade');
            $table->foreignId('formateur_id')->constrained('formateurs')->onDelete('cascade');
            $table->foreignId('salle_id')->constrained('salles')->onDelete('cascade');
            $table->string('jour'); // Lundi, Mardi, Mercredi, Jeudi, Vendredi, Samedi
            $table->integer('creneau'); // 1, 2, 3, 4
            $table->timestamps();

            // Règles de non-conflit applicatives et base de données !
            $table->unique(['groupe_id', 'jour', 'creneau'], 'unq_groupe_jour_creneau');
            $table->unique(['formateur_id', 'jour', 'creneau'], 'unq_formateur_jour_creneau');
            $table->unique(['salle_id', 'jour', 'creneau'], 'unq_salle_jour_creneau');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seances');
    }
};
