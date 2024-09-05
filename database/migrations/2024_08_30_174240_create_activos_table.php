<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activos', function (Blueprint $table) {
            $table->id();
            $table->string('marca');
            $table->string('modelo');
            $table->string('patente');
            $table->string('numero_interno');
            $table->integer('year');
            $table->string('horometro');
            $table->integer('kilometraje');
            $table->string('color');
            $table->string('chasis');
            $table->string('numero_motor');
            $table->integer('status');
            $table->unsignedBigInteger('tipo_activo_id');
            $table->foreign('tipo_activo_id')->references('id')->on('tipo_activos');
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
        Schema::dropIfExists('activos');
    }
}
