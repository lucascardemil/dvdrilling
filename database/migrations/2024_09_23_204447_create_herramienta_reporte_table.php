<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHerramientaReporteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('herramienta_reporte', function (Blueprint $table) {
            $table->id();
            $table->double('barras_3');
            $table->double('barras_3_5');
            $table->double('barril');
            $table->double('total_barril');
            $table->double('muerto');
            $table->double('contra');
            $table->double('f_inicio');
            $table->double('f_termino');
            $table->double('recuperacion');
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
        Schema::dropIfExists('herramienta_reporte');
    }
}
