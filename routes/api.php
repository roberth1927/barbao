<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('register', 'Sistema\AuthController@register');
    Route::post('login', 'Sistema\AuthController@login');
    Route::get('refresh', 'Sistema\AuthController@refresh');

    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('user', 'Sistema\AuthController@user');
        Route::post('logout', 'Sistema\AuthController@logout');
        Route::get('get_permiso', 'Sistema\AuthController@getPermiso');

        Route::resource('encuestas/tipos', 'Encuestas\TipoController', [
            'except' => ['create', 'edit', 'destroy']
        ]);
    });
});