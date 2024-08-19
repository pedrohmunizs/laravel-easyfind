<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/')->namespace('App\Http\Controllers')->group(function () {
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

Route::group(['prefix' => 'produtos', 'namespace' => 'App\Http\Controllers'], function(){
    Route::get('/{id}/show', ['uses' => 'ProdutoController@show', 'as' => 'produtos.show'] );
    Route::get('/pesquisa', ['uses' => 'ProdutoController@search', 'as' => 'produtos.search'] );
    Route::get('/loadSearch', ['uses' => 'ProdutoController@loadSearch', 'as' => 'produtos.loadSearch'] );
});


Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'estabelecimentos', 'namespace' => 'App\Http\Controllers'], function(){
        Route::get('/load', ['uses' => 'EstabelecimentoController@load', 'as' => 'estabelecimentos.load'] );
        Route::get('/create', ['uses' => 'EstabelecimentoController@create', 'as' => 'estabelecimentos.create'] );
        Route::get('/{id}/edit', ['uses' => 'EstabelecimentoController@edit', 'as' => 'estabelecimentos.edit'] );
        Route::get('/', ['uses' => 'EstabelecimentoController@index', 'as' => 'estabelecimentos.index'] );
        Route::post('/',['uses' => 'EstabelecimentoController@store', 'as' => 'estabelecimentos.store'] );
        Route::put('/{id}',['uses' => 'EstabelecimentoController@update', 'as' => 'estabelecimentos.update'] );
    });

    Route::group(['prefix' => 'produtos', 'namespace' => 'App\Http\Controllers'], function(){
        Route::get('/{idEstabelecimento}', ['uses' => 'ProdutoController@index', 'as' => 'produtos.index'] );
        Route::get('/{idEstabelecimento}/create', ['uses' => 'ProdutoController@create', 'as' => 'produtos.create'] );
        Route::get('/{idEstabelecimento}/load', ['uses' => 'ProdutoController@load', 'as' => 'produtos.load'] );
        Route::get('/{id}/edit', ['uses' => 'ProdutoController@edit', 'as' => 'produtos.edit'] );
        Route::post('/',['uses' => 'ProdutoController@store', 'as' => 'produtos.store'] );
        Route::put('/{id}',['uses' => 'ProdutoController@update', 'as' => 'produtos.update'] );
        Route::patch('/{id}',['uses' => 'ProdutoController@active', 'as' => 'produtos.active'] );
        Route::delete('/{id}',['uses' => 'ProdutoController@destroy', 'as' => 'produtos.destroy'] );
    });

    Route::group(['prefix' => 'secoes', 'namespace' => 'App\Http\Controllers'], function(){
        Route::get('/{id}/edit', ['uses' => 'SecaoController@edit', 'as' => 'secoes.edit'] );
        Route::get('/{idEstabelecimento}', ['uses' => 'SecaoController@index', 'as' => 'secoes.index'] );
        Route::get('/{idEstabelecimento}/load', ['uses' => 'SecaoController@load', 'as' => 'secoes.load'] );
        Route::get('/{idEstabelecimento}/create', ['uses' => 'SecaoController@create', 'as' => 'secoes.create'] );
        Route::post('/',['uses' => 'SecaoController@store', 'as' => 'secoes.store'] );
        Route::put('/{id}',['uses' => 'SecaoController@update', 'as' => 'secoes.update'] );
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

    Route::group(['prefix' =>'avaliacoes', 'namespace' => 'App\Http\Controllers'], function(){
        Route::post('/', ['uses' => 'AvaliacaoController@store', 'as' => 'avaliacoes.store']);
    });

    Route::group(['prefix' => 'usuarios', 'namespace' => 'App\Http\Controllers'], function(){
        Route::get('/',['uses' => 'UserController@logout', 'as' => 'usuarios.logout'] );
    });

    Route::group(['prefix' =>'carrinhos', 'namespace' => 'App\Http\Controllers'], function(){
        Route::get('/load', ['uses' => 'CarrinhoController@load', 'as' => 'carrinhos.load']);
        Route::get('/', ['uses' => 'CarrinhoController@index', 'as' => 'carrinhos.index']);
        Route::post('/', ['uses' => 'CarrinhoController@store', 'as' => 'carrinhos.store']);
        Route::patch('/{id}', ['uses' => 'CarrinhoController@update', 'as' => 'carrinhos.update']);
    });

    Route::group(['prefix' =>'pedidos', 'namespace' => 'App\Http\Controllers'], function(){
        Route::get('/create',['uses' => 'PedidoController@create', 'as' => 'pedidos.create']);
        Route::get('/load',['uses' => 'PedidoController@load', 'as' => 'pedidos.load']);
        Route::get('/{id}/show',['uses' => 'PedidoController@show', 'as' => 'pedidos.show']);
        Route::get('/',['uses' => 'PedidoController@index', 'as' => 'pedidos.index']);
        Route::get('/{idEstabelecimento}/index',['uses' => 'PedidoController@indexComerciante', 'as' => 'pedidos.indexComerciante']);
        Route::get('/{idEstabelecimento}/load',['uses' => 'PedidoController@loadComerciante', 'as' => 'pedidos.loadComerciante']);
        Route::get('/{idEstabelecimento}/historico',['uses' => 'PedidoController@historic', 'as' => 'pedidos.historico']);
        Route::get('/{idEstabelecimento}/historico/load',['uses' => 'PedidoController@loadHistoric', 'as' => 'pedidos.loadHistorico']);
        Route::get('/{idEstabelecimento}/show/{id}',['uses' => 'PedidoController@showComerciante', 'as' => 'pedidos.showComerciante']);
        Route::patch('/{id}',['uses' => 'PedidoController@changeStatus', 'as' => 'pedidos.status'] );
        Route::post('/', ['uses' => 'PedidoController@store', 'as' => 'pedidos.store']);
    });

    Route::group(['prefix' => 'consumidores', 'namespace' => 'App\Http\Controllers'], function(){
        Route::get('/{id}/edit',['uses' => 'ConsumidorController@edit', 'as' => 'consumidores.edit'] );
        Route::put('/{id}',['uses' => 'ConsumidorController@update', 'as' => 'consumidores.update'] );
    });

    Route::group(['prefix' => 'comerciantes', 'namespace' => 'App\Http\Controllers'], function(){
        Route::get('/{id}/edit',['uses' => 'ComercianteController@edit', 'as' => 'comerciantes.edit'] );
        Route::put('/{id}',['uses' => 'ComercianteController@update', 'as' => 'comerciantes.update'] );
    });
});