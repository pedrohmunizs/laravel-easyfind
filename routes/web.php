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
        Route::get('/load', ['uses' => 'EstabelecimentoController@load', 'as' => 'estabelecimentos.load'] );
        Route::get('/', ['uses' => 'EstabelecimentoController@index', 'as' => 'estabelecimentos.index'] );
        Route::post('/',['uses' => 'EstabelecimentoController@store', 'as' => 'estabelecimentos.store'] );
    });

    Route::group(['prefix' => 'produtos', 'namespace' => 'App\Http\Controllers'], function(){
        Route::get('/{idEstabelecimento}', ['uses' => 'ProdutoController@index', 'as' => 'produtos.index'] );
        Route::get('/{idEstabelecimento}/create', ['uses' => 'ProdutoController@create', 'as' => 'produtos.create'] );
        Route::get('/{idEstabelecimento}/load', ['uses' => 'ProdutoController@load', 'as' => 'produtos.load'] );
        Route::post('/',['uses' => 'ProdutoController@store', 'as' => 'produtos.store'] );
    });

    Route::group(['prefix' => 'secoes', 'namespace' => 'App\Http\Controllers'], function(){
        Route::get('/{idEstabelecimento}', ['uses' => 'SecaoController@index', 'as' => 'secoes.index'] );
        Route::get('/{idEstabelecimento}/load', ['uses' => 'SecaoController@load', 'as' => 'secoes.load'] );
        Route::get('/{idEstabelecimento}/create', ['uses' => 'SecaoController@create', 'as' => 'secoes.create'] );
        Route::post('/',['uses' => 'SecaoController@store', 'as' => 'secoes.store'] );
    });
    
    Route::group(['prefix' => 'metodos', 'namespace' => 'App\Http\Controllers'], function(){
        Route::get('/{idEstabelecimento}/create', ['uses' => 'MetodoPagamentoAceitoController@create', 'as' => 'metodos.create'] );
        Route::get('/{idEstabelecimento}/load', ['uses' => 'MetodoPagamentoAceitoController@load', 'as' => 'metodos.load'] );
        Route::get('/{idEstabelecimento}', ['uses' => 'MetodoPagamentoAceitoController@index', 'as' => 'metodos.index'] );
        Route::post('/', ['uses' => 'MetodoPagamentoAceitoController@store', 'as' => 'metodos.store'] );
    });

    Route::group(['prefix' =>'agendas', 'namespace' => 'App\Http\Controllers'], function(){
        Route::get('/{idEstabelecimento}', ['uses' => 'AgendaController@index', 'as' => 'agendas.index']);
        Route::post('/{idEstabelecimento}', ['uses' => 'AgendaController@update', 'as' => 'agendas.update']);
    });
});