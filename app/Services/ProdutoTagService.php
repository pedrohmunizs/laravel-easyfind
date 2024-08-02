<?php

namespace App\Services;

use App\Models\ProdutoTag;
use Exception;

class ProdutoTagService{

    public function store($tags, $idProduto)
    {
        try{
            $tags = json_decode($tags['fk_tag']);
            
            foreach($tags as $tag){
                $produtoTag = new ProdutoTag();
                $produtoTag->fk_tag = $tag;
                $produtoTag->fk_produto = $idProduto;
                $produtoTag->save();
            }

            return response()->json(null, 201);

        }catch(Exception $e){
            throw $e;
        }
    }
}