<?php

use Illuminate\Http\Request;

Route::prefix('auth')->group(function () {

    Route::group(['middleware' => 'auth:api'], function(){

        
        //RUTAS MODULO EMPRESAS
         
        Route::get('empresas', 'Sistema\EmpresasController@index')->middleware('permission:empresas_index');
        Route::get('empresas/{id}', 'Sistema\EmpresasController@show')->middleware('permission:empresas_show');
        Route::post('empresas', 'Sistema\EmpresasController@store')->middleware('permission:empresas_store');
        Route::put('empresas/{id}', 'Sistema\EmpresasController@update')->middleware('permission:empresas_update');
        Route::get('empresas_activas', 'Sistema\EmpresasController@empresas_activas');

        // RUTAS PARA EL MODULO DE USUARIOS

        Route::get('usuarios/roles/listado', 'Sistema\Usuarios\RolesController@listado');
        Route::get('usuarios/permisos/{id_empresa}/{rol_id}/{sub_modulo}', 'Sistema\Usuarios\PermisosController@permisos');
        Route::post('usuarios/permisos', 'Sistema\Usuarios\PermisosController@store');

        Route::get('usuarios', 'Sistema\Usuarios\UsuariosController@index')->middleware('permission:usuario_index');
        Route::get('usuarios/{id}', 'Sistema\Usuarios\UsuariosController@show')->middleware('permission:usuario_show');
        Route::post('usuarios', 'Sistema\Usuarios\UsuariosController@store')->middleware('permission:usuario_store');
        Route::put('usuarios/{id}', 'Sistema\Usuarios\UsuariosController@update')->middleware('permission:usuario_update');

        // Route::get('usuarios/permisos_rol/{id_empresa}/{rol_id}', 'Sistema\Usuarios\PermisosController@permisos_rol');
        // Route::put('usuarios/permisos', 'Sistema\Usuarios\PermisosController@update');

        
        //RUTAS MODULO ROLES DE USUARIO
        
        
        Route::get('usuarios_roles/{id}', 'Sistema\Usuarios\RolesController@show')->middleware('permission:usuario_roles_show');
        Route::get('usuarios_roles', 'Sistema\Usuarios\RolesController@index')->middleware('permission:usuario_roles_index');
        Route::post('usuarios_roles', 'Sistema\Usuarios\RolesController@store')->middleware('permission:usuario_roles_store');
        Route::put('usuarios_roles/{id}', 'Sistema\Usuarios\RolesController@update')->middleware('permission:usuario_roles_update');
              

    });
});