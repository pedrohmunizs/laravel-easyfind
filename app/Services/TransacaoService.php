<?php

namespace App\Services;

use App\Models\Transacao;
use Exception;

class TransacaoService
{
    public function store($item, $idPedido)
    {
        $transacao = new Transacao();
        $transacao->valor = ($item->valor * $item->quantidade);
        $transacao->fk_pedido = $idPedido;
        $transacao->save();
            
        return $transacao;
    }
}