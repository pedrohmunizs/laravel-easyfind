<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/')->namespace('App\Http\Controllers')->group(function () {
    Route::get('/teste',['uses' => 'ComercianteController@management', 'as' => 'comerciante.management'] );
    Route::get('/create',['uses' => 'ComercianteController@create', 'as' => 'comerciante.create'] );
    Route::post('/comerciantes',['uses' => 'ComercianteController@store', 'as' => 'comerciante.store'] );
    Route::get('/login',['uses' => 'ComercianteController@login', 'as' => 'login'] );
    Route::post('/',['uses' => 'ComercianteController@login1', 'as' => 'comerciante.login1'] );
});
Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'estabelecimentos', 'namespace' => 'App\Http\Controllers'], function(){
        Route::get('/teste',['uses' => 'ComercianteController@management', 'as' => 'comerciante.management'] );
        Route::get('/load', ['uses' => 'EstabelecimentoController@load', 'as' => 'estabelecimentos.load'] );
        Route::get('/', ['uses' => 'EstabelecimentoController@index', 'as' => 'estabelecimentos.index'] );
        Route::post('/',['uses' => 'EstabelecimentoController@store', 'as' => 'estabelecimentos.store'] );
    });
});