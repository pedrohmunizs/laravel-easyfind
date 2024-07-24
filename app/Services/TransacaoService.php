<?php

namespace App\Services;

use App\Models\Transacao;
use Exception;

class TransacaoService
{
    public function store($valor, $idPedido)
    {
        $transacao = new Transacao();
        $transacao->valor = $valor;
        $transacao->fk_pedido = $idPedido;
        $transacao->save();
            
        return $transacao;
    }
}