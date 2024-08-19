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

    public function update($id, $data, $tags)
    {
        try{   
            $produto = Produto::find($id);
            $produto->fill($data);
            $produto->save();

            if(json_decode($tags['fk_tag'])){
                $this->produtoTagService->update($tags, $produto->id);
            }

            if(isset($data['images_existing'])){
                $this->imagemService->deleteProdutoImagem($data['images_existing'], $produto->id);
            }

            if(isset($data['images'])){
                $this->imagemService->storeProduto($data['images'], $produto->id);
            }

            return response()->json(['message' => 'Produto editado com sucesso!'], 201);

        }catch(Exception $e){
            throw $e;
        }
    }
}