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
            $table->integer('horas');
            $table->string('desde');
            $table->string('hasta');
            $table->string('total');
            $table->integer('metros');
            $table->integer('inclinacion');
            $table->integer('rumbo');
            $table->string('programa');
            $table->string('diametro');
            $table->integer('status');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
