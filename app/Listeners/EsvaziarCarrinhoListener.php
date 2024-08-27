<?php

namespace App\Listeners;

use App\Events\EsvaziarCarrinho;
use App\Models\Carrinho;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EsvaziarCarrinhoListener
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
    public function handle(EsvaziarCarrinho $event): void
    {
        $idEstabelecimento = $event->idEstabelecimento;

        Carrinho::where('fk_consumidor', auth()->user()->consumidor->id)
            ->whereHas('produto.secao.estabelecimento', function ($query) use ($idEstabelecimento) {
                $query->where('id', $idEstabelecimento);
            })->delete();
    }
}
