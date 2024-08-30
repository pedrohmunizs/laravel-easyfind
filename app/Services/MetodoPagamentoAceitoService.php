<?php

namespace App\Services;

use App\Models\MetodoPagamentoAceito;

class MetodoPagamentoAceitoService
{
    public function store($metodos, $idEstabelecimento)
    {
        foreach($metodos as $metodo){

            $existe = MetodoPagamentoAceito::where('fk_estabelecimento', $idEstabelecimento)->where('fk_metodo_pagamento', $metodo)->first();

            if(!$existe){
                $aceito = new MetodoPagamentoAceito();
                $aceito->fk_metodo_pagamento = $metodo;
                $aceito->fk_estabelecimento = $idEstabelecimento;
                $aceito->save();
            }

            if($existe && $existe->status == false){
                $existe->status = true;
                $existe->save();
            }
        }
    }

    public function destroy($id)
    {
        $metodo = MetodoPagamentoAceito::find($id);
        $metodo->status = false;
        $metodo->save();
    }
}