<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/')->namespace('App\Http\Controllers')->group(function () {
   // Route::get('/',['uses' => 'UserController@index', 'as' => 'home'] );
    Route::get('/',['uses' => 'EasyFindController@index', 'as' => 'home'] );
});

Route::group(['prefix' => 'usuarios', 'namespace' => 'App\Http\Controllers'], function(){
    Route::get('/create',['uses' => 'UserController@create', 'as' => 'usuarios.create'] );
    Route::get('/login',['uses' => 'UserController@login', 'as' => 'login'] );
    Route::post('/',['uses' => 'UserController@auth', 'as' => 'usuarios.auth'] );
});

Route::group(['prefix' => 'comerciantes', 'namespace' => 'App\Http\Controllers'], function(){
    Route::get('/create',['uses' => 'ComercianteController@create', 'as' => 'comerciantes.create'] );
    Route::post('/',['uses' => 'ComercianteController@store', 'as' => 'comerciantes.store'] );
});

Route::group(['prefix' => 'consumidores', 'namespace' => 'App\Http\Controllers'], function(){
    Route::get('/create',['uses' => 'ConsumidorController@create', 'as' => 'consumidores.create'] );
    Route::post('/',['uses' => 'ConsumidorController@store', 'as' => 'consumidores.store'] );
});

Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'estabelecimentos', 'namespace' => 'App\Http\Controllers'], function(){
        Route::get('/load', ['uses' => 'EstabelecimentoController@load', 'as' => 'estabelecimentos.load'] );
        Route::get('/create', ['uses' => 'EstabelecimentoController@create', 'as' => 'estabelecimentos.create'] );
        Route::get('/', ['uses' => 'EstabelecimentoController@index', 'as' => 'estabelecimentos.index'] );
        Route::post('/',['uses' => 'EstabelecimentoController@store', 'as' => 'estabelecimentos.store'] );
    });

    Route::group(['prefix' => 'produtos', 'namespace' => 'App\Http\Controllers'], function(){
        Route::get('/{idEstabelecimento}', ['uses' => 'ProdutoController@index', 'as' => 'produtos.index'] );
        Route::get('/{idEstabelecimento}/create', ['uses' => 'ProdutoController@create', 'as' => 'produtos.create'] );
        Route::get('/{idEstabelecimento}/load', ['uses' => 'ProdutoController@load', 'as' => 'produtos.load'] );
        Route::post('/',['uses' => 'ProdutoController@store', 'as' => 'produtos.store'] );
        Route::patch('/{id}',['uses' => 'ProdutoController@active', 'as' => 'produtos.active'] );
        Route::delete('/{id}',['uses' => 'ProdutoController@destroy', 'as' => 'produtos.destroy'] );
    });

    Route::group(['prefix' => 'secoes', 'namespace' => 'App\Http\Controllers'], function(){
        Route::get('/{idEstabelecimento}', ['uses' => 'SecaoController@index', 'as' => 'secoes.index'] );
        Route::get('/{idEstabelecimento}/load', ['uses' => 'SecaoController@load', 'as' => 'secoes.load'] );
        Route::get('/{idEstabelecimento}/create', ['uses' => 'SecaoController@create', 'as' => 'secoes.create'] );
        Route::post('/',['uses' => 'SecaoController@store', 'as' => 'secoes.store'] );
        Route::delete('/{id}',['uses' => 'SecaoController@destroy', 'as' => 'secoes.destroy'] );
    });
    
    Route::group(['prefix' => 'metodos', 'namespace' => 'App\Http\Controllers'], function(){
        Route::get('/{idEstabelecimento}/create', ['uses' => 'MetodoPagamentoAceitoController@create', 'as' => 'metodos.create'] );
        Route::get('/{idEstabelecimento}/load', ['uses' => 'MetodoPagamentoAceitoController@load', 'as' => 'metodos.load'] );
        Route::get('/{idEstabelecimento}', ['uses' => 'MetodoPagamentoAceitoController@index', 'as' => 'metodos.index'] );
        Route::post('/', ['uses' => 'MetodoPagamentoAceitoController@store', 'as' => 'metodos.store'] );
        Route::delete('/{id}', ['uses' => 'MetodoPagamentoAceitoController@destroy', 'as' => 'metodos.destroy'] );
    });

    Route::group(['prefix' =>'agendas', 'namespace' => 'App\Http\Controllers'], function(){
        Route::get('/{idEstabelecimento}', ['uses' => 'AgendaController@index', 'as' => 'agendas.index']);
        Route::post('/{idEstabelecimento}', ['uses' => 'AgendaController@update', 'as' => 'agendas.update']);
    });
});