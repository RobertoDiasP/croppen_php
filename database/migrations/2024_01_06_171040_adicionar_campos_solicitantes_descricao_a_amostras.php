<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdicionarCamposSolicitantesDescricaoAAmostras extends Migration
{
    public function up()
    {
        Schema::table('amostras', function (Blueprint $table) {
            $table->string('solicitantes')->nullable();
            $table->text('descricao')->nullable();
        });
    }

    public function down()
    {
        Schema::table('amostras', function (Blueprint $table) {
            $table->dropColumn('solicitantes');
            $table->dropColumn('descricao');
        });
    }
}
