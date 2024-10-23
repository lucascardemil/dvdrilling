<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatrizChecklistCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriz_checklist_categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('status');
            $table->unsignedBigInteger('matriz_checklist_id');
            $table->foreign('matriz_checklist_id')->references('id')->on('matriz_checklist');
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
        Schema::dropIfExists('matriz_checklist_categorias');
    }
}
