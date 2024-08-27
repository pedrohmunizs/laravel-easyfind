<?php

namespace App\Services;

use App\Jobs\SaveImageEstabelecimentoJob;
use App\Jobs\SaveImageProdutoJob;
use App\Models\Imagem;
use Exception;
use Illuminate\Support\Facades\Storage;

class ImagemService
{
    public function storeEstabelecimento($request, $fk_estabelecimento)
    {
        try{
            $imagem = Imagem::where('fk_estabelecimento', $fk_estabelecimento)->first();

            if($imagem){
                $this->deleteImagem($imagem->id);
            }

            $path = $request->store('temp', 'public');
            
            SaveImageEstabelecimentoJob::dispatch($path, $fk_estabelecimento)->onQueue('saveImageEstabelecimento');

            return response()->json(null, 201);

        }catch(Exception $e){
            throw $e;
        }
    }

    public function storeProduto($imagens, $fk_produto)
    {
        try{
            foreach($imagens as $img){

                $path = $img->store('temp', 'public');

                SaveImageProdutoJob::dispatch($path, $fk_produto)->onQueue('saveImageProduto');
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

    public function deleteProdutoImagem($imagens, $idProduto)
    {
        try {
            $imagens = Imagem::where('fk_produto', $idProduto)->whereNotIn('nome_referencia', $imagens)->get();

            foreach($imagens as $imagem){

                $imagePath = public_path('img/produtos/' . $imagem->nome_referencia);

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }

                $imagem->delete();
            }

            return response()->json(['message' => 'Imagem deletada com sucesso!'], 200);

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function destroyAll($idProduto)
    {
        try{
            $imagens = Imagem::where('fk_produto', $idProduto)->get();

            foreach($imagens as $imagem){

                $imagePath = public_path('img/produtos/' . $imagem->nome_referencia);

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }

                $imagem->delete();
            }

            return response()->json(['message' => 'Imagem deletada com sucesso!'], 200);

        }catch(Exception $e){
            throw $e;
        }
    }
}