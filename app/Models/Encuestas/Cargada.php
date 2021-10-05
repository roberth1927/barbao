<?php

namespace App\Models\Encuestas;

use Illuminate\Database\Eloquent\Model;

class Cargada extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'encuesta_cargadas';
    // protected $hidden = [
    //     'id'
    // ];
    protected $fillable = [
        'encuestas_id', 'empresas_id', 'cliente_id', 'orden_id', 'empresas',  'tipo_estado', 'respuesta', 'fecha_respuesta', 'dispositivo', 'ip', 'user', 'id_ws', 'token'
    
    ];

    public function encuesta_cargada(){ 
        return $this->belongsTo(Encuesta::class, ['encuestas_id', 'empresas_id'], ['id', 'empresas_id']);//pertenece a
    }

    public function empresas(){
        return $this->belongsTo(Empresas::class, 'empresas_id');//pertenece a
    }

}
