<?php

namespace App\Services;

use App\Models\Secao;
use Exception;

class SecaoService{

    public function store($request)
    {
        try{
            $secao = new Secao();
            $secao->fill($request);
            $secao->save();
            
            return response()->json(['message' => 'Seção criado com sucesso!'], 201);
            
        }catch(Exception $e){
            throw $e;
        }
    }

    public function destroy($id)
    {
        $secao = Secao::where('id', $id)->first();
        $secao->delete();
        
        return response()->json(['message' => 'Seção removida com sucesso!'], 204);        
    }

    public function update($id, $descricao)
    {
        try{
            $secao = Secao::find($id);
            $secao->descricao = $descricao;
            $secao->save();

            return response()->json(['message' => 'Seção atualizado com sucesso!'], 201);

        }catch(Exception $e){
            throw $e;
        }
    }
}