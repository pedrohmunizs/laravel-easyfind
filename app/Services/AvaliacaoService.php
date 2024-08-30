<?php

namespace App\Services;

use App\Models\Avaliacao;
use Exception;

class AvaliacaoService
{
    public function store($data, $idConsumidor)
    {
        $avaliacao = new Avaliacao();
        $avaliacao->fill($data);
        $avaliacao->fk_consumidor = $idConsumidor;
        $avaliacao->save();

        return $avaliacao;
    }
}