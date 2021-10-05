<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncuestaTiposTable extends Migration
{
   
    public function up()
    {
        Schema::create('encuesta_tipos', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('nombre');
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('encuesta_tipos');
    }
}
