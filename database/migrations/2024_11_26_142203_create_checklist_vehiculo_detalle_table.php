<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistVehiculoDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklist_vehiculo_detalle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checklist_vehiculo_id');
            $table->foreign('checklist_vehiculo_id')->references('id')->on('checklist_vehiculo');
            $table->integer('status');
            $table->string('conductor')->nullable();
            $table->integer('kilometraje_inicial')->nullable();
            $table->integer('kilometraje_final')->nullable();
            $table->integer('horometro_inicial')->nullable();
            $table->integer('horometro_final')->nullable();
            $table->string('numero_interno')->nullable();
            $table->string('proyecto')->nullable();
            $table->string('faena')->nullable();
            $table->string('turno')->nullable();
            $table->integer('litros')->nullable();
            $table->string('observacion_bitacora')->nullable();
            $table->boolean('carga_combustible')->default(false);
            $table->boolean('estado_equipo')->default(false);
            $table->string('imagen_combustible')->nullable();
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
        Schema::dropIfExists('checklist_vehiculo_detalle');
    }
}
