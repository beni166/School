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
        Schema::table('decisions_scolaires', function (Blueprint $table) {
            $table->decimal('moyenne_annuelle', 5, 2)
                ->nullable()
                ->after('decision');
        });
    }

    public function down(): void
    {
        Schema::table('decisions_scolaires', function (Blueprint $table) {
            $table->dropColumn('moyenne_annuelle');
        });
    }
};
