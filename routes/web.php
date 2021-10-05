<?php


Route::get('/informe', function () {
    return view('informe');
});

// Route::get('/{any}', 'InicioController@index')->where('any', '.*');

// Route to handle page reload in Vue except for api routes
Route::get('/{any?}', function (){
    return view('inicio');
})->where('any', '^(?!api\/)[\/\w\.-]*');


