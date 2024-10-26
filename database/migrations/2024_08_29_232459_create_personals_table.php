<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->string('run');
            $table->unsignedBigInteger('cargo_id'); // Clave foránea
            $table->foreign('cargo_id')->references('id')->on('cargos');
            $table->integer('status');
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
        Schema::dropIfExists('personals');
    }
}
