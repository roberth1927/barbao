<?php

namespace App\Models\Sistema\Permisos;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'permissions';

    public function rol(){
        return $this->belongsToMany('App\Models\Sistema\Permisos\Rol','role_has_permissions', 'permission_id', 'role_id');
    }
}