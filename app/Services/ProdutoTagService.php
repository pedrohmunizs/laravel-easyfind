<?php

namespace App\Services;

use App\Models\ProdutoTag;

class ProdutoTagService{

    public function store($tags, $idProduto)
    {
        $tags = json_decode($tags['fk_tag']);

        foreach($tags as $tag){
            $produtoTag = new ProdutoTag();
            $produtoTag->fk_tag = $tag;
            $produtoTag->fk_produto = $idProduto;
            $produtoTag->save();
        }
    }
}