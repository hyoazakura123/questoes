<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alternativas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('questao_id')
                  ->constrained('questoes')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->text('texto');
            $table->boolean('correta')->default(false);
            $table->text('comentario')->nullable();
            $table->timestamps();
        });

        // Garantia de apenas uma alternativa correta por questão (MySQL / PostgreSQL)
        DB::statement("
            CREATE UNIQUE INDEX unica_alternativa_correta
            ON alternativas (questao_id)
            WHERE correta = true
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('alternativas');
    }
};
