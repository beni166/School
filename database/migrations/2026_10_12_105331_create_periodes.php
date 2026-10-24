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
        Schema::create('periodes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('annee_scolaire_id')
                ->constrained('annees_scolaires');

            $table->enum('type', ['trimestre', 'semestre']);
            $table->unsignedTinyInteger('numero');
            $table->string('libelle'); // 1er trimestre, 2e semestre...
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->boolean('cloturee')->default(false);
            $table->timestamps();

            $table->unique([
                'annee_scolaire_id',
                'type',
                'numero'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodes');
    }
};
