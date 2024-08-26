<?php

namespace App\Services;

use App\Models\ItemVenda;
use App\Models\Produto;
use Exception;

class ItemVendaService
{
    public function store($request, $idPedido)
    {
        $itensVenda = $request['itemVenda'];

        $valor = 0;
        foreach($itensVenda as $item){

            try{
                $produto = Produto::find($item['fk_produto']);
                $itemVenda = new ItemVenda();
                $itemVenda->fill($item);
                $itemVenda->fk_pedido = $idPedido;
                $itemVenda->fk_consumidor = auth()->user()->consumidor->id;
                $itemVenda->is_promocao_ativa = $produto->is_promocao_ativa;
                
                if($produto->is_promocao_ativa){
                    $itemVenda->valor = $produto->preco_oferta;
                    $valor += $produto->preco_oferta * $itemVenda->quantidade;
                }else{
                    $itemVenda->valor = $produto->preco;
                    $valor += $produto->preco * $itemVenda->quantidade;
                }
                $itemVenda->save();
                
            }catch(Exception $e){
                throw $e;
            }

        }
        return $valor;
    }
}