<?php

namespace App\Listeners;

use App\Events\TransacaoEvent;
use App\Models\Transacao;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TransacaoListener
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
    public function handle(TransacaoEvent $event): void
    {
        $transacao = new Transacao();
        $transacao->valor = $event->valor;
        $transacao->fk_pedido = $event->idPedido;

        $transacao->save();
    }
}
