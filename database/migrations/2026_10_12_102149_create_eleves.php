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
        // eleves
        Schema::create('eleves', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->enum('sexe', ['M', 'F']);
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->text('adresse')->nullable();
            $table->string('telephone_tuteur')->nullable();
            $table->timestamps();
        });

        // inscriptions
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eleve_id')->constrained('eleves');
            $table->foreignId('annee_scolaire_id')
                ->constrained('annees_scolaires');
            $table->foreignId('classe_id')->constrained('classes');

            $table->string('numero_inscription')->unique();
            $table->date('date_inscription');
            $table->enum('statut', [
                'inscrit',
                'transfere',
                'abandon',
                'termine'
            ])->default('inscrit');

            $table->timestamps();

            $table->unique(['eleve_id', 'annee_scolaire_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eleves');
        Schema::dropIfExists('inscriptions');
    }
};
