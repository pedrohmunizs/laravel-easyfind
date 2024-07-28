<?php

namespace App\Http\Controllers;

use App\Enums\StatusPedido;
use App\Models\BandeiraMetodo;
use App\Models\Estabelecimento;
use App\Models\ItemVenda;
use App\Models\MetodoPagamento;
use App\Models\Pedido;
use App\Models\Produto;
use App\Services\PedidoService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    protected $service;

    public function __construct(PedidoService $pedidoService) {
        $this->service = $pedidoService;
    }

    public function index()
    {
        return view('pedidos.index');
    }

    public function load(Request $request)
    {
        $status = array_filter($request->toArray());

        $itensVenda = ItemVenda::where('fk_consumidor', auth()->user()->consumidor->id)->get();
        $pedidos = array_unique($itensVenda->pluck('fk_pedido')->toArray());
        $pedidos = Pedido::whereIn('id', $pedidos);

        if($status){
            $pedidos->where('status', $status);
        }

        return view('components.pedidos.card-consumidor',[
            'itensVenda' => $itensVenda,
            'pedidos' => $pedidos->get()
        ]);
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

    public function show($id)
    {
        $pedido = Pedido::find($id);

        return view('pedidos.show',[
            'pedido' => $pedido
        ]);
    }

    public function indexComerciante($idEstabelecimento)
    {
        $estabelecimento = Estabelecimento::where('id', $idEstabelecimento)->first();

        return view('pedidos.comerciantes.index',[
            'estabelecimento' => $estabelecimento
        ]);
    }

    public function loadComerciante($idEstabelecimento, Request $request)
    {
        $range = $request['range'];
        $order = $request['order'];
        $filter = array_filter($request['filter']);

        $pedidos = Pedido::join('bandeiras_metodos', 'bandeiras_metodos.id', '=', 'pedidos.fk_metodo_aceito')
                        ->join('metodos_pagamento_aceitos', 'metodos_pagamento_aceitos.fk_metodo_pagamento', '=', 'bandeiras_metodos.id')
                        ->join('estabelecimentos', 'metodos_pagamento_aceitos.fk_estabelecimento', '=', 'estabelecimentos.id')
                        ->where('estabelecimentos.id', $idEstabelecimento)
                        ->select('pedidos.*')
                        ->groupBy('pedidos.id');

        if(!empty($range)){
            $rangeDate = Carbon::now()->subDays($request['range']);
            $pedidos->where('pedidos.created_at', '>=', $rangeDate);
        }

        if(!empty($order)){
            $pedidos->orderBy('pedidos.created_at', $order);
        }

        if(!empty($filter)){

            if(isset($filter['status'])){
                $pedidos->where('pedidos.status', $filter['status']);
            }
            
            if(isset($filter['is_pagamento_online'])){
                $pedidos->where('pedidos.is_pagamento_online', $filter['is_pagamento_online']);
            }
        }

        $pedidos = $pedidos->paginate(10, ['*'], 'page', 1);

        $tableContent = view('pedidos.comerciantes.table-content', [
            'pedidos' => $pedidos,
            'estabelecimento' => $idEstabelecimento
        ])->render();

        $pagination = $pedidos->links('pagination::bootstrap-5')->render();

        return response()->json([
            'tableContent' => $tableContent,
            'pagination' => $pagination
        ]);
    }

    public function showComerciante($idEstabelecimento, $id)
    {
        $estabelecimento = Estabelecimento::find($idEstabelecimento);
        $pedido = Pedido::find($id);

        return view('pedidos.comerciantes.show', [
            'estabelecimento' => $estabelecimento,
            'pedido' => $pedido
        ]);
    }

    public function changeStatus($id, Request $request)
    {
        $pedido = Pedido::find($id);

        if($pedido->status->value == StatusPedido::Cancelado->value){
            return response()->json(['message' => 'Este pedido já foi cancelado!'], 400);
        }

        if($pedido->status->value == StatusPedido::Finalizado->value){
            return response()->json(['message' => 'Este pedido já foi finalizado!'], 400);
        }


        $pedido = $this->service->changeStatus($id, $request['status']);

        return $pedido;
    }
}
