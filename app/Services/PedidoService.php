<?php

namespace App\Services;

use App\Enums\StatusPedido;
use App\Events\EsvaziarCarrinho;
use App\Events\UpdateTotalProdutoSold;
use App\Models\Carrinho;
use App\Models\Pedido;
use App\Models\Produto;
use Exception;

class PedidoService
{
    protected $itemService;
    protected $transacaoService;

    public function __construct(ItemVendaService $itemVendaService, TransacaoService $transacaoService) {
        $this->itemService = $itemVendaService;
        $this->transacaoService = $transacaoService;
    }

    public function store($request)
    {
        $data = $request['pedido'];

        try{
            $pedido = new Pedido();
            $pedido->fill($data);
            $pedido->status = StatusPedido::Pendente;

            $pedido->save();

        }catch(Exception $e){
            throw $e;
        }

        $itemVenda = $this->itemService->store($request, $pedido->id);

        $this->transacaoService->store($itemVenda, $pedido->id);

        if($data['origem'] == 'carrinho'){

            $produto = Produto::find($request['itemVenda'][0]['fk_produto']);
            $estabelecimentoId = $produto->secao->estabelecimento->id;

            event(new EsvaziarCarrinho($estabelecimentoId));
        }

        return response()->json(['message' => 'Pedido realizado com sucesso!'], 201);
    }

    public function changeStatus($id, $status)
    {
        try{
            $pedido = Pedido::find($id);
            $pedido->status = $status;
            $pedido->save();

            if($status == StatusPedido::Finalizado->value){
                $itens = $pedido->itensVenda;
                foreach($itens as $item){
                    event(new UpdateTotalProdutoSold($item->produto, $item->quantidade));
                }
            }

            return response()->json(['message' => 'Status do pedido atualizado com sucesso!'], 201);

        }catch(Exception $e){
            throw $e;
        }
    }
}