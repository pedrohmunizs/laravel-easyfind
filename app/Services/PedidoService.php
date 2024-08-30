<?php

namespace App\Services;

use App\Enums\StatusPedido;
use App\Events\EsvaziarCarrinho;
use App\Events\TransacaoEvent;
use App\Jobs\SendEmailJob;
use App\Models\Pedido;
use App\Models\Produto;

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

        $email = [
            'valor' => $itemVenda,
            'id' => $pedido->id,
            'estabelecimento' => $pedido->itensVenda->first()->produto->secao->estabelecimento->id
        ];

        SendEmailJob::dispatch([
            'toName' => $pedido->itensVenda->first()->produto->secao->estabelecimento->nome,
            'toEmail' => $pedido->itensVenda->first()->produto->secao->estabelecimento->email,
            'subject' => "Novo pedido recebido",
            'template' => "create-pedido",
            'email' => $email
        ])->onQueue('newPedido');

        return $pedido;
    }
}