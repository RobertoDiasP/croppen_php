<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrcamentoidTable extends Migration
{
    public function up()
    {
        Schema::create('orcamentoid', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('orcamento_id');
            $table->foreign('orcamento_id')->references('id')->on('orcamento');
            // Adicione outras colunas conforme necessário
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orcamentoid');
    }
}
