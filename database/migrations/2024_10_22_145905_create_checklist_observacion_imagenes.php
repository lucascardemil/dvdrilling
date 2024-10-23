<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistObservacionImagenes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklist_observacion_imagenes', function (Blueprint $table) {
            $table->id();
            $table->string('imagen');
            $table->unsignedBigInteger('checklist_observacion_id');
            $table->foreign('checklist_observacion_id')->references('id')->on('checklist_observaciones');
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
        Schema::dropIfExists('checklist_observacion_imagenes');
    }
}
