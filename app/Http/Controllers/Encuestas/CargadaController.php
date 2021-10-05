<?php

namespace App\Http\Controllers\Encuestas;

use App\Http\Requests\Encuestas\CargadaStoreRequest;
use App\Http\Requests\Encuestas\CargadaUpdateRequest;
use App\Models\Encuestas\Cargada;
use App\EmergencyCallReceived;
use App\Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Encuestas\Encuesta;
use Carbon\Carbon;

use Jenssegers\Agent\Agent;


class CargadaController extends Controller
{

    public function index(){     {
        return Cargada::with([
            $encuesta = 'encuesta_cargada' => function ($query) {
            $query->select('*'); 
            },
            $empresas = 'encuesta_cargada.empresas' => function ($query) {
                   $query->select('id', 'nombre');
             }])->get()
             ->map(function ($ev){
                return[
                        'id'             => $ev->id,
                        'encuesta'       => $ev->encuesta_cargada->nombre,
                        'empresa'        => $ev->empresas_id,
                        'cliente'        => $ev->cliente_id,
                        'orden'          => $ev->orden_id,
                        'empresas'       => $ev->empresas,
                        'tipo estado'    => $ev->tipo_estado,
                        'respuesta'      => $ev->respuesta,
                        'fecha respuesta'=> $ev->fecha_respuesta,
                        'dispositivo'    => $ev->dispositivo,
                        'ip'             => $ev->ip,
                        'user'           => $ev->user,
                        'id_ws'         => $ev->id_ws,
                        'token'         => $ev->token
                                    
                        ];
                    });
                
            }
    }

    public function jason (){
        return Cargada::
                    with([
                    $pregunta = 'encuesta_cargada' => function ($query) {
                        $query->select('*');
                    }])->get()                           
                    ->map(function ($ev){
                        return [ 

                            'RESPUESTAS_CLIENTES'     => json_decode($ev->respuesta)
                        

                        ];
                    });
        
    }
           
    public function resjson($encuestas_id, $empresas_id)
    {
        $query =  Cargada::where('encuestas_id', $encuestas_id)
                    ->where('empresas_id', $empresas_id)
                    ->with(['encuesta_cargada.encuesta_preguntas'])
                    ->get();   


        return response()->json($query[0]->encuesta_cargada->encuesta_preguntas);                  
    }

    public function email(){
        return Cargada::orderBy('id')
                        ->get() 
                        ->map(function ($ev){
                            $data = array (
                                'cliente_id' => $ev->cliente_id,
                                'name' => $ev->token
                            
                            );
                            \Mail::send('emails.welcome', $data, function ($message){
                                $message->to('robinmoralesquiroz@gmail.com')->subject('Encuesta de Satisfacción');
                            });
                            return "Tu e-mail fue enviado correctamente";
                
                        });
    }

    public function encuesta_cliente ($token){
        $cargada = Cargada::where('token', $token)
                            ->with([
                            $pregunta = 'encuesta_cargada.encuesta_preguntas.pregunta_respuestas' => function ($query) {
                                $query->select('*', 'opcion as text', 'peso as value')->orderBy("peso","asc");
                            }])
                            ->get();
            if($cargada[0]->tipo_estado == 'RESUELTA'){
                return response()->json([
                    'message'   => 'La encuesta ya fue resuelta. '
                ], 202);
            }else{
                return $cargada;
            }
    }

    public function encuesta_cliente_resuelta ($cliente_id){
        $cargada = Cargada::where('cliente_id', $cliente_id)

                            ->with([
                            $pregunta = 'encuesta_cargada.encuesta_preguntas.pregunta_respuestas' => function ($query) {
                                $query->select('*');
                            }])
                            ->get();
                            return $cargada;
    }
    
    public function store(CargadaStoreRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                'message'   => 'Los datos no son validos.', 
                'errors'    => $request->validator->errors()
            ], 422);
        }
        $Cargadas = new Cargada(); 
        $id = Cargada::where('encuestas_id',            '=',    $request->encuesta_preguntas_id)
                                ->where('empresas_id', '=',    $request->empresas_id)
                                ->max('id');  
        $Cargadas->id = $id + 1;      
        $Cargadas->encuestas_id = $request->encuestas_id;
        $Cargadas->empresas_id = $request->empresas_id;
        $Cargadas->cliente_id = $request->cliente_id;
        $Cargadas->orden_id = $request->orden_id;
        $Cargadas->empresas = $request->empresas;
        $Cargadas->tipo_estado = $request->tipo_estado;
        $Cargadas->respuesta = json_encode($request->respuestas);
        $Cargadas->fecha_respuesta = Carbon::now();
        $Cargadas->dispositivo = $request->dispositivo;
        $Cargadas->ip = $request->ip;
        $Cargadas->user = $request->user;                
        if ( $Cargadas->save() ) {
            return response()->json([
                'message' => 'Se guardó correctamente',
                'status' => 'success'
            ], 200); 
        }
    }
  
    public function show($id)
    {
        return Cargada::where('id', $id)->get(); 
    }
  
    public function update(CargadaUpdateRequest $request, $token)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                'message'   => 'Los datos no son validos.', 
                'errors'    => $request->validator->errors()
            ], 422);
        }
        
        $Agente = new Agent();
            $dispositivo = "";     
            if($Agente->is('Windows') || $Agente->is('OS X'))
            {
               $dispositivo = 'Computador';
           } else if($Agente->isMobile())
           {
            $dispositivo = 'SmarthPhone';
            } else if($Agente->isTablet())
            {
                $dispositivo = 'Tableta';
            } else {
                $dispositivo = 'No Disponible';
            }
             $Cargadas = Cargada::where('token', $token);                            
        if( $Cargadas->update ([
            'cliente_id'        => $request->cliente_id,
            'orden_id'          => $request->orden_id,
            'empresas'          => $request->empresas,
            'tipo_estado'       => 'RESUELTA',
            'respuesta'         => json_encode($request->respuesta),
            'fecha_respuesta'   => Carbon::now(),
            'dispositivo'       => $dispositivo,
            'ip' => '123456',
            //'ip'                => $request->ip,
            'user'              => $request->user,
            'id_ws'             => $request->id_ws,
            'token'             => $request->token
        ])){ 

            return response()->json([
                'message' => 'Actualizada correctamente',
                'status' => 'success'
            ], 200); 
        } 
    }

    public function cargar_datos_ws(Request $request){
        
        $encuestas_id = $request->encuestas_id;
        $empresas_id = $request->empresas_id;
        $detalle = $request->datos_ws;

        foreach ($detalle as $key => $value) {
            $id = Cargada::where('encuestas_id','=', $encuestas_id)
                         ->where('empresas_id', '=', $empresas_id)
                         ->max('id');
            
            $Cargadas = new Cargada(); 
            $Cargadas->id = $id + 1;      
            $Cargadas->encuestas_id = $request->encuestas_id;
            $Cargadas->empresas_id = $request->empresas_id;
            
            $Cargadas->cliente_id   = $value['nit'];
            $Cargadas->orden_id     = $value['numero'];
            $Cargadas->empresas     = $value['empresa'];
            $Cargadas->tipo_estado  = 'CARG';
            $Cargadas->id_ws        = $value['id'];
            $Cargadas->token        = str_replace('=','',encrypt($value['id']));
            $Cargadas->save();
        }
   
        // if ( $Cargadas->save() ) {
            return response()->json([
                'message' => 'Se guardó correctamente',
                'status' => 'success'
            ], 200); 
        //}
    }
}
