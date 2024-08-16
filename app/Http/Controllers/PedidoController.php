<?php

namespace App\Http\Controllers;

use App\Enums\StatusPedido;
use App\Models\BandeiraMetodo;
use App\Models\Carrinho;
use App\Models\Estabelecimento;
use App\Models\ItemVenda;
use App\Models\MetodoPagamento;
use App\Models\Pedido;
use App\Models\Produto;
use App\Services\PedidoService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PedidoController extends Controller
{
    protected $service;

    public function __construct(PedidoService $pedidoService) {
        $this->service = $pedidoService;
    }

    public function index()
    {
        if (Gate::denies('consumidor')) {
            abort(404);
        }

        return view('pedidos.index');
    }

    public function load(Request $request)
    {
        $status = array_filter($request->toArray());

        $itensVenda = ItemVenda::where('fk_consumidor', auth()->user()->consumidor->id)->get();
        $pedidos = array_unique($itensVenda->pluck('fk_pedido')->toArray());
        $pedidos = Pedido::whereIn('id', $pedidos)->orderBy('created_at', 'DESC');

        if($status){
            $pedidos->where('status', $status);
        }

        return view('components.pedidos.card',[
            'itensVenda' => $itensVenda,
            'pedidos' => $pedidos->get()
        ]);
    }

    public function create(Request $request)
    {
        $origem = $request['origem'];
        $mp = [];

        if($origem == 'carrinho'){

            $estabelecimentoId = $request['estabelecimento'];

            $carrinhos = Carrinho::where('fk_consumidor', auth()->user()->consumidor->id)
                ->whereHas('produto.secao.estabelecimento', function ($query) use ($estabelecimentoId) {
                    $query->where('id', $estabelecimentoId);
                })
                ->get();
            
            $produtos = Produto::whereIn('id', $carrinhos->pluck('fk_produto'))->get();

            foreach ($produtos as $produto) {
                $produto->quantidade = $carrinhos->firstWhere('fk_produto', $produto->id)->quantidade;
            }

            $metodos = $produtos[0]->secao->estabelecimento->metodosPagamentosAceito;            
            $bandeirasMetodos = $produtos[0]->secao->estabelecimento->metodosPagamentosAceito;
        }else{
            $produtos = Produto::where('id' ,$request['idProduto'])->get();
            $produtos[0]->quantidade = $request['quantidade'];
            $metodos = $produtos[0]->secao->estabelecimento->metodosPagamentosAceito;
            $bandeirasMetodos = $produtos[0]->secao->estabelecimento->metodosPagamentosAceito;
        }

        foreach($metodos as $metodo){
            $bandeirametodo = $metodo->bandeiraMetodo;
            $mp[] += $bandeirametodo->fk_metodo_pagamento;
        }

        $mp = array_unique($mp);
        $metodos = MetodoPagamento::whereIn('id', $mp)->get();

        return view('pedidos.create',[
            'produtos' => $produtos,
            'metodos' => $metodos,
            'aceitos' => $bandeirasMetodos,
            'origem' => $origem
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
                        ->whereNotIn('pedidos.status', [StatusPedido::Cancelado->value, StatusPedido::Finalizado->value])
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

    public function historic($idEstabelecimento)
    {
        $estabelecimento = Estabelecimento::find($idEstabelecimento);

        $pedidos = Pedido::join('bandeiras_metodos', 'bandeiras_metodos.id', '=', 'pedidos.fk_metodo_aceito')
            ->join('metodos_pagamento_aceitos', 'metodos_pagamento_aceitos.fk_metodo_pagamento', '=', 'bandeiras_metodos.id')
            ->join('estabelecimentos', 'metodos_pagamento_aceitos.fk_estabelecimento', '=', 'estabelecimentos.id')
            ->where('estabelecimentos.id', $idEstabelecimento)
            ->select('pedidos.*')
            ->groupBy('pedidos.id');

        return view('pedidos.comerciantes.historic', [
            'estabelecimento' => $estabelecimento
        ]);
    }

    public function loadHistoric($idEstabelecimento, Request $request)
    {
        $filter = array_filter($request['filter']);

        $pedidos = Pedido::join('bandeiras_metodos', 'bandeiras_metodos.id', '=', 'pedidos.fk_metodo_aceito')
            ->join('metodos_pagamento_aceitos', 'metodos_pagamento_aceitos.fk_metodo_pagamento', '=', 'bandeiras_metodos.id')
            ->join('estabelecimentos', 'metodos_pagamento_aceitos.fk_estabelecimento', '=', 'estabelecimentos.id')
            ->where('estabelecimentos.id', $idEstabelecimento)
            ->whereIn('pedidos.status', [StatusPedido::Cancelado->value, StatusPedido::Finalizado->value])
            ->orderBy('pedidos.created_at', $request['order'])
            ->select('pedidos.*')
            ->groupBy('pedidos.id');

        if(!empty($filter)){

            if(isset($filter['status'])){
                $pedidos->where('pedidos.status', $filter['status']);
            }

            if(isset($filter['is_pagamento_online'])){
                $pedidos->where('pedidos.is_pagamento_online', $filter['is_pagamento_online']);
            }

            if (isset($filter['data_min'])) {
                $pedidos->dateRange($filter['data_min'], null);
            }
            
            if (isset($filter['data_max'])) {
                $pedidos->dateRange(null, $filter['data_max']);
            }
        }

        $pedidos = $pedidos->paginate($request['per_page'], ['*'], 'page', $request['page']);

        $tableContent = view('pedidos.comerciantes.historic-table-content', [
            'pedidos' => $pedidos,
            'estabelecimento' => $idEstabelecimento
        ])->render();

        $pagination = $pedidos->links('pagination::bootstrap-5')->render();

        return response()->json([
            'tableContent' => $tableContent,
            'pagination' => $pagination
        ]);
    }
}
