<?php

namespace App\Models\Encuestas;

use Illuminate\Database\Eloquent\Model;
use App\Models\Encuestas\Pregunta;

class PreguntaRespuesta extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'encuesta_preguntas_respuestas';
    protected $fillable = [
        'encuesta_preguntas_id', 'empresas_id', 'encuestas_id','opcion', 'peso'
    ];

    // protected $visible = [
    //     'pregunta_id', 'opcion', 'peso', 'value', 'text', 'id'
    // ];

    protected $hidden = [
        'encuesta_preguntas_id', 'empresas_id', 'encuestas_id', 'peso', 'created_at','updated_at', 'opcion'      
        
    ];

    // public function respuestas_preguntas(){
    //     return $this->belongsTo(Pregunta::class, 'encuesta_preguntas_id', 'id');//pertenece a
    // }   
    public function respuestas_preguntas(){
        return $this->belongsTo(Pregunta::class, 'encuesta_preguntas_id', 'id');//pertenece a
    }

}
