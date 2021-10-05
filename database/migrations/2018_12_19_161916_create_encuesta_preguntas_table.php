<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncuestaPreguntasTable extends Migration
{ 
    public function up()
    {
        Schema::create('encuesta_preguntas', function (Blueprint $table) {

            $table->integer('id');
            $table->integer('encuestas_id');
            $table->integer('empresas_id');  
            $table->string('pregunta');
            $table->string('tipo');
            $table->float('peso');            
            $table->timestamps();

            $table->primary(['id', 'encuestas_id', 'empresas_id']);
            $table->foreign(['encuestas_id', 'empresas_id'])->references(['id', 'empresas_id'])->on('encuestas');
           });
    }

    public function down()
    {
        Schema::dropIfExists('encuesta_preguntas');
    }
}
