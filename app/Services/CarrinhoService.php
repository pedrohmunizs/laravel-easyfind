<?php

namespace App\Services;

use App\Models\Carrinho;
use Exception;

class CarrinhoService
{
    public function store($data, $idConsumidor)
    {
        try{
            $carrinho = new Carrinho();
            $carrinho->fill($data);
            $carrinho->fk_consumidor = $idConsumidor;
            $carrinho->save();
            
            return response()->json(['success' => 'Produto adicionado o carrinho com sucesso!', 201]);
        }catch(Exception $e){
            return $e;
        }
    }

    public function update(Carrinho $carrinho, $quantidade)
    {
        try{
            $carrinho->quantidade = ($quantidade + $carrinho->quantidade);
            $carrinho->save();

            return response()->json(['success' => 'Quantidade atualizado com sucesso!', 201]);
        }catch(Exception $e){
            return response()->json(['error' => 'Erro ao atualizar a quantidade do produto no carrinho!'], 500);
        }
    }
}