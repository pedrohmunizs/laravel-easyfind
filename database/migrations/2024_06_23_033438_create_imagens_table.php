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
        Schema::create('imagens', function (Blueprint $table) {
            $table->id();
            $table->string('nome_referencia', 100);
            $table->string('nome_imagem', 45);
            $table->unsignedBigInteger('fk_estabelecimento')->nullable();
            $table->unsignedBigInteger('fk_produto')->nullable();
            $table->timestamps();
            
            $table->foreign('fk_estabelecimento')->references('id')->on('estabelecimentos');
            $table->foreign('fk_produto')->references('id')->on('produtos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagens');
    }
};
