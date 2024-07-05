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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 45);
            $table->string('codigo_sku', 45);
            $table->decimal('preco', total:6, places:2);
            $table->string('descricao', 100);
            $table->decimal('preco_oferta', total:6, places:2);
            $table->char('codigo_barras', 13);
            $table->string('categoria', 45);
            $table->unsignedBigInteger('fk_secao');
            $table->boolean('is_ativo');
            $table->boolean('is_promocao_ativa');
            $table->integer('qtd_vendas')->nullable();

            $table->foreign('fk_secao')->references('id')->on('secoes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
