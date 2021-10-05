<?php

namespace App\Models\Sistema\Usuarios;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'usuarios_roles';

    protected $fillable = [
        'nombre'
    ];

    protected $visible = [
        'id', 'nombre'
    ];

    public function usuarios_roles(){
        return $this->hasMany('App\User', 'rol_id');
    }
}
