<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formateur_groupe', function (Blueprint $table) {
            $table->foreignId('formateur_id')->constrained('formateurs')->onDelete('cascade');
            $table->foreignId('groupe_id')->constrained('groupes')->onDelete('cascade');
            $table->primary(['formateur_id', 'groupe_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formateur_groupe');
    }
};
