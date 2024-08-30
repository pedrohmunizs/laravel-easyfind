<?php

namespace App\Services;

use App\Models\Secao;
use Exception;

class SecaoService{

    public function store($request)
    {
        $secao = new Secao();
        $secao->fill($request);
        $secao->save();
            
        return $secao;
    }

    public function destroy($id)
    {
        $secao = Secao::where('id', $id)->first();
        $secao->delete();     
    }

    public function update($id, $descricao)
    {
        $secao = Secao::find($id);
        $secao->descricao = $descricao;
        $secao->save();

        return $secao;
    }
}