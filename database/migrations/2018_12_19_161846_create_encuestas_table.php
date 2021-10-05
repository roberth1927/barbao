<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncuestasTable extends Migration
{
  
    public function up()
    {
        Schema::create('encuestas', function (Blueprint $table) {

            $table->integer('id')->unsigned();
            $table->integer('empresas_id')->unsigned();
            $table->integer('encuesta_tipos_id')->unsigned();
            $table->string('nombre');
            $table->timestamps();

            $table->primary(['id', 'empresas_id']);
            $table->foreign('empresas_id')->references('id')->on('empresas');
            $table->foreign('encuesta_tipos_id')->references('id')->on('encuesta_tipos');
        });
    }

    public function down()
    {
        Schema::dropIfExists('encuestas');
    }
}
