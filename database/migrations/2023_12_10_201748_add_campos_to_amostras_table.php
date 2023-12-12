<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposToAmostrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('amostras', function (Blueprint $table) {
            $table->date('updated_at')->nullable();
            $table->date('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('amostras', function (Blueprint $table) {
            $table->dropColumn('updated_at');
            $table->dropColumn('created_at');
        });
    }
}
