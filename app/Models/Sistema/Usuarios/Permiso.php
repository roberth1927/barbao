<?php

namespace App\Models\Sistema\Usuarios;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'usuarios_permisos';

    protected $visible = [
        'id', 'permisos'
    ];
}
