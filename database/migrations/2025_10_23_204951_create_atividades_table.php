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
        Schema::create('atividades', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('descricao') -> nullable();
            $table->date('data');           // YYYY-MM-DD
            $table->time('hora_inicio');    // HH:MM
            $table->time('hora_termino');

            $table->unsignedInteger('recorrencia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atividades');
    }
};
