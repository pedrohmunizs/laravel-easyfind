<?php

namespace App\Services;

use App\Models\MetodoPagamentoAceito;
use Exception;

class MetodoPagamentoAceitoService
{
    public function store($metodos, $idEstabelecimento)
    {
        try{
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

            return response()->json(['message' => 'Método atribuído ao estabelecimento com sucesso!'], 201);

        }catch(Exception $e){
            throw $e;
        }
    }

    public function destroy($id)
    {
        try{
            $metodo = MetodoPagamentoAceito::find($id);
            $metodo->status = false;
            $metodo->save();
            
            return response()->json(['message' => 'Método removido com sucesso!'], 204);

        }catch(Exception $e){
            throw $e;
        }
    }
}