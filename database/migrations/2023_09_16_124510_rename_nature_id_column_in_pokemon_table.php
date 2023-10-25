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
        Schema::table('pokemons', function (Blueprint $table) {
            $table->renameColumn('nature id', 'nature_id');
            $table->renameColumn('race id', 'race_id');
            $table->renameColumn('ability id', 'ability_id');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pokemons', function (Blueprint $table) {
            $table->renameColumn('nature_id', 'nature id');
            $table->renameColumn('race_id', 'race id');
            $table->renameColumn('ability_id', 'ability id');
            //
        });
    }
};
