<?php

namespace App\Http\Controllers\Sistema\Usuarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Sistema\Permisos\Rol;
use App\Http\Requests\Sistema\RolesStoreRequest;
use App\Http\Requests\Sistema\RolesUpdateRequest;

class RolesController extends Controller
{
    public function index(){
        return Rol::orderBy('name')
                    ->latest()
                    ->get();
    }

    public function listado(){
        return Rol::orderBy('name')
                    ->latest()
                    ->get()
                    ->map(function ($ev){
                        return [
                            'value' => $ev->id,
                            'text' => $ev->name
                        ];
                    });
    }

    public function show($id){
        return Rol::where('id', $id)
                    ->get();
    }

    public function store(RolesStoreRequest $request){
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                'message'   => 'Los datos no son validos.', 
                'errors'    => $request->validator->errors()
            ], 422);
        }
        
        $Rol = new Rol();
        $Rol->name = $request->name;
        $Rol->guard_name = 'api';
        
        if ( $Rol->save() ) {
            return response()->json([
                'message' => 'El rol de usuario se guardó correctamente',
                'status' => 'success'
            ], 200); 
        }
    }

    public function update(RolesUpdateRequest $request, $id){
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                'message'   => 'Los datos no son validos.', 
                'errors'    => $request->validator->errors()
            ], 422);
        }

        $Rol = Rol::findOrFail($id);
        $Rol->name = $request->name;

        if ( $Rol->update() ) {
            return response()->json([
                    'message' => 'El rol de usuario se actualizó correctamente',
                    'status' => 'success'
                ], 200);
        }
    }
}
