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
            
            return response()->json($secao, 201);
            
        }catch(Exception $e){
            throw $e;
        }
    }

    public function destroy($id)
    {
        $secao = Secao::where('id', $id)->first();
        $secao->delete();
        
        return response()->json(null, 204);
    }
}