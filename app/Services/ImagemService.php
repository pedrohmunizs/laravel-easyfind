<?php

namespace App\Services;

use App\Models\Imagem;

class ImagemService
{
    public function storeEstabelecimento($request, $fk_estabelecimento)
    {
        $imagem = new Imagem();

        $image = $request;
        $extension = $image->extension();
        $imageName = md5($image->getClientOriginalName() . strtotime("now")) . "." . $extension;
        $request->move(public_path('img/estabelecimentos'), $imageName);
        $imagem->nome_referencia = $imageName;
        $imagem->nome_imagem = $request->getClientOriginalName();
        $imagem->fk_estabelecimento = $fk_estabelecimento;

        $imagem->save();

        return $image;
    }

    public function storeProduto($imagens, $fk_produto)
    {
        foreach($imagens as $img){
            $imagem = new Imagem();

            $image = $img;
            $extension = $image->extension();
            $imageName = md5($image->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $img->move(public_path('img/produtos'), $imageName);
            $imagem->nome_referencia = $imageName;
            $imagem->nome_imagem = $img->getClientOriginalName();
            $imagem->fk_produto = $fk_produto;

            $imagem->save();
        }
    }
}