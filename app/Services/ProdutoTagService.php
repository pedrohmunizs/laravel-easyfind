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

    public function update($tags, $idProduto)
    {
        $tags = json_decode($tags['fk_tag']);

        ProdutoTag::where('fk_produto', $idProduto)->whereNotIn('fk_tag', $tags)->delete();

        foreach($tags as $tag){

            ProdutoTag::firstOrCreate([
                'fk_produto' => $idProduto,
                'fk_tag' => $tag,
            ]);
        }
    }

    public function destroy($id)
    {
        $tag = ProdutoTag::find($id);
        $tag->delete();
    }

    public function destroyAll($idProduto)
    {
        ProdutoTag::where('fk_produto', $idProduto)->delete();   
    }
}