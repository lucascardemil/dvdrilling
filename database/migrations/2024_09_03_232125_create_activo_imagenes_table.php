<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivoImagenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activo_imagenes', function (Blueprint $table) {
            $table->id();
            $table->string('ruta');
            $table->integer('status');
            $table->unsignedBigInteger('activo_id');
            $table->foreign('activo_id')->references('id')->on('activos');
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
        Schema::dropIfExists('activo_imagenes');
    }
}
