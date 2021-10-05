<?php

namespace App\Models\Sistema\Permisos;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';

    protected $visible = [
        'id', 'name'
    ];
}
