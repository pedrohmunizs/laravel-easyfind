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
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->char('cep', 8);
            $table->string('logradouro', 45);
            $table->string('bairro', 45);
            $table->string('numero', 10);
            $table->decimal('latitude', 17, 15)->nullable();
            $table->decimal('longitude', 17, 15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enderecos');
    }
};
