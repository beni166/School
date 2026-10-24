<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bulletin_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('bulletin_id')
                ->constrained('bulletins')
                ->cascadeOnDelete();

            // Relations avec les données sources
            $table->foreignId('note_id')
                ->nullable()
                ->constrained('notes')
                ->nullOnDelete();

            $table->foreignId('matiere_id')
                ->nullable()
                ->constrained('matieres')
                ->nullOnDelete();

            $table->foreignId('professeur_id')
                ->nullable()
                ->constrained('professeurs')
                ->nullOnDelete();

            // Instantanés historiques
            $table->string('matiere_libelle');
            $table->string('professeur_libelle')->nullable();

            // Notes récupérées depuis la table notes
            $table->decimal('interrogation_1', 5, 2)->nullable();
            $table->decimal('interrogation_2', 5, 2)->nullable();
            $table->decimal('devoir', 5, 2)->nullable();
            $table->decimal('composition', 5, 2)->nullable();

            // Coefficient et résultats calculés
            $table->decimal('coefficient', 5, 2);
            $table->decimal('moyenne_matiere', 5, 2)->nullable();
            $table->decimal('points_coefficientes', 7, 2)->nullable();

            $table->unsignedInteger('rang_matiere')->nullable();
            $table->text('appreciation')->nullable();

            $table->timestamps();

            // Une seule ligne par matière et par bulletin
            $table->unique(
                ['bulletin_id', 'matiere_libelle'],
                'bulletin_details_matiere_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bulletin_details');
    }
};