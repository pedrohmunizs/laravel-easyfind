<?php

namespace App\Services;

use App\Models\Avaliacao;
use Exception;

class AvaliacaoService
{
    public function store($data, $idConsumidor)
    {
        try{

            $avaliacao = new Avaliacao();
            $avaliacao->fill($data);
            $avaliacao->fk_consumidor = $idConsumidor;
            $avaliacao->save();
            
            return response()->json(['message' => 'Avaliação publicada com sucesso', 201]);
        }catch(Exception $e){
            throw $e;
        }
    }
}