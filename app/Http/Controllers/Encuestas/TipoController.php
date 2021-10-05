<?php

namespace App\Http\Controllers\Encuestas;

use App\Http\Requests\Encuestas\TipoStoreRequest;
use App\Http\Requests\Encuestas\TipoUpdateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Encuestas\Tipo;

class TipoController extends Controller
{
    public function index()
    {
        return Tipo::orderBy('id')
                    ->latest()
                    ->get();
    }

    public function show($id)
    {
        return Tipo::where('id', $id)
                    ->get();
    }

    public function store(TipoStoreRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                'message'   => 'Los datos no son validos.', 
                'errors'    => $request->validator->errors()
            ], 422);
        }

        $Tipos = new Tipo();
        $Tipos->nombre = $request->nombre;
        
        if ( $Tipos->save() ) {
            return response()->json([
                    'message' => 'El tipo de encuesta se guardó correctamente',
                    'status' => 'success'
                ], 200);
        }
    }

    public function update(TipoUpdateRequest $request, $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                'message'   => 'Los datos no son validos.', 
                'errors'    => $request->validator->errors()
            ], 422);
        }

        $validated = $request->validated();
        $Tipos = Tipo::findOrFail($id);
        $Tipos->nombre = $request->nombre;
        
        if ( $Tipos->update() ) {
            return response()->json([
                    'message' => 'El tipo de encuesta actualizó correctamente',
                    'status' => 'success'
                ], 200);
        }
    }
}
