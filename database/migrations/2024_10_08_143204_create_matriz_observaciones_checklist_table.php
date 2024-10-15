<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatrizObservacionesChecklistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriz_observaciones_checklist', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('status');
            $table->unsignedBigInteger('matriz_intervencion_checklist_id');
            $table->foreign('matriz_intervencion_checklist_id', 'fk_matriz_intervenciones_id')->references('id')->on('matriz_intervenciones_checklist');
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
        Schema::dropIfExists('matriz_observaciones_checklist');
    }
}
