<?php

namespace App\Http\Controllers\Encuestas;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Sistema\Empresas;
use App\Models\Encuestas\Tipo;
use App\Models\Encuestas\Encuesta;
use App\Models\Encuestas\Cargada;

use App\Http\Requests\Encuestas\EncuestaStoreRequest;
use App\Http\Requests\Encuestas\EncuestaUpdateRequest;

class EncuestaController extends Controller
{
   
    
    public function index()
    {
        $encuestas = Encuesta::query();
        if ( Auth::user()->rol_id <> getenv('SIS_ID_ROL_SUPER_ADMIN') ){
            $encuestas->where('empresas_id', Auth::user()->id_empresa);
        }

        return $encuestas->with([
                    $empresa = 'empresas' => function ($query) {
                        $query->select('id', 'nombre'); 
                    },
                    $tipo_encuesta = 'encuesta_tipo' => function ($query) {
                        $query->select('id', 'nombre'); 
                    }])->get()
                ->map(function ($ev){
                    return [
                        'id'                        => $ev->id,
                        'empresas_id'               => $ev->empresas->id,
                        'Empresa'                   => $ev->empresas->nombre,
                        'encuesta_tipos_id'         => $ev->encuesta_tipo->id,
                        'Tipo Encuesta'             => $ev->encuesta_tipo->nombre,
                        'nombre'                    => $ev->nombre,
                    ];
                });
    }
    
    public function store(EncuestaStoreRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                'message'   => 'Los datos no son validos.', 
                'errors'    => $request->validator->errors()
            ], 422);
        }
        
        $Encuestas = new Encuesta();
        $id = Encuesta::where('empresas_id',         '=', $request->empresas_id)
                        //->where('encuesta_tipos_id', '=',    $request->encuesta_tipos_id)                        
                        ->max('id');
        $Encuestas->id = $id + 1;
        $Encuestas->empresas_id = $request->empresas_id;   
        $Encuestas->encuesta_tipos_id = $request->encuesta_tipos_id; 
        $Encuestas->nombre = $request->nombre;
               
        if ( $Encuestas->save() ) {
            return response()->json([
                'message' => 'La encuesta se guardó correctamente',
                'status' => 'success'
            ], 200); 
            
        }
    }

    public function tipos_de_encuestas(){
        return Tipo::orderBy('id')
                ->latest()                
                ->get()
                ->map(function ($ev){
                    return [
                        'value' => $ev->id,
                        'text'  => $ev->nombre
                    ];
                });
    }
    
    public function show($id, $empresas_id)
    {
        return Encuesta::where('id', $id)
                        ->where('empresas_id', $empresas_id)
                        ->with([
                            $empresa = 'empresas' => function ($query) {
                                $query->select('id', 'nombre'); 
                            },
                            $tipo_encuesta = 'encuesta_tipo' => function ($query) {
                                $query->select('id', 'nombre'); 
                            }])->get()
                        ->map(function ($ev){
                            return [
                                'id'                        => $ev->id,
                                'empresa'                   => $ev->empresas->id,
                                'tipo_encuesta'             => $ev->encuesta_tipo->id,
                                'nombre'                    => $ev->nombre
                            ];
                        });
    }

    public function update(EncuestaUpdateRequest $request, $id, $empresas_id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                'message'   => 'Los datos no son validos.', 
                'errors'    => $request->validator->errors()
            ], 422);
        }
        $Encuestas = Encuesta::where('id', $id)
                            ->where('empresas_id', $empresas_id);

        if( $Encuestas->update([
            'nombre'            => $request->nombre,
            'encuesta_tipos_id' => $request->encuesta_tipos_id,
        ])){
            return response()->json([
                    'message' => 'La encuesta se actualizó correctamente',
                    'status' => 'success'
                ], 200);
        }
    }

    
}
