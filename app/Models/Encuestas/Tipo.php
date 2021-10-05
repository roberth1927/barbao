<?php

namespace App\Models\Encuestas;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'encuesta_tipos';
    protected $fillable = [
        'nombre'
    ];

    public function encuesta(){
        return $this->hasMany(Encuesta::class);//tiene muchos
    }
}
