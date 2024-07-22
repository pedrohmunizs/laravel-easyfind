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
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->integer('qtd_estrela');
            $table->string('comentario', 255)->nullable();
            $table->unsignedBigInteger('fk_consumidor');
            $table->unsignedBigInteger('fk_produto');
            $table->timestamps();

            $table->foreign('fk_consumidor')->references('id')->on('consumidores');
            $table->foreign('fk_produto')->references('id')->on('produtos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacoes');
    }
};
