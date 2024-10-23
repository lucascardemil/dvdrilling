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
            $table->integer('estado');
            $table->integer('status');
            $table->unsignedBigInteger('checklist_intervencion_id');
            $table->foreign('checklist_intervencion_id')->references('id')->on('checklist_intervenciones');
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
