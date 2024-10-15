<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntervencionesChecklistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intervenciones_checklist', function (Blueprint $table) {
            $table->id();
            $table->integer('status');
            $table->unsignedBigInteger('checklist_id');
            $table->foreign('checklist_id')->references('id')->on('checklist');
            $table->unsignedBigInteger('matriz_categorias_checklist_id');
            $table->foreign('matriz_categorias_checklist_id')->references('id')->on('matriz_categorias_checklist');
            $table->unsignedBigInteger('matriz_intervencion_checklist_id');
            $table->foreign('matriz_intervencion_checklist_id', 'fk_checklist_intervenciones_id')->references('id')->on('matriz_intervenciones_checklist');
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
        Schema::dropIfExists('intervenciones_checklist');
    }
}
