<?php

namespace App\Http\Controllers;

use App\Enums\StatusPedido;
use App\Models\BandeiraMetodo;
use App\Models\BandeiraPagamento;
use App\Models\Estabelecimento;
use App\Models\MetodoPagamento;
use App\Models\MetodoPagamentoAceito;
use App\Models\Pedido;
use App\Services\MetodoPagamentoAceitoService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MetodoPagamentoAceitoController extends Controller
{
    protected $service;
    
    public function __construct( MetodoPagamentoAceitoService $metodoPagamentoAceitoService) {
        $this->service = $metodoPagamentoAceitoService;
    }

    public function index($idEstabelecimento)
    {
        if (Gate::denies('comerciante')) {
            abort(404);
        }

        $estabelecimento = Estabelecimento::where('id', $idEstabelecimento)->first();
        $metodos = MetodoPagamento::all();
        $bandeiras = BandeiraPagamento::all();
        $pedidos = Pedido::whereHas('itensVenda.produto.secao.estabelecimento', function ($query) use ($idEstabelecimento) {
            $query->where('estabelecimentos.id', $idEstabelecimento);
        })
            ->whereNotIn('status', [StatusPedido::Cancelado->value, StatusPedido::Finalizado->value])
            ->get();

        return view('metodos.index',[
            'estabelecimento' => $estabelecimento,
            'metodos' =>$metodos,
            'bandeiras' =>$bandeiras,
            'pedidos' => count($pedidos)
        ]);
    }

    public function load($idEstabelecimento, Request $request)
    {   
        $metodos = MetodoPagamentoAceito::where('fk_estabelecimento', $idEstabelecimento)->where('status', 1);
        
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

        $tableContent =  view('metodos.table-content', [
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
        if (Gate::denies('comerciante')) {
            abort(404);
        }

        $estabelecimento = Estabelecimento::where('id', $idEstabelecimento)->first();

        $metodosEstabelecimento = MetodoPagamentoAceito::where('fk_estabelecimento', $idEstabelecimento)->where('status', 1)->pluck('fk_metodo_pagamento');
        
        $bandeirasMetodos = BandeiraMetodo::whereNotIn('id', $metodosEstabelecimento)->get();

        $metodosPagamento = MetodoPagamento::all();

        foreach($bandeirasMetodos as $bandeiraMetodo){
            $bandeiraMetodo->bandeira = $bandeiraMetodo->bandeiraPagamento->nome;
            $bandeiraMetodo->imagem = $bandeiraMetodo->bandeiraPagamento->imagem;
        }
        
        $pedidos = Pedido::whereHas('itensVenda.produto.secao.estabelecimento', function ($query) use ($idEstabelecimento) {
            $query->where('estabelecimentos.id', $idEstabelecimento);
        })
            ->whereNotIn('status', [StatusPedido::Cancelado->value, StatusPedido::Finalizado->value])
            ->get();

        return view('metodos.create', [
            'estabelecimento' => $estabelecimento,
            'bandeirasMetodos' => $bandeirasMetodos,
            'metodosPagamento' => $metodosPagamento,
            'pedidos' => count($pedidos)
        ]);
    }

    public function store(Request $request)
    {
        try{
            $this->service->store($request['metodo'], $request['estabelecimento']);
            return response()->json(['message' => 'Método adicionado com sucesso!'], 201);
        }catch(Exception $e){
            return response()->json(['message' => 'Erro ao adicionar método!'], 500);
        }
    }

    public function destroy($id)
    {
        try{
            $this->service->destroy($id);
            return response()->json(['message' => 'Método Excluído com sucesso!'], 204);
        }catch(Exception $e){
            return response()->json(['message' => 'Erro ao excluir método!'], 500);
        }
    }
}
