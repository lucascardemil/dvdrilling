<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistIntervencionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklist_intervenciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('status');
            $table->unsignedBigInteger('checklist_categoria_id');
            $table->foreign('checklist_categoria_id')->references('id')->on('checklist_categorias');
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
        Schema::dropIfExists('checklist_intervenciones');
    }
}
