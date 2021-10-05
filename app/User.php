<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;

    protected $guard_name = 'api';

    protected $fillable = [
        'name', 'email', 'password', 'activo'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $visible = [
        'name', 'email', 'id_empresa', 'rol_id', 'activo'
    ];

    /**
     * JWT
     */

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function empresa() {
        return $this->belongsTo('App\Models\Sistema\Empresas', 'id_empresa');
    }

    public function rol() {
        return $this->belongsTo('App\Models\Sistema\Permisos\Rol','rol_id');
    }
}
