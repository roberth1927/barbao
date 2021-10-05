<?php

namespace App\Http\Controllers\Sistema\Usuarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Sistema\Permisos\Permiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Sistema\PermisosStoreRequest;

class PermisosController extends Controller{

    public function permisos($id_empresa, $rol_id, $sub_modulo){
        $permisos = Permiso::whereHas('rol', function ($query) use ($rol_id){
                        $query->where('role_id',$rol_id);
                    })
                    ->where('sub_modulo', $sub_modulo)
                    ->get()
                    ->map(function ($ev) {
                        return [
                            $ev->name,
                        ];
                    });

        $permisos_array = [];
        foreach ( $permisos as $permiso ){
            foreach( $permiso as $clave => $valor) {
                $permisos_array[] = $valor;
            }
        }

        return $permisos_array;
    }

    public function store(Request $request){

        $rol_id     = $request->rol_id;
        $sub_modulo = $request->sub_modulo;
        $permisos   = $request->permisos;

        $rol = Role::findById($rol_id);
        $permisos_actuales = self::permisos(1, $rol_id, $sub_modulo);

        // CREA LOS PERMISOS QUE NO SE ENCUENTREN EN LA BASE DE DATOS
        foreach ( $permisos as $permiso ){
            $permission = Permission::getPermissions(['name' => $permiso, 'guard_name' => 'api'])->first();
            if ( $permission === null ){
                Permission::create(['name' => $permiso, 'sub_modulo' => $sub_modulo]);
            }
        }
        
        // ELIMINA LOS PERMISOS QUE ACTUALMENTE
        foreach( $permisos_actuales as $permiso ) {
            $permiso_model = Permission::findByName($permiso);
            if ( $permiso_model ) {
                $rol->revokePermissionTo($permiso_model);
            };
        }

        // REGISTRA LOS PERMISOS ENVIADOS DESDE EL FRONT-END
        foreach ( $permisos as $permiso ){
            $permiso_model = Permission::findByName($permiso);
            $permiso_model->assignRole($rol_id);
        }
        return response()->json([
                'message' => 'Los permisos se han actualizado correctamente',
                'status' => 'success'
            ], 200);
    }
}
