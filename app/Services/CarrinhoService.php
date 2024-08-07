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
            
            return response()->json(['message' => 'Produto adicionado o carrinho com sucesso!', 201]);
        }catch(Exception $e){
            return $e;
        }
    }

    public function update(Carrinho $carrinho, $quantidade)
    {
        try{
            $carrinho->quantidade = $quantidade;
            $carrinho->save();

            return response()->json(['message' => 'Quantidade atualizado com sucesso!', 201]);
        }catch(Exception $e){
            throw $e;
        }
    }

    public function destroy(Carrinho $carrinho)
    {
        try{
            $carrinho->delete();

            return response()->json(['message' => 'Quantidade atualizado com sucesso!', 201]);
        }catch(Exception $e){
            throw $e;
        }
    }
}