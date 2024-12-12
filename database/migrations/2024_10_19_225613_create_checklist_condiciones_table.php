<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistCondicionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklist_condiciones', function (Blueprint $table) {
            $table->id();
            $table->boolean('existe');
            $table->integer('estado')->nullable();
            $table->string('observacion');
            $table->integer('status');
            $table->unsignedBigInteger('checklist_intervencion_id');
            $table->foreign('checklist_intervencion_id')->references('id')->on('checklist_intervenciones');
            $table->unsignedBigInteger('checklist_vehiculo_id');
            $table->foreign('checklist_vehiculo_id')->references('id')->on('checklist_vehiculo');
            $table->unsignedBigInteger('checklist_vehiculo_detalle_id');
            $table->foreign('checklist_vehiculo_detalle_id')->references('id')->on('checklist_vehiculo_detalle');
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
        Schema::dropIfExists('checklist_condiciones');
    }
}
