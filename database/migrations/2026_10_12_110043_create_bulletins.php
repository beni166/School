<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bulletins', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inscription_id')
                ->constrained('inscriptions')
                ->restrictOnDelete();

            $table->foreignId('periode_id')
                ->constrained('periodes')
                ->restrictOnDelete();

            // Instantanés historiques de l'élève
            $table->string('nom_eleve');
            $table->string('prenom_eleve');
            $table->string('classe_libelle');
            $table->string('annee_libelle');

            // Résultats généraux
            $table->decimal('moyenne_generale', 5, 2)->nullable();
            $table->unsignedInteger('rang')->nullable();
            $table->text('appreciation_generale')->nullable();

            // État du bulletin
            $table->enum('statut', [
                'brouillon',
                'valide',
            ])->default('brouillon');

            $table->timestamp('valide_le')->nullable();

            $table->timestamps();

            // Un bulletin par inscription et par période
            $table->unique(
                ['inscription_id', 'periode_id'],
                'bulletins_inscription_periode_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bulletins');
    }
};