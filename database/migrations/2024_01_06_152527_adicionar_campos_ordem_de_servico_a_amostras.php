<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdicionarCamposOrdemDeServicoAAmostras extends Migration
{
    public function up()
    {
        Schema::table('amostras', function (Blueprint $table) {
            $table->unsignedBigInteger('ordem_servico_id');
            $table->foreign('ordem_servico_id')->references('id')->on('ordem_servicos');
        });
    }

    public function down()
    {
        Schema::table('amostras', function (Blueprint $table) {
            $table->dropForeign(['ordem_servico_id']);
            $table->dropColumn('ordem_servico_id');
        });
    }
}
