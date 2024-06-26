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
        Schema::create('metodos_pagamento_aceitos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_estabelecimento');
            $table->unsignedBigInteger('fk_metodo_pagamento');
            
            $table->foreign('fk_estabelecimento')->references('id')->on('estabelecimentos');
            $table->foreign('fk_metodo_pagamento')->references('id')->on('metodos_pagamento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metodos_pagamento_aceitos');
    }
};
