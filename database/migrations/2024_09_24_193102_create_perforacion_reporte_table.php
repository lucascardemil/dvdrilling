<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerforacionReporteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perforacion_reporte', function (Blueprint $table) {
            $table->id();
            $table->double('desde');
            $table->double('hasta');
            $table->double('perforado');
            $table->double('recuperado');
            $table->double('porcentaje');
            $table->double('numero_cajas');
            $table->integer('status');
            $table->unsignedBigInteger('reporte_id');
            $table->foreign('reporte_id')->references('id')->on('reportes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perforacion_reporte');
    }
}
