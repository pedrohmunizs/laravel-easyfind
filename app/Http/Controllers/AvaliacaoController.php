<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\ItemVenda;
use App\Services\AvaliacaoService;
use Illuminate\Http\Request;

class AvaliacaoController extends Controller
{
    protected $service = null;

    public function __construct(AvaliacaoService $avaliacaoService) {
        $this->service = $avaliacaoService;
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $consumidor = $user->consumidor;

        $compra = ItemVenda::where('fk_consumidor', $consumidor->id)->where('fk_produto', $request['avaliacao.fk_produto'])->first();

        if(!$compra){
            return response()->json(['message' => 'Você não comprou este produto!'], 409);
        }

        $existe = Avaliacao::where('fk_consumidor', $consumidor->id)->where('fk_produto', $request['avaliacao.fk_produto'])->first();

        if($existe){
            return response()->json(['message' => 'Você já adicionou uma avaliação a este produto!'], 409);
        }

        $data = $request['avaliacao'];

        if(empty($data['qtd_estrela'])){
            return response()->json(['message' => 'Adicione uma nota a essa avaliação!'], 400);
        }
        
        $avaliacao = $this->service->store($data, $consumidor->id);
        
        return $avaliacao;
    }

    public function load($idProduto)
    {
        $avaliacoes = Avaliacao::where('fk_produto', $idProduto)->get();
        return $avaliacoes;
    }
}
