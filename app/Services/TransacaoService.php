<?php

namespace App\Services;

use App\Models\Transacao;
use Exception;

class TransacaoService
{
    public function store($valor, $idPedido)
    {
        try{
            $transacao = new Transacao();
            $transacao->valor = ($valor);
            $transacao->fk_pedido = $idPedido;

            $transacao->save();

            return response()->json(null, 201);

        }catch(Exception $e){
            throw $e;
        }
    }
}