<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatrizChecklistIntervencionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriz_checklist_intervenciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('status');
            $table->unsignedBigInteger('matriz_checklist_categoria_id');
            $table->foreign('matriz_checklist_categoria_id', 'fk_matriz_categoria_id')->references('id')->on('matriz_checklist_categorias');
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
        Schema::dropIfExists('matriz_checklist_intervenciones');
    }
}
