<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoronaEscareadorReporteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corona_escareador_reporte', function (Blueprint $table) {
            $table->id();
            $table->string('detalle');
            $table->integer('desde');
            $table->integer('hasta');
            $table->integer('diametro');
            $table->integer('numero_corona');
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
        Schema::dropIfExists('corona_escareador_reporte');
    }
}
