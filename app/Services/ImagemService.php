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
}