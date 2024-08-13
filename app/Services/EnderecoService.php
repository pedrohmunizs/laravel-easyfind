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

    public function update($id, $data)
    {
        try{
            $endereco = Endereco::find($id);
            $endereco->fill($data);
            $endereco->save();

            return $endereco;

        }catch(Exception $e){
            throw $e;
        }
    }
}