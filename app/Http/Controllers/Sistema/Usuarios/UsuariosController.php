<?php

namespace App\Http\Controllers\Sistema\Usuarios;

use App\Http\Requests\Sistema\UsuariosStoreRequest;
use App\Http\Requests\Sistema\UsuariosUpdateRequest;
use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsuariosController extends Controller
{
    public function index(){
        return User::with('empresa','rol')
                    ->orderBy('name')
                    ->latest()
                    ->get()
                    ->map(function ($ev){
                        return [
                            'id' => $ev->id,
                            'name' => $ev->name,
                            'email' => $ev->email,
                            'activo' => $ev->activo,
                            'empresa' => $ev->empresa->nombre,
                            'rol' => $ev->rol->name,
                        ];
                    });
    }

    public function show($id){
        return User::where('id', $id)->get();
    }

    public function store(UsuariosStoreRequest $request){
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                'message'   => 'Los datos no son validos.', 
                'errors'    => $request->validator->errors()
            ], 422);
        }
        
        $Usuarios = new User();
        $Usuarios->name = $request->name;        
        $Usuarios->email = $request->email;
        $Usuarios->activo = $request->activo;
        $Usuarios->id_empresa = $request->id_empresa;
        $Usuarios->password = bcrypt($request->password);
        $Usuarios->rol_id = $request->rol_id;
        
        if ( $Usuarios->save() ) {
            return response()->json([
                'message' => 'El usuario se guardó correctamente',
                'status' => 'success'
            ], 200); 
        }
    }

    public function update(UsuariosUpdateRequest $request, $id){
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                'message'   => 'Los datos no son validos.', 
                'errors'    => $request->validator->errors()
            ], 422);
        }

        $Usuarios = User::findOrFail($id);
        $Usuarios->name = $request->name;
        $Usuarios->activo = $request->activo;
        $Usuarios->id_empresa = $request->id_empresa;
        $Usuarios->rol_id = $request->rol_id;

        if ( $Usuarios->update() ) {
            return response()->json([
                    'message' => 'El usuario se actualizó correctamente',
                    'status' => 'success'
                ], 200);
        }
    }
}
