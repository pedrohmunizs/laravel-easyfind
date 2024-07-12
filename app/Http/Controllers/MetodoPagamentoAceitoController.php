<?php

namespace App\Http\Controllers;

use App\Models\BandeiraMetodo;
use App\Models\Estabelecimento;
use App\Models\MetodoPagamento;
use App\Models\MetodoPagamentoAceito;
use App\Services\MetodoPagamentoAceitoService;
use Illuminate\Http\Request;

class MetodoPagamentoAceitoController extends Controller
{
    protected $service = null;
    
    public function __construct( MetodoPagamentoAceitoService $metodoPagamentoAceitoService) {
        $this->service = $metodoPagamentoAceitoService;
    }

    public function index($idEstabelecimento)
    {
        $estabelecimento = Estabelecimento::where('id', $idEstabelecimento)->first();
        
        return view('metodos_pagamento.index',[
            'estabelecimento' => $estabelecimento
        ]);
    }

    public function create($idEstabelecimento)
    {
        $estabelecimento = Estabelecimento::where('id', $idEstabelecimento)->first();

        $bandeirasMetodos = BandeiraMetodo::all();
        $metodosPagamento = MetodoPagamento::all();

        foreach($bandeirasMetodos as $bandeiraMetodo){
            $bandeiraMetodo->bandeira = $bandeiraMetodo->bandeiraPagamento->nome;
            $bandeiraMetodo->imagem = $bandeiraMetodo->bandeiraPagamento->imagem;
        }
        
        return view('metodos_pagamento.create', [
            'estabelecimento' => $estabelecimento,
            'bandeirasMetodos' => $bandeirasMetodos,
            'metodosPagamento' => $metodosPagamento
        ]);
    }

    public function store(Request $request)
    {
        $idEstabelecimento = $request['estabelecimento'];
        $metodos = $request['metodo'];

        $aceito = $this->service->store($metodos, $idEstabelecimento);
        return $aceito;
    }
}
