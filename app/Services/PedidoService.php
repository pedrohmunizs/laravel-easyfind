<?php

namespace App\Services;

use App\Enums\StatusPedido;
use App\Events\EsvaziarCarrinho;
use App\Events\TransacaoEvent;
use App\Models\Pedido;
use App\Models\Produto;
use Exception;

class PedidoService
{
    protected $itemService;

    public function __construct(ItemVendaService $itemVendaService) {
        $this->itemService = $itemVendaService;
    }

    public function store($request)
    {
        $data = $request['pedido'];

        $pedido = new Pedido();
        $pedido->fill($data);
        $pedido->status = StatusPedido::Pendente;

        $pedido->save();

        $itemVenda = $this->itemService->store($request, $pedido->id);

        event(new TransacaoEvent($itemVenda, $pedido->id));

        if($data['origem'] == 'carrinho'){

            $produto = Produto::find($request['itemVenda'][0]['fk_produto']);
            $estabelecimentoId = $produto->secao->estabelecimento->id;

            event(new EsvaziarCarrinho($estabelecimentoId));
        }

        return response()->json(['message' => 'Pedido realizado com sucesso!'], 201);
    }
}