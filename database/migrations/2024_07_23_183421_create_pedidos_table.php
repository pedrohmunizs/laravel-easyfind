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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('status',45);
            $table->unsignedBigInteger('fk_metodo_aceito');
            $table->boolean('is_pagamento_online');
            $table->timestamps();

            $table->foreign('fk_metodo_aceito')->references('id')->on('bandeiras_metodos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
