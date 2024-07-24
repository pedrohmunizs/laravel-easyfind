<?php

namespace App\Http\Controllers;

use App\Models\BandeiraMetodo;
use App\Models\MetodoPagamento;
use App\Models\Produto;
use App\Services\PedidoService;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    protected $service;

    public function __construct(PedidoService $pedidoService) {
        $this->service = $pedidoService;
    }

    public function create(Request $request)
    {
        $produto = Produto::find($request['idProduto']);
        $mp = [];
        $metodos = $produto->secao->estabelecimento->metodosPagamentosAceito;
        foreach($metodos as $metodo){
            $bandeirametodo = $metodo->bandeiraMetodo;
            $mp[] += $bandeirametodo->fk_metodo_pagamento;
        }

        $mp = array_unique($mp);
        $metodos = MetodoPagamento::whereIn('id', $mp)->get();
        $bandeirasMetodos = $produto->secao->estabelecimento->metodosPagamentosAceito;
        return view('pedidos.create',[
            'produto' => $produto,
            'quantidade' => $request['quantidade'],
            'metodos' => $metodos,
            'aceitos' => $bandeirasMetodos
        ]);
    }

    public function store(Request $request)
    {
        $pedido = $this->service->store($request);
        return $pedido;
    }
}
