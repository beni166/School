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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inscription_id')
                ->constrained('inscriptions');
            $table->foreignId('periode_id')->constrained('periodes');
            $table->foreignId('matiere_id')->constrained('matieres');

            $table->decimal('interrogation_1', 5, 2)->nullable();
            $table->decimal('interrogation_2', 5, 2)->nullable();
            $table->decimal('devoir', 5, 2)->nullable();
            $table->decimal('composition', 5, 2)->nullable();

            $table->timestamps();

            $table->unique([
                'inscription_id',
                'periode_id',
                'matiere_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
