<?php

namespace App\Services;

use App\Models\Carrinho;
use Exception;

class CarrinhoService
{
    public function store($data, $idConsumidor)
    {
        $carrinho = new Carrinho();
        $carrinho->fill($data);
        $carrinho->fk_consumidor = $idConsumidor;
        $carrinho->save();
            
        return $carrinho;
    }

    public function update(Carrinho $carrinho, $quantidade)
    {
        $carrinho->quantidade = $quantidade;
        $carrinho->save();

        return $carrinho;
    }

    public function destroy(Carrinho $carrinho)
    {
        $carrinho->delete();

        return $carrinho;
    }
}