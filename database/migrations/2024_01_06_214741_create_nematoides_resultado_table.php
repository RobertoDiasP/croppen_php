<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNematoidesResultadoTable extends Migration
{
    public function up()
    {
        Schema::create('nematoides_resultado', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resultado_id');
            $table->foreign('resultado_id')->references('id')->on('resultados')->onDelete('cascade');
            $table->unsignedBigInteger('nematode_id');
            $table->foreign('nematode_id')->references('id')->on('nematoides')->onDelete('cascade');
            $table->integer('quantidade');
            // Outros campos se necessário
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nematoides_resultado');
    }
}
