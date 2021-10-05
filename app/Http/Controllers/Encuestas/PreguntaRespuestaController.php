<?php

namespace App\Http\Controllers\Encuestas;

use App\Http\Requests\Encuestas\PreguntaRespuestaStoreRequest;
use App\Http\Requests\Encuestas\PreguntaRespuestaUpdateRequest;
use App\Models\Encuestas\PreguntaRespuesta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Encuestas\Encuesta;
use App\Models\Encuestas\Pregunta;


class PreguntaRespuestaController extends Controller
{
   
    public function index()
    {
        return PreguntaRespuesta::with([
        $pregunta = 'respuestas_preguntas' => function ($query) {
            $query->select('id', 'encuestas_id','pregunta'); 
        },
        
        $encuesta = 'respuestas_preguntas.encuesta' => function ($query) {
            $query->select('id', 'empresas_id', 'nombre');
        },
        $empresa = 'respuestas_preguntas.encuesta.empresas' => function ($query) {
            $query->select('id', 'nombre');
                
        }])->get()
        ->map(function ($ev){
            return[
                'id'                => $ev->id,
                 'pregunta'         => $ev->respuestas_preguntas->pregunta,
                 'encuesta'         => $ev->respuestas_preguntas->encuesta->nombre,
                 'empresa'          => $ev->respuestas_preguntas->encuesta->empresas->nombre,
                 'opcion'           => $ev->opcion,
                 'peso'             => $ev->peso
            ];
        });
       
}
    
    public function store(PreguntaRespuestaStoreRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                'message'   => 'Los datos no son validos.', 
                'errors'    => $request->validator->errors()
            ], 422);
        }
        
        $PreguntasRespuestas = new PreguntaRespuesta();
        $id = PreguntaRespuesta::where('encuesta_preguntas_id', '=',    $request->encuesta_preguntas_id)
                                ->where('empresas_id',          '=',    $request->empresas_id)
                                ->where('encuestas_id',         '=',    $request->encuestas_id)
                                ->max('id');
        $PreguntasRespuestas->id = $id + 1;
        $PreguntasRespuestas->encuesta_preguntas_id = $request->encuesta_preguntas_id;
        $PreguntasRespuestas->empresas_id = $request->empresas_id;
        $PreguntasRespuestas->encuestas_id = $request->encuestas_id;
        $PreguntasRespuestas->opcion = $request->opcion;        
        $PreguntasRespuestas->peso = $request->peso;
        
        if ( $PreguntasRespuestas->save() ) {
            return response()->json([
                'message' => 'La respuesta de la pregunta se guardó correctamente',
                'status' => 'success'
            ], 200); 
        }
    }

   
    public function show($id)
    {
        return PreguntaRespuesta::where('id', $id)->get();
    }


    public function preguntas_respuestas($encuesta_preguntas_id, $encuestas_id, $empresas_id)
    {
        return PreguntaRespuesta::orderBy("peso","desc")
                                ->where('encuesta_preguntas_id', $encuesta_preguntas_id)
                                ->where('encuestas_id', $encuestas_id)
                                ->where('empresas_id', $empresas_id)
                                ->with([
                                    $pregunta = 'respuestas_preguntas' => function ($query) {
                                        $query->select('id', 'encuestas_id','pregunta'); 
                                    },
                                    
                                    $encuesta = 'respuestas_preguntas.encuesta' => function ($query) {
                                        $query->select('id', 'empresas_id', 'nombre');
                                    },
                                    $empresa = 'respuestas_preguntas.encuesta.empresas' => function ($query) {
                                        $query->select('id', 'nombre');
                                            
                                    }])->get()
                                    ->map(function ($ev){
                                        return[
                                             'value' => $ev->opcion,
                                        ];
                                    });

                            
    }

    public function update(PreguntaRespuestaUpdateRequest $request, $id, $encuesta_preguntas_id, $empresas_id, $encuestas_id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                'message'   => 'Los datos no son validos.', 
                'errors'    => $request->validator->errors()
            ], 422);
        }

        $PreguntasRespuestas = PreguntaRespuesta::where('id', $id)
                                                ->where('encuesta_preguntas_id', $encuesta_preguntas_id)
                                                ->where('empresas_id', $empresas_id)
                                                ->where('encuestas_id', $encuestas_id);

        if ( $PreguntasRespuestas->update([
            'opcion' => $request->opcion,
            'peso' => $request->peso
        ]) ) {
            return response()->json([
                    'message' => 'La respuesta de la pregunta se actualizó correctamente',
                    'status' => 'success'
                ], 200);
        }
    }
   
}
