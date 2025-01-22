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
        Schema::create('trechos', function (Blueprint $table) {
            $table->id();
            $table->date('data_referencia');
            $table->float('km_inicial');
            $table->float('km_final');
            $table->string('tipo');
            $table->json('geo');
            $table->foreignId('uf_id')->nullable()->references('id')->on('ufs');
            $table->foreignId('rodovia_id')->nullable()->references('id')->on('rodovias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trechos');
    }
};
