<?php

namespace App\Services;

use App\Models\Endereco;

class EnderecoService
{
    public function store($data, $cepData, $id = null)
    {
        $cepData = json_decode($cepData, true);

        $endereco = new Endereco();

        if($id){
            $endereco = $endereco::find($id);
        }

        $endereco->fill($data);
        $endereco->latitude = $cepData['latitude'];
        $endereco->longitude = $cepData['longitude'];
        $endereco->save();

        return $endereco;
    }

    public function destroy($id)
    {
        $endereco = Endereco::find($id);
        $endereco->delete();
    }
}