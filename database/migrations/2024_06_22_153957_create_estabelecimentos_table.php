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
        Schema::create('estabelecimentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 45);
            $table->string('segmento', 45);
            $table->boolean('is_ativo');
            $table->string('telefone', 12);
            $table->string('email', 75);
            $table->string('enquadramento_juridico', 45);
            $table->string('url_instagram')->nullable();
            $table->string('url_facebook')->nullable();
            $table->unsignedBigInteger('fk_comerciante');
            $table->unsignedBigInteger('fk_endereco');
            $table->timestamps();
            
            $table->foreign('fk_comerciante')->references('id')->on('comerciantes');
            $table->foreign('fk_endereco')->references('id')->on('enderecos');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estabelecimentos');
    }
};
