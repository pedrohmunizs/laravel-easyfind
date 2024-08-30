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

    public function store($data, $tags)
    {
        try{
            $produto = new Produto();
            $produto->fill($data);
            $produto->save();

            if(json_decode($tags['fk_tag'])){
                $tags = $this->produtoTagService->store($tags, $produto->id);
            }

            if(isset($data['images'])){
                $this->imagemService->storeProduto($data['images'], $produto->id);
            }

            return response()->json(['message' => 'Produto cadastrado com sucesso!'], 201);

        }catch(Exception $e){
            $this->produtoTagService->destroyAll($produto->id);

            throw new Exception("Erro ao criar o estabelecimento: " . $e->getMessage());
        }
    }

    public function update($id, $data, $tags)
    {
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

        return $produto;
    }

    public function destroy($id)
    {
        $produto = Produto::find($id);
        $produto->delete();
    }
}