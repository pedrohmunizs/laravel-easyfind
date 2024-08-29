<?php

namespace App\Listeners;

use App\Enums\StatusPedido;
use App\Events\ChangeStatusPedido;
use App\Events\UpdateTotalProdutoSold;
use App\Models\Pedido;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ChangeStatusPedidoListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ChangeStatusPedido $event): void
    {
        $pedido = Pedido::find($event->id);
        $pedido->status = $event->status;
        $pedido->save();

        if($event->status == StatusPedido::Finalizado->value){
            $itens = $pedido->itensVenda;
            foreach($itens as $item){
                event(new UpdateTotalProdutoSold($item->produto, $item->quantidade));
            }
        }
    }
}
