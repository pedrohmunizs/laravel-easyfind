<?php

namespace App\Http\Controllers;

use App\Models\BandeiraMetodo;
use App\Models\BandeiraPagamento;
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
        $metodos = MetodoPagamento::all();
        $bandeiras = BandeiraPagamento::all();
        
        return view('metodos_pagamento.index',[
            'estabelecimento' => $estabelecimento,
            'metodos' =>$metodos,
            'bandeiras' =>$bandeiras
        ]);
    }

    public function load($idEstabelecimento, Request $request)
    {
        $estabelecimento = Estabelecimento::where('id', $idEstabelecimento)->first();
        
        $metodos = MetodoPagamentoAceito::where('fk_estabelecimento', $idEstabelecimento);
        
        $filter = array_filter($request['filter']);

        if(isset($filter)){

            if(isset($filter['metodo'])){
                $metodos->whereHas('bandeiraMetodo', function($query) use ($filter) {
                    $query->where('fk_metodo_pagamento', $filter['metodo']);
                });
            }

            if(isset($filter['bandeira'])){
                $metodos->whereHas('bandeiraMetodo', function($query) use ($filter) {
                    $query->where('fk_bandeira_pagamento', $filter['bandeira']);
                });
            }
        }

        $page = $request['page'];
        $perPage = intval($request['per_page']);
    
        $metodos = $metodos->paginate($perPage, ['*'], 'page', $page);

        $tableContent =  view('metodos_pagamento.table-content', [
            'metodos'  => $metodos
        ])->render();

        $pagination = $metodos->links('pagination::bootstrap-5')->render();

        return response()->json([
            'tableContent' => $tableContent,
            'pagination' => $pagination
        ]);
    }

    public function create($idEstabelecimento)
    {
        $estabelecimento = Estabelecimento::where('id', $idEstabelecimento)->first();

        $metodosEstabelecimento = MetodoPagamentoAceito::where('fk_estabelecimento', $idEstabelecimento)->pluck('fk_metodo_pagamento');
        
        $bandeirasMetodos = BandeiraMetodo::whereNotIn('id', $metodosEstabelecimento)->get();

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
