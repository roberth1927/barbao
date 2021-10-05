<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncuestaPreguntasRespuestasTable extends Migration
{
   
    public function up()
    {
        Schema::create('encuesta_preguntas_respuestas', function (Blueprint $table) {

            $table->integer('id');
            $table->integer('encuesta_preguntas_id');
            $table->integer('encuestas_id');
            $table->integer('empresas_id');
            $table->string('opcion');
            $table->float('peso');
            $table->timestamps();

            $table->primary(['id', 'encuesta_preguntas_id', 'encuestas_id', 'empresas_id']);
            $table->foreign(['encuesta_preguntas_id', 'encuestas_id','empresas_id'])->references(['id', 'encuestas_id', 'empresas_id'])->on('encuesta_preguntas');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('encuesta_preguntas_respuestas');
    }
}
