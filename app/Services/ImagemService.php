<?php

namespace App\Services;

use App\Jobs\SaveImageEstabelecimentoJob;
use App\Jobs\SaveImageProdutoJob;
use App\Models\Imagem;

class ImagemService
{
    public function storeEstabelecimento($request, $fk_estabelecimento)
    {
        $imagem = Imagem::where('fk_estabelecimento', $fk_estabelecimento)->first();

        if($imagem){
            $this->deleteImagem($imagem->id);
        }

        $path = $request->store('temp', 'public');

        SaveImageEstabelecimentoJob::dispatch($path, $fk_estabelecimento)->onQueue('saveImageEstabelecimento');
    }

    public function storeProduto($imagens, $fk_produto)
    {
        foreach($imagens as $img){
            $path = $img->store('temp', 'public');
            SaveImageProdutoJob::dispatch($path, $fk_produto)->onQueue('saveImageProduto');
        }
    }

    private function deleteImagem($imagemId)
    {
        $imagem = Imagem::findOrFail($imagemId);

        $imagePath = public_path('img/estabelecimentos/' . $imagem->nome_referencia);

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $imagem->delete();
    }

    public function deleteProdutoImagem($imagens, $idProduto)
    {
        $imagens = Imagem::where('fk_produto', $idProduto)->whereNotIn('nome_referencia', $imagens)->get();

        foreach($imagens as $imagem){
            $imagePath = public_path('img/produtos/' . $imagem->nome_referencia);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $imagem->delete();
        }
    }

    public function destroyAll($idProduto)
    {
        $imagens = Imagem::where('fk_produto', $idProduto)->get();

        foreach($imagens as $imagem){
            $imagePath = public_path('img/produtos/' . $imagem->nome_referencia);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $imagem->delete();
        }
    }
}