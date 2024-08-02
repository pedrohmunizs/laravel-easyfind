<?php

namespace App\Services;

use App\Models\Endereco;
use Exception;

class EnderecoService
{
    public function store($request)
    {
        try{
            $endereco = new Endereco();
            $endereco->fill($request);
            $endereco->save();

            return $endereco;

        }catch(Exception $e){
            throw $e;
        }
    }
}