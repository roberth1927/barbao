<?php

use Illuminate\Http\Request;


Route::prefix('auth')->group(function () {

    Route::group(['middleware' => 'auth:api'], function(){

        Route::get('tipos_de_encuestas','Encuestas\EncuestaController@tipos_de_encuestas');

        //RUTAS MODULO TIPOS DE ENCUESTA
         
        Route::get('encuestas/tipos', 'Encuestas\TipoController@index')->middleware('permission:tipos_index');
        Route::get('encuestas/tipos/{id}', 'Encuestas\TipoController@show')->middleware('permission:tipos_show');
        Route::post('encuestas/tipos', 'Encuestas\TipoController@store')->middleware('permission:tipos_store');
        Route::put('encuestas/tipos/{id}', 'Encuestas\TipoController@update')->middleware('permission:tipos_update');


        //RUTAS MODULO PREGUNTAS

        Route::get('encuestas/listado/{encuestas_id}','Encuestas\PreguntaController@listado_de_encuestas');
        Route::get('encuestas/preguntas','Encuestas\PreguntaController@index')->middleware('permission:preguntas_index');
        Route::get('encuestas/preguntas/{id}/{encuestas_id}/{empresas_id}','Encuestas\PreguntaController@show')->middleware('permission:preguntas_show');
        Route::post('encuestas/preguntas','Encuestas\PreguntaController@store')->middleware('permission:preguntas_store');
        Route::put('encuestas/preguntas/{id}/{encuestas_id}/{empresas_id}','Encuestas\PreguntaController@update')->middleware('permission:preguntas_update');


        //RUTAS MODULO PREGUNTA RESPUESTAS

        Route::get('encuestas/preguntas_respuestas/{encuesta_preguntas_id}/{empresas_id}/{encuestas_id}','Encuestas\PreguntaRespuestaController@preguntas_respuestas');
        Route::resource('encuestas/preguntas_respuestas', 'Encuestas\PreguntaRespuestaController', [
            'except' => ['create', 'edit', 'destroy','show', 'update']
        ]);


        //RUTAS MODULO ENCUESTA

        Route::get('encuestas','Encuestas\EncuestaController@index')->middleware('permission:encuestas_index');
        Route::get('encuestas/{id}/{empresas_id}','Encuestas\EncuestaController@show')->middleware('permission:encuestas_show');
        Route::post('encuestas','Encuestas\EncuestaController@store')->middleware('permission:encuestas_store');
        Route::put('encuestas/{id}/{empresas_id}','Encuestas\EncuestaController@update')->middleware('permission:encuestas_update');


        //RUTAS MODULO CARGADA

        Route::get('encuestas/cargadas/', 'Encuestas\CargadaController@index')->middleware('permission:cargadas_index');
        Route::get('encuesta_cliente/{token}', 'Encuestas\CargadaController@encuesta_cliente');
        Route::put('encuesta_cargadas/{token}', 'Encuestas\CargadaController@update');
        Route::post('encuestas/cargar_datos_ws', 'Encuestas\CargadaController@cargar_datos_ws');
        Route::get('encuesta_cliente/{cliente_id}', 'Encuestas\CargadaController@encuesta_cliente_resuelta');
        

        //RUTA ENVIO DE EMAIL

        Route::get('sendemail', 'Encuestas\CargadaController@email');  


        //RUTAS REPORTES ENCUESTAS

        Route::get('encuestas/cargadas/', 'Encuestas\CargadaController@index');

       
        //RUTA PARA OBTENER LOS DATOS DEL INFORME

        Route::get('jason/', 'Encuestas\CargadaController@jason');  
        Route::get('respuesta_jason/{encuestas_id}/{empresas_id}', 'Encuestas\CargadaController@resjson');
        
        

      Route::get('encuestas/informe', function () {
            return view('informe');
});




        // Route::get('./informe', function () {
        //     return view('informe');
        // });
        
        Route::get('/prueba',function(){//2
            $query =  App\Models\Encuestas\Cargada::all()[0];
            $query =  App\Models\Encuestas\Cargada::where('respuesta','like','%{\"pregunta_id\":2,\"valor_rta\":\"10\"}%')->get();                               
             // $count = count($query);
             return $query;
             // return $count.' personas dijeron eso';
         
         });

       

    });
});