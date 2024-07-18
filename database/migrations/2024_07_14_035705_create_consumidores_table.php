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
        Schema::create('consumidores', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 45);
            $table->unsignedBigInteger('fk_usuario');
            $table->char('cpf', 11);
            $table->string('telefone', 12);
            $table->string('genero', 45);
            $table->date('data_nascimento');
            $table->boolean('status')->default(true)->change();
            $table->dateTime('ultima_compra')->nullable();
            $table->unsignedBigInteger('fk_imagem')->nullable();

            $table->foreign('fk_usuario')->references('id')->on('users');
            $table->foreign('fk_imagem')->references('id')->on('imagens');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumidores');
    }
};
