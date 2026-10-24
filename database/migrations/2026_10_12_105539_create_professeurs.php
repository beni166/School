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
        // professeurs
        Schema::create('professeurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->nullable()->unique();
            $table->string('telephone')->nullable();
            $table->timestamps();
        });

        // matieres
        Schema::create('matieres', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('nom')->unique();
            $table->timestamps();
        });

        // programmes_classes
        Schema::create('programmes_classes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('annee_scolaire_id')
                ->constrained('annees_scolaires');
            $table->foreignId('classe_id')->constrained('classes');
            $table->foreignId('matiere_id')->constrained('matieres');

            $table->decimal('coefficient', 5, 2)->default(1);
            $table->timestamps();

            $table->unique([
                'annee_scolaire_id',
                'classe_id',
                'matiere_id'
            ]);
        });

        // affectations_professeurs
        Schema::create('affectations_professeurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annee_scolaire_id')
                ->constrained('annees_scolaires');
            $table->foreignId('classe_id')->constrained('classes');
            $table->foreignId('matiere_id')->constrained('matieres');
            $table->foreignId('professeur_id')->constrained('professeurs');

            $table->timestamps();

            $table->unique([
                'annee_scolaire_id',
                'classe_id',
                'matiere_id',
                'professeur_id'
            ], 'aff_prof_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professeurs');
        Schema::dropIfExists('matieres');
        Schema::dropIfExists('programmes_classes');
        Schema::dropIfExists('affectations_professeurs');
    }
};
