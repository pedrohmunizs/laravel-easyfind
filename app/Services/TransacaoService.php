<?php

namespace App\Services;

use App\Models\Transacao;
use Exception;

class TransacaoService
{
    public function store($item, $idPedido)
    {
        try{
            $transacao = new Transacao();
            $transacao->valor = ($item->valor * $item->quantidade);
            $transacao->fk_pedido = $idPedido;

            $transacao->save();

            return response()->json(null, 201);

        }catch(Exception $e){
            throw $e;
        }
    }
}