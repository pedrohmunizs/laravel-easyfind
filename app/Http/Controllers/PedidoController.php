<?php

namespace App\Http\Controllers;

use App\Enums\StatusPedido;
use App\Events\ChangeStatusPedido;
use App\Jobs\SendEmailJob;
use App\Models\Carrinho;
use App\Models\Consumidor;
use App\Models\Estabelecimento;
use App\Models\ItemVenda;
use App\Models\MetodoPagamento;
use App\Models\Pedido;
use App\Models\Produto;
use App\Services\PedidoService;
use Carbon\Carbon;
use Exception;
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
        if (Gate::denies('consumidor')) {
            abort(404);
        }

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

            $metodos = $produtos->first()->secao->estabelecimento->metodosPagamentosAceito;            
            $bandeirasMetodos = $produtos->first()->secao->estabelecimento->metodosPagamentosAceito;
        }else{
            $produtos = Produto::where('id' ,$request['idProduto'])->get();
            $produtos->first()->quantidade = $request['quantidade'];
            $metodos = $produtos->first()->secao->estabelecimento->metodosPagamentosAceito;
            $bandeirasMetodos = $produtos->first()->secao->estabelecimento->metodosPagamentosAceito;
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
        try{
            $this->service->store($request);
            return response()->json(['message' => 'Pedido criado com sucesso!'], 201);
        }catch(Exception $e){
            return response()->json(['message' => 'Erro ao criar pedido'], 500);
        }
    }

    public function show($id)
    {
        if (Gate::denies('consumidor')) {
            abort(404);
        }

        $pedido = Pedido::find($id);

        return view('pedidos.show',[
            'pedido' => $pedido
        ]);
    }

    public function indexComerciante($idEstabelecimento)
    {
        if (Gate::denies('comerciante')) {
            abort(404);
        }

        $estabelecimento = Estabelecimento::where('id', $idEstabelecimento)->first();

        $pedidos = Pedido::whereHas('itensVenda.produto.secao.estabelecimento', function ($query) use ($idEstabelecimento) {
            $query->where('estabelecimentos.id', $idEstabelecimento);
        })
            ->whereNotIn('status', [StatusPedido::Cancelado->value, StatusPedido::Finalizado->value])
            ->get();

        return view('pedidos.comerciantes.index',[
            'estabelecimento' => $estabelecimento,
            'pedidos' => count($pedidos)
        ]);
    }

    public function loadComerciante($idEstabelecimento, Request $request)
    {
        $range = $request['range'];
        $order = $request['order'];
        $filter = array_filter($request['filter']);

        $pedidos = Pedido::whereHas('itensVenda.produto.secao.estabelecimento', function ($query) use ($idEstabelecimento) {
            $query->where('estabelecimentos.id', $idEstabelecimento);
        })
            ->whereNotIn('status', [StatusPedido::Cancelado->value, StatusPedido::Finalizado->value]);

        if(!empty($range)){
            $rangeDate = Carbon::now()->subDays($request['range']);
            $pedidos->where('created_at', '>=', $rangeDate);
        }

        if(!empty($order)){
            $pedidos->orderBy('created_at', $order);
        }

        if(!empty($filter)){

            if(isset($filter['status'])){
                $pedidos->where('status', $filter['status']);
            }
            
            if(isset($filter['is_pagamento_online'])){
                $pedidos->where('is_pagamento_online', $filter['is_pagamento_online']);
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
        if (Gate::denies('comerciante')) {
            abort(404);
        }

        $estabelecimento = Estabelecimento::find($idEstabelecimento);

        $pedidos = Pedido::whereHas('itensVenda.produto.secao.estabelecimento', function ($query) use ($idEstabelecimento) {
            $query->where('estabelecimentos.id', $idEstabelecimento);
        })
            ->whereNotIn('status', [StatusPedido::Cancelado->value, StatusPedido::Finalizado->value])
            ->get();

        $pedido = Pedido::find($id);

        return view('pedidos.comerciantes.show', [
            'estabelecimento' => $estabelecimento,
            'pedido' => $pedido,
            'pedidos' => count($pedidos)
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

        $consumidor = Consumidor::find($pedido->itensVenda->first()->fk_consumidor);

        event(new ChangeStatusPedido($id, $request['status']));

        SendEmailJob::dispatch([
            'toName' => $consumidor->user->nome,
            'toEmail' => $consumidor->user->email,
            'subject' => "Atualização do pedido $id",
            'id' => $id
        ])->onQueue('changeStatus');

        return response()->json(['message' => 'Status do pedido atualizado com sucesso!'], 201);
    }

    public function historic($idEstabelecimento)
    {
        if (Gate::denies('comerciante')) {
            abort(404);
        }

        $estabelecimento = Estabelecimento::find($idEstabelecimento);

        $pedidos = Pedido::whereHas('itensVenda.produto.secao.estabelecimento', function ($query) use ($idEstabelecimento) {
            $query->where('estabelecimentos.id', $idEstabelecimento);
        })
            ->whereNotIn('status', [StatusPedido::Cancelado->value, StatusPedido::Finalizado->value])
            ->get();

        return view('pedidos.comerciantes.historic', [
            'estabelecimento' => $estabelecimento,
            'pedidos' => count($pedidos)
        ]);
    }

    public function loadHistoric($idEstabelecimento, Request $request)
    {
        $filter = array_filter($request['filter']);

        $pedidos = Pedido::whereHas('itensVenda.produto.secao.estabelecimento', function ($query) use ($idEstabelecimento) {
            $query->where('estabelecimentos.id', $idEstabelecimento);
        })
            ->whereIn('status', [StatusPedido::Cancelado->value, StatusPedido::Finalizado->value])
            ->orderBy('created_at', $request['order']);

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
