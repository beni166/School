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
        Schema::create('decisions_scolaires', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inscription_id')
                ->constrained('inscriptions');

            $table->enum('decision', [
                'admis',
                'ajourne',
                'redoublement',
                'transfert'
            ]);

            $table->foreignId('classe_suivante_id')
                ->nullable()->constrained('classes')->nullOnDelete();

            $table->text('observation')->nullable();
            $table->timestamps();

            $table->unique('inscription_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('decisions_scolaires');
    }
};
