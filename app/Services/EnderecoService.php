<?php

namespace App\Services;

use App\Models\Endereco;
use Exception;

class EnderecoService
{
    public function store($request, $cepData)
    {
        try{
            $cepData = json_decode($cepData, true);

            $endereco = new Endereco();
            $endereco->fill($request);
            $endereco->latitude = $cepData['latitude'];
            $endereco->longitude = $cepData['longitude'];
            $endereco->save();

            return $endereco;

        }catch(Exception $e){
            throw $e;
        }
    }

    public function update($id, $data, $cepData)
    {
        try{
            $cepData = json_decode($cepData, true);

            $endereco = Endereco::find($id);
            $endereco->fill($data);
            $endereco->latitude = $cepData['latitude'];
            $endereco->longitude = $cepData['longitude'];
            $endereco->save();

            return $endereco;

        }catch(Exception $e){
            throw $e;
        }
    }

    public function destroy($id)
    {
        $endereco = Endereco::find($id);
        $endereco->delete();
    }
}