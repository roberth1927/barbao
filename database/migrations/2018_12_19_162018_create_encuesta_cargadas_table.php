<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncuestaCargadasTable extends Migration
{
    public function up()
    {
        Schema::create('encuesta_cargadas', function (Blueprint $table) {

            $table->integer('id');
            $table->integer('encuestas_id');
            $table->integer('empresas_id');
            $table->bigInteger('cliente_id');
            $table->integer('orden_id');
            $table->string('empresas');
            $table->string('tipo_estado');
            $table->json('respuesta')->nullable();
            $table->datetime('fecha_respuesta')->nullable();
            $table->string('dispositivo')->nullable();
            $table->string('ip')->nullable();
            $table->string('user')->nullable();
            $table->bigInteger('id_ws')->nullable();
            $table->string('token');
            $table->timestamps();

            $table->primary(['id', 'encuestas_id', 'empresas_id']);
            $table->foreign(['encuestas_id', 'empresas_id'])->references(['id','empresas_id'])->on('encuestas');
        });
    }

 // $table->foreign('')->references('')->on('');
   
    public function down()
    {
        Schema::dropIfExists('encuesta_cargadas');
    }
}
