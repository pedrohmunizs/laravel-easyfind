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
        Schema::create('comerciantes', function (Blueprint $table) {
            $table->id();
            $table->char('cnpj', 14);
            $table->char('cpf', 11);
            $table->string('telefone', 12);
            $table->unsignedBigInteger('fk_usuario');
            $table->string('razao_social');
            $table->unsignedBigInteger('fk_endereco');
            
            $table->foreign('fk_usuario')->references('id')->on('users');
            $table->foreign('fk_endereco')->references('id')->on('enderecos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comerciantes');
    }
};
