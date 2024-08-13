<?php

namespace App\Services;

use App\Models\Imagem;
use Exception;

class ImagemService
{
    public function storeEstabelecimento($request, $fk_estabelecimento)
    {
        try{
            $imagem = Imagem::where('fk_estabelecimento', $fk_estabelecimento)->first();

            if($imagem){
                $this->deleteImagem($imagem->id);
            }
            $imagem = new Imagem();
            
            $image = $request;
            $extension = $image->extension();
            $imageName = md5($image->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $request->move(public_path('img/estabelecimentos'), $imageName);
            $imagem->nome_referencia = $imageName;
            $imagem->nome_imagem = $request->getClientOriginalName();
            $imagem->fk_estabelecimento = $fk_estabelecimento;
            
            $imagem->save();

            return response()->json(null, 201);

        }catch(Exception $e){
            throw $e;
        }
    }

    public function storeProduto($imagens, $fk_produto)
    {
        try{
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

            return response()->json(null, 201);

        }catch(Exception $e){
            throw $e;
        }
    }

    private function deleteImagem($imagemId)
    {
        try {
            $imagem = Imagem::findOrFail($imagemId);
            
            $imagePath = public_path('img/estabelecimentos/' . $imagem->nome_referencia);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $imagem->delete();

            return response()->json(['message' => 'Imagem deletada com sucesso!'], 200);

        } catch (Exception $e) {
            throw $e;
        }
    }
}