<?php

namespace App\Listeners;

use App\Events\UpdateTotalProdutoSold;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateTotalProdutoSoldListener
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
    public function handle(UpdateTotalProdutoSold $event): void
    {
        $produto = $event->produto;
        $produto->qtd_vendas = ($produto->qtd_vendas + $event->qtd) ;
        $produto->save();
    }
}
