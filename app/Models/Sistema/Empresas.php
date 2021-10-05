<?php

namespace App\Models\Sistema;

use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    use \Awobaz\Compoships\Compoships;
    
    protected $fillable = [
        'nombre', 'activa', 'email'
    ];

    protected $visible = [
        'id', 'nombre', 'email', 'activa'
    ];

    public function usuarios(){
        return $this->hasMany(App\Usuarios::class, 'id_empresa');
    }
}
