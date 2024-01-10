<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposToOrcamentoidTable extends Migration
{
    public function up()
    {
        Schema::table('orcamentoid', function (Blueprint $table) {
            $table->string('descricao')->nullable();
            $table->decimal('valor', 10, 2);
            // Adicione outros campos conforme necessário
        });
    }

    public function down()
    {
        Schema::table('orcamentoid', function (Blueprint $table) {
            $table->dropColumn('descricao');
            $table->dropColumn('valor');
            
            // Remova outros campos conforme necessário
        });
    }
}
