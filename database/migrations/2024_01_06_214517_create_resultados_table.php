<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultadosTable extends Migration
{
    public function up()
    {
        Schema::create('resultados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('amostra_id');
            $table->foreign('amostra_id')->references('id')->on('amostras')->onDelete('cascade');
            // Outros campos do resultado
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('resultados');
    }
}
