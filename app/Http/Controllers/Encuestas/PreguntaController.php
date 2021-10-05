<?php

namespace App\Http\Controllers\Encuestas;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Requests\Encuestas\PreguntaStoreRequest;
use App\Http\Requests\Encuestas\PreguntaUpdateRequest;
use App\Http\Controllers\Controller;

use App\Models\Sistema\Empresas;
use App\Models\Encuestas\Encuesta;
use App\Models\Encuestas\Pregunta;

class PreguntaController extends Controller
{  
    public function index()
    {
        $pregunta = Pregunta::query();
        if ( Auth::user()->rol_id <> getenv('SIS_ID_ROL_SUPER_ADMIN') ){
            $pregunta->where('empresas_id', Auth::user()->id_empresa);
        }
        return $pregunta->with([    
            $empresa = 'encuesta.empresas' => function ($query) {
                $query->select('id', 'nombre'); 
            }])->get()
            ->map(function ($ev){
                return[
                    'id'            => $ev->id,
                    'encuestas_id'  => $ev->encuesta->id,
                    'encuesta'      => $ev->encuesta->nombre,
                    'empresas_id'   => $ev->encuesta->empresas->id,
                    'empresa'       => $ev->encuesta->empresas->nombre,
                    'pregunta'      => $ev->pregunta,
                    'tipo'          => $ev->tipo,
                    'peso'          => $ev->peso
                
                ];
            });   
    }
 
    public function listado_de_encuestas($empresas_id){
        return Encuesta::where('empresas_id', $empresas_id)
                        ->orderBy('id')
                        ->latest()                
                        ->get()
                        ->map(function ($ev){
                            return [
                                'value'         => $ev->id,
                                'text'          => $ev->nombre
                            ];
                        });
    }

    public function listado_de_preguntas($encuestas_id){
        return Pregunta::where('encuestas_id', $encuestas_id)
                        ->orderBy('id')
                        ->latest()                
                        ->get()
                        ->map(function ($ev){
                            return [
                                'pregunta'         => $ev->pregunta
                            ];
                        });
    }

    public function preguntas_opciones($id, $encuestas_id, $empresas_id){
        return Pregunta::where('id', $id)
                        ->where('encuestas_id', $encuestas_id)
                        ->where('empresas_id', $empresas_id)
                        ->with([
                            $opciones = 'pregunta_respuestas' => function ($query) {
                            $query->select(['id','encuesta_preguntas_id', 'opcion']);   
                        
                            }])->get()
                                ->map(function ($ev){
                                    return[
                                        'id'           => $ev->id,
                                        'pregunta'     => $ev->pregunta,
                                        'opciones'     => $ev->pregunta_respuestas->opcion
                                        
                                    ];
                                });
            
        }

    public function store(PreguntaStoreRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                'message'   => 'Los datos no son validos.', 
                'errors'    => $request->validator->errors()
            ], 422);
        }
        
        $Preguntas = new Pregunta();
        $id = Pregunta::where('empresas_id',    '=',    $request->empresas_id)
                        ->where('encuestas_id', '=',    $request->encuestas_id)
                        ->max('id');
        $Preguntas->id              = $id + 1;
        $Preguntas->encuestas_id    = $request->encuestas_id;
        $Preguntas->empresas_id     = $request->empresas_id;
        $Preguntas->pregunta        = $request->pregunta;
        $Preguntas->tipo            = $request->tipo;
        $Preguntas->peso            = $request->peso;
        
        if ( $Preguntas->save() ) {
            return response()->json([
                    'message' => 'La pregunta se guardó correctamente',
                    'status' => 'success'
                ], 200);
        }
    }
   
    public function show($id, $encuestas_id, $empresas_id)
    {
        return Pregunta::where('id', $id)
                        ->where('encuestas_id', $encuestas_id)
                        ->where('empresas_id', $empresas_id)
                        ->with([
                        
                        $encuesta = 'encuesta' => function ($query) {
                            $query->select('id', 'empresas_id', 'nombre'); 
                        },      
                        $empresa = 'encuesta.empresas' => function ($query) {
                            $query->select('id', 'nombre'); 
                        
                                
                        }])->get()
                        ->map(function ($ev){
                            return[
                                'id'         => $ev->id,
                                'Encuesta'   => $ev->encuesta->id,
                                'Empresa'    => $ev->encuesta->empresas->id,
                                'pregunta'   => $ev->pregunta,
                                'tipo'       => $ev->tipo,
                                'peso'       => $ev->peso
                            ];
                        });
    }
  
    public function update(PreguntaUpdateRequest $request, $id, $encuestas_id, $empresas_id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                'message'   => 'Los datos no son validos.', 
                'errors'    => $request->validator->errors()
            ], 422);
        }
        $Preguntas = Pregunta::where('id', $id)
                              ->where('encuestas_id', $encuestas_id)
                              ->where('empresas_id', $empresas_id);

        if ( $Preguntas->update([
            'pregunta'  => $request->pregunta,
            'tipo'      => $request->tipo,
            'peso'      => $request->peso
        ])){ 
            
            return response()->json([
                    'message' => 'La pregunta se actualizó correctamente',
                    'status' => 'success'
                ], 200);
        }
    }
}
