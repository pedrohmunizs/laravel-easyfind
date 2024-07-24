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
        Schema::create('itens_venda', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('fk_consumidor');
            $table->unsignedBigInteger('fk_pedido');
            $table->unsignedBigInteger('fk_produto');
            $table->integer('quantidade');
            $table->decimal('valor', 6, 2);
            $table->boolean('is_promocao_ativa');

            $table->foreign('fk_consumidor')->references('id')->on('consumidores');
            $table->foreign('fk_pedido')->references('id')->on('pedidos');
            $table->foreign('fk_produto')->references('id')->on('produtos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens_venda');
    }
};
