<?php

namespace App\Models\Encuestas;

use Illuminate\Database\Eloquent\Model;
use App\Models\Encuestas\PreguntaRespuesta;

class Pregunta extends Model
{
use \Awobaz\Compoships\Compoships;

    protected $table = 'encuesta_preguntas';

    protected $fillable = [
        'encuestas_id', 'empresas_id', 'pregunta', 'tipo', 'peso' 
    ];

    protected $hidden = [
       'peso', 'encuestas_id','empresas_id','created_at', 'updated_at'
    ];

    public function encuesta(){
        return $this->belongsTo('App\Models\Encuestas\Encuesta', ['encuestas_id', 'empresas_id'], ['id', 'empresas_id']);//pertenece a
    }

    public function pregunta_respuestas(){
        return $this->hasMany(PreguntaRespuesta::class, ['encuesta_preguntas_id', 'empresas_id', 'encuestas_id'], ['id', 'empresas_id', 'encuestas_id']);//tiene muchas
    }
}
