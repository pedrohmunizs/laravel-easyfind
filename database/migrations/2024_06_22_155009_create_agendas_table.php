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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->time('horario_inicio');
            $table->time('horario_fim');
            $table->string('dia', 45);
            $table->unsignedBigInteger('fk_estabelecimento');

            $table->foreign('fk_estabelecimento')->references('id')->on('estabelecimentos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
