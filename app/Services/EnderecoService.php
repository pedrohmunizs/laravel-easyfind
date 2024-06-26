<?php

namespace App\Services;

use App\Models\Endereco;

class EnderecoService
{
    public function store($request)
    {
        $endereco = new Endereco();
        $endereco->fill($request);
        $endereco->save();
        return $endereco;
    }
}