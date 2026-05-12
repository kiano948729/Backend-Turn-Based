<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('class_spell', function (Blueprint $table) {

            $table->foreignId('game_class_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('spell_id')
                ->constrained()
                ->onDelete('cascade');

            $table->primary([
                'game_class_id',
                'spell_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_spell');
    }
};
