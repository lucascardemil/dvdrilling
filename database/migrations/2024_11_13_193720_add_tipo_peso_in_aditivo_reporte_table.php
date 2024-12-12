<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoPesoInAditivoReporteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aditivo_reporte', function (Blueprint $table) {
            $table->string('tipo_peso')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aditivo_reporte', function (Blueprint $table) {
            $table->dropColumn('tipo_peso');
        });
    }
}
