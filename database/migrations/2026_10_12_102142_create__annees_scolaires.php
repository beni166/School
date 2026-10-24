<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // annees_scolaires
        Schema::create('annees_scolaires', function (Blueprint $table) {
            $table->id();
            $table->string('libelle', 20)->unique(); // 2026-2027
            $table->date('date_debut');
            $table->date('date_fin');
            $table->boolean('active')->default(false);
            $table->timestamps();
        });

        // cycles
        Schema::create('cycles', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique(); // Collège, Lycée
            $table->timestamps();
        });

        // niveaux
        Schema::create('niveaux', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cycle_id')->constrained('cycles');
            $table->string('nom'); // 6e, 5e, Terminale...
            $table->unsignedSmallInteger('ordre');
            $table->timestamps();

            $table->unique(['cycle_id', 'nom']);
        });

        // classes
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('niveau_id')->constrained('niveaux');
            $table->string('nom'); // A, B, C...
            $table->timestamps();

            $table->unique(['niveau_id', 'nom']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
        Schema::dropIfExists('niveaux');
        Schema::dropIfExists('cycles');
        Schema::dropIfExists('annees_scolaires');
    }
};
