<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proyecto_id');
            $table->foreign('proyecto_id')->references('id')->on('proyectos');
            $table->string('empresa');
            $table->string('sondaje');
            $table->dateTime('fecha');
            $table->string('sonda');
            $table->string('turno');
            $table->string('horas');
            $table->string('desde');
            $table->string('hasta');
            $table->string('total');
            $table->string('metros');
            $table->string('inclinacion');
            $table->string('rumbo');
            $table->string('programa');
            $table->string('diametro');
            $table->integer('status');
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
        Schema::dropIfExists('reportes');
    }
}
