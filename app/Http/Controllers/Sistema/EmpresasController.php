<?php

namespace App\Http\Controllers\Sistema;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Sistema\EmpresaStoreRequest;
use App\Http\Requests\Sistema\EmpresaUpdateRequest;
use App\Models\Sistema\Empresas;

class EmpresasController extends Controller
{
    public function index(){
        return Empresas::orderBy('nombre')
                        ->latest()
                        ->get();
    }

    public function show($id){
        return Empresas::where('id', $id)->get();
    }

    public function empresas_activas(){
        $empresas = Empresas::query();

        if ( Auth::user()->rol_id <> 1 ){
            $empresas->where('id', Auth::user()->id_empresa);
        }
        return $empresas->where('activa', 1)
                        ->orderBy('nombre')
                        ->latest()
                        ->get()
                        ->map(function ($ev){
                            return [
                                'value' => $ev->id,
                                'text' => $ev->nombre
                            ];
                        });
    }

    public function store(EmpresaStoreRequest $request){

        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                'message'   => 'Los datos no son validos.', 
                'errors'    => $request->validator->errors()
            ], 422);
        }

        $Empresas = new Empresas();
        $Empresas->nombre = $request->nombre;
        $Empresas->activa = $request->activa;
        $Empresas->email = $request->email;
        
        if ( $Empresas->save() ) {
            return response()->json([
                    'message' => 'La empresa se guardó correctamente',
                    'status' => 'success'
                ], 201);
        }
    }

    public function update(EmpresaUpdateRequest $request, $id){
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                'message'   => 'Los datos no son validos.', 
                'errors'    => $request->validator->errors()
            ], 422);
        }

        $Empresas = Empresas::findOrFail($id);
        $Empresas->nombre = $request->nombre;
        $Empresas->activa = $request->activa;
        $Empresas->email = $request->email;

        if ( $Empresas->update() ) {
            return response()->json([
                    'message' => 'La empresa se actualizó correctamente',
                    'status' => 'success'
                ], 200);
        }
    }
}
