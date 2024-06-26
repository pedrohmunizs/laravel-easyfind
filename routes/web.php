<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/')->namespace('App\Http\Controllers')->group(function () {
    Route::get('/',['uses' => 'ComercianteController@create', 'as' => 'comerciante.create'] );
    Route::post('/comerciantes',['uses' => 'ComercianteController@store', 'as' => 'comerciante.store'] );
});
