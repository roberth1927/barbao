<?php

namespace App\Models\Encuestas;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sistema\Empresas;

class Encuesta extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'encuestas';
    protected $fillable = [
        'empresas_id', 'encuesta_tipos_id', 'nombre'
    ];

    protected $hidden = [
        'empresas_id', 'encuesta_tipos_id','created_at', 'updated_at'      
    ];

    public function empresas(){
        return $this->belongsTo(Empresas::class, 'empresas_id');//pertenece a
    }

    public function encuesta_tipo(){
        return $this->belongsTo(Tipo::class, 'encuesta_tipos_id');//pertenece a
    }

    public function encuesta_cargadas(){
        return $this->hasMany(Cargada::class);//tiene muchas
    }

    public function encuesta_preguntas(){
        return $this->hasMany(Pregunta::class, ['encuestas_id', 'empresas_id'], ['id', 'empresas_id']);//tiene muchas
    }    
}
