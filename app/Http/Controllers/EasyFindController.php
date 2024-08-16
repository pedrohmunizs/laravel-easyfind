<?php

namespace App\Http\Controllers;

use App\Models\Estabelecimento;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EasyFindController extends Controller
{
    public function index()
    {
        if(auth()->user()){
            if (Gate::denies('consumidor')) {
                return view('institucional.index');
            }
        }

        $produtos = Produto::where('is_ativo', true)->inRandomOrder()->limit(6)->get();
        $promocoes = Produto::where('is_ativo', true)->where('is_promocao_ativa', true)->inRandomOrder()->limit(6)->get();
        $estabelecimentos = Estabelecimento::where('is_ativo', true)->inRandomOrder()->limit(4)->get();
        
        foreach($estabelecimentos as $estabelecimento){
            $produtosEstabelecimento = [];
            $count = 0;
            foreach($estabelecimento->secoes as $secao){
                foreach($secao->produtos->where('is_ativo', true) as $produto){
                    if ($count < 3) {
                        array_push($produtosEstabelecimento, $produto);
                        $count++;
                    } else {
                        break ;
                    }
                }
            }

            $estabelecimento->produtos_filtrados = $produtosEstabelecimento;
        }

        return view('easyfind.index',[
            'produtos' => $produtos,
            'estabelecimentos' => $estabelecimentos,
            'ofertas' => $promocoes
        ]);
    }
}
