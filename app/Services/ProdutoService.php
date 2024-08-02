<?php

namespace App\Services;

use App\Models\Produto;
use Exception;

class ProdutoService{

    protected $produtoTagService;
    protected $imagemService;

    public function __construct(ProdutoTagService $produtoTagService, ImagemService $imagemService) {
        $this->produtoTagService = $produtoTagService;
        $this->imagemService = $imagemService;
    }

    public function store($produto, $tags)
    {
        try{
            $newProduto = new Produto();
            $newProduto->fill($produto);
            $newProduto->save();

            if(json_decode($tags['fk_tag'])){
                $this->produtoTagService->store($tags, $newProduto->id);
            }

            $this->imagemService->storeProduto($produto['images'], $newProduto->id);
            
            return response()->json(['message' => 'Produto cadastrado com sucesso!'], 201);

        }catch(Exception $e){
            throw $e;
        }
    }
}