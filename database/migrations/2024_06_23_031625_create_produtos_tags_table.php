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
        Schema::create('produtos_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_tag');
            $table->unsignedBigInteger('fk_produto');

            $table->foreign('fk_tag')->references('id')->on('tags');
            $table->foreign('fk_produto')->references('id')->on('produtos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos_tags');
    }
};
