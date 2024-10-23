<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistObservacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklist_observaciones', function (Blueprint $table) {
            $table->id();
            $table->string('observacion');
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
        Schema::dropIfExists('checklist_observaciones');
    }
}
