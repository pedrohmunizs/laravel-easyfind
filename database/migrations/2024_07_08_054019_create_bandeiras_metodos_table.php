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
        Schema::create('bandeiras_metodos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_metodo_pagamento');
            $table->unsignedBigInteger('fk_bandeira_pagamento');
            
            $table->foreign('fk_bandeira_pagamento')->references('id')->on('bandeiras_pagamento');
            $table->foreign('fk_metodo_pagamento')->references('id')->on('metodos_pagamento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bandeiras_metodos');
    }
};
