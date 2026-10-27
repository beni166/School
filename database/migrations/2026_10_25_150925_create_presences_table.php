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
        Schema::create('presences', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inscription_id')
                ->constrained('inscriptions')
                ->restrictOnDelete();

            $table->date('date_presence');

            $table->enum('statut', ['present','absent','retard','absence_justifiee',])->default('present');
            $table->time('heure_arrivee')->nullable();
            $table->text('motif')->nullable();
            // Utilisateur qui effectue l'appel, si connecté.
            $table->foreignId('enregistre_par') ->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            // Un seul enregistrement par inscription et par jour.
            $table->unique(
                ['inscription_id', 'date_presence'],
                'presences_inscription_date_unique'
            );

            $table->index(['date_presence', 'statut']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
