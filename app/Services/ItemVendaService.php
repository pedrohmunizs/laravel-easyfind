<?php

namespace App\Services;

use App\Models\ItemVenda;
use App\Models\Produto;
use Exception;

class ItemVendaService
{
    public function store($request, $idPedido)
    {
        try{
            $produto = Produto::find($request['itemVenda.fk_produto']);
            $itemVenda = new ItemVenda();
            $itemVenda->fill($request['itemVenda']);
            $itemVenda->fk_pedido = $idPedido;
            $itemVenda->fk_consumidor = auth()->user()->consumidor->id;
            $itemVenda->valor = $produto->preco;
            $itemVenda->is_promocao_ativa = $produto->is_promocao_ativa;
            
            if($produto->is_promocao_ativa){
                $itemVenda->valor = $produto->preco_oferta;
            }
        
            $itemVenda->save();
            
            return $itemVenda;
        }catch(Exception $e){
            throw $e;
        }
    }
}