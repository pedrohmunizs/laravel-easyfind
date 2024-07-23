<?php

namespace App\Services;

use App\Models\Produto;
use Exception;

class ProdutoService{

    protected $produtoTagService = null;
    protected $imagemService = null;

    public function __construct(ProdutoTagService $produtoTagService, ImagemService $imagemService) {
        $this->produtoTagService = $produtoTagService;
        $this->imagemService = $imagemService;
    }

    public function store($produto, $tags)
    {
        try{
            $produto['preco'] = trim(substr($produto['preco'], 2));
            $produto['preco'] = str_replace(".", "", $produto['preco']);
            $produto['preco'] = str_replace(',', '.', $produto['preco']);
            $produto['preco'] = number_format((float) $produto['preco'], 2, '.', '');

            $produto['preco_oferta'] = trim(substr($produto['preco_oferta'], 2));
            $produto['preco_oferta'] = str_replace(".", "", $produto['preco_oferta']);
            $produto['preco_oferta'] = str_replace(',', '.', $produto['preco_oferta']);
            $produto['preco_oferta'] = number_format((float) $produto['preco_oferta'], 2, '.', '');

            $newProduto = new Produto();
            $newProduto->fill($produto);
            $newProduto->save();

            if(json_decode($tags['fk_tag'])){
                $tags = $this->produtoTagService->store($tags, $newProduto->id);
            }

            $imagens = $this->imagemService->storeProduto($produto['images'], $newProduto->id);
            
            return response()->json($produto, 201);

        }catch(Exception $e){
            throw $e;
        }
    }
}